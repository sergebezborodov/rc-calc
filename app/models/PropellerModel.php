<?php

/**
 * Модель пропеллера
 *
 * @property integer $id
 * @property integer $manufacter_id
 * @property float $diametr
 * @property float $pitch
 * @property integer $blades_count
 * @property float $twist
 * @property float $const
 * @property float $gear_ratio
 * @property int $max_rpm_const
 * @property string $date_updated
 * @property string $date_created
 *
 * @property ManufacterModel $manufacter
 */
class PropellerModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PropellerModel the static model class
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
		return 'propeller';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('manufacter_id, diametr, pitch', 'required'),
			array('manufacter_id, blades_count', 'numerical', 'integerOnly'=>true),
			array('diametr, pitch', 'numerical'),
			array('date_updated, date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, manufacter_id, diametr, pitch, blades_count, date_updated, date_created', 'safe', 'on'=>'search'),
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
			'diametr' => 'Diametr',
			'pitch' => 'Pitch',
			'blades_count' => 'Blades Count',
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
		$criteria->compare('diametr',$this->diametr);
		$criteria->compare('pitch',$this->pitch);
		$criteria->compare('blades_count',$this->blades_count);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('date_created',$this->date_created,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    public static function getList()
    {
        return Y::dbc()
            ->select('p.id, m.title')
            ->from(self::model()->tableName() . ' AS p')
            ->leftJoin('manufacter AS m', 'm.id = p.manufacter_id')
            ->where('1=1')
            ->order('m.title ASC')
            ->queryAssoc();
    }

    /**
     * @return array
     */
    public static function loadAll()
    {
        return Y::dbc()
            ->select('p.id, m.title, p.diametr, p.pitch, p.blades_count, p.twist, p.const, p.gear_ratio, p.max_rpm_const')
            ->from(self::model()->tableName() . ' AS p')
            ->leftJoin('manufacter AS m', 'm.id = p.manufacter_id')
            ->where('1=1')
            ->queryAssoc();
    }
}
