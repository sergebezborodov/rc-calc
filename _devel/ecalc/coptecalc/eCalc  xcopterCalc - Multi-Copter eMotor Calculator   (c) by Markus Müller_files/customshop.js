//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
// This Source-Code deals with the hit counter and logo of different shops.
// The Hit Counter Shows The total hits. In the Statistics The Shop Hits are shown.
//
// Hit Counter Management: http://www.easycounter.com/user/
//
// If Customer Likes Imperial Units at start-up of engl. version 
// adapt selectCustomerUnits() --> preselect.js
//
// www.modellflugtipps.de Ranking Code ganz unten!
// 
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//
if (document['referrer']['indexOf']('modellbau-ramseyer.ch') >= 0) {
    location['replace']('./accessdenied.htm');
};
if (document['referrer']['indexOf']('flightcorner.ch') >= 0) {
    location['replace']('./accessdenied.htm');
};
if (document['referrer']['indexOf']('injetdesigns.com') >= 0) {
    location['replace']('./accessdenied.htm');
};
var motorcalcD = 'motorcalc.htm' + location['search'];
var motorcalcE = 'motorcalc_e.htm' + location['search'];
var motorcalcF = 'motorcalc_f.htm' + location['search'];
var motorcalcC = 'motorcalc_c.htm' + location['search'];
var fancalcD = 'fancalc.htm' + location['search'];
var fancalcE = 'fancalc_e.htm' + location['search'];
var fancalcF = 'fancalc_f.htm' + location['search'];
var fancalcC = 'fancalc_c.htm' + location['search'];
var helicalcD = 'helicalc.htm' + location['search'];
var helicalcE = 'helicalc_e.htm' + location['search'];
var helicalcF = 'helicalc_f.htm' + location['search'];
var helicalcC = 'helicalc_c.htm' + location['search'];
var xcoptercalcD = 'xcoptercalc.htm' + location['search'];
var xcoptercalcE = 'xcoptercalc_e.htm' + location['search'];
var xcoptercalcF = 'xcoptercalc_f.htm' + location['search'];
var xcoptercalcC = 'xcoptercalc_c.htm' + location['search'];
var userStatementAccepted = false;
var isServicePayed = true;
var isCommercialUser = true;
var theShopLogo = '<a href=\'http://www.s4a.ch\' target=\'_blank\'><img border=\'0\' src=\'calcs/p_s4alogo.gif\' width=\'81\' height=\'45\'></a>';
var theShopMotors = '<OPTION value=39>actro <OPTION value=52>Aeolian <OPTION value=41>ARC <OPTION value=1>AXI <OPTION value=25>Cyclon <OPTION value=38>Dualsky <OPTION value=30>E-flite <OPTION value=31>EMAX  <OPTION value=10>ePower X <OPTION value=50>EP Product<OPTION value=32>Faigao <OPTION value=33>Flyware <OPTION value=2>Hacker <OPTION value=21>HET <OPTION value=36>Himax <OPTION value=3>Hyperion <OPTION value=28>Infinite <OPTION value=37>KEDA <OPTION value=6>Kontronik <OPTION value=20>Lehner <OPTION value=11>Leomotion <OPTION value=59>Leopard <OPTION value=56>LiPolice <OPTION value=55>Magic Torque <OPTION value=4>Mini AC <OPTION value=9>Mega Motor <OPTION value=5>NeuMotors <OPTION value=57>O.S.Motor <OPTION value=60>Planet-Hobby <OPTION value=40>Plettenberg <OPTION value=53>PowerHD <OPTION value=48>ProTronik <OPTION value=51>Pulso <OPTION value=54>RCTimer <OPTION value=43>RedRock <OPTION value=47>RimFire <OPTION value=44>robbe ROXXY <OPTION value=42>Roton <OPTION value=8>Scorpion <OPTION value=58>Tenshock <OPTION value=45>Thunder Tiger <OPTION value=46>Tiger Motor <OPTION value=34>Torcster <OPTION value=35>Turnigy <OPTION value=21>Typhoon <OPTION value=7>Waypoint <OPTION value=49>Xera <OPTION value=0>Alle </OPTION>';
var theShopCounter = '<img src=\'http://www.easycounter.com/counter.php?s4a,other\' border=\'0\' alt=\'Website Hit Counter\'>';
var theShopForm = 'admin_s4a/add.asp';
var theShopCustomData = '';

function acceptUserStatement() {
    var _0x646bx1a = '';
    if (!isServicePayed) {
        _0x646bx1a = msgUserStatement1;
    };
    _0x646bx1a = _0x646bx1a + msgUserStatement2;
    if (confirm(_0x646bx1a)) {
        userStatementAccepted = true;
    };
};

function showLeaveMsg() {
    var _0x646bx1a = '';
    if (!isServicePayed) {
        _0x646bx1a = msgLeave;
        alert(_0x646bx1a);
    };
};

