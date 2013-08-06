//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
//   All source codes, data, texts, pictures and graphs and their arrangements are subject 
//   to copyright and are the intellectual property of Solution for All Markus Müller. 
//   They may neither be copied for forwarding nor used in an amended form or on other 
//   websites or servers or any kind of electronic device.
//
//
// Parameters:
//   General: as spaces are not alowed in a URL-Address replace the spaces with _ when
//            calling a setup
//   ?CustomerName: The Customer Name has always to be fist
//   Units:    imperial or metric for engl. version only
//   Weight:   Weight of Helicopter (Heli & Car Calc only!))
//   Width, Height, Time: Car dimensions
//   Elevation:Field Eleevation in Meters
//   AirTemp:  Air Temperatur in °C
//   Batteries:(part of) Batterie Name as stated in the Batterie Drop Down List
//   chargestate: State of Battery Charging: full, normal, low
//   s:        number of Cells in serie
//   p:        number of Cells in parallel
//   ESC:      (part of) ESC Name as stated in the Contoler Drop Down List
//   Motor:    Name of Motor Manufacturer as stated in the Motor Drop Down List
//   Type:     (part of) Motor Type Name as stated in the Motor Type Drop Down List
//   Gear:     Gear Ratio e.g. 6.7
//   Propeller:(part of) Propeller Name as stated in the Propeller Drop Down List
//               Diameter: Propeller Diameter in inces
//               Pitch :   Propeller Pitch in inces 
//               Blades:   Number of Blades
//   EDF:      (part of) Impeller Name as stated in the Impeller Drop Down List
//               FSA: % of Fan Sweap Area
//   Rotor:    (part of) Rotor Typ as stated in the Rotor Drop Down List
//               Pitch: Rotor Pitch in °
//   CarTyp, DriveTyp
//   pinion,spur,transmission, differential, wheel
//   Cooling:  excellent, good, medium poor, very_poor for Case Temp. Prediction
//
//   Calling example:
//   http://www.ecalc.ch/motorcalc.htm?s4a&Motor=Scorpion&type=4025-16&esc=90A&Batteries=3300&p=2&S=8&propeller=APC_Electric&diameter=18&pitch=8
//
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//

function selectCustomerUnits(_0x9f0fx2) {
    if ((document['referrer']['indexOf']('rcgroups.com') >= 0) || (document['referrer']['indexOf']('castlecreations.com') >= 0) || (document['referrer']['indexOf']('neumotors.com') >= 0)) {
        _0x9f0fx2['units']['options'][1]['selected'] = true;
        changeUnits(_0x9f0fx2);
    };
};

