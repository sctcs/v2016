function Validate(theForm)
{ 

 if (theForm.StudentFristName)
 {
 	if (theForm.StudentFristName.value == "")
	  {
		alert("Please complete the \"First Name\" field.");
		theForm.StudentFristName.focus();
		return (false);
	  }
	  
	  var targetlist = "<>/\@|%^#.*&()~[]{}";
	  var checkStr = theForm.StudentFristName.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		
		for (j = 0;  j < targetlist.length;  j++)
		{
		  if (ch == targetlist.charAt(j))
			{
				
				allValid = false;
				break; 
			
			}
			
		}
		
		if (!allValid)
		  {
			alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"First Name\" filed");
			theForm.StudentFristName.focus();
			
			return (false);
			//break;
		  }
		allNum += ch;
		
		
	  }
	  
	  
	
	 
 }

 
 if (theForm.StudentLastName)
 {
 	if (theForm.StudentLastName.value == "")
	  {
		alert("Please complete the \"Last Name\" field.");
		theForm.StudentLastName.focus();
		return (false);
	  }
	  
	var targetlist = "<>/\@|%^#.*&()~[]{}";
	  var checkStr = theForm.StudentLastName.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		
		for (j = 0;  j < targetlist.length;  j++)
		{
		  if (ch == targetlist.charAt(j))
			{
				
				allValid = false;
				break; 
			
			}
			
		}
		
		if (!allValid)
		  {
			alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"Last Name\" filed");
			theForm.StudentLastName.focus();
			
			return (false);
			//break;
		  }
		allNum += ch;
		
		
	  }
	  
	  
	
 }
 
 
 //////////////////////////////////////////////////
  ////   Radion button  studentGender          ///
  /////////////////////////////////////////////////
   if (theForm.studentGender)
   { 
   		if (theForm.studentGender[0].checked==false && theForm.studentGender[1].checked==false )
		{
			alert("Please make selection in \"Student Gender\"Field!");
			theForm.studentGender[0].focus();
			return false;
		}
		
   }
   
   
   ////////////////////////////////////////////////////
   /// DOD
   ///////////////////////////////////////////////////
   if (theForm.DateOfBirth)
   { 
   	if (theForm.DateOfBirth.value == "")
	  {
		alert("Please Provide the \"Date of Birth\" field.");
		
		if (theForm.SelectMonth.value == "" )
		{ theForm.SelectMonth.focus();}
		else if (theForm.selectDay.value == "")
		{ theForm.selectDay.focus();}
		else if (theForm.SelectYear.value == "")
		{ theForm.SelectYear.focus();}
		
		return (false);
	  }
		
   }
   
   ////////////////////////////////////////////////////
   /// End of DOD
   ///////////////////////////////////////////////////
   
   
   
   
   //////////////////////////////////////////////////
  ////   Radion button  studentType          ///
  /////////////////////////////////////////////////
   if (theForm.studentType)
   { 
   		if (theForm.studentType[0].checked==false && theForm.studentType[1].checked==false )
		{
			alert("Please select\"Student Type\"!");
			theForm.studentType[0].focus();
			return false;
			
		}
		
		if (theForm.studentType[0].checked==true )
		{ 
		   if (theForm.NewStudentLevel.value == 0)
		   {
		   		alert("Please select a\"Grade\"!");
				theForm.NewStudentLevel.focus();
				return false;
		   }
		}
		else if (theForm.studentType[1].checked==true )
		{
			if (theForm.ReturnStudentLevel.value == 0)
		   {
				alert("Please select a\"Class\"!");
				theForm.ReturnStudentLevel.focus();
				return false;
			}
		}
   }
   
 
 
 /////////////////////////////////////////
 //// Start  Checking Phone number     ////
 //////////////////////////////////////////
