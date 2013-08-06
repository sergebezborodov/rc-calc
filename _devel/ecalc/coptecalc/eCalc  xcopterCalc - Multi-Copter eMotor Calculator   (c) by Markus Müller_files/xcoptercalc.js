//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
//   All source codes, data, texts, pictures and graphs and their arrangements are subject 
//   to copyright and are the intellectual property of Solution for All Markus M�ller. 
//   They may neither be copied for forwarding nor used in an amended form or on other 
//   websites or servers or any kind of electronic device.
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//
var theVersion = 'V X5.17 06.09.12' + ' / ' + dataVersion + ' with ' + motorArray['length'] + ' Motors';
var propellerArray = [
    ['APC SlowFly SF', 1.11, true],
    ['APC Electric E', 1.08, true],
    ['APC Speed E', 1.08, true],
    ['Aeronaut CamCarbon', 1.06, false],
    ['Fiala', 1.09, true],
    ['GWS', 1.18, true],
    ['Ramoser 5-Blatt/Blades', 1.35, true],
    ['Carbon-Fold-Prop', 1.18, false]
];
var accuChargeState = 1;
var wGrad = 1;

function loadDropDown(_0xa916x6) {
    var _0xa916x7 = _0xa916x6['celltype'];
    var _0xa916x8, _0xa916x9;
    for (_0xa916x8 = 0; _0xa916x8 < cellArray['length']; _0xa916x8++) {
        _0xa916x9 = cellArray[_0xa916x8];
        _0xa916x7['options'][_0xa916x8 + 1] = new Option(_0xa916x9[0] + ' - ' + _0xa916x9[4] + '/' + _0xa916x9[5] + 'C', _0xa916x8 + 1, false, false);
    };
    _0xa916x7 = _0xa916x6['conttype'];
    for (_0xa916x8 = 0; _0xa916x8 < controlerArray['length']; _0xa916x8++) {
        _0xa916x9 = controlerArray[_0xa916x8];
        _0xa916x7['options'][_0xa916x8 + 1] = new Option(_0xa916x9[0], _0xa916x8 + 1, false, false);
    };
    if (_0xa916x6['hersteller'][_0xa916x6['hersteller']['selectedIndex']]['value'] >= 0) {
        loadMotorTyps(_0xa916x6);
    };
    _0xa916x7 = _0xa916x6['proptype'];
    for (_0xa916x8 = 0; _0xa916x8 < propellerArray['length']; _0xa916x8++) {
        _0xa916x9 = propellerArray[_0xa916x8];
        _0xa916x7['options'][_0xa916x8 + 1] = new Option(_0xa916x9[0], _0xa916x8 + 1, false, false);
    };
};

