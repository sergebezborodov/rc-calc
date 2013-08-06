//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
//   All source codes, data, texts, pictures and graphs and their arrangements are subject 
//   to copyright and are the intellectual property of Solution for All Markus M�ller. 
//   They may neither be copied for forwarding nor used in an amended form or on other 
//   websites or servers or any kind of electronic device.
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//
var TheCellMaxC = 100;
var MotorWeight = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorLength = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorLimit = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorConsts = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorNoLoad = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorNoLoadVoltage = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorPols = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorRes = new Array(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);
var MotorLimitTyp = new Array('A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A', 'A');
var airdensity;
var stdAirdensity = 101325 / 287.05 / 288.15;
var fontErrorColor = '#FF4040';
var fontDisabledColor = '#F08080';
var fontColor = '#000000';

function acceptUserStatement() {
    var _0xadf1x11 = '';
    if (!isServicePayed) {
        _0xadf1x11 = msgUserStatement1;
    };
    _0xadf1x11 = _0xadf1x11 + msgUserStatement2;
    if (confirm(_0xadf1x11)) {
        userStatementAccepted = true;
    };
};

function showLeaveMsg() {
    var _0xadf1x11 = '';
    if (!isServicePayed) {
        _0xadf1x11 = msgLeave;
        alert(_0xadf1x11);
    };
};
//
//if ((document['URL']['indexOf']('http://www.s4a.ch/') != 0) && (document['URL']['indexOf']('http://s4a.ch/') != 0) && (document['URL']['indexOf']('http://www.ecalc.ch/') != 0) && (document['URL']['indexOf']('http://ecalc.ch/') != 0)) {
//    motorArray = 0;
//    cellArray = 0;
//    controlerArray = 0;
//    alert(msgCV);
//    location['replace']('http://www.ecalc.ch/illegalcopy.htm');
//};

function configBatterie() {
    if (GetSelectValue(document['inputform']['celltype']) == 0) {
        document['inputform']['outCellCap']['disabled'] = false;
        document['inputform']['outRc']['disabled'] = false;
        document['inputform']['Vcell']['disabled'] = false;
        document['inputform']['outCellOz']['disabled'] = false;
    } else {
        document['inputform']['outCellCap']['disabled'] = true;
        document['inputform']['outRc']['disabled'] = true;
        document['inputform']['Vcell']['disabled'] = true;
        document['inputform']['outCellOz']['disabled'] = true;
    };
    motorcalcs();
};

function configESC() {
    if (GetSelectValue(document['inputform']['conttype']) == 0) {
        document['inputform']['Resc']['disabled'] = false;
        document['inputform']['ResI']['disabled'] = false;
        document['inputform']['ResIMax']['disabled'] = false;
        document['inputform']['ResWt']['disabled'] = false;
    } else {
        document['inputform']['Resc']['disabled'] = true;
        document['inputform']['ResI']['disabled'] = true;
        document['inputform']['ResIMax']['disabled'] = true;
        document['inputform']['ResWt']['disabled'] = true;
    };
    motorcalcs();
};

function configMotor() {
    if (GetSelectValue(document['inputform']['motortyp']) == 0) {
        document['inputform']['outKv']['disabled'] = false;
        document['inputform']['outRm']['disabled'] = false;
        document['inputform']['outIo']['disabled'] = false;
        document['inputform']['outUIo']['disabled'] = false;
        document['inputform']['outLimit']['disabled'] = false;
        document['inputform']['outLimitTyp']['disabled'] = false;
        document['inputform']['outPols']['disabled'] = false;
        document['inputform']['outLength']['disabled'] = false;
        document['inputform']['outMotoroz']['disabled'] = false;
    } else {
        document['inputform']['outKv']['disabled'] = true;
        document['inputform']['outRm']['disabled'] = true;
        document['inputform']['outIo']['disabled'] = true;
        document['inputform']['outUIo']['disabled'] = true;
        document['inputform']['outLimit']['disabled'] = true;
        document['inputform']['outLimitTyp']['disabled'] = true;
        document['inputform']['outPols']['disabled'] = true;
        document['inputform']['outLength']['disabled'] = true;
        document['inputform']['outMotoroz']['disabled'] = true;
    };
    motorcalcs();
};

function configProp() {
    if (GetSelectValue(document['inputform']['proptype']) == 0) {
        document['inputform']['propconst']['disabled'] = false;
    } else {
        document['inputform']['propconst']['disabled'] = true;
    };
    motorcalcs();
};

