//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
//   All source codes, data, texts, pictures and graphs and their arrangements are subject 
//   to copyright and are the intellectual property of Solution for All Markus Müller. 
//   They may neither be copied for forwarding nor used in an amended form or on other 
//   websites or servers or any kind of electronic device.
//
//   using free ware flot (http://code.google.com/p/flot/)
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//
var plotVersion = '1.07';
var lable1;
var lable2;
var lable3a, lable3b;
var lable4;
var lable5;
var lable6;
var lable7;
var TheUnits = 'metric';
lable1 = msgLable1;
lable2 = msgLable2;
lable3a = msgLable3a;
lable3b = msgLable3b;
lable4 = msgLable4;
lable5 = msgLable5;
lable6 = msgLable6;
lable7 = msgLable7;

function plotMotorGraph(_0xa0f5xc) {
    with(document['inputform']) {
        var _0xa0f5xd = [];
        var _0xa0f5xe = [];
        var _0xa0f5xf = [];
        var _0xa0f5x10 = [];
        var _0xa0f5x11 = [];
        var _0xa0f5x12 = [];
        var _0xa0f5x13 = [];
        var _0xa0f5x14 = 1;
        var _0xa0f5x15 = 100;
        var _0xa0f5x16 = 100000;
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'W') && (outLimit['value'] != '') && (1 * outLimit['value'] > 0)) {
            _0xa0f5x16 = (1 * outLimit['value']) / outVmotor['value'];
        };
        if ((outLimitTyp['options'][outLimitTyp['selectedIndex']]['text'] == 'A') && (outLimit['value'] != '') && (1 * outLimit['value'] > 0)) {
            _0xa0f5x16 = (1 * outLimit['value']);
        };
        if (ResIMax['value'] != '' && 1 * ResIMax['value'] > 0 && _0xa0f5x16 > 1 * ResIMax['value']) {
            _0xa0f5x16 = 1 * ResIMax['value'];
        };
        if (GetSelectValue(celltype) > 0) {
            if (_0xa0f5x16 > cellArray[GetSelectValue(celltype)][5] * outCellCap['value'] / 1000) {
                _0xa0f5x16 = cellArray[GetSelectValue(celltype)][5] * outCellCap['value'] / 1000;
            };
        };
        xmin = Number(GetIo(accuChargeState * Vcell['value'] * numcells['value'], 1 * outIo['value']));
        ymax = 100;
        ymin = 0;
        if (TheUnits == 'metric') {
            lable5 = msgLable5;
        } else {
            lable5 = msgLable5F;
        };
        if (TheUnits == 'metric') {
            lable7 = msgLable7;
        } else {
            lable7 = msgLable7F;
        };
        if (outImotor['value'] < 8.5) {
            xmax = 10;
        } else {
            xmax = 1.2 * outImotor['value'];
        };
        _0xa0f5x14 = GetSelectValue(PowerScale);
        if ((1 * outRPM['value']) > 17500) {
            _0xa0f5x15 = 1000;
        };
        if (_0xa0f5x14 == 0) {
            _0xa0f5x14 = 1;
            if (1 * outWout['value'] > 200) {
                _0xa0f5x14 = 2;
            };
            if (1 * outWout['value'] > 500) {
                _0xa0f5x14 = 5;
            };
            if (1 * outWout['value'] > 1000) {
                _0xa0f5x14 = 10;
            };
            if (1 * outWout['value'] > 2000) {
                _0xa0f5x14 = 20;
            };
            if (1 * outWout['value'] > 5000) {
                _0xa0f5x14 = 50;
            };
            if (1 * outWout['value'] > 10000) {
                _0xa0f5x14 = 100;
            };
        };
        if (TheUnits == 'metric') {
            TheTemp = 1 * temp['value'];
            TheMotorLength = 1 * outLength['value'];
        } else {
            TheTemp = (1 * temp['value'] - 32) / 9 * 5;
            TheMotorLength = 25.4 * outLength['value'];
        };
        var _0xa0f5x17 = (xmax - xmin) / 70;
        var _0xa0f5x18;
        for (x = xmin; x <= xmax; x += _0xa0f5x17) {
            var _0xa0f5x19 = (accuChargeState * Vcell['value'] * numcells['value']) - ((1 * outRc['value'] * numcells['value'] / cellsparallel['value'] * x) + (Resc['value'] * x));
            var _0xa0f5x1a = _0xa0f5x19 * x;
            var _0xa0f5x1b = (_0xa0f5x19 - x * outRm['value']) * (x - GetIo(_0xa0f5x19, x));
            var _0xa0f5x1c = outKv['value'] * (_0xa0f5x19 - (x * outRm['value']));
            _0xa0f5xd['push']([x, (_0xa0f5x1a / _0xa0f5x14)]);
            if (_0xa0f5x1b <= 0) {
                _0xa0f5x1b = 0;
            };
            _0xa0f5xe['push']([x, round((_0xa0f5x1b / _0xa0f5x1a) * 100, 2)]);
            if (_0xa0f5x1c <= 0) {
                _0xa0f5x1c = 0;
            };
            _0xa0f5xf['push']([x, _0xa0f5x1c / _0xa0f5x15]);
            _0xa0f5x10['push']([x, ((_0xa0f5x1a - _0xa0f5x1b) / _0xa0f5x14)]);
            plotTemp = TheTemp + (_0xa0f5x1a - _0xa0f5x1b) * 2.718 * GetSelectValue(cooling) / 6.283186 / (TheMotorLength / 1000) / (-0.024 * (273.15 + 1 * TheTemp) + 65.552);
            if (TheUnits == 'imperial') {
                plotTemp = plotTemp * 9 / 5 + 32;
            };
            _0xa0f5x11['push']([x, plotTemp]);
        };
        var _0xa0f5x1d = [{
            color: 'rgb(255, 245, 234)',
            xaxis: {
                from: _0xa0f5x16
            }
        }, {
            color: 'rgb(255, 210, 164)',
            lineWidth: 2,
            xaxis: {
                from: _0xa0f5x16,
                to: _0xa0f5x16
            }
        }];
        if (TheUnits == 'metric') {
            _0xa0f5x18 = $['plot']($('#placeholder'), [{
                label: lable1 + _0xa0f5x14 + 'W]',
                data: _0xa0f5xd,
                lines: {
                    show: true
                }
            }, {
                label: lable2,
                data: _0xa0f5xe,
                lines: {
                    show: true
                }
            }, {
                label: lable3a + _0xa0f5x15 + lable3b,
                data: _0xa0f5xf,
                lines: {
                    show: true
                },
                color: 'rgb(100, 30, 100)'
            }, {
                label: lable4,
                data: _0xa0f5x10,
                lines: {
                    show: true
                },
                color: 'rgb(190, 100, 0)'
            }, {
                label: lable7,
                data: _0xa0f5x13,
                lines: {
                    show: true
                },
                color: 'rgb(30, 180, 20)'
            }, {
                label: lable5,
                data: _0xa0f5x11,
                lines: {
                    show: true
                },
                threshold: {
                    below: '80',
                    color: 'rgb(30, 180, 20)'
                },
                color: 'rgb(200, 20, 30)'
            }], {
                xaxis: {
                    min: 0
                },
                yaxis: {
                    min: 0,
                    autoscaleMargin: null
                },
                grid: {
                    markings: _0xa0f5x1d
                },
                legend: {
                    position: 'nw'
                }
            });
        } else {
            _0xa0f5x18 = $['plot']($('#placeholder'), [{
                label: lable1 + _0xa0f5x14 + 'W]',
                data: _0xa0f5xd,
                lines: {
                    show: true
                }
            }, {
                label: lable2,
                data: _0xa0f5xe,
                lines: {
                    show: true
                }
            }, {
                label: lable3a + _0xa0f5x15 + lable3b,
                data: _0xa0f5xf,
                lines: {
                    show: true
                },
                color: 'rgb(100, 30, 100)'
            }, {
                label: lable4,
                data: _0xa0f5x10,
                lines: {
                    show: true
                },
                color: 'rgb(190, 100, 0)'
            }, {
                label: lable7,
                data: _0xa0f5x13,
                lines: {
                    show: true
                },
                color: 'rgb(30, 180, 20)'
            }, {
                label: lable5,
                data: _0xa0f5x11,
                lines: {
                    show: true
                },
                threshold: {
                    below: '180',
                    color: 'rgb(30, 180, 20)'
                },
                color: 'rgb(200, 20, 30)'
            }], {
                xaxis: {
                    min: 0
                },
                yaxis: {
                    min: 0,
                    autoscaleMargin: null
                },
                grid: {
                    markings: _0xa0f5x1d
                },
                legend: {
                    position: 'nw'
                }
            });
        };
        var _0xa0f5x1e;
        if (xmax > 1.1 * _0xa0f5x16) {
            _0xa0f5x1e = _0xa0f5x18['pointOffset']({
                x: _0xa0f5x16,
                y: 0.96 * _0xa0f5x18['getAxes']()['yaxis']['datamax']
            });
            $('#placeholder')['append']('<div style="position:absolute;left:' + (_0xa0f5x1e['left'] + 12) + 'px;top:' + (_0xa0f5x1e['top'] - 12) + 'px;color:"rgb(255, 128, 0)";font-size:smaller">' + msgLimit + '</div>');
            var _0xa0f5x1f = _0xa0f5x18['getCanvas']()['getContext']('2d');
            _0xa0f5x1f['beginPath']();
            _0xa0f5x1f['moveTo'](_0xa0f5x1e['left'], _0xa0f5x1e['top']);
            _0xa0f5x1f['lineTo'](_0xa0f5x1e['left'], _0xa0f5x1e['top'] - 10);
            _0xa0f5x1f['lineTo'](_0xa0f5x1e['left'] + 10, _0xa0f5x1e['top'] - 5);
            _0xa0f5x1f['lineTo'](_0xa0f5x1e['left'], _0xa0f5x1e['top']);
            _0xa0f5x1f['fillStyle'] = 'rgb(255, 210, 164)';
            _0xa0f5x1f['fill']();
        };
        _0xa0f5x1e = _0xa0f5x18['pointOffset']({
            x: (0.88 * xmax),
            y: (0.03 * _0xa0f5x18['getAxes']()['yaxis']['datamax'])
        });
        $('#placeholder')['append']('<div style="position:absolute;left:' + (_0xa0f5x1e['left'] + 4) + 'px;top:' + _0xa0f5x1e['top'] + 'px;color:#666;font-size:7pt">(c) by s4a &nbsp;&nbsp;&nbsp;V' + plotVersion + '</div>');
        var _0xa0f5x20 = Math['round'](((1 * outImotor['value']) - xmin) / _0xa0f5x17);
        if (_0xa0f5x20 > 0) {
            _0xa0f5x18['highlight'](0, _0xa0f5x20);
            _0xa0f5x18['highlight'](1, _0xa0f5x20);
            _0xa0f5x18['highlight'](2, _0xa0f5x20);
            _0xa0f5x18['highlight'](3, _0xa0f5x20);
        };
        if (_0xa0f5xc) {
            var _0xa0f5x20;
            if (document['inputform']['outIhover'] != null) {
                _0xa0f5x20 = Math['round'](((1 * outIhover['value']) - xmin) / _0xa0f5x17);
            };
            if (document['inputform']['outImaxV'] != null) {
                _0xa0f5x20 = Math['round'](((1 * outImaxV['value']) - xmin) / _0xa0f5x17);
            };
            if (_0xa0f5x20 > 0) {
                _0xa0f5x18['highlight'](0, _0xa0f5x20);
                _0xa0f5x18['highlight'](1, _0xa0f5x20);
                _0xa0f5x18['highlight'](3, _0xa0f5x20);
            };
        };
    };
};