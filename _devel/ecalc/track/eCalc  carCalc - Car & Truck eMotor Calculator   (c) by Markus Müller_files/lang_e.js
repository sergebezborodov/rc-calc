
//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
// This Source-Code deals with the Error Messages in different Languages.
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//
//-----------------------------------------------------------------------------------------

// English:

var theDonationForm = 		"<form action='https://www.paypal.com/cgi-bin/webscr' method='post'>"+
				"<input type='hidden' name='cmd' value='_s-xclick'>"+
				"<input type='hidden' name='hosted_button_id' value='UHHTBVT44LR2N'>"+
				"<input type='image' src='https://www.paypalobjects.com/en_US/CH/i/btn/btn_donateCC_LG.gif' border='0' name='submit' alt='PayPal - The safer, easier way to pay online!'>"+
				"<img alt='' border='0' src='https://www.paypalobjects.com/de_DE/i/scr/pixel.gif' width='1' height='1'></form>";



var msgUserStatement1 = 	"This is a free Service from Solution for All (www.s4a.ch).\n" +
                                "For continuous develpment we appreciate donation from satisfied customers.\n" +
                                "Thank you.\n\n" +
                                "For commercial use please contact ecalc@s4a.ch\n\n";

var msgUserStatement2 =		"Statement for using this calculator:\n" +
                  		"All values are calculated and may deviate from the real.\n" +
                  		"Before flight you have to recheck the actual max. current.\n" +
                  		"All max. values must stay within the limits of the manufacturer.\n"+
                  		"A commercial use is forbidden. eCalc is subject to copyright.\n"+
                  		"We reject any liability!\n\n"+
                  		"Do you accept this Statement?";

var msgLeave =			"This is a free Service from Solution for All (www.s4a.ch).\n" +
             			"For continuous develpment we appreciate donation from satisfied customers.\n" +
             			"Thank you.";

var msgUserStatementNotAccepted="You did not accept the statement for using this calculator. Therefore no calculation is done.";

var msgCV =                     "Copyright Violation!\nYou are using an unauthorized copy of this software.\nThis is an offence against international copyright laws.\nPlease report this violation to ecalc@s4a.ch\n\nThank you.";

var msgTwoCells =		"* Most Motor uses at least 2 LiPo Cells or more *";

var msgBelowIOpt =              "* Running below the Current of optimal Efficiency is inefficient. Use a smaller motor *";

var msgUMotorHigh =             "* The Motor Voltage is close to the Limit - please verify the max. allowed Motor Voltage *";

var msgMaxCurrentESC =		"* max. current over the limit of the controller *";

var msgMaxCurrentMotor =	"* max. current over the limit of the motor. Please verify the limits (current, power, rpm) defined by the manufacturer! *";

var msgMaxPowerMotor =		"* max. power over the limit of the motor. Please check the limits! *";

var msgMaxCuttentBattery =	"* max. current over the limit of the battery *";

var msgPropStall =		"* Prop may stall -> static thrust may not be reached! (see Prop Stall Thrust) *";
var msgPropStallX =		"* Prop will stall, calculation for hovering not possible! (reduce Pitch) *";

var msgNegPitch =               "* Your propeller values (Twist and Pitch) resulting in a negative propeller pitch *";

var msgRotorStall =		"* Rotor may stall -> static thrust may not be reached! (see Rotor Stall Thrust) *";

var msgTipSpeed =               "* The Blade Tip Speed is over MACH .85 *";

var msgStaticThrust =		"* static Thrust < Drive Weight *";

var msgOverTemp =		"* the prediction of the motor case temperature is critical (>80°C/180°F). Please check! *";

var msgThrustDuct =             "* thrust duct calculation is not possible for this EDF *";

var msgFSA =			"* your thrust duct has a wrong dimension. A correct calculation is not possible. Choose 60..100% FSA *";

var msgUnableHover =            "* The Power is not sufficient to hover *";
var msgBadManeuver =            "* For good maneuverability you need Throttle of less than 80% *";

var msgBurnSetup =              "* This Current will burn your entire setup *";
var msgUnrealsisticSetup =      "* Your Setup is unrealistic and way out of Limits *";

var msgPitchToHover1 =          "(at approx. ";
var msgPitchToHover2 =          "° Pitch)";


//for Graphic
var msgLable1 = "el. Power [in ";
var msgLable2 = "Efficiency [%]";
var msgLable3a= "max. Revolutions [in ";
var msgLable3b= "rpm]";
var msgLable4 = "wast Power [W]";
var msgLable5 = "Motor Case Temp. overlimit [°C]";
var msgLable5F= "Motor Case Temp. overlimit [°F]";
var msgLable6 = "max. Current at ";
var msgLable7 = "Motor Case Temp. [°C]";
var msgLable7F = "Motor Case Temp. [°F]";
var msgLimit = "over Limit"; 




