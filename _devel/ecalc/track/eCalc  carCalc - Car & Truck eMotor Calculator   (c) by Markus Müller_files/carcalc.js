//*****         Copyright 2005-2011 by Markus Mueller, www.s4a.ch, Switzerland        *****
//-----------------------------------------------------------------------------------------
//   All source codes, data, texts, pictures and graphs and their arrangements are subject 
//   to copyright and are the intellectual property of Solution for All Markus M�ller. 
//   They may neither be copied for forwarding nor used in an amended form or on other 
//   websites or servers or any kind of electronic device.
//
//   *** (c) This Source-Code might NOT be used without any permission from M. Mueller *** 
//

var _0x3041=["\x56\x20\x58\x43\x30\x2E\x30\x34\x2C\x20\x32\x30\x2E\x39\x2E\x31\x30\x20\x2F\x20","\x61\x70\x70\x4E\x61\x6D\x65","\x63\x65\x6C\x6C\x74\x79\x70\x65","\x6C\x65\x6E\x67\x74\x68","\x6F\x70\x74\x69\x6F\x6E\x73","\x20\x2D\x20","\x2F","\x43","\x63\x6F\x6E\x74\x74\x79\x70\x65","\x76\x61\x6C\x75\x65","\x73\x65\x6C\x65\x63\x74\x65\x64\x49\x6E\x64\x65\x78","\x68\x65\x72\x73\x74\x65\x6C\x6C\x65\x72","","\x74\x65\x78\x74","\x20","\x41","\x57","\x73\x71\x72\x74","\x69\x6E\x70\x75\x74\x66\x6F\x72\x6D","\x6F\x75\x74\x57\x61\x72\x6E\x69\x6E\x67","\x70\x6F\x77","\x50\x49","\x61\x62\x73","\x30\x2E\x30"];var theVersion=_0x3041[0]+dataVersion;var evaluateEDF=false;var withAirData=true;var browserName=navigator[_0x3041[1]];var accuChargeState=1;var qnh=1013;function loadDropDown(_0x48e6x8){var _0x48e6x9=_0x48e6x8[_0x3041[2]];var _0x48e6xa,_0x48e6xb;for(_0x48e6xa=0;_0x48e6xa<cellArray[_0x3041[3]];_0x48e6xa++){_0x48e6xb=cellArray[_0x48e6xa];_0x48e6x9[_0x3041[4]][_0x48e6xa+1]= new Option(_0x48e6xb[0]+_0x3041[5]+_0x48e6xb[4]+_0x3041[6]+_0x48e6xb[5]+_0x3041[7],_0x48e6xa+1,false,false);} ;_0x48e6x9=_0x48e6x8[_0x3041[8]];for(_0x48e6xa=0;_0x48e6xa<controlerArray[_0x3041[3]];_0x48e6xa++){_0x48e6xb=controlerArray[_0x48e6xa];_0x48e6x9[_0x3041[4]][_0x48e6xa+1]= new Option(_0x48e6xb[0],_0x48e6xa+1,false,false);} ;if(_0x48e6x8[_0x3041[11]][_0x48e6x8[_0x3041[11]][_0x3041[10]]][_0x3041[9]]>=0){loadMotorTyps(_0x48e6x8);} ;} ;function calcElectric(){with(document[_0x3041[18]]){if(celltype[_0x3041[10]]>0){Akku[_0x3041[9]]=cellArray[celltype[_0x3041[10]]-1][0];} else {Akku[_0x3041[9]]=_0x3041[12];} ;Regler[_0x3041[9]]=conttype[_0x3041[4]][conttype[_0x3041[10]]][_0x3041[13]];Motor[_0x3041[9]]=hersteller[_0x3041[4]][hersteller[_0x3041[10]]][_0x3041[13]]+_0x3041[14]+motortyp[_0x3041[4]][motortyp[_0x3041[10]]][_0x3041[13]];if(numcells[_0x3041[9]]<=1){numcells[_0x3041[9]]=1;} ;if(cellsparallel[_0x3041[9]]<=1){cellsparallel[_0x3041[9]]=1;} ;if(Vcell[_0x3041[9]]<=0.5){Vcell[_0x3041[9]]=0.5;} ;if(Resc[_0x3041[9]]<=0){Resc[_0x3041[9]]=0;} ;if((1*outLimit[_0x3041[9]])<(1*outIo[_0x3041[9]])){outLimit[_0x3041[9]]=outIo[_0x3041[9]];} ;TheCellNum=GetSelectValue(celltype)-1;if(TheCellNum>=0){TheCellRc=cellArray[TheCellNum][2];TheCellCap=cellArray[TheCellNum][1];TheCellWeight=cellArray[TheCellNum][3];TheCellMaxC=cellArray[TheCellNum][5];TheCellV=cellArray[TheCellNum][6];outRc[_0x3041[9]]=TheCellRc;outCellCap[_0x3041[9]]=TheCellCap*cellsparallel[_0x3041[9]];outCellOz[_0x3041[9]]=TheCellWeight;Vcell[_0x3041[9]]=TheCellV;} ;TheContNum=GetSelectValue(conttype)-1;if(TheContNum>=0){Resc[_0x3041[9]]=controlerArray[TheContNum][1];ResWt[_0x3041[9]]=controlerArray[TheContNum][2];ResI[_0x3041[9]]=controlerArray[TheContNum][3];ResIMax[_0x3041[9]]=controlerArray[TheContNum][4];} ;TheCellCap=outCellCap[_0x3041[9]];TheCellWeight=outCellOz[_0x3041[9]];outPackOz[_0x3041[9]]=round(TheCellWeight*numcells[_0x3041[9]]*cellsparallel[_0x3041[9]],3);outPackV[_0x3041[9]]=round(Vcell[_0x3041[9]]*numcells[_0x3041[9]],2);TheMotorNum=GetSelectValue(motortyp);if(TheMotorNum>0){TheMotorNoLoad=MotorNoLoad[TheMotorNum];TheMotorNoLoadVoltage=MotorNoLoadVoltage[TheMotorNum];TheMotorPols=MotorPols[TheMotorNum];TheMotorKv=MotorConsts[TheMotorNum];if(hersteller[_0x3041[4]][hersteller[_0x3041[10]]][_0x3041[9]]==20){TheMotorKv=round((TheMotorKv/0.95),0);} ;TheMotorRes=round(MotorRes[TheMotorNum]/1000,5);TheMotorLength=MotorLength[TheMotorNum];TheMotorLimit=MotorLimit[TheMotorNum];TheMotorLimitTyp=MotorLimitTyp[TheMotorNum];TheMotorKt=1352/TheMotorKv;outMotoroz[_0x3041[9]]=MotorWeight[TheMotorNum];} else {TheMotorNoLoad=outIo[_0x3041[9]];TheMotorNoLoadVoltage=1*outUIo[_0x3041[9]];TheMotorPols=1*outPols[_0x3041[9]];TheMotorKv=outKv[_0x3041[9]];TheMotorRes=outRm[_0x3041[9]];TheMotorLength=outLength[_0x3041[9]];TheMotorLimit=outLimit[_0x3041[9]];TheMotorLimitTyp=outLimitTyp[_0x3041[4]][outLimitTyp[_0x3041[10]]][_0x3041[9]];TheMotorKt=1352/TheMotorKv;} ;outKv[_0x3041[9]]=TheMotorKv;outKt[_0x3041[9]]=TheMotorKt;outRm[_0x3041[9]]=TheMotorRes;outIo[_0x3041[9]]=TheMotorNoLoad;outUIo[_0x3041[9]]=TheMotorNoLoadVoltage;outPols[_0x3041[9]]=TheMotorPols;outLength[_0x3041[9]]=TheMotorLength;outLimit[_0x3041[9]]=TheMotorLimit;if(TheMotorLimitTyp==_0x3041[15]){outLimitTyp[_0x3041[10]]=0;} ;if(TheMotorLimitTyp==_0x3041[16]){outLimitTyp[_0x3041[10]]=1;} ;TempFELoss=(Vcell[_0x3041[9]]*numcells[_0x3041[9]]*TheMotorNoLoad);TempIMaxEff=round(Math[_0x3041[17]](TempFELoss/TheMotorRes),2);TempVoltsToMotorMaxEff=(Vcell[_0x3041[9]]*numcells[_0x3041[9]])-((outRc[_0x3041[9]]*numcells[_0x3041[9]]/cellsparallel[_0x3041[9]]*TempIMaxEff)+(Resc[_0x3041[9]]*TempIMaxEff));TempIoEstimate=GetIo(TempVoltsToMotorMaxEff,TempIMaxEff);FELoss=TempVoltsToMotorMaxEff*TempIoEstimate;IMaxEff=round(Math[_0x3041[17]](FELoss/TheMotorRes),2);VoltsToMotorMaxEff=(Vcell[_0x3041[9]]*numcells[_0x3041[9]])-((outRc[_0x3041[9]]*numcells[_0x3041[9]]/cellsparallel[_0x3041[9]]*IMaxEff)+(Resc[_0x3041[9]]*IMaxEff));IoEstimate=GetIo(VoltsToMotorMaxEff,IMaxEff);WInMaxEff=round(VoltsToMotorMaxEff*IMaxEff,2);WOutMaxEff=round((VoltsToMotorMaxEff-TheMotorRes*IMaxEff)*(IMaxEff-IoEstimate),2);PctMaxEff=round((WOutMaxEff/WInMaxEff)*100,1);outIEff[_0x3041[9]]=IMaxEff;outVEff[_0x3041[9]]=round(VoltsToMotorMaxEff,2);outRPMEff[_0x3041[9]]=round(TheMotorKv*(VoltsToMotorMaxEff-(IMaxEff*TheMotorRes)),0);outWinEff[_0x3041[9]]=WInMaxEff;outWoutEff[_0x3041[9]]=WOutMaxEff;outPctMaxEff[_0x3041[9]]=PctMaxEff;} ;} ;function motorcalcs(){document[_0x3041[18]][_0x3041[19]][_0x3041[9]]=_0x3041[12];if(userStatementAccepted==false){document[_0x3041[18]][_0x3041[19]][_0x3041[9]]=msgUserStatementNotAccepted;return ;} ;with(document[_0x3041[18]]){airdensity=100*qnh*Math[_0x3041[20]]((1-(0.0065*elevation[_0x3041[9]]/288.15)),5.255)/287.05/(1*temp[_0x3041[9]]+273.15);totalreduction[_0x3041[9]]=round(1*diffGear[_0x3041[9]]*transmission[_0x3041[9]]*spurpinion[_0x3041[9]]/motorpinion[_0x3041[9]],3);calcElectric();var _0x48e6xe=0.0;var _0x48e6xf=0.0;var _0x48e6x10=0.0;var _0x48e6x11=0.0;var _0x48e6x12=0.0;var _0x48e6x13=0.0;var _0x48e6x14=0.0;var _0x48e6x15;_0x48e6x12=0.9*numcells[_0x3041[9]]*Vcell[_0x3041[9]];_0x48e6x13=_0x48e6x12*outKv[_0x3041[9]]/(1.0*totalreduction[_0x3041[9]])*(1.0*wheeldiameter[_0x3041[9]])*Math[_0x3041[21]]/60/1000;outPctEffmaxV[_0x3041[9]]=outPctMaxEff[_0x3041[9]];while(Math[_0x3041[22]](_0x48e6x14-_0x48e6x13)>0.01){_0x48e6x14=_0x48e6x13;_0x48e6x10=Math[_0x3041[20]](_0x48e6x14,3)/2*GetSelectValue(cw)*carWidth[_0x3041[9]]/1000*carHeight[_0x3041[9]]/1000*airdensity;_0x48e6xf=_0x48e6x10/(0.01*outPctEffmaxV[_0x3041[9]])/(1.00*GetSelectValue(efficiencyTransmission));_0x48e6xe=_0x48e6xf/_0x48e6x12;_0x48e6x11=(1.0*Vcell[_0x3041[9]]*numcells[_0x3041[9]])-((1.0*outRc[_0x3041[9]]*numcells[_0x3041[9]]/(1.0*cellsparallel[_0x3041[9]])*_0x48e6xe)+(_0x48e6xe*Resc[_0x3041[9]]));_0x48e6x15=GetIo(VoltsToMotorMaxEff,_0x48e6xe);_0x48e6x12=_0x48e6x11;_0x48e6x13=(_0x48e6x11-(_0x48e6xe*outRm[_0x3041[9]]))*outKv[_0x3041[9]]/(1.0*totalreduction[_0x3041[9]])*(1.0*wheeldiameter[_0x3041[9]])*Math[_0x3041[21]]/60/1000;outWinmaxV[_0x3041[9]]=round(_0x48e6x11*_0x48e6xe,2);outWoutmaxV[_0x3041[9]]=round((_0x48e6x11-_0x48e6xe*outRm[_0x3041[9]])*(_0x48e6xe-_0x48e6x15),2);outPctEffmaxV[_0x3041[9]]=round(100.0*outWoutmaxV[_0x3041[9]]/(1.0*outWinmaxV[_0x3041[9]]),1);if((1*outPctEffmaxV[_0x3041[9]])<0){_0x48e6x14=_0x48e6x13;} ;} ;if(_0x48e6xe>_0x48e6x15){outImaxV[_0x3041[9]]=round(_0x48e6xe,2);} else {outImaxV[_0x3041[9]]=_0x48e6x15;} ;if((1*outPctEffmaxV[_0x3041[9]])<0){outVmaxV[_0x3041[9]]=_0x3041[12];outRPMmaxV[_0x3041[9]]=_0x3041[12];outWinmaxV[_0x3041[9]]=_0x3041[12];outPctEffmaxV[_0x3041[9]]=_0x3041[12];outWoutmaxV[_0x3041[9]]=_0x3041[12];outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgBurnSetup;} else {outVmaxV[_0x3041[9]]=round(_0x48e6x11,2);outRPMmaxV[_0x3041[9]]=round(1*outKv[_0x3041[9]]*(_0x48e6x11-(_0x48e6xe*outRm[_0x3041[9]])),0);outWheelRpm[_0x3041[9]]=round(1*outRPMmaxV[_0x3041[9]]/(1.0*totalreduction[_0x3041[9]]),0);} ;outCarSpeedMetric[_0x3041[9]]=round(_0x48e6x13*3.6,2);outCarSpeedImperial[_0x3041[9]]=round(_0x48e6x13*3.6*0.62,2);outRolloutMetric[_0x3041[9]]=round(Math[_0x3041[21]]*wheeldiameter[_0x3041[9]]/(1.0*totalreduction[_0x3041[9]]),0);outRolloutImperial[_0x3041[9]]=round(Math[_0x3041[21]]*wheeldiameter[_0x3041[9]]/(1.0*totalreduction[_0x3041[9]])/25.4,2);_0x48e6x10=1*AUW[_0x3041[9]]/timeToSpeed[_0x3041[9]]*Math[_0x3041[20]](_0x48e6x13,2)+Math[_0x3041[20]](_0x48e6x13,3)/2*GetSelectValue(cw)*carWidth[_0x3041[9]]/1000*carHeight[_0x3041[9]]/1000*airdensity;outPout[_0x3041[9]]=round(_0x48e6x10,2);outPctEff[_0x3041[9]]=outPctMaxEff[_0x3041[9]];_0x48e6x12=0;_0x48e6x11=1*numcells[_0x3041[9]]*Vcell[_0x3041[9]];while(Math[_0x3041[22]](_0x48e6x12-_0x48e6x11)>0.01){_0x48e6x12=_0x48e6x11;_0x48e6xf=_0x48e6x10/(0.01*outPctEff[_0x3041[9]])/GetSelectValue(efficiencyTransmission);_0x48e6xe=_0x48e6xf/_0x48e6x12;_0x48e6x11=(Vcell[_0x3041[9]]*numcells[_0x3041[9]])-((outRc[_0x3041[9]]*numcells[_0x3041[9]]/cellsparallel[_0x3041[9]]*_0x48e6xe)+(Resc[_0x3041[9]]*_0x48e6xe));_0x48e6x15=GetIo(VoltsToMotorMaxEff,_0x48e6xe);_0x48e6x13=(_0x48e6x11-(_0x48e6xe*outRm[_0x3041[9]]))*outKv[_0x3041[9]]/totalreduction[_0x3041[9]]*wheeldiameter[_0x3041[9]]*Math[_0x3041[21]]/60/1000;outWin[_0x3041[9]]=round(_0x48e6x11*_0x48e6xe,2);outWout[_0x3041[9]]=round((_0x48e6x11-_0x48e6xe*outRm[_0x3041[9]])*(_0x48e6xe-_0x48e6x15),2);outPctEff[_0x3041[9]]=round(100*outWout[_0x3041[9]]/(1*outWin[_0x3041[9]]),1);if((1*outPctEff[_0x3041[9]])<0){_0x48e6x12=_0x48e6x11;} ;} ;if(_0x48e6xe>_0x48e6x15){outImotor[_0x3041[9]]=round(_0x48e6xe,2);} else {outImotor[_0x3041[9]]=_0x48e6x15;} ;if((1*outPctEff[_0x3041[9]])<0){outVmotor[_0x3041[9]]=_0x3041[23];outRPM[_0x3041[9]]=_0x3041[23];outWin[_0x3041[9]]=_0x3041[23];outPctEff[_0x3041[9]]=_0x3041[23];outWout[_0x3041[9]]=_0x3041[23];outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgBurnSetup;} else {outVmotor[_0x3041[9]]=round(_0x48e6x11,2);outRPM[_0x3041[9]]=round(1*outKv[_0x3041[9]]*(_0x48e6x11-(_0x48e6xe*outRm[_0x3041[9]])),0);} ;_0x48e6xe=1*outImotor[_0x3041[9]];outMaxC[_0x3041[9]]=round(_0x48e6xe/(0.001*outCellCap[_0x3041[9]]),1);outPackV[_0x3041[9]]=round(1*numcells[_0x3041[9]]*Vcell[_0x3041[9]],2);outPackVeff[_0x3041[9]]=round((1*outPackV[_0x3041[9]])-(_0x48e6xe*outRc[_0x3041[9]]*numcells[_0x3041[9]]/cellsparallel[_0x3041[9]]),2);outDuration[_0x3041[9]]=round(0.00085*outCellCap[_0x3041[9]]/_0x48e6xe*60,2);outDurationMix[_0x3041[9]]=round(0.00085*outCellCap[_0x3041[9]]/_0x48e6xe*2*60,2);outPackOz[_0x3041[9]]=round(TheCellWeight*numcells[_0x3041[9]]*cellsparallel[_0x3041[9]],0);outPowersysOz[_0x3041[9]]=round(((1*outMotoroz[_0x3041[9]])+(1*ResWt[_0x3041[9]])+(1*outPackOz[_0x3041[9]]))*1.1,0);outPin[_0x3041[9]]=outWin[_0x3041[9]];outTotEff[_0x3041[9]]=round(1*outPout[_0x3041[9]]/outPin[_0x3041[9]],2);plotMotorGraph(true);if(numcells[_0x3041[9]]<2){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgTwoCells;} ;if((1*outMaxC[_0x3041[9]])>(1*TheCellMaxC)){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgMaxCuttentBattery;} ;if((ResIMax[_0x3041[9]]!=_0x3041[12])&&((1*outImotor[_0x3041[9]])>(1*ResIMax[_0x3041[9]]))){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgMaxCurrentESC;} ;if((outLimitTyp[_0x3041[4]][outLimitTyp[_0x3041[10]]][_0x3041[13]]==_0x3041[15])&&(outLimit[_0x3041[9]]!=_0x3041[12])&&(1*outIEff[_0x3041[9]]>0.9*outLimit[_0x3041[9]])){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgUMotorHigh;} ;if((outLimitTyp[_0x3041[4]][outLimitTyp[_0x3041[10]]][_0x3041[13]]==_0x3041[16])&&(outLimit[_0x3041[9]]!=_0x3041[12])&&(1*outIEff[_0x3041[9]]*outVEff[_0x3041[9]]>0.9*outLimit[_0x3041[9]])){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgUMotorHigh;} ;if((1*outIEff[_0x3041[9]])>(1*outImotor[_0x3041[9]])&&1*outPctMaxEff[_0x3041[9]]-1*outPctEff[_0x3041[9]]>3){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgBelowIOpt;} ;if((outLimitTyp[_0x3041[4]][outLimitTyp[_0x3041[10]]][_0x3041[13]]==_0x3041[15])&&(outLimit[_0x3041[9]]!=_0x3041[12])&&(1*outImotor[_0x3041[9]]>1*outLimit[_0x3041[9]])){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgMaxCurrentMotor;} ;if((outLimitTyp[_0x3041[4]][outLimitTyp[_0x3041[10]]][_0x3041[13]]==_0x3041[16])&&(outLimit[_0x3041[9]]!=_0x3041[12])&&(1*outWin[_0x3041[9]]>1*outLimit[_0x3041[9]])){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgMaxPowerMotor;} ;var _0x48e6x16=0;_0x48e6x16=1*temp[_0x3041[9]]+(1*outWin[_0x3041[9]]-1*outWout[_0x3041[9]])*2.718*GetSelectValue(cooling)/6.283186/(outLength[_0x3041[9]]/1000)/(-0.024*(273.15+1*temp[_0x3041[9]])+65.552);if(_0x48e6x16>80){outWarning[_0x3041[9]]=outWarning[_0x3041[9]]+msgOverTemp;} ;} ;} ;
