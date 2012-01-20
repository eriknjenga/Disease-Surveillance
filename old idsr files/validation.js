/***************************/
//@Author: Adrian "yEnS" Mato Gondelle & Ivan Guardado Castro
//@website: www.yensdesign.com
//@email: yensamg@gmail.com
//@license: Feel free to use it, but keep this credits please!					
/***************************/

$(document).ready(function(){
	//global vars
	var form = $("#customForm");
		
	//infant/sample id
	var pid= $("#pid");
	var pidInfo = $("#pidInfo");
	//age months
	var age= $("#age");
	var ageInfo = $("#ageInfo");
	//age
	var ageweeks= $("#ageweeks");
	var ageweeksInfo = $("#ageweeksInfo");
	
	//no of spots
	var spot= $("#sspot");
	var spotInfo = $("#spotInfo");	
	//recieved status
	var srecstatus= $("#srecstatus");
	var recstatusInfo = $("#recstatusInfo");	
	//mother hiv
	var mhivstatus= $("#mhivstatus");
	var mhivstatusInfo = $("#mhivstatusInfo");
	//mother feeding
	var mbfeeding= $("#mbfeeding");
	var mbfeedingInfo = $("#mbfeedingInfo");
	//mother drug
	var mdrug= $("#mdrug");
	var mdrugInfo = $("#mdrugInfo");
	//infant prophylaxis
	var infantprophylaxis= $("#infantprophylaxis");
	var infantprophylaxisInfo = $("#infantprophylaxisInfo");
	//entry point
	var mentpoint= $("#mentpoint");
	var mentpointInfo = $("#mentpointInfo");
	//datecollected
	var sdoc= $("#datecollected");
	var sdocInfo = $("#sdocInfo");
	//dAte received
	var sdrec= $("#datereceived");
	var sdrecInfo = $("#sdrecInfo");
	//dAte dispatched
	var ddispatched= $("#datedispatched");
	var ddispatchedInfo = $("#datedispatchedInfo");
	
	//rejectedreason
	var rejectedreason= $("#rejectedreason");
	var rejectedreasonInfo = $("#rejectedreasonInfo");
	//repeatreason
	var repeatreason= $("#repeatreason");
	var repeatreasonInfo = $("#repeatreasonInfo");
	

	
	
	
	//On blur
	
	pid.blur(validatePid);
	age.blur(validateAge);
	ageweeks.blur(validateAgeweeks);
	spot.blur(validateSpot);
	srecstatus.blur(validateSrecstatus);
	mhivstatus.blur(validateMhivstatus);
	mbfeeding.blur(validateMbfeeding);
	mdrug.blur(validateMdrug);
	infantprophylaxis.blur(validateInfantprophylaxis);
	 mentpoint.blur(validateMentpoint);
	 sdoc.blur(validateDatecollected);
	 sdrec.blur(validateDateReceived);
	//ddispatched.blur(validateDispatchfromfacility);
	//rejectedreason.blur(validateRejectedRepeatReasons);
	//repeatreason.blur(validateRejectedRepeatReasons);
	//On key press

	pid.keyup(validatePid);
	age.keyup(validateAge);
	ageweeks.keyup(validateAgeweeks);
	spot.keyup(validateSpot);
	srecstatus.keyup(validateSrecstatus);
	mhivstatus.keyup(validateMhivstatus);
	mbfeeding.keyup(validateMbfeeding);
	mdrug.keyup(validateMdrug);
	infantprophylaxis.keyup(validateInfantprophylaxis);
	mentpoint.keyup(validateMentpoint);
	sdoc.keyup(validateDatecollected);
	sdrec.keyup(validateDateReceived);
	//ddispatched.keyup(validateDispatchfromfacility);
	//rejectedreason.keyup(validateRejectedRepeatReasons);
	//repeatreason.keyup(validateRejectedRepeatReasons);
	//ON CLICK
		sdoc.click(validateDatecollected);
	sdrec.click(validateDateReceived);
	//ddispatched.click(validateDispatchfromfacility);
	// confirmatorypcr.click(validateConfirmatorypcr);
	//on chnage
	sdoc.change(validateDatecollected);
	sdrec.change(validateDateReceived);
	//ddispatched.change(validateDispatchfromfacility);
	//rejectedreason.change(validateRejectedRepeatReasons);
	//repeatreason.change(validateRejectedRepeatReasons);
	//On Submitting validateCat() && validateDatepicker()& validateRepeatforrejection()& validateRejectedRepeatReasons()& validateConfirmDates()
	form.submit(function()
		{//
		if( validatePid()   & validateAge() & validateAgeweeks()  & validateMhivstatus() & validateMbfeeding() & validateMdrug() & validateInfantprophylaxis() &validateMentpoint() & validateSpot() & validateSrecstatus()    & validateDatecollected() & validateDateReceived()    )
			return true
		else
			return false;
	});
	
	
 
	//ensure facility selected
		function validateDatepicker(){
		//if it's NOT valid
		if(datepicker.val().length < 1){
			datepicker.addClass("error");
			datepickerInfo.text("Please Enter DOB!");
			datepickerInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			datepicker.removeClass("error");
			datepickerInfo.text("");
			datepickerInfo.removeClass("error");
			return true;
		}
	}
//ensure infant/sample code not null
	function validatePid()
	{
		
	//if it's NOT valid
		if(pid.val().length < 1){
			pid.addClass("error");
			pidInfo.text("Please  enter sample code!");
			pidInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			pid.removeClass("error");
			pidInfo.text("");
			pidInfo.removeClass("error");
			return true;
		}
	}
	
	
	//ensure infant/sample code not null
	function validateAge()
	{
		
		var a = $("#age").val();
			var filter = /^[0-9_.]+$/;
//if it's NOT valid

			 if ((age.val() > 18.9) || (!(filter.test(a)))  )  //if it's NOT valid
		{		
				age.addClass("error");
			ageInfo.text("Please  enter Valid Month!");
			ageInfo.addClass("error");
			return false;
		
		}
		else { //if it's valid email
				age.removeClass("error");
			ageInfo.text(""); 
			ageInfo.removeClass("error");
			return true;
				
			
			
		}		
		
	
		
	}
	
	//ensure infant/sample code not null
	function validateAgeweeks()
	{
		
		var a = $("#ageweeks").val();
		var filter = /^[0-9_.]+$/;
//if it's NOT valid

			 if ((ageweeks.val() > 72.9) || (!(filter.test(a)))  )  //if it's NOT valid
		{		
				ageweeks.addClass("error");
			ageweeksInfo.text("Please  enter Valid Weeks!");
			ageweeksInfo.addClass("error");
			return false;
		
		}
		else { //if it's valid email
				ageweeks.removeClass("error");
			ageweeksInfo.text(""); 
			ageweeksInfo.removeClass("error");
			return true;
				
			
			
		}		
		
	
		
	}
	//ensure mother hiv
		function validateMhivstatus(){
		//if it's NOT valid
		if(mhivstatus.val().length < 1){
			mhivstatus.addClass("error");
			mhivstatusInfo.text("Please Select Mother HIV Status!");
			mhivstatusInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			mhivstatus.removeClass("error");
			mhivstatusInfo.text("");
			mhivstatusInfo.removeClass("error");
			return true;
		}
	}
	//ensure mother drugs
		function validateMdrug(){
		//if it's NOT valid
		if(mdrug.val().length < 1){
			mdrug.addClass("error");
			mdrugInfo.text("Please Select PMTCT Intervention!");
			mdrugInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			mdrug.removeClass("error");
			mdrugInfo.text("");
			mdrugInfo.removeClass("error");
			return true;
		}
	}
	
	//ensure mother feeding type
		function validateMbfeeding(){
		//if it's NOT valid
		if(mbfeeding.val().length < 1){
			mbfeeding.addClass("error");
			mbfeedingInfo.text("Please Select Feeding Type!");
			mbfeedingInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			mbfeeding.removeClass("error");
			mbfeedingInfo.text("");
			mbfeedingInfo.removeClass("error");
			return true;
		}
	}
	//ensure mother entry point
		function validateMentpoint(){
		//if it's NOT valid
		if(mentpoint.val().length < 1){
			mentpoint.addClass("error");
			mentpointInfo.text("Please Select Entry Point!");
			mentpointInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			mentpoint.removeClass("error");
			mentpointInfo.text("");
			mentpointInfo.removeClass("error");
			return true;
		}
	}
	//validate infant prophylaxis
	
			function validateInfantprophylaxis(){
		//if it's NOT valid
		if(infantprophylaxis.val().length < 1){
			infantprophylaxis.addClass("error");
			infantprophylaxisInfo.text("Please Select Infant Prophylaxis Type!");
			infantprophylaxisInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			infantprophylaxis.removeClass("error");
			infantprophylaxisInfo.text("");
			infantprophylaxisInfo.removeClass("error");
			return true;
		}
	}
	//ensure no of spots selected
		function validateSpot(){
		//if it's NOT valid
		if(spot.val().length < 1){
			spot.addClass("error");
			spotInfo.text("Please Select Number of Spots!");
			spotInfo.addClass("error");
			return false;
		}
		//if it's valid
		else{
			spot.removeClass("error");
			spotInfo.text("");
			spotInfo.removeClass("error");
			return true;
		}
	}
		//ensure received status not null; must select
		function validateSrecstatus(){
		//if it's NOT valid
		if(srecstatus.val().length < 1){
			srecstatus.addClass("error");
			recstatusInfo.text("Please Select Received Status!");
			recstatusInfo.addClass("error");
			return false;
		}
		//if it's valid
		else
		{
			srecstatus.removeClass("error");
			recstatusInfo.text("");
			recstatusInfo.removeClass("error");
			validateRejectedRepeatReasons();
			return true;
			
		}
	}
	
	//ensure received status not null; must select
		function validateRejectedRepeatReasons()
		{
		//if it's NOT valid
			if(   (srecstatus.val()=="3") && (rejectedreason.val()=="") )
			{
			 rejectedreason.addClass("error");
			 rejectedreasonInfo.text("Please Select Reason for Rejection!");
			 rejectedreasonInfo.addClass("error");
			return false;
			}
			else if( (srecstatus.val()=="3") && (repeatreason.val().length <1) )
			{
			repeatreason.addClass("error");
			repeatreasonInfo.text("Please Select Reason for Repeat!");
			repeatreasonInfo.addClass("error");
			return false;
			} 
			else
			{
			
			rejectedreason.removeClass("error");
			rejectedreasonInfo.text("");
			rejectedreasonInfo.removeClass("error");
			repeatreason.removeClass("error");
			repeatreasonInfo.text("");
			repeatreasonInfo.removeClass("error");
			return true;
			}
			
		}
	
	//validate date colleceted
	function validateDatecollected(){
		var a = $("#password");
		var b = $("#confirmpassword");

		//it's NOT valid
		if(sdoc.val().length <1){
			sdoc.addClass("error");
			sdocInfo.text("Please Enter Date Collected");
			sdocInfo.addClass("error");
			return false;
		}
		//it's valid
		else{			
			sdoc.removeClass("error");
			sdocInfo.text("");
			sdocInfo.removeClass("error");
			
			return true;
		}
	}
	function validateConfirmDates()
	{
	
				/*	//are NOT valid
					if( sdoc.val() >= sdrec.val() ){
					sdoc.addClass("error");
					sdocInfo.text("Invalid Date Collected!,Should not be greater than date received.");
					sdocInfo.addClass("error");
					return false;
					}
					else if( ddispatched.val() > sdrec.val() ){
					ddispatched.addClass("error");
					ddispatchedInfo.text("Invalid Date Dispatched!,Should not be Greater than Date Received.");
					ddispatchedInfo.addClass("error");
					return false;
					}
					//are valid
					else{
					sdoc.removeClass("error");
					sdocInfo.text("");
					sdocInfo.removeClass("error");
					ddispatched.removeClass("error");
					ddispatchedInfo.text("");
					ddispatchedInfo.removeClass("error");
					return true;
					
					}
					*/
				
	}
		//validate date received
	function validateDateReceived(){
		var a = $("#password");
		var b = $("#confirmpassword");

		//it's NOT valid
		if(sdrec.val().length <1){
			sdrec.addClass("error");
			sdrecInfo.text("Please Enter Date Received");
			sdrecInfo.addClass("error");
			return false;
		}
		//it's valid
		else{			
			sdrec.removeClass("error");
			sdrecInfo.text("");
			sdrecInfo.removeClass("error");
			//validateConfirmDates();
			return true;
		}
	}
	//validate date dispatched from facility
	

	
	//validate passwords
	/*function validateRepeatforrejection(){
		
		//it's NOT valid  && (confirmatorypcr.val()=="Y"))
		if(repeatforrejection.val().length > 0)
		  {
		 	repeatforrejection.removeClass("error");
			repeatInfo.text("");
			repeatInfo.removeClass("error");
			validateConfirmatorypcr();
			return true;
		}
		
	}*/
	//function validateConfirmatorypcr()
	//{
		
		//are NOT valid
		/*if( (confirmatorypcr.val()=="Y") && (repeatforrejection.val()=="Y")  )
		{
			confirmatorypcr.addClass("error");
			confirmatoryInfo.text("Select only one option!");
			confirmatoryInfo.addClass("error");
			return false;
		}
				//are valid
		else 
		{
			confirmatorypcr.removeClass("error");
			confirmatoryInfo.text("");
			confirmatoryInfo.removeClass("error");
			return true;
		}
	}
	*/
	
	
});