function motorcalcs() {

    with(document['inputform']) {
        replaceComma();
        outWarning['value'] = '';
        resetInputFontColor();
        accuChargeState = 1.0 * GetSelectValue(chargeState);
        if (celltype['selectedIndex'] > 0) {
            Akku['value'] = cellArray[celltype['selectedIndex'] - 1][0];
        } else {
            Akku['value'] = '';
        };
        Regler['value'] = conttype['options'][conttype['selectedIndex']]['text'];
        Motor['value'] = hersteller['options'][hersteller['selectedIndex']]['text'] + ' ' + motortyp['options'][motortyp['selectedIndex']]['text'];
        Prop['value'] = proptype['options'][proptype['selectedIndex']]['text'] + ' ' + propdiameter['value'] + 'x' + proppitch['value'];
        if (1 * GetSelectValue(proptwist) != 0) {
            Prop['value'] = Prop['value'] + ' (Mittelst\xFCck ' + GetSelectValue(proptwist) + ')';
        };
        if (rotorNumber['value'] < 2) {
            rotorNumber['value'] = 2;
        };
        if (numcells['value'] <= 1) {
            numcells['value'] = 1;
        };
        if (cellsparallel['value'] <= 1) {
            cellsparallel['value'] = 1;
        };
        if (Vcell['value'] <= 0.5) {
            Vcell['value'] = 0.5;
        };
        if (numcells['value'] < 2) {
            outWarning['value'] = outWarning['value'] + msgTwoCells;
            numcells['style']['color'] = fontErrorColor;
        };
        if (Resc['value'] <= 0) {
            Resc['value'] = 0;
        };
        if (outLimitTyp['options'][outLimitTyp['selectedIndex']]['value'] = 'A' && ((1 * outLimit['value']) < (1 * outIo['value']))) {
            outLimit['value'] = outIo['value'];
        };
        TheCellNum = GetSelectValue(celltype) - 1;
        if (TheCellNum >= 0) {
            TheCellRc = cellArray[TheCellNum][2];
            TheCellCap = cellArray[TheCellNum][1];
            TheCellWeight = cellArray[TheCellNum][3];
            TheCellMaxC = cellArray[TheCellNum][5];
            TheCellV = cellArray[TheCellNum][6];
            outRc['value'] = TheCellRc;
            outCellCap['value'] = TheCellCap * cellsparallel['value'];
            if (TheUnits == 'metric') {
                outCellOz['value'] = TheCellWeight;
            } else {
                outCellOz['value'] = round(TheCellWeight / 28.35, 2);
            };
            Vcell['value'] = TheCellV;
        };
        TheContNum = GetSelectValue(conttype) - 1;
        if (TheContNum >= 0) {
            Resc['value'] = controlerArray[TheContNum][1];
            if (TheUnits == 'metric') {
                ResWt['value'] = controlerArray[TheContNum][2];
            } else {
                ResWt['value'] = round(controlerArray[TheContNum][2] / 28.35, 2);
            };
            ResI['value'] = controlerArray[TheContNum][3];
            ResIMax['value'] = controlerArray[TheContNum][4];
        };
        TheCellCap = outCellCap['value'];
        TheCellWeight = outCellOz['value'];
        outPackOz['value'] = round(TheCellWeight * numcells['value'] * cellsparallel['value'], 3);
        outPackV['value'] = round(Vcell['value'] * numcells['value'], 2);
        TheMotorNum = GetSelectValue(motortyp);
        if (TheMotorNum > 0) {
            TheMotorNoLoad = MotorNoLoad[TheMotorNum];
            TheMotorNoLoadVoltage = MotorNoLoadVoltage[TheMotorNum];
            TheMotorPols = MotorPols[TheMotorNum];
            TheMotorKv = MotorConsts[TheMotorNum];
            if (hersteller['options'][hersteller['selectedIndex']]['value'] == 20) {
                TheMotorKv = round((TheMotorKv / 0.95), 0);
            };
            TheMotorRes = round(MotorRes[TheMotorNum] / 1000, 5);
            TheMotorLength = MotorLength[TheMotorNum];
            TheMotorLimit = MotorLimit[TheMotorNum];
            TheMotorLimitTyp = MotorLimitTyp[TheMotorNum];
            TheMotorKt = 1352 / TheMotorKv;
            if (TheUnits == 'metric') {
                outMotoroz['value'] = MotorWeight[TheMotorNum];
            } else {
                outMotoroz['value'] = round(MotorWeight[TheMotorNum] / 28.35, 2);
            };
        } else {
            TheMotorNoLoad = 1 * outIo['value'];
            TheMotorNoLoadVoltage = 1 * outUIo['value'];
            TheMotorPols = 1 * outPols['value'];
            TheMotorKv = 1 * outKv['value'];
            TheMotorRes = 1 * outRm['value'];
            if (TheUnits == 'metric') {
                TheMotorLength = 1 * outLength['value'];
            } else {
                TheMotorLength = 25.4 * outLength['value'];
            };
            TheMotorLimit = 1 * outLimit['value'];
            TheMotorLimitTyp = outLimitTyp['options'][outLimitTyp['selectedIndex']]['value'];
            TheMotorKt = 1352 / TheMotorKv;
        };
        outKv['value'] = TheMotorKv;
        outKt['value'] = TheMotorKt;
        outRm['value'] = TheMotorRes;
        outIo['value'] = TheMotorNoLoad;
        outUIo['value'] = TheMotorNoLoadVoltage;
        outPols['value'] = TheMotorPols;
        outLimit['value'] = TheMotorLimit;
        if (TheMotorLimitTyp == 'A') {
            outLimitTyp['selectedIndex'] = 0;
        };
        if (TheMotorLimitTyp == 'W') {
            outLimitTyp['selectedIndex'] = 1;
        };
        if (TheUnits == 'metric') {
            outLength['value'] = TheMotorLength;
        } else {
            outLength['value'] = round(TheMotorLength / 25.4, 2);
        };
        TempFELoss = (accuChargeState * Vcell['value'] * numcells['value'] * TheMotorNoLoad);
        TempIMaxEff = round(Math['sqrt'](TempFELoss / TheMotorRes), 2);
        TempVoltsToMotorMaxEff = (accuChargeState * Vcell['value'] * numcells['value']) - ((outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * TempIMaxEff) + (Resc['value'] * TempIMaxEff));
        TempIoEstimate = GetIo(TempVoltsToMotorMaxEff, TempIMaxEff);
        FELoss = TempVoltsToMotorMaxEff * TempIoEstimate;
        IMaxEff = round(Math['sqrt'](FELoss / TheMotorRes), 2);
        VoltsToMotorMaxEff = (accuChargeState * Vcell['value'] * numcells['value']) - ((outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * IMaxEff) + (Resc['value'] * IMaxEff));
        IoEstimate = GetIo(VoltsToMotorMaxEff, IMaxEff);
        WInMaxEff = round(VoltsToMotorMaxEff * IMaxEff, 2);
        WOutMaxEff = round((VoltsToMotorMaxEff - TheMotorRes * IMaxEff) * (IMaxEff - IoEstimate), 2);
        PctMaxEff = round((WOutMaxEff / WInMaxEff) * 100, 1);
        outIEff['value'] = IMaxEff;
        outVEff['value'] = round(VoltsToMotorMaxEff, 2);
        outRPMEff['value'] = round(TheMotorKv * (VoltsToMotorMaxEff - (IMaxEff * TheMotorRes)), 0);
        outWinEff['value'] = WInMaxEff;
        outWoutEff['value'] = WOutMaxEff;
        outPctMaxEff['value'] = PctMaxEff;
        outPowersys['value'] = round(((1 * rotorNumber['value'] * outMotoroz['value']) + (1 * rotorNumber['value'] * ResWt['value']) + (1 * outPackOz['value'])) * 1.1, 2);
        if (GetSelectValue(wtCalc) == 'AUW') {
            outAUW['value'] = 1 * CopterWt['value'];
        } else {
            outAUW['value'] = 1 * CopterWt['value'] + 1 * outPowersys['value'];
        };
        TheAUW = 0;
        if (TheUnits == 'metric') {
            TheAUW = 0.001 * outAUW['value'];
        } else {
            TheAUW = 0.001 * 28.35 * outAUW['value'];
        };
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'A') && (outLimit['value'] != '') && (1 * outIEff['value'] > 0.9 * outLimit['value'])) {
            outWarning['value'] = outWarning['value'] + msgUMotorHigh;
            outVmotor['style']['color'] = fontErrorColor;
        };
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'W') && (outLimit['value'] != '') && (1 * outIEff['value'] * outVEff['value'] > 0.9 * outLimit['value'])) {
            outWarning['value'] = outWarning['value'] + msgUMotorHigh;
            outVmotor['style']['color'] = fontErrorColor;
        };
        propcalcs();
        if ((ResIMax['value'] != '') && ((1 * document['inputform']['outImotor']['value']) > (1 * document['inputform']['ResIMax']['value']))) {
            outWarning['value'] = outWarning['value'] + msgMaxCurrentESC;
            ResIMax['style']['color'] = fontErrorColor;
            outImotor['style']['color'] = fontErrorColor;
        };
    };
};