function preselectComponents(_0x9f0fx2) {
    if (isCommercialUser) {
        var _0x9f0fx4 = window['location']['search'];
        var _0x9f0fx5 = new Array();
        var _0x9f0fx6;
        var _0x9f0fx7 = new Array();
        var _0x9f0fx8 = new Array();
        _0x9f0fx4 = _0x9f0fx4['toLowerCase']()['replace'](/_/g, ' ');
        _0x9f0fx7 = _0x9f0fx4['split']('&');
        for (i = 1; i < _0x9f0fx7['length']; i++) {
            _0x9f0fx8 = _0x9f0fx7[i]['split']('=');
            _0x9f0fx6 = _0x9f0fx8[0];
            _0x9f0fx5[_0x9f0fx6] = _0x9f0fx8[1];
        };
        if (location['href']['indexOf']('calc_e.htm') >= 0) {
            selectCustomerUnits(_0x9f0fx2);
            if (_0x9f0fx5['units'] && (_0x9f0fx5['units'] == 'imperial')) {
                _0x9f0fx2['units']['options'][1]['selected'] = true;
                changeUnits(_0x9f0fx2);
            };
        };
        if (_0x9f0fx5['weight']) {
            _0x9f0fx2['CopterWt']['value'] = _0x9f0fx5['weight'];
        };
        if (_0x9f0fx5['calc']) {
            if (_0x9f0fx5['calc'] == 'auw') {
                _0x9f0fx2['wtCalc']['options'][0]['selected'] = true;
            } else {
                if (_0x9f0fx5['calc'] == 'sum') {
                    _0x9f0fx2['wtCalc']['options'][1]['selected'] = true;
                };
            };
        };
        if (_0x9f0fx5['rotornumber']) {
            _0x9f0fx2['rotorNumber']['value'] = _0x9f0fx5['rotornumber'];
        };
        if (_0x9f0fx5['elevation']) {
            _0x9f0fx2['elevation']['value'] = _0x9f0fx5['elevation'];
        };
        if (_0x9f0fx5['airtemp']) {
            _0x9f0fx2['temp']['value'] = _0x9f0fx5['airtemp'];
        };
        if (_0x9f0fx5['batteries']) {
            for (i = 1; i < _0x9f0fx2['celltype']['options']['length']; i++) {
                if (_0x9f0fx2['celltype']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['batteries']) >= 0) {
                    _0x9f0fx2['celltype']['options'][i]['selected'] = true;
                    break;
                };
            };
            configBatterie();
        };
        if (_0x9f0fx5['s']) {
            _0x9f0fx2['numcells']['value'] = _0x9f0fx5['s'];
        };
        if (_0x9f0fx5['p']) {
            _0x9f0fx2['cellsparallel']['value'] = _0x9f0fx5['p'];
        };
        if (_0x9f0fx5['chargestate']) {
            if (_0x9f0fx5['chargestate'] == 'full') {
                _0x9f0fx2['chargeState']['options'][0]['selected'] = true;
            } else {
                if (_0x9f0fx5['chargestate'] == 'normal') {
                    _0x9f0fx2['chargeState']['options'][1]['selected'] = true;
                } else {
                    if (_0x9f0fx5['chargestate'] == 'low') {
                        _0x9f0fx2['chargeState']['options'][2]['selected'] = true;
                    };
                };
            };
        };
        if (_0x9f0fx5['esc']) {
            for (i = 1; i < _0x9f0fx2['conttype']['options']['length']; i++) {
                if (_0x9f0fx2['conttype']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['esc']) >= 0) {
                    _0x9f0fx2['conttype']['options'][i]['selected'] = true;
                    break;
                };
            };
            configESC();
        };
        if (_0x9f0fx5['motor']) {
            for (i = 1; i < _0x9f0fx2['hersteller']['options']['length']; i++) {
                if (_0x9f0fx2['hersteller']['options'][i]['text']['toLowerCase']() == _0x9f0fx5['motor']) {
                    _0x9f0fx2['hersteller']['options'][i]['selected'] = true;
                    loadMotorTyps(_0x9f0fx2);
                    break;
                };
            };
            if (_0x9f0fx5['type']) {
                for (i = 1; i < _0x9f0fx2['motortyp']['options']['length']; i++) {
                    if (_0x9f0fx2['motortyp']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['type']) >= 0) {
                        _0x9f0fx2['motortyp']['options'][i]['selected'] = true;
                        break;
                    };
                };
            };
            configMotor();
        };
        if (_0x9f0fx5['gear']) {
            _0x9f0fx2['gearratio']['value'] = _0x9f0fx5['gear'];
        };
        if (_0x9f0fx5['rotorteeth']) {
            _0x9f0fx2['rotorT']['value'] = _0x9f0fx5['rotorteeth'];
        };
        if (_0x9f0fx5['motorteeth']) {
            _0x9f0fx2['motorT']['value'] = _0x9f0fx5['motorteeth'];
        };
        if (_0x9f0fx5['propeller']) {
            for (i = 1; i < _0x9f0fx2['proptype']['options']['length']; i++) {
                if (_0x9f0fx2['proptype']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['propeller']) >= 0) {
                    _0x9f0fx2['proptype']['options'][i]['selected'] = true;
                    break;
                };
            };
            if (_0x9f0fx5['proptwist']) {
                _0x9f0fx2['proptwist']['options'][(1 * _0x9f0fx5['proptwist'])]['selected'] = true;
            };
            if (_0x9f0fx5['diameter']) {
                _0x9f0fx2['propdiameter']['value'] = _0x9f0fx5['diameter'];
            };
            if (_0x9f0fx5['pitch']) {
                _0x9f0fx2['proppitch']['value'] = _0x9f0fx5['pitch'];
            };
            if (_0x9f0fx5['blades']) {
                _0x9f0fx2['propblades']['value'] = _0x9f0fx5['blades'];
            };
            configProp();
        };
        if (_0x9f0fx5['edf']) {
            for (i = 1; i < _0x9f0fx2['proptype']['options']['length']; i++) {
                if (_0x9f0fx2['proptype']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['edf']) >= 0) {
                    _0x9f0fx2['proptype']['options'][i]['selected'] = true;
                    break;
                };
            };
            if (_0x9f0fx5['fsa']) {
                _0x9f0fx2['duct']['value'] = _0x9f0fx5['fsa'];
            };
        };
        if (_0x9f0fx5['rotor']) {
            for (i = 1; i < _0x9f0fx2['proptype']['options']['length']; i++) {
                if (_0x9f0fx2['proptype']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['rotor']) >= 0) {
                    _0x9f0fx2['proptype']['options'][i]['selected'] = true;
                    break;
                };
            };
            if (_0x9f0fx5['pitch']) {
                for (i = 1; i < _0x9f0fx2['rotorpitch']['options']['length']; i++) {
                    if (_0x9f0fx2['rotorpitch']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['pitch']) >= 0) {
                        _0x9f0fx2['rotorpitch']['options'][i]['selected'] = true;
                        break;
                    };
                };
            };
            if (_0x9f0fx5['diameter']) {
                _0x9f0fx2['propdiameter']['value'] = _0x9f0fx5['diameter'];
            };
            if (_0x9f0fx5['blades']) {
                _0x9f0fx2['propblades']['value'] = _0x9f0fx5['blades'];
            };
            configProp();
        };
        if (_0x9f0fx5['width']) {
            _0x9f0fx2['carWidth']['value'] = _0x9f0fx5['width'];
        };
        if (_0x9f0fx5['height']) {
            _0x9f0fx2['carHeight']['value'] = _0x9f0fx5['height'];
        };
        if (_0x9f0fx5['time']) {
            _0x9f0fx2['timeToSpeed']['value'] = _0x9f0fx5['time'];
        };
        if (_0x9f0fx5['cartyp']) {
            for (i = 1; i < _0x9f0fx2['cw']['options']['length']; i++) {
                if (_0x9f0fx2['cw']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['cartyp']) >= 0) {
                    _0x9f0fx2['cw']['options'][i]['selected'] = true;
                    break;
                };
            };
        };
        if (_0x9f0fx5['drivetyp']) {
            for (i = 1; i < _0x9f0fx2['efficiencyTransmission']['options']['length']; i++) {
                if (_0x9f0fx2['efficiencyTransmission']['options'][i]['text']['toLowerCase']()['indexOf'](_0x9f0fx5['drivetyp']) >= 0) {
                    _0x9f0fx2['efficiencyTransmission']['options'][i]['selected'] = true;
                    break;
                };
            };
        };
        if (_0x9f0fx5['pinion']) {
            _0x9f0fx2['motorpinion']['value'] = _0x9f0fx5['pinion'];
        };
        if (_0x9f0fx5['spur']) {
            _0x9f0fx2['spurpinion']['value'] = _0x9f0fx5['spur'];
        };
        if (_0x9f0fx5['transmission']) {
            _0x9f0fx2['transmission']['value'] = _0x9f0fx5['transmission'];
        };
        if (_0x9f0fx5['differential']) {
            _0x9f0fx2['diffGear']['value'] = _0x9f0fx5['differential'];
        };
        if (_0x9f0fx5['wheel']) {
            _0x9f0fx2['wheeldiameter']['value'] = _0x9f0fx5['wheel'];
        };
        if (_0x9f0fx5['cooling']) {
            if (_0x9f0fx5['cooling'] == 'excellent') {
                _0x9f0fx2['cooling']['options'][0]['selected'] = true;
            } else {
                if (_0x9f0fx5['cooling'] == 'good') {
                    _0x9f0fx2['cooling']['options'][1]['selected'] = true;
                } else {
                    if (_0x9f0fx5['cooling'] == 'medium') {
                        _0x9f0fx2['cooling']['options'][2]['selected'] = true;
                    } else {
                        if (_0x9f0fx5['cooling'] == 'poor') {
                            _0x9f0fx2['cooling']['options'][3]['selected'] = true;
                        } else {
                            if (_0x9f0fx5['cooling'] == 'very poor') {
                                _0x9f0fx2['cooling']['options'][4]['selected'] = true;
                            };
                        };
                    };
                };
            };
        };
        motorcalcs();
    };
    _0x9f0fx2['celltype']['focus']();
};

