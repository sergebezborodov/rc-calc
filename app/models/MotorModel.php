<?php

/**
 *
 * Модель мотора
 *
 * @property integer $id
 * @property integer $manufacter_id
 * @property string $model
 * @property integer $kw
 * @property float $resistance
 * @property float $current_noload
 * @property float $current_noload_voltage
 *
 * @property string $limit_type A|W
 * @property float $limit_value
 *
 * @property integer $weight
 * @property int $length
 *
 * @property integer $mag_poles_count
 *
 * @property string $date_updated
 * @property string $date_created
 *
 * @property ManufacterModel $manufacter
 */
class MotorModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MotorModel the static model class
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
		return 'motor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('model, resistance, kw, current_noload, current_noload_voltage' , 'required'),
            array('manufacter_id, limit_value, weight, length, mag_poles_count', 'required'),
			/*array('manufacter_id, kw, resistance, current_noload, current_max, weight', 'required'),
			array('manufacter_id, kw, weight, mag_poles_count', 'numerical', 'integerOnly'=>true),
			array('resistance, current_noload, current_max', 'numerical'),*/

			array('id, manufacter_id, model', 'safe', 'on'=>'search'),
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
			'kw' => 'Kw',
			'resistance' => 'Resistance',
			'current_noload' => 'Current Noload',
			'current_limit' => 'Current Limit',
			'weight' => 'Weight',
			'mag_poles_count' => 'Mag Poles Count',
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
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('manufacter_id',$this->manufacter_id);
		$criteria->compare('kw',$this->kw);
		$criteria->compare('resistance',$this->resistance);
		$criteria->compare('current_noload',$this->current_noload);

		$criteria->compare('weight',$this->weight);
		$criteria->compare('mag_poles_count',$this->mag_poles_count);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public function getLimitTypeValues()
    {
        return array(
            'A' => 'A',
            'W' => 'W',
        );
    }


    /**
     * Загрузка моторов по производителю
     *
     * @param int $manufacterId
     * @return array
     */
    public static function loadByManufacterId($manufacterId)
    {
        return Y::dbc()
            ->select(array(
                'id', 'model', 'kw', 'resistance', 'current_noload', 'current_noload_voltage',
                'limit_type', 'limit_value', 'weight', 'length', 'mag_poles_count'
            ))
            ->from(self::model()->tableName())
            ->where('manufacter_id = :mid', array(':mid' => $manufacterId))
            ->queryAssoc();
    }

}