function propcalcs() {
    with(document['inputform']) {
        ThePropNum = GetSelectValue(proptype) - 1;
        if (ThePropNum >= 0) {
            propconst['value'] = propellerArray[ThePropNum][1];
            if (propellerArray[ThePropNum][2]) {
                proptwist['options'][3]['selected'] = true;
            };
            proptwist['disabled'] = propellerArray[ThePropNum][2];
        } else {
            proptwist['disabled'] = false;
        };
        if (propconst['value'] <= 0) {
            propconst['value'] = 1.31;
        };
        if (propblades['value'] <= 0) {
            propblades['value'] = 2;
        };
        effdiameter = propdiameter['value'] * Math['pow'](propblades['value'] / 2, 0.2);
        effpitch = Math['tan'](2 * Math['PI'] / 360 * (Math['atan'](1 * proppitch['value'] / Math['PI'] / propdiameter['value'] / 0.75) * 360 / 2 / Math['PI'] + 1 * GetSelectValue(proptwist))) * 0.75 * Math['PI'] * propdiameter['value'];
        if (effpitch < 0) {
            outWarning['value'] = outWarning['value'] + msgNegPitch;
            proppitch['style']['color'] = fontErrorColor;
        };
        if ((effpitch > 0) && ((1 * effpitch / effdiameter) > 0.665)) {
            outWarning['value'] = outWarning['value'] + msgPropStallX;
            proppitch['style']['color'] = fontErrorColor;
        };
        outEffDiameter['value'] = round(effdiameter, 2);
    };
    CalcPropMotorCurrent();
};

