<?php

/**
 * Модель производителя
 *
 * @property integer $id
 * @property string $title
 * @property string $date_updated
 * @property string $date_created
 */
class ManufacterModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ManufacterModel the static model class
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
		return 'manufacter';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>50),

            array('id, title, date_updated, date_created', 'safe', 'on'=>'search'),
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
			'id' => 'ID',
			'title' => 'Title',
			'date_updated' => 'Date Updated',
			'date_created' => 'Date Created',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return array плоский список производителей
     */
    public static function getList()
    {
        return Y::dbc()
            ->select('id, title')
            ->from(self::model()->tableName())
            ->where('1=1')
            ->order('title')
            ->queryAssoc();
    }

    public static function getListWithMotorsExists()
    {
        return Y::dbc()
            ->select('m.id, m.title')
            ->from(self::model()->tableName() . ' AS m')
            ->leftJoin('motor AS mot', 'mot.manufacter_id = m.id')
            ->where('mot.id IS NOT NULL')
            ->order('title')
            ->group('m.id')
            ->queryAssoc();
    }
}
