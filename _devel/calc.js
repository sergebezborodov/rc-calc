function round(a, b) {
    return (Math['round'](a * Math['pow'](10, b)) / Math['pow'](10, b));
}

var stdAirdensity = 101325 / 287.05 / 288.15;
var motorCooling = 1;
/*
 1 - excellent
 1.75 - good
 2.5 - medium
 3.5 - poor
 5.5 - very poor
 */

var numRotors = 4,
    baseWeight = 500,
    isWeightIncludeDrive = true,

    airPressure = 1013,
    elevation = 500,
    airTemp = 25,
    wGrad = 1,

    motorKv = 1100,
    motorWeight = 67,
    motorResistance = 0.45,
    motorLimitType = 'W',
    motorLimitValue = 210,
    motorNoLoadCurrent = 0.8,
    motorNoLoadVoltage = 8,
    motorMagPoles = 10,
    motorLength = 35,

    escCurrent = 10,
    escMaxCurrent = 10,
    escWeight = 13,
    escResistance = 0.015,

    batterySerial = 3,
    batteryParallel = 1,
    batteryCapacity = 2500,
    batteryVoltPerCell = 3.7,
    batteryWeightPerCell = 66,
    batteryResistance = 0.009,
    batteryChargeState = 1,
    batteryCellMaxC = 70,

    propDiameter = 8,
    propPitch = 3.8,
    propBladesCount = 2,
    propTwist = 0,
    propConst = 1.11,
    propGearRatio = 1;

function GetIo(d, x) {

    //Po = 1 * outIo['value'] * (1 * outUIo['value'] - 1 * 1 * outIo['value'] * outRm['value']);
    var Po = motorNoLoadCurrent * (motorNoLoadVoltage - motorNoLoadCurrent * motorResistance);
    //Fdreh = 1 * outKv['value'] * (1 * outUIo['value'] - 1 * outIo['value'] * outRm['value']) * outPols['value'] / 120;
    var Fdreh = motorKv * (motorNoLoadVoltage - motorNoLoadCurrent * motorResistance) * motorMagPoles / 120;
    //FELossPerKg = 0.000000164668 * Math['pow'](Fdreh, 3) - 0.0000646501 * Math['pow'](Fdreh, 2) + 0.127483 * Fdreh - 1.94292;
    var FELossPerKg = 0.000000164668 * Math.pow(Fdreh, 3) - 0.0000646501 * Math.pow(Fdreh, 2) + 0.127483 * Fdreh - 1.94292;
    //NF = FELossPerKg / Po;
    var NF = FELossPerKg / Po;
    //Fdreh = 1 * outKv['value'] * (d - x * outRm['value']) * outPols['value'] / 120;
    Fdreh = motorKv * (d - x * motorResistance) * motorMagPoles / 120;
    //FELossEst = (0.000000164668 * Math['pow'](Fdreh, 3) - 0.0000646501 * Math['pow'](Fdreh, 2) + 0.127483 * Fdreh - 1.94292) / NF;
    var FELossEst = (0.000000164668 * Math.pow(Fdreh, 3) - 0.0000646501 * Math.pow(Fdreh, 2) + 0.127483 * Fdreh - 1.94292) / NF;
    //IoLoss = FELossEst / (d - x * outRm['value']);
    var IoLoss = FELossEst / (d - x * motorResistance);

//        if (d < 1 * outUIo['value']) {
//            Im = 1 * outIo['value'] / outUIo['value'] * (d - 1 * outUIo['value']);
//        } else {
//            Ife = 1 * outIo['value'] * outUIo['value'] / d;
//            Im = Math['sqrt'](Math['pow'](1 * outIo['value'], 2) - Math['pow'](Ife, 2));
//        };
    var Im;
    if (d < motorNoLoadVoltage) {
        Im = motorNoLoadCurrent / motorNoLoadVoltage * (d - motorNoLoadVoltage);
    } else {
        var Ife = motorNoLoadCurrent * motorNoLoadVoltage / d;
        Im = Math.sqrt(Math.pow(motorNoLoadCurrent, 2) - Math.pow(Ife, 2));
    }

    //ILossTotal = 0.45 * outIo['value'] + 0.55 * IoLoss;
    var ILossTotal = 0.45 * motorNoLoadCurrent + 0.55 * IoLoss;
    // ILossNotLinear = 1;
    var ILossNotLinear = 1;


//        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'W') && (outLimit['value'] != '') && (x > (1 * outLimit['value'] / Vcell['value'] / numcells['value']))) {
//            ILossNotLinear = (x * Vcell['value'] * numcells['value']) / (1 * outLimit['value']);
//        };
//        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'A') && (outLimit['value'] != '') && (x > 1 * outLimit['value'])) {
//            ILossNotLinear = x / (1 * outLimit['value']);
//        };
    if ((motorLimitType == 'W') && (motorLimitValue > 0) && (x > (motorLimitValue / batteryVoltPerCell / batterySerial))) {
        ILossNotLinear = (x * batteryVoltPerCell * batterySerial) / (motorLimitValue);
    }
    if ((motorLimitType == 'A') && (motorLimitValue > 0) && (x > motorLimitValue)) {
        ILossNotLinear = x / motorLimitValue;
    }

    return (Math.pow(ILossNotLinear, 0.4 * ILossNotLinear * ILossNotLinear) * (ILossTotal));
}


