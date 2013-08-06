<?php

/**
 * ESC модель
 *
 * @property integer $id
 * @property integer $manufacter_id
 * @property string $title
 * @property integer $current_max
 * @property integer $current_normal
 * @property int $resistance
 * @property integer $weight
 * @property string $date_updated
 * @property string $date_created
 *
 * @property ManufacterModel $manufacter
 */
class EscModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EscModel the static model class
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
		return 'esc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('title, current_max, current_normal, resistance, weight', 'required'),
			array('manufacter_id, current_max, current_normal, weight', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>50),

			array('id, manufacter_id, title, current_max, current_normal, weight, date_updated, date_created', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
            'manufacter' => array(self::BELONGS_TO, 'ManufacterModel', 'manufacter_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'manufacter_id' => 'Manufacter',
			'title' => 'Title',
			'current_max' => 'Current Max',
			'current_normal' => 'Current Normal',
			'weight' => 'Weight',
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
		$criteria->compare('manufacter_id',$this->manufacter_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('current_max',$this->current_max);
		$criteria->compare('current_normal',$this->current_normal);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * @return array плоский список
     */
    public static function getList()
    {
        return Y::dbc()
            ->select('id, title')
            ->from(self::model()->tableName())
            ->where('1=1')
            ->queryAssoc();
    }

    /**
     * @return array
     */
    public static function loadAll()
    {
        return Y::dbc()
            ->select('id, title, current_max, current_normal, resistance, weight')
            ->from(self::model()->tableName())
            ->where('1=1')
            ->queryAssoc();
    }
}