function CalcPropMotorCurrent() {
    with(document['inputform']) {
        TheElevation = 0;
        effdiameter = 1 * outEffDiameter['value'];
        MotorIo = 1 * outIo['value'];
        MotorIoVoltage = 1 * outUIo['value'];
        MotorKv = 1 * outKv['value'];
        MotorRm = 1 * outRm['value'];
        if (TheUnits == 'metric') {
            TheElevation = 1 * elevation['value'];
            TheTemp = 1 * temp['value'];
            TheQNH = 1 * qnh['value'];
        } else {
            TheElevation = 1 / 3.281 * elevation['value'];
            TheTemp = (1 * temp['value'] - 32) / 9 * 5;
            TheQNH = 33.864 * qnh['value'];
        };
        VoltsToMotor = (accuChargeState * Vcell['value'] * numcells['value']) - ((1 * outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * MotorIo) + (Resc['value'] * MotorIo));
        if (effdiameter <= 0 || effpitch <= 0) {
            Imotor = GetIo(VoltsToMotor, MotorIo);
        } else {
            tempg = propconst['value'] * Math['pow'](effdiameter, 4) * effpitch * (Math['pow'](12, - 5) * 1E-9) * Math['pow']((MotorKv / gearratio['value']), 3);
            tempr = (outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value']) + (1 * Resc['value']) + (1 * MotorRm);
            Vbatt = accuChargeState * Vcell['value'] * numcells['value'];
            IoEstimate = GetIo(1 * outVEff['value'], 1 * outIEff['value']);
            tempb = (-2 * tempr * Vbatt - 1 / tempg) / (tempr * tempr);
            tempc = (Math['pow'](Vbatt, 2) + IoEstimate / tempg) / (tempr * tempr);
            if (tempb * tempb / 4 > tempc) {
                tempz = Math['sqrt'](Math['pow'](tempb, 2) / 4 - tempc);
                tempi1 = -tempb / 2 + tempz;
                tempi2 = -tempb / 2 - tempz;
                if (tempi2 > 0) {
                    Imotor = tempi2;
                } else {
                    Imotor = tempi1;
                };
            } else {
                Imotor = 0;
            };
        };
        airdensity = 100 * TheQNH * Math['pow']((1 - (0.0065 * TheElevation / 288.15)), 5.255) / 287.05 / (1 * TheTemp + 273.15);
        if ((Imotor / stdAirdensity * airdensity) > GetIo(VoltsToMotor, MotorIo)) {
            Imotor = Imotor / stdAirdensity * airdensity;
        };
        outImotor['value'] = round(Imotor, 2);
        outImotorTot['value'] = round(Imotor * rotorNumber['value'], 2);
        outMaxC['value'] = round((Imotor / outCellCap['value'] * 1000 * rotorNumber['value']), 1);
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'A') && (outLimit['value'] != '') && (1 * outImotor['value'] > 1 * outLimit['value'])) {
            outWarning['value'] = outWarning['value'] + msgMaxCurrentMotor;
            outLimit['style']['color'] = fontErrorColor;
            outImotor['style']['color'] = fontErrorColor;
        };
        if ((1 * outMaxC['value']) > (1 * TheCellMaxC)) {
            outWarning['value'] = outWarning['value'] + msgMaxCuttentBattery;
            outMaxC['style']['color'] = fontErrorColor;
        };
        outPackVeff['value'] = round((accuChargeState * outPackV['value']) - (Imotor * outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value']), 2);
        outDuration['value'] = round(((outCellCap['value'] / 1000) / Imotor / rotorNumber['value']) * 60, 2);
    };
    CalcMotorValues();
};

function CalcMotorValues() {
    with(document['inputform']) {
        MotorIo = 1 * outIo['value'];
        MotorIoVoltage = 1 * outUIo['value'];
        MotorKv = 1 * outKv['value'];
        MotorRm = 1 * outRm['value'];
        VoltsToMotor = (accuChargeState * Vcell['value'] * numcells['value']) - ((1 * outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * outImotor['value']) + (Resc['value'] * outImotor['value']));
        MotorRPM = MotorKv * (VoltsToMotor - (outImotor['value'] * MotorRm));
        IoEstimate = GetIo(VoltsToMotor, 1 * outImotor['value']);
        WattsIn = round(VoltsToMotor * outImotor['value'], 2);
        WattsOut = round((VoltsToMotor - MotorRm * outImotor['value']) * (1 * outImotor['value'] - IoEstimate), 2);
        PctEff = round((WattsOut / WattsIn) * 100, 1);
        Pin = 1 * outImotor['value'] * accuChargeState * outPackV['value'];
        Pout = WattsOut;
        TotEff = Pout / Pin;
        outVmotor['value'] = round(VoltsToMotor, 2);
        outWin['value'] = WattsIn;
        outWout['value'] = WattsOut;
        outPctEff['value'] = PctEff;
        outRPM['value'] = round(MotorRPM, 0);
        outPin['value'] = round(Pin * rotorNumber['value'], 2);
        outPout['value'] = round(Pout * rotorNumber['value'], 2);
        outTotEff['value'] = round((TotEff * 100), 1);
        effdiameter = outEffDiameter['value'];
        if (gearratio['value'] <= 0) {
            gearratio['value'] = 1;
        };
        proprpm = MotorRPM / gearratio['value'];
        Propwatts = propconst['value'] * Math['pow'](effdiameter / 12, 4) * (effpitch / 12) * Math['pow'](proprpm / 1000, 3);
        HP = Propwatts / 745.699871582;
        Pitchspeed = proprpm * effpitch / 1056;
        ThrustatSpeed = 16 * 375 * Propwatts / (746 * Pitchspeed);
        Tgrams = effpitch * Math['pow'](effdiameter, 3) * Math['pow'](proprpm / 1000, 2) * 28.3 * 0.981 / 10000;
        Tkg = Tgrams / 1000;
        Tn = Tkg * 9.80665;
        Tlbs = Tn / 4.44822161526;
        StaticToz = Tlbs * 16;
        if ((effpitch > 0) && ((effpitch / effdiameter) > 0.665)) {} else {}; if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'W') && (outLimit['value'] != '') && (WattsIn > 1 * outLimit['value'])) {
            outWarning['value'] = outWarning['value'] + msgMaxPowerMotor;
            outWin['style']['color'] = fontErrorColor;
            outLimit['style']['color'] = fontErrorColor;
        };
        var _0xa916xe = 0;
        _0xa916xe = TheTemp + (1 * outWin['value'] - 1 * outWout['value']) * 2.718 * GetSelectValue(cooling) / 6.283186 / (TheMotorLength / 1000) / (-0.024 * (273.15 + 1 * TheTemp) + 65.552);
        if (_0xa916xe > 80) {
            outWarning['value'] = outWarning['value'] + msgOverTemp;
        };
        calcHover();
        if (1 * propdiameter['value'] > 0) {
            plotMotorGraph(true);
        };
        if ((1 * outPctMaxEff['value'] <= 0) || ((1 * outImotor['value'] > 1 * outIEff['value']) && (1 * outPctEff['value'] < 40))) {
            outWarning['value'] = msgUnrealsisticSetup;
        };
    };
};

