<?php

/**
 * Модель батареии
 *
 * @property integer $id
 * @property integer $manufacter_id
 * @property string $title
 * @property int $norm_c
 * @property int $burst_c
 * @property integer $cell_count
 * @property integer $parallel_count
 * @property integer $capacity
 * @property float $resistance
 * @property float $volt_per_cell
 * @property integer $weight_per_cell
 * @property string $date_updated
 * @property string $date_created
 *
 * @property ManufacterModel $manufacter
 */
class BatteryModel extends BaseActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BatteryModel the static model class
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
		return 'battery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('norm_c, burst_c', 'required'),
			array('manufacter_id, cell_count, capacity, resistance, volt_per_cell, weight_per_cell', 'required'),
			array('manufacter_id, cell_count, parallel_count, capacity, weight_per_cell', 'numerical', 'integerOnly'=>true),
			array('resistance, volt_per_cell', 'numerical'),

            array('id, manufacter_id, cell_count, parallel_count, capacity, resistance, volt_per_cell, weight_per_cell, date_updated, date_created', 'safe', 'on'=>'search'),
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
            'id'              => 'ID',
            'manufacter_id'   => 'Manufacter',
            'cell_count'      => 'Cell Count',
            'parallel_count'  => 'Parallel Count',
            'capacity'        => 'Capacity',
            'resistance'      => 'Resistance',
            'volt_per_cell'   => 'Volt Per Cell',
            'weight_per_cell' => 'Weight Per Cell',
            'date_updated'    => 'Date Updated',
            'date_created'    => 'Date Created',
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
		$criteria->compare('cell_count',$this->cell_count);
		$criteria->compare('parallel_count',$this->parallel_count);
		$criteria->compare('capacity',$this->capacity);
		$criteria->compare('resistance',$this->resistance);
		$criteria->compare('volt_per_cell',$this->volt_per_cell);
		$criteria->compare('weight_per_cell',$this->weight_per_cell);
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
            ->select(array('id', 'title', 'norm_c', 'burst_c', 'cell_count', 'parallel_count', 'capacity', 'resistance',
                'volt_per_cell', 'weight_per_cell'))
            ->from(self::model()->tableName())
            ->where('1=1')
            ->queryAssoc();
    }

    public function beforeSave()
    {
        parent::beforeSave();

        $this->title = $this->generateTitle();

        return true;
    }

    protected function generateTitle()
    {
        return "LiPo {$this->capacity}mAh - {$this->norm_c}/{$this->burst_c}";
    }
}
