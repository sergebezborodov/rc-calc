function GetIo(d, x) {
    with(document['inputform']) {
        Po = 1 * outIo['value'] * (1 * outUIo['value'] - 1 * 1 * outIo['value'] * outRm['value']);

        Fdreh = 1 * outKv['value'] * (1 * outUIo['value'] - 1 * outIo['value'] * outRm['value']) * outPols['value'] / 120;
        FELossPerKg = 0.000000164668 * Math['pow'](Fdreh, 3) - 0.0000646501 * Math['pow'](Fdreh, 2) + 0.127483 * Fdreh - 1.94292;
        NF = FELossPerKg / Po;
        Fdreh = 1 * outKv['value'] * (d - x * outRm['value']) * outPols['value'] / 120;
        FELossEst = (0.000000164668 * Math['pow'](Fdreh, 3) - 0.0000646501 * Math['pow'](Fdreh, 2) + 0.127483 * Fdreh - 1.94292) / NF;
        IoLoss = FELossEst / (d - x * outRm['value']);
        if (d < 1 * outUIo['value']) {
            Im = 1 * outIo['value'] / outUIo['value'] * (d - 1 * outUIo['value']);
        } else {
            Ife = 1 * outIo['value'] * outUIo['value'] / d;
            Im = Math['sqrt'](Math['pow'](1 * outIo['value'], 2) - Math['pow'](Ife, 2));
        };
        ILossTotal = 0.45 * outIo['value'] + 0.55 * IoLoss;
        ILossNotLinear = 1;
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'W') && (outLimit['value'] != '') && (x > (1 * outLimit['value'] / Vcell['value'] / numcells['value']))) {
            ILossNotLinear = (x * Vcell['value'] * numcells['value']) / (1 * outLimit['value']);
        };
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'A') && (outLimit['value'] != '') && (x > 1 * outLimit['value'])) {
            ILossNotLinear = x / (1 * outLimit['value']);
        };
        return (Math['pow'](ILossNotLinear, 0.4 * ILossNotLinear * ILossNotLinear) * (ILossTotal));
    };
};

// outIo - noLoadCurrent
// outUIo - voltage
// outRm - resistance
// outPols - mag poles
// outLimit - motor limit

var d, x;

var noLoadCurrent, voltage, motorResistance, motorKv, motorMagPoles;
var motorLimitType; // W|A
var motorLimitValue;

var voltPerCell, cellCount;

//Po = 1 * outIo['value'] * (1 * outUIo['value'] - 1 * 1 * outIo['value'] * outRm['value']);
var Po = noLoadCurrent * (voltage - noLoadCurrent * motorResistance);

//Fdreh = outKv['value'] * (outUIo['value'] - 1 * outIo['value'] * outRm['value']) * outPols['value'] / 120;
var Fdreh = motorKv * (voltage - noLoadCurrent * motorResistance) * motorMagPoles / 120;

//FELossPerKg = 0.000000164668 * Math['pow'](Fdreh, 3) - 0.0000646501 * Math['pow'](Fdreh, 2) + 0.127483 * Fdreh - 1.94292;
var FELossPerKg = 0.000000164668 * Math.pow(Fdreh, 3) - 0.0000646501 * Math.pow(Fdreh, 2) + 0.127483 * Fdreh - 1.94292;

// NF = FELossPerKg / Po;
var NF = FELossPerKg / Po;

// Fdreh = 1 * outKv['value'] * (d - x * outRm['value']) * outPols['value'] / 120;
Fdreh = motorKv * (d - x * motorResistance) * motorMagPoles / 120;

// FELossEst = (0.000000164668 * Math['pow'](Fdreh, 3) - 0.0000646501 * Math['pow'](Fdreh, 2) + 0.127483 * Fdreh - 1.94292) / NF;
var FELossEst = (0.000000164668 * Math.pow(Fdreh, 3) - 0.0000646501 * Math.pow(Fdreh, 2) + 0.127483 * Fdreh - 1.94292) / NF;

// IoLoss = FELossEst / (d - x * outRm['value']);
var IoLoss = FELossEst / (d - x * motorResistance);

if (d < voltage) {
    Im = noLoadCurrent / voltage * (d - voltage);
} else {
    Ife = noLoadCurrent * voltage / d;
    Im = Math.sqrt(Math.pow(noLoadCurrent, 2) - Math.pow(Ife, 2));
}

//ILossTotal = 0.45 * outIo['value'] + 0.55 * IoLoss;
var ILossTotal = 0.45 * noLoadCurrent + 0.55 * IoLoss;
ILossNotLinear = 1;

if ((motorLimitType == 'W') && (motorLimitValue > 0) && (x > (motorLimitValue / voltPerCell / cellCount))) {
    ILossNotLinear = (x * voltPerCell * cellCount) / (motorLimitValue);
}
if ((motorLimitType == 'A') && (motorLimitValue > 0) && (x > motorLimitValue)) {
    ILossNotLinear = x / motorLimitValue;
}

var RES =  (Math.pow(ILossNotLinear, 0.4 * ILossNotLinear * ILossNotLinear) * (ILossTotal));