function isCallAllowed(_0x646bx1d, _0x646bx1e) {
    var _0x646bx1f = location['search']['split']('&');
    if ((_0x646bx1f[0] == '?' + _0x646bx1d) && ((document['referrer']['search'](_0x646bx1e) >= 0) || (document['referrer']['search']('s4a.ch') >= 0) || (document['referrer']['search']('ecalc.ch') >= 0) || (document['referrer'] == ''))) {
        if (document['referrer']['search']('ecalc.ch') >= 0) {
            theShopCounter = '';
        } else {
            theShopCounter = '<img src=\'http://www.easycounter.com/counter.php?s4a,' + _0x646bx1d + '\' border=\'0\' alt=\'Website Hit Counter\'>';
        };
        return true;
    } else {
        return false;
    };
};
if (isCallAllowed('s4a', 's4a.ch') || isCallAllowed('s4a', 'ecalc.ch')) {
    theShopCounter = '<img src=\'http://www.easycounter.com/counter.php?s4a,s4a\' border=\'0\' alt=\'Website Hit Counter\'>';
    isServicePayed = false;
} else {
    if (isCallAllowed('ecalc', 'rcgroups.com') || isCallAllowed('ecalc', 'ecalc.ch') || isCallAllowed('ecalc', 's4a.ch')) {
        theShopCounter = '<img src=\'http://www.easycounter.com/counter.php?s4a,eCalc\' border=\'0\' alt=\'Website Hit Counter\'>';
        isServicePayed = false;
    } else {
        if (isCallAllowed('castle', 'castlecreations.com')) {
            theShopLogo = '<a href=\'http://www.castlecreations.com\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/castlecreations.jpg\'></a>';
            theDonationForm = theShopLogo;
            theShopCustomData = '<script language=\'JavaScript\' src=\'./calcs/custom/castlecreations.js\'> </script>';
            theShopForm = '';
        } else {
            if (isCallAllowed('dualsky', 'dualsky.com')) {
                theShopLogo = '<a href=\'http://www.dualsky.com/\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/dualsky.jpg\'></a>';
                theDonationForm = theShopLogo;
                theShopMotors = '<OPTION value=38 selected>Dualsky </OPTION>';
                theShopForm = '';
                theShopCustomData = '<script language=\'JavaScript\' src=\'./calcs/custom/dualsky.js\'> </script>';
            } else {
                if (isCallAllowed('grischa', 'grischamodellbau.ch')) {
                    theShopLogo = '<a href=\'http://www.grischamodellbau.ch\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/grischa.jpg\'></a>';
                    theDonationForm = '<a href=\'http://www.grischamodellbau.ch\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/grischa2.jpg\'></a>';
                    theShopMotors = '<OPTION value=30>E-flite <OPTION value=50>EP Product<OPTION value=36>Himax <OPTION value=48>ProTronik <OPTION value=44>robbe ROXXY <OPTION value=45>Thunder Tiger </OPTION>';
                    theShopForm = '';
                } else {
                    if (isCallAllowed('leomotion', 'leomotion.com') || isCallAllowed('leomotion', 'leomotion.ch')) {
                        theShopLogo = '<a href=\'http://www.leomotion.com\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/leomotion.jpg\'></a>';
                        theDonationForm = theShopLogo;
                        theShopMotors = '<OPTION value=11 selected>Leomotion </OPTION>';
                        theShopForm = 'admin_leomotion/add.asp';
                    } else {
                        if (isCallAllowed('eflight', '')) {
                            if ((document['referrer']['search']('epower.ch/login') >= 0) || (document['referrer']['search']('ecalc.ch') >= 0)) {
                                theShopLogo = '<a href=\'http://www.eflight.ch\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/eflight.gif\'></a>';
                                theDonationForm = theShopLogo;
                                theShopMotors = '<OPTION value=1>AXI <OPTION value=10>ePower <OPTION value=2>Hacker <OPTION value=3>Hyperion <OPTION value=4>Mini AC <OPTION value=9>Mega Motor <OPTION value=5>NeuMotors <OPTION value=6>Kontronik <OPTION value=8>Scorpion <OPTION value=46>Tiger Motor <OPTION value=7>Waypoint </OPTION>';
                                theShopForm = 'admin_eflight/add.asp';
                            } else {
                                sec = 'motorcalc';
                                if (location['pathname'] == '/motorcalc.htm') {
                                    sec = 'motorcalc';
                                } else {
                                    if (location['pathname'] == '/fancalc.htm') {
                                        sec = 'fancalc';
                                    } else {
                                        if (location['pathname'] == '/helicalc.htm') {
                                            sec = 'helicalc';
                                        };
                                    };
                                };
                                location['replace']('http://epower.ch/login/in.php?sec=' + sec);
                            };
                        } else {
                            if (isCallAllowed('neumotors', 'neumotors.com')) {
                                theShopLogo = '<a href=\'http://www.neumotors.com\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/neumotors.jpg\'></a>';
                                theDonationForm = theShopLogo;
                                theShopMotors = '<OPTION value=5 selected>NeuMotors </OPTION>';
                                theShopCustomData = '<script language=\'JavaScript\' src=\'./calcs/custom/castlecreations.js\'> </script>';
                                theShopForm = '';
                            } else {
                                if (isCallAllowed('generic', 'ecalc.ch')) {
                                    theShopLogo = '<a href=\'http://www.s4a.ch/\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/generic.gif\'></a>';
                                    theDonationForm = theShopLogo;
                                    theShopForm = '';
                                } else {
                                    if (isCallAllowed('espritmodel', 'espritmodel.com')) {
                                        theShopLogo = '<a href=\'http://www.espritmodel.com\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/espritmodel.jpg\'></a>';
                                        theDonationForm = theShopLogo;
                                        theShopMotors = '<OPTION value=1>AXI <OPTION value=30>E-flite <OPTION value=2>Hacker <OPTION value=3>Hyperion <OPTION value=6>Kontronik <OPTION value=9>Mega Motor <OPTION value=5>NeuMotors <OPTION value=47>RimFire <OPTION value=8>Scorpion <OPTION value=49>Xera <OPTION value=0>All </OPTION>';
                                        theShopForm = '';
                                        theShopCounter = '<img src=\'http://www.easycounter.com/counter.php?ecalc,espritmodel\' border=\'0\' alt=\'Website Hit Counter\'>';
                                    } else {
                                        if (isCallAllowed('lindinger', 'lindinger.at')) {
                                            theShopLogo = '<a href=\'http://www.lindinger.at\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/lindinger.jpg\'></a>';
                                            theDonationForm = theShopLogo;
                                            theShopMotors = '<OPTION value=1>AXI <OPTION value=38>Dualsky <OPTION value=30>E-flite <OPTION value=2>Hacker <OPTION value=3>Hyperion <OPTION value=6>Kontronik <OPTION value=9>Mega Motor <OPTION value=57>O.S.Motor <OPTION value=44>robbe ROXXY </OPTION>';
                                            theShopForm = '';
                                        } else {
                                            if (isCallAllowed('modelflight', 'modelflight.com.au')) {
                                                theShopLogo = '<a href=\'http://www.modelflight.com.au\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/generic.gif\'></a>';
                                                theDonationForm = theShopLogo;
                                                theShopMotors = '<OPTION value=38>Dualsky <OPTION value=30>E-flite <OPTION value=6>Kontronik <OPTION value=11>Leomotion </OPTION>';
                                                theShopForm = '';
                                            } else {
                                                if (isCallAllowed('123qweasd', 'epproduct.com')) {
                                                    theShopLogo = '<a href=\'http://www.epproduct.com\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/x_epproduct.jpg\'></a>';
                                                    theDonationForm = theShopLogo;
                                                    theShopMotors = '<OPTION value=50 selected>EP </OPTION>';
                                                    theShopCounter = '<img src=\'http://www.easycounter.com/counter.php?s4a,epproduct\' border=\'0\' alt=\'Website Hit Counter\'>';
                                                    theShopForm = '';
                                                } else {
                                                    if (isCallAllowed('simprop', 'simprop.de')) {
                                                        theShopLogo = '<a href=\'http://www.simprop.de\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/simprop.gif\'></a>';
                                                        theDonationForm = theShopLogo;
                                                        theShopMotors = '<OPTION value=55 selected>Magic Torque <OPTION value=47>RimFire </OPTION>';
                                                        theShopForm = '';
                                                    } else {
                                                        if (isCallAllowed('kontronik', 'kontronik.com')) {
                                                            theShopLogo = '<a href=\'http://www.kontronik.com\' target=\'_top\'><img border=\'0\' src=\'calcs/logo/kontronik.jpg\'></a>';
                                                            theDonationForm = theShopLogo;
                                                            theShopMotors = '<OPTION value=6 selected>Kontronik </OPTION>';
                                                            theShopForm = '';
                                                        } else {
                                                            isServicePayed = false;
                                                            isCommercialUser = false;
                                                        };
                                                    };
                                                };
                                            };
                                        };
                                    };
                                };
                            };
                        };
                    };
                };
            };
        };
    };
};
theShopCounter = theShopCounter + '<a href=\'http://www.modellflugtipps.de/toplinks/toplinks.php?id=2016\' target=\'_blank\'>' + '<img src=\'http://www.modellflugtipps.de/toplinks/image.php?id=2016\' border=0 vspace=0 hspace=0 height=\'0\' width=\'0\'></a>';