function createLink(_0x9f0fx2) {
    with(document['inputform']) {
        if (isCommercialUser) {
            var _0x9f0fxa = '';
            _0x9f0fxa = location['host'] + location['pathname'];
            var _0x9f0fxb = location['search']['split']('&');
            _0x9f0fxa = _0x9f0fxa + _0x9f0fxb[0];
            if (_0x9f0fx2['units'] != null) {
                if (_0x9f0fx2['units']['selectedIndex'] == 1) {
                    _0x9f0fxa = _0x9f0fxa + '&units=imperial';
                };
            };
            if (_0x9f0fx2['CopterWt'] != null) {
                _0x9f0fxa = _0x9f0fxa + '&weight=' + _0x9f0fx2['CopterWt']['value'];
            };
            if (_0x9f0fx2['wtCalc'] != null) {
                _0x9f0fxa = _0x9f0fxa + '&calc=' + _0x9f0fx2['wtCalc']['options'][_0x9f0fx2['wtCalc']['selectedIndex']]['value'];
            };
            if (_0x9f0fx2['rotorNumber'] != null) {
                _0x9f0fxa = _0x9f0fxa + '&rotornumber=' + _0x9f0fx2['rotorNumber']['value'];
            };
            _0x9f0fxa = _0x9f0fxa + '&elevation=' + _0x9f0fx2['elevation']['value'];
            _0x9f0fxa = _0x9f0fxa + '&airtemp=' + _0x9f0fx2['temp']['value'];
            if (_0x9f0fx2['celltype']['selectedIndex'] > 0) {
                _0x9f0fxa = _0x9f0fxa + '&batteries=' + _0x9f0fx2['celltype']['options'][_0x9f0fx2['celltype']['selectedIndex']]['text'];
                _0x9f0fxa = _0x9f0fxa + '&s=' + _0x9f0fx2['numcells']['value'];
                _0x9f0fxa = _0x9f0fxa + '&p=' + _0x9f0fx2['cellsparallel']['value'];
                if (_0x9f0fx2['chargeState'] != null) {
                    _0x9f0fxa = _0x9f0fxa + '&chargestate=';
                    if (_0x9f0fx2['chargeState']['selectedIndex'] == 0) {
                        _0x9f0fxa = _0x9f0fxa + 'full';
                    } else {
                        if (_0x9f0fx2['chargeState']['selectedIndex'] == 1) {
                            _0x9f0fxa = _0x9f0fxa + 'normal';
                        } else {
                            if (_0x9f0fx2['chargeState']['selectedIndex'] == 2) {
                                _0x9f0fxa = _0x9f0fxa + 'low';
                            };
                        };
                    };
                };
            };
            if (_0x9f0fx2['conttype']['selectedIndex'] > 0) {
                _0x9f0fxa = _0x9f0fxa + '&esc=' + _0x9f0fx2['conttype']['options'][_0x9f0fx2['conttype']['selectedIndex']]['text'];
            };
            if (_0x9f0fx2['hersteller']['selectedIndex'] > 0) {
                _0x9f0fxa = _0x9f0fxa + '&motor=' + _0x9f0fx2['hersteller']['options'][_0x9f0fx2['hersteller']['selectedIndex']]['text'];
            };
            _0x9f0fxb = _0x9f0fx2['motortyp']['options'][_0x9f0fx2['motortyp']['selectedIndex']]['text']['split'](' (');
            if (_0x9f0fx2['motortyp']['selectedIndex'] > 0) {
                _0x9f0fxa = _0x9f0fxa + '&type=' + _0x9f0fxb[0];
            };
            if ((_0x9f0fx2['gearratio'] != null) && (_0x9f0fx2['gearratio']['value'] != '1.00')) {
                _0x9f0fxa = _0x9f0fxa + '&gear=' + _0x9f0fx2['gearratio']['value'];
            };
            if ((location['pathname']['indexOf']('motorcalc') >= 0) || (location['pathname']['indexOf']('xcoptercalc') >= 0)) {
                if (_0x9f0fx2['proptype']['selectedIndex'] > 0) {
                    _0x9f0fxa = _0x9f0fxa + '&propeller=' + _0x9f0fx2['proptype']['options'][_0x9f0fx2['proptype']['selectedIndex']]['text'];
                    if (!_0x9f0fx2['proptwist']['disabled']) {
                        _0x9f0fxa = _0x9f0fxa + '&proptwist=' + _0x9f0fx2['proptwist']['selectedIndex'];
                    };
                    if (_0x9f0fx2['propdiameter']['value'] != '') {
                        _0x9f0fxa = _0x9f0fxa + '&diameter=' + _0x9f0fx2['propdiameter']['value'];
                    };
                    if (_0x9f0fx2['proppitch']['value'] != '') {
                        _0x9f0fxa = _0x9f0fxa + '&pitch=' + _0x9f0fx2['proppitch']['value'];
                    };
                    if (_0x9f0fx2['propblades'] != null && _0x9f0fx2['propblades']['value'] != '') {
                        _0x9f0fxa = _0x9f0fxa + '&blades=' + _0x9f0fx2['propblades']['value'];
                    };
                };
            };
            if (location['pathname']['indexOf']('fancalc') >= 0) {
                if (_0x9f0fx2['proptype']['selectedIndex'] > 0) {
                    _0x9f0fxa = _0x9f0fxa + '&edf=' + _0x9f0fx2['proptype']['options'][_0x9f0fx2['proptype']['selectedIndex']]['text'];
                    if (_0x9f0fx2['duct']['value'] != '100') {
                        _0x9f0fxa = _0x9f0fxa + '&fsa=' + _0x9f0fx2['duct']['value'];
                    };
                };
            };
            if (location['pathname']['indexOf']('helicalc') >= 0) {
                if (_0x9f0fx2['proptype']['selectedIndex'] > 0) {
                    _0x9f0fxa = _0x9f0fxa + '&rotor=' + _0x9f0fx2['proptype']['options'][_0x9f0fx2['proptype']['selectedIndex']]['text'];
                    if (_0x9f0fx2['propdiameter']['value'] != '') {
                        _0x9f0fxa = _0x9f0fxa + '&diameter=' + _0x9f0fx2['propdiameter']['value'];
                    };
                    _0x9f0fxa = _0x9f0fxa + '&pitch=' + _0x9f0fx2['rotorpitch']['options'][_0x9f0fx2['rotorpitch']['selectedIndex']]['text'];
                };
                if ((_0x9f0fx2['rotorT'] != null)) {
                    _0x9f0fxa = _0x9f0fxa + '&rotorteeth=' + _0x9f0fx2['rotorT']['value'];
                };
                if ((_0x9f0fx2['motorT'] != null)) {
                    _0x9f0fxa = _0x9f0fxa + '&motorteeth=' + _0x9f0fx2['motorT']['value'];
                };
            };
            if (location['pathname']['indexOf']('carcalc') >= 0) {
                if (_0x9f0fx2['carWidth']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&width=' + _0x9f0fx2['carWidth']['value'];
                };
                if (_0x9f0fx2['carHeight']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&height=' + _0x9f0fx2['carHeight']['value'];
                };
                if (_0x9f0fx2['timeToSpeed']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&time=' + _0x9f0fx2['timeToSpeed']['value'];
                };
                _0x9f0fxa = _0x9f0fxa + '&cartyp=' + _0x9f0fx2['cw']['options'][_0x9f0fx2['cw']['selectedIndex']]['text'];
                _0x9f0fxa = _0x9f0fxa + '&drivetyp=' + _0x9f0fx2['efficiencyTransmission']['options'][_0x9f0fx2['efficiencyTransmission']['selectedIndex']]['text'];
                if (_0x9f0fx2['motorpinion']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&pinion=' + _0x9f0fx2['motorpinion']['value'];
                };
                if (_0x9f0fx2['spurpinion']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&spur=' + _0x9f0fx2['spurpinion']['value'];
                };
                if (_0x9f0fx2['transmission']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&transmission=' + _0x9f0fx2['transmission']['value'];
                };
                if (_0x9f0fx2['diffGear']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&differential=' + _0x9f0fx2['diffGear']['value'];
                };
                if (_0x9f0fx2['wheeldiameter']['value'] != '') {
                    _0x9f0fxa = _0x9f0fxa + '&wheel=' + _0x9f0fx2['wheeldiameter']['value'];
                };
            };
            _0x9f0fxa = _0x9f0fxa['toLowerCase']()['replace'](/\s/g, '_');
            document['getElementById']('directLink')['innerHTML'] = _0x9f0fxa;
        };
    };
};