var TempFELoss = (batteryChargeState * batteryVoltPerCell * batterySerial * motorNoLoadCurrent);
console.log('TempFELoss:' + TempFELoss);

var TempIMaxEff = round(Math.sqrt(TempFELoss / motorResistance), 2);
console.log('TempIMaxEff:' + TempIMaxEff);

var TempVoltsToMotorMaxEff = (batteryChargeState * batteryVoltPerCell * batterySerial)
    - ((batteryResistance * batterySerial / batteryParallel * numRotors * TempIMaxEff)
        + (escResistance * TempIMaxEff));
console.log('TempVoltsToMotorMaxEff: ' + TempVoltsToMotorMaxEff);

var TempIoEstimate = GetIo(TempVoltsToMotorMaxEff, TempIMaxEff);
console.log('TempIoEstimate: ' + TempIoEstimate);

var FELoss = TempVoltsToMotorMaxEff * TempIoEstimate;
console.log('FELoss: ' + FELoss);

var IMaxEff = round(Math.sqrt(FELoss / motorResistance), 2);
console.log('IMaxEff: ' + IMaxEff);

var VoltsToMotorMaxEff = (batteryChargeState * batteryVoltPerCell * batterySerial)
    - ((batteryResistance * batterySerial / batteryParallel * numRotors * IMaxEff) + (escResistance * IMaxEff));
console.log('VoltsToMotorMaxEff: ' + VoltsToMotorMaxEff);

var IoEstimate = GetIo(VoltsToMotorMaxEff, IMaxEff);
console.log('IoEstimate: ' + IoEstimate);

var WInMaxEff = round(VoltsToMotorMaxEff * IMaxEff, 2);
console.log('WInMaxEff: ' + WInMaxEff);

var WOutMaxEff = round((VoltsToMotorMaxEff - motorResistance * IMaxEff) * (IMaxEff - IoEstimate), 2);
console.log('WOutMaxEff: ' + WOutMaxEff);

var PctMaxEff = round((WOutMaxEff / WInMaxEff) * 100, 1);
console.log('PctMaxEff: ' + PctMaxEff);


var outIEff = IMaxEff;
var outVEff = round(VoltsToMotorMaxEff, 2);
var outRPMEff = round(motorKv * (VoltsToMotorMaxEff - (IMaxEff * motorResistance)), 0);
console.log('outRPMEff: ' + outRPMEff);

var batteryTotalWeight = round(batteryWeightPerCell * batterySerial * batteryParallel, 3);
console.log('batteryTotalWeight: ' + batteryTotalWeight);
var outPowersys = round(((numRotors * motorWeight) + (numRotors * escWeight) + (batteryTotalWeight)) * 1.1, 2);
console.log('outPowersys: ' + outPowersys);

var outAUW;
if (isWeightIncludeDrive) {
    outAUW = baseWeight;
} else {
    outAUW = baseWeight + outPowersys;
}

var effdiameter = propDiameter * Math.pow(propBladesCount / 2, 0.2);
console.log('effdiameter: ' + effdiameter);
effpitch = Math.tan(2 * Math.PI / 360 * (Math.atan(propPitch / Math.PI / propDiameter / 0.75) * 360 / 2 / Math.PI + propTwist))
    * 0.75 * Math.PI * propDiameter;