if (theForm.area)
  {
	if (theForm.area.value == "")
	  {
		alert("Please complete the \"Telephone Number\" field.");
		theForm.area.focus();
		return (false);
	  }
	
	  if (theForm.area.value.length < 3)
	  {
		alert("Please complete the \"Telephone Number\" field.");
		theForm.area.focus();
		return (false);
	  }
	
	  var checkOK = "0123456789";
	  var checkStr = theForm.area.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		  if (ch == checkOK.charAt(j))
			break;
		if (j == checkOK.length)
		{
		  allValid = false;
		  break;
		}
		allNum += ch;
	  }
	  if (!allValid)
	  {
		alert("Please enter only digits in the \"Telephone Number\" field.");
		theForm.area.focus();
		return (false);
	  }
	
	  if (theForm.prefix.value == "")
	  {
		alert("Please complete the \"Telephone Number\" field.");
		theForm.prefix.focus();
		return (false);
	  }
	
	  if (theForm.prefix.value.length < 3)
	  {
		alert("Please complete the \"Telephone Number\" field.");
		theForm.prefix.focus();
		return (false);
	  }
	
	  var checkOK = "0123456789";
	  var checkStr = theForm.prefix.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		  if (ch == checkOK.charAt(j))
			break;
		if (j == checkOK.length)
		{
		  allValid = false;
		  break;
		}
		allNum += ch;
	  }
	  if (!allValid)
	  {
		alert("Please enter only digits in the \"Telephone Number\" field.");
		theForm.prefix.focus();
		return (false);
	  }
	
	  if (theForm.suffix.value == "")
	  {
		alert("Please complete the \"Telephone Number\" field.");
		theForm.suffix.focus();
		return (false);
	  }
	
	  if (theForm.suffix.value.length < 4)
	  {
		alert("Please complete the \"Telephone Number\" field.");
		theForm.suffix.focus();
		return (false);
	  }
	
	  var checkOK = "0123456789";
	  var checkStr = theForm.suffix.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		  if (ch == checkOK.charAt(j))
			break;
		if (j == checkOK.length)
		{
		  allValid = false;
		  break;
		}
		allNum += ch;
	  }
	  if (!allValid)
	  {
		alert("Please enter only digits in the \"Telephone Number\" field.");
		theForm.suffix.focus();
		return (false);
	  }
  }
  
  /////////////////////////////////////////////////
 ////   End of Checking Phone nubmer  ///
////////////////////////////////////////////////
 
 
 
 /////////////////////////////////////////
 //// Start  Checking Cell Phone number     ////
 //////////////////////////////////////////
if (theForm.Carea)
  { 
	if ( theForm.Carea.value != "")
	  { 
		if (theForm.Carea.value.length < 3)
		  {
			alert("Please complete the \"Cell phone Number\" field.");
			theForm.Carea.focus();
			return (false);
		  }
		
		  var checkOK = "0123456789";
		  var checkStr = theForm.Carea.value;
		  var allValid = true;
		  var decPoints = 0;
		  var allNum = "";
		  for (i = 0;  i < checkStr.length;  i++)
		  {
			ch = checkStr.charAt(i);
			for (j = 0;  j < checkOK.length;  j++)
			  if (ch == checkOK.charAt(j))
				break;
			if (j == checkOK.length)
			{
			  allValid = false;
			  break;
			}
			allNum += ch;
		  }
		  if (!allValid)
		  {
			alert("Please enter only digits in the \"Cell phone Number\" field.");
			theForm.Carea.focus();
			return (false);
		  }
	  }
	
	  
	
	  if (theForm.Cprefix.value != "")
	  {
			if (theForm.Cprefix.value.length < 3)
			  {
				alert("Please complete the \"Cell phone Number\" field.");
				theForm.Cprefix.focus();
				return (false);
			  }
			
			  var checkOK = "0123456789";
			  var checkStr = theForm.Cprefix.value;
			  var allValid = true;
			  var decPoints = 0;
			  var allNum = "";
			  for (i = 0;  i < checkStr.length;  i++)
			  {
				ch = checkStr.charAt(i);
				for (j = 0;  j < checkOK.length;  j++)
				  if (ch == checkOK.charAt(j))
					break;
				if (j == checkOK.length)
				{
				  allValid = false;
				  break;
				}
				allNum += ch;
			  }
			  if (!allValid)
			  {
				alert("Please enter only digits in the \"Cell phone Number\" field.");
				theForm.Cprefix.focus();
				return (false);
			  }
	  
	  }
	
	  
	
	  if (theForm.Csuffix.value != "")
	  {
		if (theForm.Csuffix.value.length < 4)
		  {
			alert("Please complete the \"Cell phone Number\" field.");
			theForm.Csuffix.focus();
			return (false);
		  }
		
		  var checkOK = "0123456789";
		  var checkStr = theForm.Csuffix.value;
		  var allValid = true;
		  var decPoints = 0;
		  var allNum = "";
		  for (i = 0;  i < checkStr.length;  i++)
		  {
			ch = checkStr.charAt(i);
			for (j = 0;  j < checkOK.length;  j++)
			  if (ch == checkOK.charAt(j))
				break;
			if (j == checkOK.length)
			{
			  allValid = false;
			  break;
			}
			allNum += ch;
		  }
		  if (!allValid)
		  {
			alert("Please enter only digits in the \"Cell phone Number\" field.");
			theForm.Csuffix.focus();
			return (false);
		  }
		
		
	  }
	
	  
  }
  
  /////////////////////////////////////////////////
 ////   End of Checking Cell Phone nubmer  ///
