<?php

class TestController extends BaseController
{
    public function actionCalc()
    {
        $p = new CopterCalcModel;
        $p->copterTypeId = 4;
        $p->totalWeight = 500;
        $p->isWeightIncludeDrive = true;

        $p->motorKv = 1100;
        $p->motorWeight = 67;
        $p->motorResistance = 0.45;
        $p->motorLimitType = 'A';
        $p->motorLimitValue = 210;
        $p->motorCurrentNoLoad = 0.8;
        $p->motorNoLoadVoltage = 8;
        $p->motorMagPoles = 10;
        $p->motorLength = 35;

        $p->escCurrentContinuous = 10;
        $p->escCurrentMax = 10;
        $p->escWeight = 13;
        $p->escResistance = 0.015;

        $p->batterySerialCount = 3;
        $p->batteryParallelCount = 1;
        $p->batteryCapacity = 2500;
        $p->batteryVoltPerCell = 3.7;
        $p->batteryWeightPerCell = 66;
        $p->batteryResistance = 0.009;
        $p->batteryChargeState = 1;
        $p->batteryBurstC = 70;

        $p->propDiametr = 8;
        $p->propPitch = 3.8;
        $p->propBladesCount = 2;
        $p->propTwist = 0;
        $p->propConst = 1.11;
        $p->propGearRatio = 1;


        $formula = new CopterCalcFormula($p);
        $res = $formula->calculate();
        dd($res);
    }
}