console.log('effpitch: ' + effpitch);


if (effpitch < 0) {
    // Your propeller values (Twist and Pitch) resulting in a negative propeller pitch
}
if ((effpitch > 0) && ((effpitch / effdiameter) > 0.665)) {
    // Prop will stall, calculation for hovering not possible! (reduce Pitch)
}

var outEffDiameter = round(effdiameter, 2);


// CalcPropMotorCurrent

var VoltsToMotor = (batteryChargeState * batteryVoltPerCell * batterySerial)
    - ((batteryResistance * batterySerial / batteryParallel * numRotors * motorNoLoadCurrent)
    + (escResistance * motorNoLoadCurrent));
console.log('VoltsToMotor: ' + VoltsToMotor);

if (effdiameter <= 0 || effpitch <= 0) {
    Imotor = GetIo(VoltsToMotor, motorNoLoadCurrent);
} else {
    var tempg = propConst * Math.pow(effdiameter, 4) * effpitch * (Math.pow(12, - 5) * 1E-9) * Math.pow((motorKv / propGearRatio), 3);
    console.log('tempg: ' + tempg);
    var tempr = (batteryResistance * batterySerial / batteryParallel * numRotors) + escResistance + motorResistance;
    console.log('tempr: ' + tempr);
    var Vbatt = batteryChargeState * batteryVoltPerCell * batterySerial;
    console.log('Vbatt: ' + Vbatt);
    var _IoEstimate = GetIo(outVEff, outIEff);
    console.log('_IoEstimate: ' + _IoEstimate);
    var tempb = (-2 * tempr * Vbatt - 1 / tempg) / (tempr * tempr);
    console.log('tempb: ' + tempb);
    var tempc = (Math.pow(Vbatt, 2) + _IoEstimate / tempg) / (tempr * tempr);
    console.log('tempc: ' + tempc);

    if (tempb * tempb / 4 > tempc) {
        tempz = Math.sqrt(Math.pow(tempb, 2) / 4 - tempc);
        tempi1 = -tempb / 2 + tempz;
        tempi2 = -tempb / 2 - tempz;
        if (tempi2 > 0) {
            Imotor = tempi2;
        } else {
            Imotor = tempi1;
        }
    } else {
        Imotor = 0;
    }
}

var airdensity = 100 * airPressure * Math.pow((1 - (0.0065 * elevation / 288.15)), 5.255) / 287.05 / (airTemp + 273.15);
if ((Imotor / stdAirdensity * airdensity) > GetIo(VoltsToMotor, motorNoLoadCurrent)) {
    Imotor = Imotor / stdAirdensity * airdensity;
}
console.log('------ outImotor: ' + Imotor);


var outImotor = round(Imotor, 2); // max. Current
var outImotorTot = round(Imotor * numRotors, 2); // A maximum
var outMaxC = round((Imotor / batteryCapacity * 1000 * numRotors), 1); // Battery max. Load

if ((motorLimitType == 'A') && (motorLimitValue) && (outImotor > motorLimitValue)) {
    // max. current over the limit of the motor. Please verify the limits (current, power, rpm) defined by the manufacturer!
}
if (outMaxC > batteryCellMaxC) {
    // max. current over the limit of the battery
}
console.log('----------outMaxC: ' + outMaxC);

// Battery Voltage
var outPackV = batteryVoltPerCell * batterySerial;
var outPackVeff = round((batteryChargeState * outPackV) - (Imotor * batteryResistance * batterySerial / batteryParallel * numRotors), 2);
console.log('outPackVeff: ' + outPackVeff);

var outDuration = round(((batteryCapacity / 1000) / Imotor / numRotors) * 60, 2);
console.log('outDuration: ' + outDuration);


