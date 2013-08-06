<?php

/**
 * Модель пользователя
 *
 * @property integer $id
 * @property string $name
 * @property string $avatar
 * @property string $email
 * @property string $city
 * @property string $hash
 * @property string $username
 * @property string $date_updated
 * @property string $date_created
 * @property string $date_lastlogin
 */
class UserModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserModel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('name, email, username', 'required'),
			array('name, city', 'length', 'max'=>50),
			array('avatar', 'file', 'allowEmpty' => true, 'types' => 'jpg, jpeg, gif, png'),
			array('email', 'length', 'max'=>100),
            array('username', 'unique', 'message' => _t('user', 'This username have another user')),
            array('username', 'validateUsername'),

			array('id, name, avatar, email, city, date_updated, date_created, date_lastlogin', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
        return array(
            'id'             => 'ID',
            'name'           => 'Name',
            'avatar'         => 'Avatar',
            'email'          => 'Email',
            'city'           => 'City',

            'username'       => _t('user', 'Your page URL'),

            'date_updated'   => 'Date Updated',
            'date_created'   => 'Date Created',
            'date_lastlogin' => 'Date Lastlogin',
        );
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('avatar',$this->avatar,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_lastlogin',$this->date_lastlogin,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function validateUsername()
    {
        if (!preg_match('/[a-zA-Z-_\d+]+/', $this->username)) {
            $this->addError('username', _t('user', 'Username can have only "a-z - _"'));
        }
    }

    /**
     * @param $identity
     * @return UserModel|null
     */
    public static function getProfileByIdentity($identity)
    {
        if($identity instanceof IAuthService) {
            $idenId = self::getAuthIdentIdByServiceName($identity->getServiceName());
            $userId = Y::dbc()
                ->select('user_id')
                ->from('user_identity')
                ->where('auth_identity_id = :iden AND identity_hash = :hash', array(
                    ':iden' => $idenId,
                    ':hash' => $identity->getId(),
                ))
            ->queryScalar();

            if ($userId) {
                return UserModel::model()->findByPk($userId);
            }
        }

        return null;
    }

    /**
     * Создает пользователя
     *
     * @static
     * @param IAuthService $authIdentity
     * @param CBaseUserIdentity $identity
     * @return UserModel
     */
    public static function createByIdentity($authIdentity, $identity)
    {
        BaseActiveRecord::beginTransaction();

        try {
            $user = new UserModel;
            $user->name  = $authIdentity->getAttribute('name');
            $user->email = $authIdentity->getAttribute('email');
            $user->city  = $authIdentity->getAttribute('city');
            $user->hash  = H::generateRandomString(7);

            $user->save(false);

            if ($user->name) {
                $user->username = StringHelper::createSlug($user->name);
            } else {
                $user->username = $user->id;
            }
            $user->save(false, array('username'));

            $identityId = self::getAuthIdentIdByServiceName($authIdentity->getServiceName());

            Y::dbc()->insert('user_identity', array(
                'user_id'          => $user->id,
                'auth_identity_id' => $identityId,
                'identity_hash'    => $identity->getId(),
            ));
            BaseActiveRecord::commitTransaction();

            return $user;
        } catch (Exception $e) {
            BaseActiveRecord::rollbackTransaction();
        }

        return null;
    }

    protected static function getAuthIdentIdByServiceName($service)
    {
        return Y::dbc()
            ->select('id')
            ->from('auth_identity')
            ->where('alias = :alias', array(':alias' => $service))
            ->queryScalar();
    }

    /**
     * Авторизация пользователя
     *
     * @param IAuthService $authIdentity
     * @param CBaseUserIdentity $identity
     * @return boolean whether login is successful
     */
    public function login($authIdentity = null, $identity = null)
    {
        $fake = new FakeUserIdentity(UserModel::getProfileByIdentity($authIdentity));

        Yii::app()->user->login($fake);

        $this->date_lastlogin = new CDbExpression('NOW()');
        $this->save(false, array('date_lastlogin'));

        return true;
    }

    public function beforeSave()
    {
        if (!parent::beforeSave()) {
            return false;
        }

        if ($file = CUploadedFile::getInstance($this, 'avatar')) {
            $fileName = 'avatar'.'.'.$file->extensionName;
            if (file_exists($fileName)) {
                @unlink($fileName);
            }

            if (!$file->saveAs(H::getStoragePathForUser($this).DS.$fileName)) {
                return false;
            }

            $this->avatar = $fileName;

            if (!$this->processUserAvatar()) {
                return false;
            }
        } else {
            unset($this->logo);
        }

        return true;
    }

    /**
     * Обработка изображений пользователя
     */
    protected function processUserAvatar()
    {
        $storage = H::getStoragePathForUser($this).DS;
        try {
            $image = new Imagick($storage.$this->avatar);
        } catch (Exception $e) {
            $this->addError('avatar', _t('profile', 'Bad image'));
            return false;
        }
        foreach (Y::param('storage.avatar') as $name => $params) {
            $width = $params['width'];
            $height = $params['height'];

            $image->thumbnailImage($width, $height);

            $image->writeimage($storage.$name.'-avatar.jpg');
        }

        return true;
    }

    /**
     * Имя файла аватара в нужном размере
     *
     * @param $size
     * @return string
     * @throws AppException
     */
    public function getAvatarFileForSize($size)
    {
        if (!in_array($size, array_keys(Y::param('storage.avatar')))) {
            throw new AppException('Invalid size - '. $size);
        }

        return $size . '-avatar.jpg';
    }

    /**
     * @param string $userName
     * @return UserModel
     */
    public function findByUserName($userName)
    {
        return self::model()->findByAttributes(array(
            'username' => $userName,
        ));
    }
}