////////////////////////////////////////////////



  
  
  
  
  /////////////////////////////////////////////////
 ////   Primary Contact First Name  //////////////
 ////////////////////////////////////////////////
   if (theForm.PCFristName)
 {
 	if (theForm.PCFristName.value == "")
	  {
		alert("Please complete the \"Primary Contact First Name\" field.");
		theForm.PCFristName.focus();
		return (false);
	  }
	  
	  var targetlist = "<>/\@|%^#.*&()~[]{}";
	  var checkStr = theForm.PCFristName.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		
		for (j = 0;  j < targetlist.length;  j++)
		{
		  if (ch == targetlist.charAt(j))
			{
				
				allValid = false;
				break; 
			
			}
			
		}
		
		if (!allValid)
		  {
			alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"Primary Contact First Name\" filed");
			theForm.PCFristName.focus();
			
			return (false);
			//break;
		  }
		allNum += ch;
		
		
	  }
	  
	  
	
	 
 }
   
 
 
 
 /////////////////////////////////////////////////
 ////   Primary Contact Last Name  //////////////
 ////////////////////////////////////////////////
   if (theForm.PCLastName)
 {
 	if (theForm.PCLastName.value == "")
	  {
		alert("Please complete the \"Primary Contact Last Name\" field.");
		theForm.PCLastName.focus();
		return (false);
	  }
	  
	  var targetlist = "<>/\@|%^#.*&()~[]{}";
	  var checkStr = theForm.PCLastName.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		
		for (j = 0;  j < targetlist.length;  j++)
		{
		  if (ch == targetlist.charAt(j))
			{
				
				allValid = false;
				break; 
			
			}
			
		}
		
		if (!allValid)
		  {
			alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"Primary Contact Last Name\" filed");
			theForm.PCLastName.focus();
			
			return (false);
			//break;
		  }
		allNum += ch;
		
		
	  }
	  
	  
	
	 
 } 
 
 
 /////////////////////////////////////////////////
 ////   PCEmail    /////////////////////////////////
 ////////////////////////////////////////////////
  if (theForm.PCEmail)
  {
  	if (theForm.PCEmail.value == "")
	  {
		alert("Please complete the \"Email\" field.");
		theForm.PCEmail.focus();
		return (false);
	  }
	  else
	  {
		var checkStr = theForm.PCEmail.value;
		var atnum = 0
		var atdot = 0
		for (i = 0;  i < checkStr.length;  i++)
		{
			ch = checkStr.charAt(i);
			if (ch == "@")
				atnum = atnum +1;
			else if (ch == ".")
				atdot = atdot +1;
		}
		if ((atnum == 0 || atnum > 1) || (atdot == 0)){
			alert("You must enter a valid email address");
			theForm.PCEmail.focus();
			return (false);
		}
	  }		
  }
  



  
  
  
  
  /////////////////////////////////////////////////
 ////   Seconday Contact First Name  //////////////
 ////////////////////////////////////////////////
   if (theForm.SCFristName)
 {
 	if (theForm.SCFristName.value != "")
	  {
			var targetlist = "<>/\@|%^#.*&()~[]{}";
			  var checkStr = theForm.SCFristName.value;
			  var allValid = true;
			  var decPoints = 0;
			  var allNum = "";
			  for (i = 0;  i < checkStr.length;  i++)
			  {
				ch = checkStr.charAt(i);
				
				for (j = 0;  j < targetlist.length;  j++)
				{
				  if (ch == targetlist.charAt(j))
					{
						
						allValid = false;
						break; 
					
					}
					
				}
				
				if (!allValid)
				  {
					alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"Secondary Contact First Name\" filed");
					theForm.SCFristName.focus();
					
					return (false);
					//break;
				  }
				allNum += ch;
				
				
			  }
	  	  }
	  
	  
	  
	  
	
	 
 }
   
 
 
 
 /////////////////////////////////////////////////
 ////   Primary Contact Last Name  //////////////
 ////////////////////////////////////////////////
   if (theForm.SCLastName)
 {
 	if (theForm.SCLastName.value != "")
	  {
			var targetlist = "<>/\@|%^#.*&()~[]{}";
			  var checkStr = theForm.SCLastName.value;
			  var allValid = true;
			  var decPoints = 0;
			  var allNum = "";
			  for (i = 0;  i < checkStr.length;  i++)
			  {
				ch = checkStr.charAt(i);
				
				for (j = 0;  j < targetlist.length;  j++)
				{
				  if (ch == targetlist.charAt(j))
					{
						
						allValid = false;
						break; 
					
					}
					
				}
				
				if (!allValid)
				  {
					alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"Secondary Contact Last Name\" filed");
					theForm.SCLastName.focus();
					
					return (false);
					//break;
				  }
				allNum += ch;
				
				
			  }
	  	  }
	  
	  
	
	 
 } 
 
 
 /////////////////////////////////////////////////
 ////   SCEmail    /////////////////////////////////
 ////////////////////////////////////////////////
  if (theForm.SCEmail)
  {
  	if (theForm.SCEmail.value != "")
	  {
		var checkStr = theForm.SCEmail.value;
		var atnum = 0
		var atdot = 0
		for (i = 0;  i < checkStr.length;  i++)
		{
			ch = checkStr.charAt(i);
			if (ch == "@")
				atnum = atnum +1;
			else if (ch == ".")
				atdot = atdot +1;
		}
		if ((atnum == 0 || atnum > 1) || (atdot == 0)){
			alert("You must enter a valid email address");
			theForm.SCEmail.focus();
			return (false);
		}
	  }		
  }
  