// CalcMotorValues
var outPctEff, outWout;
(function CalcMotorValues() {

    var VoltsToMotor = (batteryChargeState * batteryVoltPerCell * batterySerial) - ((batteryResistance * batterySerial / batteryParallel * numRotors * outImotor)
        + (escResistance * outImotor));
console.log('-------VoltsToMotor:' + VoltsToMotor);
    var MotorRPM = motorKv * (VoltsToMotor - (outImotor * motorResistance));
    console.log('MotorRPM: ' + MotorRPM);

    var IoEstimate = GetIo(VoltsToMotor, outImotor);
    console.log('IoEstimate: ' + IoEstimate);

    var WattsIn = round(VoltsToMotor * outImotor, 2);
    console.log('WattsIn: ' + WattsIn);
    var WattsOut = round((VoltsToMotor - motorResistance * outImotor) * (outImotor - IoEstimate), 2);
    console.log('WattsOut: ' + WattsOut);
    var PctEff = round((WattsOut / WattsIn) * 100, 1);
    console.log('PctEff: ' + PctEff);

    var Pin = outImotor * batteryChargeState * outPackV;
    console.log('Pin: ' + Pin);

    var Pout = WattsOut;
    var TotEff = Pout / Pin;
    console.log('TotEff: ' + TotEff);

    var outVmotor = round(VoltsToMotor, 2);
    var outWin = WattsIn;
    outWout = WattsOut;
    outPctEff = PctEff;
    var outRPM = round(MotorRPM, 0);
    var outPin = round(Pin * numRotors, 2);
    var outPout = round(Pout * numRotors, 2);
    var outTotEff = round((TotEff * 100), 1);
    var effdiameter = outEffDiameter;
    if (propGearRatio <= 0) {
        propGearRatio = 1;
    }

    var proprpm = MotorRPM / propGearRatio;
console.log('------proprpm:' + proprpm);
    var Propwatts = propConst * Math.pow(effdiameter / 12, 4) * (effpitch / 12) * Math.pow(proprpm / 1000, 3);
    console.log('Propwatts: ' + Propwatts);

    var HP = Propwatts / 745.699871582;
    var Pitchspeed = proprpm * effpitch / 1056;
    console.log('------Pitchspeed:' + Pitchspeed);
    var ThrustatSpeed = 16 * 375 * Propwatts / (746 * Pitchspeed);
    console.log('ThrustatSpeed: ' + ThrustatSpeed);

    var Tgrams = effpitch * Math.pow(effdiameter, 3) * Math.pow(proprpm / 1000, 2) * 28.3 * 0.981 / 10000;
    console.log('Tgrams: ' + Tgrams);

    var Tkg = Tgrams / 1000;
    var Tn = Tkg * 9.80665;
    var Tlbs = Tn / 4.44822161526;
    var StaticToz = Tlbs * 16;

    if ((effpitch > 0) && ((effpitch / effdiameter) > 0.665)) {

    } else {

    }
    if ((motorLimitType == 'W') && (motorLimitValue > 0) && (WattsIn > motorLimitValue)) {
        // max. power over the limit of the motor. Please check the limits!
    }


    var motorTemp = airTemp + (outWin - outWout) * 2.718 * motorCooling / 6.283186 / (motorLength / 1000) / (-0.024 * (273.15 + airTemp) + 65.552);
    if (motorTemp > 80) {
        // the prediction of the motor case temperature is critical (>80�C/180�F). Please check!
    }
    console.log('motorTemp: ' +  motorTemp);
    calcHover();

//    if ((1 * outPctMaxEff['value'] <= 0) || ((1 * outImotor['value'] > 1 * outIEff['value']) && (1 * outPctEff['value'] < 40))) {
//        outWarning['value'] = msgUnrealsisticSetup;
//    };
})();