function calcHover() {
    with(document['inputform']) {
        var _0xa916x10;
        var x;

        var e = Math['pow'](1 * propconst['value'], 0.33333)
            * Math['sqrt'](2 * 1 * Math['pow'](TheAUW / rotorNumber['value'], 3)
            *  Math['pow'](9.81, 3) / airdensity / Math['pow'](0.001 * 25.4 * effdiameter / 2, 2) / Math['PI']) / wGrad;
        var b = 1 * outRm['value']; // внутреннее сопротивление мотора

        // outIo - no-load Current
        // outVEff - напряжение
        var a = -1 * outIo['value'] * outRm['value'] - 1 * outVEff['value'];
        var c = e + 1 * outIo['value'] * outVEff['value'];


        I1 = (-a + Math['sqrt'](a * a - 4 * b * c)) / 2 / b;
        I2 = (-a - Math['sqrt'](a * a - 4 * b * c)) / 2 / b;

        if ((I1 > 0) && (I1 < 1 * outImotor['value'])) {
            x = I1;
        };
        if ((I2 > 0) && (I2 < 1 * outImotor['value'])) {
            x = I2;
        };
        var d = (accuChargeState * Vcell['value'] * numcells['value']) - ((1 * outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * x) + (Resc['value'] * x));


        IoEst = GetIo(d, x);
        b = 1 * outRm['value'];
        a = -IoEst * outRm['value'] - d;
        c = e + IoEst * d;



        I1 = (-a + Math['sqrt'](a * a - 4 * b * c)) / 2 / b;
        I2 = (-a - Math['sqrt'](a * a - 4 * b * c)) / 2 / b;
        if ((I1 > 0) && (I1 < 1 * outImotor['value'])) {
            x = I1;
        };
        if ((I2 > 0) && (I2 < 1 * outImotor['value'])) {
            x = I2;
        };
        d = (accuChargeState * Vcell['value'] * numcells['value']) - ((1 * outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * x) + (Resc['value'] * x));
        ImaxAUW = (1 - Math['sqrt'](1 - 0.8)) * outImotor['value'];
        VoltmaxAUW = (accuChargeState * Vcell['value'] * numcells['value']) - ((1 * outRc['value'] * numcells['value'] / cellsparallel['value'] * rotorNumber['value'] * ImaxAUW) + (Resc['value'] * ImaxAUW));
        WirkungsgradMotor = 0.01 * outPctEff['value'];

        maxAUW = 1 * rotorNumber['value'] * Math['pow']((Math['PI'] * airdensity * Math['pow'](ImaxAUW * VoltmaxAUW * WirkungsgradMotor / Math['pow'](1 * propconst['value'], 0.33333) * wGrad, 2) * Math['pow'](0.001 * 25.4 * effdiameter / 2, 2) / 2 / 1 / Math['pow'](9.81, 3)), 0.33333333);
        if ((e <= (1 * outWout['value'])) & ((1 * effpitch / effdiameter) < 0.666)) {
            outIhover['value'] = round(x, 2);
            outVhover['value'] = round(d, 2);
            outThrottle['value'] = round((1 - Math['pow'](1 - x / outImotor['value'], 2)) * 100, 0);
            outWinhover['value'] = round(x * d, 2);
            outWouthover['value'] = round(e, 2);
            outPctEffhover['value'] = round(e / x / d * 100, 1);
            outDurationMix['value'] = round(((outCellCap['value'] / 1000) * 0.85 / rotorNumber['value'] / x * 60), 2);
            outIhoverTot['value'] = round(x * rotorNumber['value'], 2);
            outPayload['value'] = round(1000 * (maxAUW - TheAUW), 0);
            outPayloadImp['value'] = round(1 / 28.35 * outPayload['value'], 2);
            outhoverPin['value'] = round(x * accuChargeState * Vcell['value'] * numcells['value'] * rotorNumber['value'], 2);
            outhoverPout['value'] = round(e * rotorNumber['value'], 2);
            outhoverTotEff['value'] = round((100 * outhoverPout['value'] / outhoverPin['value']), 1);
        } else {
            outIhover['value'] = '';
            outIhoverTot['value'] = '';
            outVhover['value'] = '';
            outThrottle['value'] = '';
            outWinhover['value'] = '';
            outWouthover['value'] = '';
            outPctEffhover['value'] = '';
            outDurationMix['value'] = '';
            outIhoverTot['value'] = '';
            outPayload['value'] = '';
            outPayloadImp['value'] = '';
            outhoverPin['value'] = '';
            outhoverPout['value'] = '';
            outhoverTotEff['value'] = '';
            outWarning['value'] = outWarning['value'] + msgUnableHover;
            outAUW['style']['color'] = fontErrorColor;
        };
        if (1 * outThrottle['value'] > 80) {
            outWarning['value'] = outWarning['value'] + msgBadManeuver;
            outAUW['style']['color'] = fontErrorColor;
            outThrottle['style']['color'] = fontErrorColor;
        };
    };
};