function loadMotorTyps(_0xadf1x18) {
    var _0xadf1x19 = _0xadf1x18['hersteller'][_0xadf1x18['hersteller']['selectedIndex']]['value'];
    var _0xadf1x1a = _0xadf1x18['motortyp'];
    var _0xadf1x1b, _0xadf1x1c;
    var _0xadf1x1d = _0xadf1x1a['options']['length'];
    var _0xadf1x1e;
    for (_0xadf1x1b = _0xadf1x1d - 1; _0xadf1x1b >= 1; _0xadf1x1b--) {
        _0xadf1x1a['options'][_0xadf1x1b] = null;
    };
    var _0xadf1x1c = 1;
    for (_0xadf1x1b = 0; _0xadf1x1b < motorArray['length']; _0xadf1x1b++) {
        _0xadf1x1e = motorArray[_0xadf1x1b];
        if ((_0xadf1x1e[0] == _0xadf1x19) || (_0xadf1x19 == 0)) {
            _0xadf1x1a['options'][_0xadf1x1c] = new Option(_0xadf1x1e[1] + ' (' + _0xadf1x1e[2] + ')', _0xadf1x1c, false, false);
            MotorConsts[_0xadf1x1c] = _0xadf1x1e[2];
            MotorRes[_0xadf1x1c] = _0xadf1x1e[3];
            MotorNoLoad[_0xadf1x1c] = _0xadf1x1e[4];
            MotorNoLoadVoltage[_0xadf1x1c] = _0xadf1x1e[5];
            MotorPols[_0xadf1x1c] = _0xadf1x1e[6];
            MotorLimit[_0xadf1x1c] = _0xadf1x1e[7];
            MotorLimitTyp[_0xadf1x1c] = _0xadf1x1e[8];
            MotorLength[_0xadf1x1c] = _0xadf1x1e[9];
            MotorWeight[_0xadf1x1c] = _0xadf1x1e[10];
            _0xadf1x1c++;
        };
    };
    configMotor();
};

function clearMotorTyps(_0xadf1x18) {
    var _0xadf1x19 = _0xadf1x18['hersteller'][_0xadf1x18['hersteller']['selectedIndex']]['value'];
    var _0xadf1x1a = _0xadf1x18['motortyp'];
    var _0xadf1x1b;
    var _0xadf1x1d = _0xadf1x1a['options']['length'];
    for (_0xadf1x1b = _0xadf1x1d - 1; _0xadf1x1b >= 0; _0xadf1x1b--) {
        _0xadf1x1a['options'][_0xadf1x1b] = null;
    };
    _0xadf1x1a['options'][0] = new Option('Anderer', 0, true, true);
};

function round(_0xadf1x21, _0xadf1x22) {
    return (Math['round'](_0xadf1x21 * Math['pow'](10, _0xadf1x22)) / Math['pow'](10, _0xadf1x22));
};

function GetSelectValue(_0xadf1x24) {
    var _0xadf1x25 = _0xadf1x24['selectedIndex'];
    return _0xadf1x24['options'][_0xadf1x25]['value'];
};

function resetInputFontColor() {
    for (i = 0; i < document['inputform']['elements']['length']; i++) {
        if (document['inputform']['elements'][i]['type'] == 'text') {
            document['inputform']['elements'][i]['style']['color'] = fontColor;
        };
        if (document['inputform']['elements'][i]['type'] == 'select-one') {
            document['inputform']['elements'][i]['style']['color'] = fontColor;
        };
    };
    if (document['inputform']['outPropSThrust'] != null) {
        document['inputform']['outPropSThrust']['style']['fontWeight'] = 'bold';
    };
    if (document['inputform']['outPropThrust'] != null) {
        document['inputform']['outPropThrust']['style']['fontWeight'] = 'normal';
    };
    if (document['inputform']['outPropSThrustImp'] != null) {
        document['inputform']['outPropSThrustImp']['style']['fontWeight'] = 'bold';
    };
    if (document['inputform']['outPropThrustImp'] != null) {
        document['inputform']['outPropThrustImp']['style']['fontWeight'] = 'normal';
    };
};

function replaceComma() {
    for (i = 0; i < document['inputform']['elements']['length']; i++) {
        if (document['inputform']['elements'][i]['type'] == 'text') {
            document['inputform']['elements'][i]['value'] = document['inputform']['elements'][i]['value']['replace'](/,/g, '.');
        };
    };
};

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