function calcHover()
{
    var TheAUW = outAUW * 0.001;
    console.log('TheAUW: ' + TheAUW);
    var e = Math.pow(propConst, 0.33333)
        * Math.sqrt(2 *  Math.pow(TheAUW / numRotors, 3)
        * Math.pow(9.81, 3) / airdensity / Math.pow(0.001 * 25.4 * effdiameter / 2, 2) / Math.PI) / wGrad;

    console.log('e: ' + e);

    var a = -1 * motorNoLoadCurrent * motorResistance - outVEff;
    console.log('a: ' + a);

    var c = e + motorNoLoadCurrent * outVEff;
    console.log('c: ' + c);

    var I1 = (-a + Math.sqrt(a * a - 4 * motorResistance * c)) / 2 / motorResistance;
    console.log('I1: ' + I1);
    var I2 = (-a - Math.sqrt(a * a - 4 * motorResistance * c)) / 2 / motorResistance;
    console.log('I2: ' + I2);

    var x;
    if ((I1 > 0) && (I1 < outImotor)) {
        x = I1;
    }
    if ((I2 > 0) && (I2 < outImotor)) {
        x = I2;
    }
console.log('-------x:' +  x);
    var d = (batteryChargeState * batteryVoltPerCell * batterySerial) - ((batteryResistance * batterySerial / batteryParallel * numRotors * x)
        + (escResistance * x));
    console.log('d: ' + d);

    var IoEst = GetIo(d, x);
    console.log('IoEst: ' + IoEst);
    a = -IoEst * motorResistance - d;
    c = e + IoEst * d;

    I1 = (-a + Math['sqrt'](a * a - 4 * motorResistance * c)) / 2 / motorResistance;
    I2 = (-a - Math['sqrt'](a * a - 4 * motorResistance * c)) / 2 / motorResistance;
    if ((I1 > 0) && (I1 < outImotor)) {
        x = I1;
    }
    if ((I2 > 0) && (I2 < outImotor)) {
        x = I2;
    }
    d = (batteryChargeState * batteryVoltPerCell * batterySerial) - ((batteryResistance * batterySerial / batteryParallel * numRotors * x)
        + (escResistance * x));
    console.log('d: ' + d);

    var ImaxAUW = (1 - Math.sqrt(1 - 0.8)) * outImotor;
    console.log('ImaxAUW: ' + ImaxAUW);

    var VoltmaxAUW = (batteryChargeState * batteryVoltPerCell * batterySerial)
        - ((batteryResistance * batterySerial / batteryParallel * numRotors * ImaxAUW) + (escResistance * ImaxAUW));
    console.log('VoltmaxAUW: ' + VoltmaxAUW);

    var WirkungsgradMotor = 0.01 * outPctEff;
    console.log('WirkungsgradMotor: ' + WirkungsgradMotor);

    var maxAUW = numRotors * Math.pow((Math.PI * airdensity * Math.pow(ImaxAUW * VoltmaxAUW * WirkungsgradMotor / Math.pow(propConst, 0.33333) * wGrad, 2)
        * Math.pow(0.001 * 25.4 * effdiameter / 2, 2) / 2 / Math.pow(9.81, 3)), 0.33333333);
    console.log('maxAUW: ' + maxAUW);

    if ((e <= (outWout)) && ((effpitch / effdiameter) < 0.666)) {
        var outIhover = round(x, 2);
        console.log('outIhover: ' + outIhover);

        var outVhover = round(d, 2);
        console.log('outVhover: ' + outVhover);

        var outThrottle = round((1 - Math.pow(1 - x / outImotor, 2)) * 100, 0);
        console.log('outThrottle: ' + outThrottle);

        var outWinhover = round(x * d, 2);
        console.log('outWinhover: ' + outWinhover);

        var outWouthover = round(e, 2);
        console.log('outWouthover: ' + outWouthover);

        var outPctEffhover = round(e / x / d * 100, 1);
        console.log('outPctEffhover: ' + outPctEffhover);

        var outDurationMix = round(((batteryCapacity / 1000) * 0.85 / numRotors / x * 60), 2);
        console.log('outDurationMix: ' + outDurationMix);

        var outIhoverTot = round(x * numRotors, 2);
        console.log("outIhoverTot: " + outIhoverTot);

        var outPayload = round(1000 * (maxAUW - TheAUW), 0);
        console.log('outPayload: ' + outPayload);

        var outPayloadImp = round(1 / 28.35 * outPayload, 2);
        console.log('outPayloadImp: ' + outPayloadImp);

        var outhoverPin = round(x * batteryChargeState * batteryVoltPerCell * batterySerial * numRotors, 2);
        console.log('outhoverPin: ' + outhoverPin);

        var outhoverPout = round(e * numRotors, 2);
        console.log('outhoverPout: ' + outhoverPout);

        var outhoverTotEff = round((100 * outhoverPout / outhoverPin), 1);
        console.log('outhoverTotEff: ' + outhoverTotEff);
    } else {
        // error
    }

    if (outThrottle > 80) {
        // For good maneuverability you need Throttle of less than 80%
    }
}