function changeUnits(_0xa916x6) {
    if (GetSelectValue(_0xa916x6['units']) == 'imperial') {
        TheUnits = 'imperial';
        document['getElementById']('lbCopterWt')['innerHTML'] = 'oz';
        document['getElementById']('lbSeaLevel')['innerHTML'] = 'ft ASL';
        document['getElementById']('lbTemp')['innerHTML'] = '\xB0F';
        document['getElementById']('lbPress')['innerHTML'] = 'inHg';
        document['getElementById']('lbCellWt')['innerHTML'] = 'oz';
        document['getElementById']('lbResWt')['innerHTML'] = 'oz';
        document['getElementById']('lbMotorLen')['innerHTML'] = 'in';
        document['getElementById']('lbMotorWt')['innerHTML'] = 'oz';
        document['getElementById']('lbBatWt')['innerHTML'] = 'oz';
        document['getElementById']('lbDriveWt')['innerHTML'] = 'oz';
        document['getElementById']('lbAUW')['innerHTML'] = 'oz';
        _0xa916x6['CopterWt']['value'] = round(1 / 28.35 * _0xa916x6['CopterWt']['value'], 2);
        _0xa916x6['outAUW']['value'] = round(1 * _0xa916x6['outAUW']['value'] / 28.35, 2);
        _0xa916x6['elevation']['value'] = round(3.281 * _0xa916x6['elevation']['value'], 0);
        _0xa916x6['temp']['value'] = round(32 + 9 / 5 * _0xa916x6['temp']['value'], 0);
        _0xa916x6['qnh']['value'] = round(1 / 33.864 * _0xa916x6['qnh']['value'], 2);
    } else {
        TheUnits = 'metric';
        document['getElementById']('lbCopterWt')['innerHTML'] = 'g';
        document['getElementById']('lbSeaLevel')['innerHTML'] = 'm ASL';
        document['getElementById']('lbTemp')['innerHTML'] = '\xB0C';
        document['getElementById']('lbPress')['innerHTML'] = 'hPa';
        document['getElementById']('lbCellWt')['innerHTML'] = 'g';
        document['getElementById']('lbResWt')['innerHTML'] = 'g';
        document['getElementById']('lbMotorLen')['innerHTML'] = 'mm';
        document['getElementById']('lbMotorWt')['innerHTML'] = 'g';
        document['getElementById']('lbBatWt')['innerHTML'] = 'g';
        document['getElementById']('lbDriveWt')['innerHTML'] = 'g';
        document['getElementById']('lbAUW')['innerHTML'] = 'g';
        _0xa916x6['CopterWt']['value'] = round(28.35 * _0xa916x6['CopterWt']['value'], 0);
        _0xa916x6['outAUW']['value'] = round(28.35 * _0xa916x6['outAUW']['value'], 0);
        _0xa916x6['elevation']['value'] = round(0.3048 * _0xa916x6['elevation']['value'], 0);
        _0xa916x6['temp']['value'] = round((1 * _0xa916x6['temp']['value'] - 32) / 9 * 5, 0);
        _0xa916x6['qnh']['value'] = round(33.864 * _0xa916x6['qnh']['value'], 0);
    };
    motorcalcs();
};
