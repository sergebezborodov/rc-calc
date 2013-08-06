<?php

/**
 * Модель калькулятора для коптеров
 */
class CopterCalcModel extends CalcModel
{
// --- общая информация

    /**
     * @var string единицы измерения метрические/имперские
     */
    public $units = 'metric';

    /**
     * @var int id типа коптера
     */
    public $copterTypeId = 4;

    /**
     * @var int вес в граммах
     */
    public $totalWeight = 800;

    /**
     * @var bool включен в общий вес вес двигателей
     */
    public $isWeightIncludeDrive = true;

// --- моторы

    /**
     * @var int производитель мотора
     */
    public $motorManufacterId;

    /**
     * @var int модель мотора
     */
    public $motorModelId;

    /**
     * @var int
     */
    public $motorKv;

    /**
     * @var int вес в граммах
     */
    public $motorWeight;

    /**
     * @var int длина мотора
     */
    public $motorLength = 30;

    /**
     * @var float сопртивление мотора в омах
     */
    public $motorResistance;

    /**
     * @var float потребляемый ток в спокойном режиме
     */
    public $motorCurrentNoLoad;

    public $motorNoLoadVoltage;

    /**
     * @var float максимальный значение тока или мощности на моторе
     */
    public $motorLimitValue;

    /**
     * @var string тип максимального значения на моторе - мощность или ток
     */
    public $motorLimitType = 'A';

    /**
     * @var int количество магнитов в моторе
     */
    public $motorMagPoles;


// --- ESC

    /**
     * @var int id ESC
     */
    public $escId;

    /**
     * @var int рабочий ток ESC
     */
    public $escCurrentContinuous;

    /**
     * @var int максимальный ток
     */
    public $escCurrentMax;

    /**
     * @var int вес в граммах
     */
    public $escWeight;

    /**
     * @var float внутреннее сопротивление
     */
    public $escResistance;


// --- Battery

    /**
     * @var int
     */
    public $batteryId;

    /**
     * @var int
     */
    public $batterySerialCount;

    /**
     * @var int емкость батареи в mAh
     */
    public $batteryCapacity;

    /**
     * @var int количество батарей в параллели
     */
    public $batteryParallelCount;

    /**
     * @var float напряжение батареи на банку
     */
    public $batteryVoltPerCell;

    /**
     * @var int вес в граммах на банку
     */
    public $batteryWeightPerCell;

    /**
     * @var float внутреннее сопротивление батареи
     */
    public $batteryResistance;

    /**
     * @var int коээф разряжения батареи C
     */
    public $batteryNormC;

    /**
     * @var int макстмальное C
     */
    public $batteryBurstC;

    /**
     * @var int состояние заряда батареи
     */
    public $batteryChargeState = 1;


// --- Prop

    /**
     * @var int тип пропеллера
     */
    public $propTypeId;

    /**
     * @var float диаметр пропеллера в дюймах
     */
    public $propDiametr;

    /**
     * @var float pitch пропеллера в дюймах
     */
    public $propPitch;

    /**
     * @var int количество лопастей
     */
    public $propBladesCount;

    /**
     * @var float
     */
    public $propTwist = 0;

    /**
     * @var float
     */
    public $propConst = 1.05;

    /**
     * @return float
     */
    public $propGearRatio = 1;

    /**
     * @var int
     */
    public $propMaxRpmConst;

    public function rules()
    {
        return array(
            // main info group
            array('totalWeight', 'required'),
            array('totalWeight', 'length', 'min' => 0),

            array('copterTypeId', 'in', 'range' => array_keys($this->getCopterTypeList())),
            array('totalWeight, isWeightIncludeDrive', 'numerical', 'integerOnly' => true),

            // motor
            array('motorKv, motorWeight, motorMagPoles, motorLength', 'required'),
            array('motorKv, motorWeight, motorMagPoles, motorLength', 'numerical', 'integerOnly' => true),
            array('motorKv, motorWeight, motorMagPoles, motorLength', 'numerical', 'min' => 1),


            array('motorResistance, motorCurrentNoLoad, motorNoLoadVoltage, motorLimitValue', 'required'),
            array('motorResistance, motorCurrentNoLoad, motorNoLoadVoltage, motorLimitValue', 'numerical'),
            array('motorResistance, motorCurrentNoLoad, motorNoLoadVoltage, motorLimitValue', 'numerical', 'min' => 0.0001),

            array('motorLimitType', 'in', 'range' => array_keys(MotorModel::model()->getLimitTypeValues())),

            array('motorManufacterId, motorModelId', 'numerical', 'integerOnly' => true), // TODO: validate in DB

            // esc
            array('escId', 'numerical', 'integerOnly' => true), // TODO: validate in DB
            array('escWeight', 'required'),
            array('escWeight', 'numerical', 'integerOnly' => true),
            array('escWeight', 'numerical', 'min' => 0),
            array('escCurrentContinuous, escCurrentMax, escResistance', 'required'),
            array('escCurrentContinuous, escCurrentMax, escResistance', 'numerical'),
            array('escCurrentContinuous, escCurrentMax, escResistance', 'length', 'min' => 0),

            //battery
            array('batteryId', 'numerical', 'integerOnly' => true), // TODO: validate in DB
            array('batterySerialCount, batteryCapacity, batteryParallelCount, batteryWeightPerCell', 'required'),
            array('batterySerialCount, batteryCapacity, batteryParallelCount, batteryWeightPerCell',
                'numerical', 'integerOnly' => true),
            array('batterySerialCount, batteryCapacity, batteryParallelCount, batteryWeightPerCell',
                 'numerical', 'min' => 0.00001),
            array('batteryNormC, batteryBurstC', 'required'),
            array('batteryNormC, batteryBurstC', 'numerical', 'integerOnly' => true),
            array('batteryNormC, batteryBurstC', 'numerical', 'min' => 0),
            array('batteryVoltPerCell, batteryResistance', 'required'),
            array('batteryVoltPerCell, batteryResistance', 'numerical'),
            array('batteryVoltPerCell, batteryResistance', 'length', 'min' => 0.00001),

            // prop
            array('propTypeId', 'numerical', 'integerOnly' => true), // TODO: validate in DB
            array('propBladesCount', 'required'),
            array('propBladesCount', 'numerical', 'integerOnly' => true),
            array('propBladesCount', 'numerical', 'min' => 1),
            array('propDiametr, propPitch, propTwist, propConst, propGearRatio', 'required'),
            array('propDiametr, propPitch, propTwist, propConst, propGearRatio, propMaxRpmConst', 'numerical'),
            array('propDiametr, propPitch, propTwist, propConst, propGearRatio, propMaxRpmConst', 'length', 'min' => 0),

            array('title', 'safe'),
        );
    }


    /**
     * @return array список типов коптеров
     */
    public function getCopterTypeList()
    {
        return array(
            3 => _t('copter', 'Tri'),
            4 => _t('copter', 'Quad'),
            6 => _t('copter', 'Hexa'),
            8 => _t('copter', 'Octo'),
            10 => _t('copter', 'Deca (10 rotors)'),
        );
    }

    public function getNumRotors()
    {
        return $this->copterTypeId;
    }
}
