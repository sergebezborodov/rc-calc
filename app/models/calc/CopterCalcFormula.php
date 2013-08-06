<?php

/**
 * Формула расчета для коптеров
 */
class CopterCalcFormula extends PComponent
{
    /**
     * @var CopterCalcModel
     */
    protected $data;

    public function __construct($calcModel)
    {
        $this->data = $calcModel;
    }

    protected function getIo($d, $x)
    {
        $v = $this->data;
        // var Po = motorNoLoadCurrent * (motorNoLoadVoltage - motorNoLoadCurrent * motorResistance);
        $Po = $v->motorCurrentNoLoad * ($v->motorNoLoadVoltage - $v->motorCurrentNoLoad * $v->motorResistance);

        // var Fdreh = motorKv * (motorNoLoadVoltage - motorNoLoadCurrent * motorResistance) * motorMagPoles / 120;
        $Fdreh = $v->motorKv * ($v->motorNoLoadVoltage - $v->motorCurrentNoLoad * $v->motorResistance) * $v->motorMagPoles / 120;

        // var FELossPerKg = 0.000000164668 * Math.pow(Fdreh, 3) - 0.0000646501 * Math.pow(Fdreh, 2) + 0.127483 * Fdreh - 1.94292;
        $FELossPerKg = 0.000000164668 * pow($Fdreh, 3) - 0.0000646501 * pow($Fdreh, 2) + 0.127483 * $Fdreh - 1.94292;

        // var NF = FELossPerKg / Po;
        $NF = $FELossPerKg / $Po;

        // Fdreh = motorKv * (d - x * motorResistance) * motorMagPoles / 120;
        $Fdreh = $v->motorKv * ($d - $x * $v->motorResistance) * $v->motorMagPoles / 120;

        // var FELossEst = (0.000000164668 * Math.pow(Fdreh, 3) - 0.0000646501 * Math.pow(Fdreh, 2) + 0.127483 * Fdreh - 1.94292) / NF;
        $FELossEst = (0.000000164668 * pow($Fdreh, 3) - 0.0000646501 * pow($Fdreh, 2) + 0.127483 * $Fdreh - 1.94292) / $NF;

        // var IoLoss = FELossEst / (d - x * motorResistance);
        $IoLoss = $FELossEst / ($d - $x * $v->motorResistance);

        if ($d < $v->motorNoLoadVoltage) {
            // Im = motorNoLoadCurrent / motorNoLoadVoltage * (d - motorNoLoadVoltage);
            $Im = $v->motorCurrentNoLoad / $v->motorNoLoadVoltage * ($d - $v->motorNoLoadVoltage);
        } else {
            // var Ife = motorNoLoadCurrent * motorNoLoadVoltage / d;
            $Ife = $v->motorCurrentNoLoad * $v->motorNoLoadVoltage / $d;
            // Im = Math.sqrt(Math.pow(motorNoLoadCurrent, 2) - Math.pow(Ife, 2));
            $Im = sqrt(pow($v->motorCurrentNoLoad, 2) - pow($Ife, 2));
        }

        // var ILossTotal = 0.45 * motorNoLoadCurrent + 0.55 * IoLoss;
        $ILossTotal = 0.45 * $v->motorCurrentNoLoad + 0.55 * $IoLoss;

        $ILossNotLinear = 1;

//        if ((motorLimitType == 'W') && (motorLimitValue > 0) && (x > (motorLimitValue / batteryVoltPerCell / batterySerial))) {
//            ILossNotLinear = (x * batteryVoltPerCell * batterySerial) / (motorLimitValue);
//        }
//        if ((motorLimitType == 'A') && (motorLimitValue > 0) && (x > motorLimitValue)) {
//            ILossNotLinear = x / motorLimitValue;
//        }

        if ($v->motorLimitType == 'W' && $v->motorLimitValue > 0
            && ($x > ($v->motorLimitValue / $v->batteryVoltPerCell / $v->batterySerialCount))) {
            // ILossNotLinear = (x * batteryVoltPerCell * batterySerial) / (motorLimitValue);
            $ILossNotLinear = ($x * $v->batteryVoltPerCell * $v->batterySerialCount) / ($v->motorLimitValue);
        }
        if (($v->motorLimitType == 'A') && ($v->motorLimitValue > 0) && ($x > $v->motorLimitValue)) {
            $ILossNotLinear = $x / $v->motorLimitValue;
        }

        return (pow($ILossNotLinear, 0.4 * $ILossNotLinear * $ILossNotLinear) * ($ILossTotal));
    }