////////////////////////////////////////////////////
//// end of secondary contact email
////////////////////////////////////////////////////


////////////////////////////////////////////////
//// Password
///////////////////////////////////////////////
 if (theForm.PW)
 {
 	if (theForm.PW.value == "")
	  {
		alert("Please complete the \"Password\" field.");
		theForm.PW.focus();
		return (false);
	  }
	
	  var checkStr = theForm.PW.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  if (checkStr.length < 4)
	  {
		alert("Please enter at least 4 characters in the \"Password\" field.");
		theForm.PW.focus();
		return (false);
	  }
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		if (ch == "'")
		 allValid = false;
	
		allNum += ch;
	  }
	
	 if (!allValid)
	  {
		alert("No ' is allowed in the \"Password\" field.");
		theForm.PW.focus();
		return (false);
	  }
 }
 
 if (theForm.rpw)
 {
 	if (theForm.rpw.value == "")
	  {
		alert("Please complete the \"Retrype Password\" field.");
		theForm.rpw.focus();
		return (false);
	  }
	 else if (theForm.rpw.value != theForm.PW.value)
	 {
	 	alert("Retype password is not same as the password");
		theForm.rpw.focus();
		return (false);
	 }
 }



  
  if (theForm.Address)
 {
 	if (theForm.Address.value == "")
	  {
		alert("Please complete the \"Address \" field.");
		theForm.Address.focus();
		return (false);
	  }
	  
	 var targetlist = "<>/\@|%^#*&()~[]{}";
	  var checkStr = theForm.Address.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		
		for (j = 0;  j < targetlist.length;  j++)
		{
		  if (ch == targetlist.charAt(j))
			{
				
				allValid = false;
				break; 
			
			}
			
		}
		
		if (!allValid)
		  {
			alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"Address \" filed");
			theForm.Address.focus();
			
			return (false);
			//break;
		  }
		allNum += ch;
		
		
	  }
	  
	  
  
  	  
 }
 

 if (theForm.city)
 {
 	if (theForm.city.value == "")
	  {
		alert("Please complete the \"City\" field.");
		theForm.city.focus();
		return (false);
	  }
	  
	  var targetlist = "<>/\@|%^#*&()~[]{}";
	  var checkStr = theForm.city.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		
		for (j = 0;  j < targetlist.length;  j++)
		{
		  if (ch == targetlist.charAt(j))
			{
				
				allValid = false;
				break; 
			
			}
			
		}
		
		if (!allValid)
		  {
			alert("Special characters \"< > /  \\ @ |  %  ^  #  . * & ( ) ~ [ ] { } \" can not be used in the \"City \" filed");
			theForm.city.focus();
			
			return (false);
			//break;
		  }
		allNum += ch;
		
		
	  }
	  
 }
 
  
 
	
	
 
 
 if (theForm.state)
 {
 	if (theForm.state.value == "" )
		{
			alert("Please complete the \"state\" field.");
			theForm.state.focus();
			return (false);
		}
 }
  
 
 
  if (theForm.zip)
 {	
	if (theForm.zip.value == "")
	  {
		alert("Please complete the \"Zip Code\" field.");
		theForm.zip.focus();
		return (false);
	  }
 }
  
  
  if (theForm.zip)
 {
	if (theForm.zip.value.length < 5)
	  {
		alert("Please enter 5 digits in the \"Zip Code\" field.");
		theForm.zip.focus();
		return (false);
	  }
	  
	  var checkOK = "0123456789";
	  var checkStr = theForm.zip.value;
	  var allValid = true;
	  var decPoints = 0;
	  var allNum = "";
	  for (i = 0;  i < checkStr.length;  i++)
	  {
		ch = checkStr.charAt(i);
		for (j = 0;  j < checkOK.length;  j++)
		  if (ch == checkOK.charAt(j))
			break;
		if (j == checkOK.length)
		{
		  allValid = false;
		  break;
		}
		allNum += ch;
	  }
	  if (!allValid)
	  {
		alert("Please enter only digits in the \"Zip Code\" field.");
		theForm.zip.focus();
		return (false);
	  }
 } 
 
  
 


 

 

 if (theForm.pwanswer)
 {
 	if (theForm.pwanswer.value == "")
	  {
		alert("Please answer the password reminder question.");
		theForm.pwanswer.focus();
		return (false);
	  }
 }

 
  
   //////////////////////////////////////////////////
  ////   Radion button  studentphoto          ///
  /////////////////////////////////////////////////
   if (theForm.studentphoto)
   { 
   		if (theForm.studentphoto[0].checked==false && theForm.studentphoto[1].checked==false )
		{
			alert("Please select\"Yes\" or \"No\" for taking photos!");
			theForm.studentphoto[0].focus();
			return false;
			
		}
		
   }
 

 //////////////////////////////////////////////////
  ////   Radion button  studentphoto          ///
  /////////////////////////////////////////////////
   if (theForm.agreemyinfo)
   { 
   		if (theForm.agreemyinfo[0].checked==false && theForm.agreemyinfo[1].checked==false )
		{
			alert("Please select\"Yes\" or \"No\"  for giving information!");
			theForm.agreemyinfo[0].focus();
			return false;
			
		}
		
   }

 
