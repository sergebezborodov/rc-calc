<?php

/**
 * Результат расчета
 *
 * @property float $flightTimeHover
 * @property float $flightTimeMin
 * @property int $addPayload
 * @property float $throttle
 * @property int $totalWeight
 * @property float $totalCurrentMax
 * @property float $totalCurrentHover
 * @property float $maxBatteryLoad
 * @property float $totalDriveWeight
 *
 * @property array $warnings
 */
class CopterCalcResult
{
    protected $_flightTimeHover;

    protected $_flightTimeMin;

    protected $_addPayload;

    protected $_totalWeight;

    protected $_throttle;


    protected $_totalCurrentMax;

    protected $_totalCurrentHover;

    protected $_maxBatteryLoad;

    protected $_totalDriveWeight;

    protected $warnings = array();

    public function toArray()
    {
        return array(
            'throttle'          => $this->_throttle,
            'flightTimeHover'   => $this->_flightTimeHover,
            'flightTimeMin'     => $this->_flightTimeMin,
            'addPayload'        => $this->_addPayload,
            'totalWeight'       => $this->_totalWeight,

            'totalCurrentMax'   => $this->_totalCurrentMax,
            'totalCurrentHover' => $this->_totalCurrentHover,
            'maxBatteryLoad'    => $this->_maxBatteryLoad,
            'totalDriveWeight'  => $this->_totalDriveWeight,

            'warnings'          => $this->warnings,
        );
    }

    public function addWarning($text)
    {
        $this->warnings[] = $text;
    }

    /**
     * PHP Magick Method
     *
     * @param string $name
     * @param mixed $value
     */
    public function __set($name, $value)
    {
        if (!$value) {
            $value = null;
        }
        if (is_numeric($value)) {
            $value = floatval($value);
        }
        if (is_nan($value)) {
            $this->{'_'.$name} = null;
        } else {
            $this->{'_'.$name} = $value;
        }
    }

    public function __get($name)
    {
        return $this->{'_'.$name};
    }
}