    /**
     * Расчет
     *
     * @return CopterCalcResult
     */
    public function calculate()
    {
        $result = new CopterCalcResult();
        $v = $this->data;

        // var TempFELoss = (batteryChargeState * batteryVoltPerCell * batterySerial * motorNoLoadCurrent);
        $TempFELoss = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount * $v->motorCurrentNoLoad);

        // var TempIMaxEff = round(Math.sqrt(TempFELoss / motorResistance), 2);
        $TempIMaxEff = round(sqrt($TempFELoss / $v->motorResistance), 2);

        /*
            var TempVoltsToMotorMaxEff = (batteryChargeState * batteryVoltPerCell * batterySerial)
            - ((batteryResistance * batterySerial / batteryParallel * numRotors * TempIMaxEff)
            + (escResistance * TempIMaxEff));
         */
        $TempVoltsToMotorMaxEff = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $TempIMaxEff)
                + ($v->escResistance * $TempIMaxEff));


        // var TempIoEstimate = GetIo(TempVoltsToMotorMaxEff, TempIMaxEff);
        $TempIoEstimate = $this->getIo($TempVoltsToMotorMaxEff, $TempIMaxEff);

        // var FELoss = TempVoltsToMotorMaxEff * TempIoEstimate;
        $FELoss = $TempVoltsToMotorMaxEff * $TempIoEstimate;

        // var IMaxEff = round(Math.sqrt(FELoss / motorResistance), 2);
        $IMaxEff = round(sqrt($FELoss / $v->motorResistance), 2);

        //var VoltsToMotorMaxEff = (batteryChargeState * batteryVoltPerCell * batterySerial)
        // - ((batteryResistance * batterySerial / batteryParallel * numRotors * IMaxEff) + (escResistance * IMaxEff));
        $VoltsToMotorMaxEff = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $IMaxEff)
                + ($v->escResistance * $IMaxEff));

        // var IoEstimate = GetIo(VoltsToMotorMaxEff, IMaxEff);
        $IoEstimate = $this->getIo($VoltsToMotorMaxEff, $IMaxEff);

        // var WInMaxEff = round(VoltsToMotorMaxEff * IMaxEff, 2);
        $WInMaxEff = round($VoltsToMotorMaxEff * $IMaxEff, 2);

        // var WOutMaxEff = round((VoltsToMotorMaxEff - motorResistance * IMaxEff) * (IMaxEff - IoEstimate), 2);
        $WOutMaxEff = round(($VoltsToMotorMaxEff - $v->motorResistance * $IMaxEff) * ($IMaxEff - $IoEstimate), 2);

        // var PctMaxEff = round((WOutMaxEff / WInMaxEff) * 100, 1);
        $PctMaxEff = round(($WOutMaxEff / $WInMaxEff) * 100, 1);

        // Optimal Efficiency Current
        $outIEff = $IMaxEff;
        if ($v->escCurrentContinuous < $outIEff) {
            $result->addWarning(_t('copter', 'Continuos current per motor {cur}A is more than ESC current', array(
                '{cur}' => $outIEff,
            )));
        }

        //var outVEff = round(VoltsToMotorMaxEff, 2);
        $outVEff = round($VoltsToMotorMaxEff, 2);
        // var outRPMEff = round(motorKv * (VoltsToMotorMaxEff - (IMaxEff * motorResistance)), 0);
        $outRPMEff = round($v->motorKv * ($VoltsToMotorMaxEff - ($IMaxEff * $v->motorResistance)), 0);

        // var batteryTotalWeight = round(batteryWeightPerCell * batterySerial * batteryParallel, 3);
        $batteryTotalWeight = round($v->batteryWeightPerCell * $v->batterySerialCount * $v->batteryParallelCount, 3);

        // var outPowersys = round(((numRotors * motorWeight) + (numRotors * escWeight) + (batteryTotalWeight)) * 1.1, 2);
        $outPowersys = round((($v->getNumRotors() * $v->motorWeight) + ($v->getNumRotors() * $v->escWeight)
            + ($batteryTotalWeight)) * 1.1, 2);

        $result->totalDriveWeight = $outPowersys;
        /*var outAUW;
        if (isWeightIncludeDrive) {
            outAUW = baseWeight;
        } else {
            outAUW = baseWeight + outPowersys;
        }*/
        if ($v->isWeightIncludeDrive) {
            $outAUW = $v->totalWeight;
        } else {
            $outAUW = $v->totalWeight + $outPowersys;
        }
        $result->totalWeight = $outAUW;

        // var effdiameter = propDiameter * Math.pow(propBladesCount / 2, 0.2);
        $effdiameter = $v->propDiametr * pow($v->propBladesCount / 2, 0.2);

        // effpitch = Math.tan(2 * Math.PI / 360 * (Math.atan(propPitch / Math.PI / propDiameter / 0.75) * 360 / 2 / Math.PI + propTwist))
        // * 0.75 * Math.PI * propDiameter;
        $effpitch = tan(2 * pi() / 360 * (atan($v->propPitch / PI() / $v->propDiametr / 0.75) * 360 / 2 / pi() + $v->propTwist))
            * 0.75 * pi() * $v->propDiametr;

        if ($effpitch < 0) {
            $result->addWarning(_t('copter', 'Your propeller values (Twist and Pitch) resulting in a negative propeller pitch'));
        }
        if (($effpitch > 0) && (($effpitch / $effdiameter) > 0.665)) {
            $result->addWarning(_t('copter', 'Prop will stall, calculation for hovering not possible! (reduce Pitch)'));
        }

        // var outEffDiameter = round(effdiameter, 2);
        $outEffDiameter = round($effdiameter, 2);



        // CalcPropMotorCurrent ----------------------------------------------------------------------------------------

        $VoltsToMotor = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $v->motorCurrentNoLoad)
                + ($v->escResistance * $v->motorCurrentNoLoad));

        if ($effdiameter <= 0 || $effpitch <= 0) {
            $Imotor = $this->getIo($VoltsToMotor, $v->motorCurrentNoLoad);
        } else {
            // var tempg = propConst * Math.pow(effdiameter, 4) * effpitch * (Math.pow(12, - 5) * 1E-9) * Math.pow((motorKv / propGearRatio), 3);
            $tempg = $v->propConst * pow($effdiameter, 4) * $effpitch * (pow(12, - 5) * 1E-9) * pow(($v->motorKv / $v->propGearRatio), 3);
            // var tempr = (batteryResistance * batterySerial / batteryParallel * numRotors) + escResistance + motorResistance;
            $tempr = ($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors())
                + $v->escResistance + $v->motorResistance;
            // var Vbatt = batteryChargeState * batteryVoltPerCell * batterySerial;
            $Vbatt = $v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount;
            //var _IoEstimate = GetIo(outVEff, outIEff);
            $_IoEstimate = $this->getIo($outVEff, $outIEff);

            //var tempb = (-2 * tempr * Vbatt - 1 / tempg) / (tempr * tempr);
            $tempb = (-2 * $tempr * $Vbatt - 1 / $tempg) / ($tempr * $tempr);
            //var tempc = (Math.pow(Vbatt, 2) + _IoEstimate / tempg) / (tempr * tempr);
            $tempc = (pow($Vbatt, 2) + $_IoEstimate / $tempg) / ($tempr * $tempr);

            if ($tempb * $tempb / 4 > $tempc) {
                $tempz = sqrt(pow($tempb, 2) / 4 - $tempc);
                $tempi1 = -$tempb / 2 + $tempz;
                $tempi2 = -$tempb / 2 - $tempz;
                if ($tempi2 > 0) {
                    $Imotor = $tempi2;
                } else {
                    $Imotor = $tempi1;
                }
            } else {
                $Imotor = 0;
            }
        }

        // var airdensity = 100 * airPressure * Math.pow((1 - (0.0065 * elevation / 288.15)), 5.255) / 287.05 / (airTemp + 273.15);
        $airPressure = Y::param('formula.copter.airPressure');
        $elevation   = Y::param('formula.copter.elevation');
        $airTemp     = Y::param('formula.copter.airTemp');
        $stdAirdensity = Y::param('formula.copter.stdAirdensity');


        $airdensity = 100 * $airPressure * pow((1 - (0.0065 * $elevation / 288.15)), 5.255) / 287.05 / ($airTemp + 273.15);

        if (($Imotor / $stdAirdensity * $airdensity) > $this->getIo($VoltsToMotor, $v->motorCurrentNoLoad)) {
            $Imotor = $Imotor / $stdAirdensity * $airdensity;
        }

        // max. Current per motor
        $outImotor = round($Imotor, 2);
        if ($v->escCurrentMax < $outImotor) {
            $result->addWarning(_t('copter', 'Max current per motor {cur}A is more than ESC current', array(
                '{cur}' => $outImotor,
            )));
        }

        // var outImotorTot = round(Imotor * numRotors, 2); // A maximum
        $outImotorTot = round($Imotor * $v->getNumRotors(), 2);
        $result->totalCurrentMax = $outImotorTot;

        // var outMaxC = round((Imotor / batteryCapacity * 1000 * numRotors), 1); // Battery max. Load
        $outMaxC = round(($Imotor / ($v->batteryCapacity  * $v->batteryParallelCount) * 1000 * $v->getNumRotors()), 1);
        $result->maxBatteryLoad = $outMaxC;

        if (($v->motorLimitType == 'A') && ($v->motorLimitValue) && ($outImotor > $v->motorLimitValue)) {
            $result->addWarning(_t('copter', 'max. current over the limit of the motor. Please verify the limits (current, power, rpm) defined by the manufacturer!'));
            // max. current over the limit of the motor. Please verify the limits (current, power, rpm) defined by the manufacturer!
        }

        // var WattsIn = round(VoltsToMotor * outImotor, 2);
        $WattsIn = round($VoltsToMotor * $outImotor, 2);
        if (($v->motorLimitType == 'W') && ($v->motorLimitValue > 0) && ($WattsIn > $v->motorLimitValue)) {
            $result->addWarning(_t('copter', 'Max. power over the limit of the motor. Please check the limits!'));
        }

        if ($outMaxC > $v->batteryBurstC) {
            $result->addWarning(_t('copter', 'max. current over the limit of the battery'));
            // max. current over the limit of the battery
        }

        // Battery Voltage
        // var outPackV = batteryVoltPerCell * batterySerial;
        $outPackV = $v->batteryVoltPerCell * $v->batterySerialCount;
        //var outPackVeff = round((batteryChargeState * outPackV) - (Imotor * batteryResistance * batterySerial / batteryParallel * numRotors), 2);
        $outPackVeff = round(($v->batteryChargeState * $outPackV)
            - ($Imotor * $v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors()), 2);

        // var outDuration = round(((batteryCapacity / 1000) / Imotor / numRotors) * 60, 2);
        if ($Imotor == 0) {
            $result->addWarning(_t('copter', 'Your Setup is unrealistic and way out of Limits'));
            return $result;
        }

        $outDuration = round(((($v->batteryCapacity * $v->batteryParallelCount )/ 1000) / $Imotor / $v->getNumRotors()) * 60, 2);

        // CalcMotorValues ---------------------------------------------------------------------------------------------

        // var VoltsToMotor = (batteryChargeState * batteryVoltPerCell * batterySerial)
        // - ((batteryResistance * batterySerial / batteryParallel * numRotors * outImotor)
        // + (escResistance * outImotor));
        $VoltsToMotor = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $outImotor)
            + ($v->escResistance * $outImotor));



        // var MotorRPM = motorKv * (VoltsToMotor - (outImotor * motorResistance));
        $MotorRPM = $v->motorKv * ($VoltsToMotor - ($outImotor * $v->motorResistance));

        //var IoEstimate = GetIo(VoltsToMotor, outImotor);
        $IoEstimate = $this->getIo($VoltsToMotor, $outImotor);


        // var WattsOut = round((VoltsToMotor - motorResistance * outImotor) * (outImotor - IoEstimate), 2);
        $WattsOut = round(($VoltsToMotor - $v->motorResistance * $outImotor) * ($outImotor - $IoEstimate), 2);

        // var PctEff = round((WattsOut / WattsIn) * 100, 1);
        $PctEff = round(($WattsOut / $WattsIn) * 100, 1);

        // var Pin = outImotor * batteryChargeState * outPackV;
        $Pin = $outImotor * $v->batteryChargeState * $outPackV;

        // var Pout = WattsOut;
        $Pout = $WattsOut;

        // var TotEff = Pout / Pin;
        $TotEff = $Pout / $Pin;

        // var outVmotor = round(VoltsToMotor, 2);
        $outVmotor = round($VoltsToMotor, 2);

        // var outWin = WattsIn;
        $outWin = $WattsIn;

        $outWout = $WattsOut;
        $outPctEff = $PctEff;

        // var outRPM = round(MotorRPM, 0);
        $outRPM = round($MotorRPM, 0);

        //var outPin = round(Pin * numRotors, 2);
        $outPin = round($Pin * $v->getNumRotors(), 2);

        //var outPout = round(Pout * numRotors, 2);
        $outPout = round($Pout * $v->getNumRotors(), 2);

        // var outTotEff = round((TotEff * 100), 1);
        $outTotEff = round(($TotEff * 100), 1);

        // var effdiameter = outEffDiameter;
        $effdiameter = $outEffDiameter;

        if ($v->propGearRatio <= 0) {
            $v->propGearRatio = 1;
        }

        // var proprpm = MotorRPM / propGearRatio;
        $proprpm = $MotorRPM / $v->propGearRatio;
        if ($v->propMaxRpmConst > 0) {
            $propMaxRpm = $v->propMaxRpmConst / $v->propDiametr;
            if ($proprpm > $propMaxRpm) {
                $p = Y::nf()->formatDecimal(round($proprpm, 0));
                $pm = Y::nf()->formatDecimal(round($propMaxRpm, 0));
//                $p = round($proprpm, 0);
//                $pm = round($propMaxRpm, 0);
                $result->addWarning(_t('copter', "Prop RPM limit is {pm}, motor max RPM is {p}. Please, be careful", array(
                    '{pm}' => $pm,
                    '{p}'  => $p,
                )));
            }
        }


        // var Propwatts = propConst * Math.pow(effdiameter / 12, 4) * (effpitch / 12) * Math.pow(proprpm / 1000, 3);
        $Propwatts = $v->propConst * pow($effdiameter / 12, 4) * ($effpitch / 12) * pow($proprpm / 1000, 3);

        // var HP = Propwatts / 745.699871582;
        $HP = $Propwatts / 745.699871582;

        //var Pitchspeed = proprpm * effpitch / 1056;
        $Pitchspeed = $proprpm * $effpitch / 1056;

        //var ThrustatSpeed = 16 * 375 * Propwatts / (746 * Pitchspeed);
        $ThrustatSpeed = 16 * 375 * $Propwatts / (746 * $Pitchspeed);

        //var Tgrams = effpitch * Math.pow(effdiameter, 3) * Math.pow(proprpm / 1000, 2) * 28.3 * 0.981 / 10000;
        $Tgrams = $effpitch * pow($effdiameter, 3) * pow($proprpm / 1000, 2) * 28.3 * 0.981 / 10000;

        // var Tkg = Tgrams / 1000;
        $Tkg = $Tgrams / 1000;

        // var Tn = Tkg * 9.80665;
        $Tn = $Tkg * 9.80665;

        // var Tlbs = Tn / 4.44822161526;
        $Tlbs = $Tn / 4.44822161526;

        //var StaticToz = Tlbs * 16;
        $StaticToz = $Tlbs * 16;

        if (($effpitch > 0) && (($effpitch / $effdiameter) > 0.665)) {} else {}

        // var motorTemp = airTemp + (outWin - outWout) * 2.718 * motorCooling / 6.283186 / (motorLength / 1000) / (-0.024 * (273.15 + airTemp) + 65.552);
        $motorCooling = Y::param('formula.copter.motorCooling');
        $motorTemp = $airTemp + ($outWin - $outWout) * 2.718 * $motorCooling / 6.283186 / ($v->motorLength / 1000)
            / (-0.024 * (273.15 + $airTemp) + 65.552);

        if ($motorTemp > 80) {
            $result->addWarning(_t('copter', 'the prediction of the motor case temperature is critical (>80C). Please check!'));
        }

        // calcHover ---------------------------------------------------------------------------------------------------

        //var TheAUW = outAUW * 0.001;
        $TheAUW = $outAUW * 0.001;

        // var e = Math.pow(propConst, 0.33333)
        //      * Math.sqrt(2 *  Math.pow(TheAUW / numRotors, 3)
        //      * Math.pow(9.81, 3) / airdensity / Math.pow(0.001 * 25.4 * effdiameter / 2, 2) / Math.PI) / wGrad;

        $wGrad = Y::param('formula.copter.wGrad');
        $e = pow($v->propConst, 0.33333)
            * sqrt(2 * pow($TheAUW / $v->getNumRotors(), 3)
            * pow(9.81, 3) / $airdensity / pow(0.001 * 25.4 * $effdiameter / 2, 2) / pi()) / $wGrad;

        // var a = -1 * motorNoLoadCurrent * motorResistance - outVEff;
        $a = -1 * $v->motorCurrentNoLoad * $v->motorResistance - $outVEff;

        //var c = e + motorNoLoadCurrent * outVEff;
        $c = $e + $v->motorCurrentNoLoad * $outVEff;

        // var I1 = (-a + Math.sqrt(a * a - 4 * motorResistance * c)) / 2 / motorResistance;
        $I1 = (-$a + sqrt($a * $a - 4 * $v->motorResistance * $c)) / 2 / $v->motorResistance;

        //var I2 = (-a - Math.sqrt(a * a - 4 * motorResistance * c)) / 2 / motorResistance;
        $I2 = (-$a - sqrt($a * $a - 4 * $v->motorResistance * $c)) / 2 / $v->motorResistance;

        $x = 0;
        if (($I1 > 0) && ($I1 < $outImotor)) {
            $x = $I1;
        }
        if (($I2 > 0) && ($I2 < $outImotor)) {
            $x = $I2;
        }

        /*var d = (batteryChargeState * batteryVoltPerCell * batterySerial) - ((batteryResistance * batterySerial / batteryParallel * numRotors * x)
        + (escResistance * x));*/

        $d = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $x)
            + ($v->escResistance * $x));

        //var IoEst = GetIo(d, x);
        $IoEst = $this->getIo($d, $x);

        // a = -IoEst * motorResistance - d;
        $a = -$IoEst * $v->motorResistance - $d;
        $c = $e + $IoEst * $d;

        // I1 = (-a + Math['sqrt'](a * a - 4 * motorResistance * c)) / 2 / motorResistance;
        $I1 = (-$a + sqrt($a * $a - 4 * $v->motorResistance * $c)) / 2 / $v->motorResistance;
        $I2 = (-$a - sqrt($a * $a - 4 * $v->motorResistance * $c)) / 2 / $v->motorResistance;

        if (($I1 > 0) && ($I1 < $outImotor)) {
            $x = $I1;
        }
        if (($I2 > 0) && ($I2 < $outImotor)) {
            $x = $I2;
        }

        $d = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $x)
            + ($v->escResistance * $x));

        // var ImaxAUW = (1 - Math.sqrt(1 - 0.8)) * outImotor;
        $ImaxAUW = (1 - sqrt(1 - 0.8)) * $outImotor;

        // var VoltmaxAUW = (batteryChargeState * batteryVoltPerCell * batterySerial)
        //  - ((batteryResistance * batterySerial / batteryParallel * numRotors * ImaxAUW) + (escResistance * ImaxAUW));
        $VoltmaxAUW = ($v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount)
            - (($v->batteryResistance * $v->batterySerialCount / $v->batteryParallelCount * $v->getNumRotors() * $ImaxAUW)
                + ($v->escResistance * $ImaxAUW));

        // var WirkungsgradMotor = 0.01 * outPctEff;
        $WirkungsgradMotor = 0.01 * $outPctEff;

        //var maxAUW = numRotors * Math.pow((Math.PI * airdensity * Math.pow(ImaxAUW * VoltmaxAUW * WirkungsgradMotor / Math.pow(propConst, 0.33333) * wGrad, 2)
        //    * Math.pow(0.001 * 25.4 * effdiameter / 2, 2) / 2 / Math.pow(9.81, 3)), 0.33333333);

        $maxAUW = $v->getNumRotors() * pow((pi() * $airdensity * pow($ImaxAUW * $VoltmaxAUW * $WirkungsgradMotor / pow($v->propConst, 0.33333) * $wGrad, 2)
                    * pow(0.001 * 25.4 * $effdiameter / 2, 2) / 2 / pow(9.81, 3)), 0.33333333);

        if (($e <= ($outWout)) && (($effpitch / $effdiameter) < 0.666)) {
            //var outIhover = round(x, 2);
            $outIhover = round($x, 2);

            // var outVhover = round(d, 2);
            $outVhover = round($d, 2);

            // var outThrottle = round((1 - Math.pow(1 - x / outImotor, 2)) * 100, 0);
            $outThrottle = round((1 - pow(1 - $x / $outImotor, 2)) * 100, 0);
            $result->throttle = $outThrottle;

            // var outWinhover = round(x * d, 2);
            $outWinhover = round($x * $d, 2);

            //var outWouthover = round(e, 2);
            $outWouthover = round($e, 2);

            // var outPctEffhover = round(e / x / d * 100, 1);
            $outPctEffhover = round($e / $x / $d * 100, 1);

            // var outDurationMix = round(((batteryCapacity / 1000) * 0.85 / numRotors / x * 60), 2);
            $outDurationMix = round(((($v->batteryCapacity * $v->batteryParallelCount) / 1000) * 0.85 / $v->getNumRotors() / $x * 60), 2);
            $result->flightTimeHover = $outDurationMix;
            $result->flightTimeMin = $outDuration;

            // var outIhoverTot = round(x * numRotors, 2);
            $outIhoverTot = round($x * $v->getNumRotors(), 2);
            $result->totalCurrentHover = $outIhoverTot;

            //var outPayload = round(1000 * (maxAUW - TheAUW), 0);
            $outPayload = round(1000 * ($maxAUW - $TheAUW), 0);
            $result->addPayload = $outPayload;

            // var outPayloadImp = round(1 / 28.35 * outPayload, 2);
            $outPayloadImp = round(1 / 28.35 * $outPayload, 2);

            // var outhoverPin = round(x * batteryChargeState * batteryVoltPerCell * batterySerial * numRotors, 2);
            $outhoverPin = round($x * $v->batteryChargeState * $v->batteryVoltPerCell * $v->batterySerialCount * $v->getNumRotors(), 2);

            // var outhoverPout = round(e * numRotors, 2);
            $outhoverPout = round($e * $v->getNumRotors(), 2);

            // var outhoverTotEff = round((100 * outhoverPout / outhoverPin), 1);
            $outhoverTotEff = round((100 * $outhoverPout / $outhoverPin), 1);

            if ($outThrottle > 80) {
                $result->addWarning(_t('copter', 'For good maneuverability you need Throttle of less than 80%'));
                // For good maneuverability you need Throttle of less than 80%
            }
        } else {
            $result->flightTimeMin = '';
            $result->flightTimeHover = '';
            $result->addPayload = '';
            $result->totalCurrentHover = '';
            $result->totalCurrentMax = '';
            $result->maxBatteryLoad = '';

            $result->addWarning(_t('copter', 'The Power is not sufficient to hover'));
        }

        return $result;
    }
}