////////////////////////////////////////
 ////   Terms of Agreement Accept    ///
//////////////////////////////////////

  if (theForm.agreement)
  { 
  	if (theForm.agreement.checked != true)
	{
		alert("Please put a check on box next to \"Terms of Agreement\" to show that you accept the terms. Thank-you");
		theForm.agreement.focus();
		return false;
	}
  }
  
  

 
  if (theForm.username)
 {
 	if (theForm.username.value == "")
	  {
		alert("Please complete the \"User name\" field.");
		theForm.username.focus();
		return (false);
	  }

	  

 }
 
 


 /////////////////user email////////////////
 if (theForm.userEmail)
 {
 	if (theForm.userEmail.value == "")
	  {
		alert("Please provide your email address.");
		theForm.userEmail.focus();
		return (false);
	  }

	  var checkStr = theForm.userEmail.value;
	  var atnum = 0
	  var atdot = 0
		for (i = 0;  i < checkStr.length;  i++)
		{
			ch = checkStr.charAt(i);
			if (ch == "@")
				atnum = atnum +1;
			else if (ch == ".")
				atdot = atdot +1;
		}
		if ((atnum == 0 || atnum > 1) || (atdot == 0)){
			alert("You must enter a valid email address");
			theForm.userEmail.focus();
			return (false);
		}

 }

/////////////////login ID////////////////
 if (theForm.loginID)
 {
 	if (theForm.loginID.value == "")
	  {
		alert("Please provide your login ID.");
		theForm.loginID.focus();
		return (false);
	  }
 }
 
 /////////////////user PW////////////////
 if (theForm.userPW)
 {
 	if (theForm.userPW.value == "")
	  {
		alert("Please provide your login password.");
		theForm.userPW.focus();
		return (false);
	  }
 }


//alert("hj"); 

   return (true);
} 
 

