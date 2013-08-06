<?php

/**
 * Сохраненные расчеты
 */
class CalcModel extends CFormModel
{
    /**
     * @var bool новая запись
     */
    protected $_isNew;

    /**
     * @var string id расчета
     */
    protected $_hash;

    /**
     * @var int id пользователя
     */
    protected $_psUserId;

    /**
     * @var int id владельца
     */
    protected $_userId;

    /**
     * @var bool сохранен у пользователя в списке
     */
    protected $_inUserList;

    public $title;

    /**
     * @var int
     */
    protected $_viewCount;

    /**
     * @var UserModel
     */
    protected $_ownerModel;

    public function __construct($scenario = '')
    {
        parent::__construct($scenario);

        if (Y::isAuthed()) {
            $this->_userId = Y::userId();
        }
        $this->_psUserId = rand(1, 1000);//Y::sm()->getUser()->id;
        $this->_inUserList = false;
    }

    /**
     * @return MongoCollection
     */
    protected static function collection()
    {
        return Y::mongo()->{'calc'};
    }

    /**
     * @return int всего расчетов в базе
     */
    public static function getTotal()
    {
        return self::collection()->count();
    }

    /**
     * @param int $count количество
     * @return array самые популярные расчеты
     */
    public static function getPopular($count = 20)
    {
        $items = self::collection()
            ->find()
            ->sort(array('view_count' => -1))
            ->limit($count);

        if (!$items) {
            return array();
        }
        $result = array();
        foreach ($items as $item) {
            if (!empty($item['hash'])) {
                $result[] = self::loadCalc($item['hash']);
            }
        }
        return $result;
    }

    /**
     * Выборка всех расчетов по пользователю
     *
     * @param $userId
     * @return array
     */
    public static function findAllByUserId($userId)
    {
        $items = self::collection()->find(
            array('$and' => array(
                array('$or' => array(
                    array('in_user_list' => true),
                    array('in_user_list' => 1),
                    array('in_user_list' => "1"),
                )),
                array('$or' => array(
                    array('user_id' => intval($userId)),
                    array('user_id' => strval($userId))
                )),
        ))

        );
        if (!$items) {
            return array();
        }
        $result = array();
        foreach ($items as $item) {
            if (!empty($item['hash'])) {
                $result[] = self::loadCalc($item['hash']);
            }
        }
        return $result;
    }

    /**
     * Сохраняет расчет в базу
     *
     * @return string hash
     */
    public function saveCalc()
    {
        $this->_psUserId = Y::sm()->getUser()->id;
        $item = self::collection()->findOne(array('hash' => $this->getHash()));
        if (!$item) {
            $item = array(
                'class'        => get_class($this),
                'ps_user_id'   => $this->_psUserId,
                'hash'         => $this->getHash(),
                'view_count'   => 1,
                'date_created' => new MongoDate(),
            );
        }

        if (!$this->title) {
            $this->title = _t('copter', 'No title');
        }

        $item['data']          = $this->attributes;
        $item['date_updated']  = new MongoDate();
        $item['in_user_list']  = (bool)$this->_inUserList;

        $item['date_lastview'] = new MongoDate();
        $item['user_id']       = (int)$this->_userId;

        if ($this->getIsNew()) {
            self::collection()->insert($item, array('safe' => true));
        } else {
            self::collection()->update(array('hash' => $this->_hash), $item,
                array('safe' => true, 'fsync' => true));
        }

        return $this->getHash();
    }


    /**
     * Загрузка расчета из базы
     *
     * @param string $hash
     * @return CopterCalcModel|null
     */
    public static function loadCalc($hash)
    {
        $item = self::collection()->findOne(array('hash' => $hash));
        if (!$item) {
            return null;
        }

        //$item['view_count']++;
        //$item['date_lastview'] = new MongoDate();

        //self::collection()->update(array('hash' => $hash), $item, array('safe' => true, 'fsync' => true));

        $className = $item['class'];
        $calc = new $className;
        $calc->attributes = $item['data'];

        $calc->_isNew = false;
        $calc->_hash = $hash;
        $calc->_psUserId = $item['ps_user_id'];
        $calc->_userId = !empty($item['user_id']) ? (int)$item['user_id'] : null;
        $calc->_viewCount = $item['view_count'];
        $calc->_inUserList = !empty($item['in_user_list']);

        return $calc;
    }

    /**
     * Добавляет коптер в список пользователя
     */
    public function addToUserList()
    {
        $this->_inUserList = true;
    }

    /**
     * Удаляет из списка пользователей
     */
    public function removeFromUserList()
    {
        $this->_inUserList = false;
    }

    /**
     * Добавляет просмотр
     */
    public function addView()
    {
        $item = self::collection()->findOne(array('hash' => $this->getHash()));
        if (!$item) {
            return null;
        }

        $item['view_count']++;
        $item['date_lastview'] = new MongoDate();

        self::collection()->update(array('hash' => $this->getHash()), $item, array('safe' => true, 'fsync' => true));
    }

    /**
     * Устанавливает значение
     *
     * @param string $value
     */
    public function setHash($value)
    {
        $this->_hash = $value;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        if ($this->_hash == null) {
            $this->_hash = $this->generateHash();
        }
        return $this->_hash;
    }

    /**
     * @return string
     */
    public function generateHash()
    {
        return H::generateRandomString(Y::param('hashLength'));
    }

    public function getIsNew()
    {
        if ($this->_isNew === null) {
            $this->_isNew = !(bool)self::collection()->count(array('hash' => $this->_hash));
        }
        return $this->_isNew;
    }

    /**
     * @return bool если текущий user владелец данного расчета
     */
    public function getIsVisitorOwner()
    {
        return $this->_psUserId == Y::sm()->getUser()->id;
    }

    public function resetVisitorOwner()
    {
        $this->_psUserId = Y::sm()->getUser()->id;
        $this->_hash = $this->generateHash();
        $this->_inUserList = false;
    }

    /**
     * @return bool является ли текущий юзер владельцем
     */
    public function getIsOwner()
    {
        return $this->_userId == Y::userId();
    }

    public function getViewCount()
    {
        return $this->_viewCount;
    }

    public function getInUserList()
    {
        return $this->_inUserList;
    }

    /**
     * @return UserModel
     */
    public function getOwnerModel()
    {
        if ($this->_ownerModel == null) {
            $this->_ownerModel = UserModel::model()->findByPk($this->_userId);
        }
        return $this->_ownerModel;
    }

    public function setInUserList($value)
    {
        $this->_inUserList = $value;
    }

    /**
     * @param array $values
     * @param bool $safeOnly
     */
    public function setAttributes($values,$safeOnly=true)
    {
        parent::setAttributes($values, $safeOnly);
        $this->postProcessAttributes();
    }

    /**
     * Пост процессинг аттрибутов
     * замена запятой на точку
     */
    protected function postProcessAttributes()
    {
        foreach ($this->attributes as $key => $val) {
            if (strpos($val, ',') !== false) {
                $this->{$key} = str_replace(',', '.', $val);
            }
        }
    }

}
