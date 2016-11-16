<?php //header( 'Location: ../News/YCCSRegistratonCloseForFall2007.php' ) ;?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Registration</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
<script language="JavaScript">
function SSAutoTab(input, Gnext, len, e)
	{
		if(input.value.length >= len )
		{
			if (eval("document.all."+Gnext))
			{
				eval("document.all."+Gnext).focus();
			}
			
		}
	}
	
	
function displayme(which)
	{
		if (which =='NewStudentLine')
		{
			document.all('NewStudentLine').style.display = "";
			document.all('ReturnStudentLine').style.display = "none";
			//document.all('returingcusotmer').style.display = "none";
			//alert("OK1");
		}
		else if (which=='ReturnStudentLine')
		{
			document.all('ReturnStudentLine').style.display = "";
			document.all.NewStudentLine.style.display = "none";
			
		}
		else if (which=='ArtClassSelect')
		{	
			if (document.all.ArtChoose[0].checked ==true)
			{ 	document.all('ArtClassSelect').style.display = ""; }
			else if (document.all.ArtChoose[1].checked ==true)
			{document.all('ArtClassSelect').style.display = "none";}
			
		}
		else if (which=='VolunteerLine'  )
		{
			if ( document.all.volunteer.value== 4 )
			{ document.all('VolunteerLine').style.display = ""; }
			else
			{document.all.VolunteerLine.style.display = "none"; }
			
		}
		
		
	}

</script>
<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="26%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>
						
						
					</td>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>Student Registration</b></font></td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="left"><font color="#CC0000"><li>&nbsp;The online registration will be closed at 8:00pm, Wednesday, Sept 12, 2007. </li></font> </td>
							</tr>
							
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="left"><font color="#CC0000"><li>&nbsp;Please complete your registration(s) for the Fall 2007 semester <b>before 12:00 PM 9/10/2007.</b> If you pass this deadline, you will be charged $2.00 for each registration. Thanks for your cooperation. In addition, this on-line registration form will be closed at 8:00pm, Sept 12, 2007. </li></font> </td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="left"><font color="#CC0000"><li>&nbsp;For best result, we suggest you to choose Internet Explorer or FireFox to fill out this registration form, Thanks.</li></font> </td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<tr>
											<td align="center" colspan="2"><b>Student Information</b></td>
										</tr>
										<form name="NewMember" action="MemberRegProcess.php" method="post" onSubmit="return Validate(this);">
										<!-- <tr>
											<td width="50%" align="Right">English Name<font color="#FF0000">*</font></td>
											<td align="left">
												
												<table width="100%">
													<tr>
														<td align="left">First Name</td>
														
														<td align="left">Last Name</td>
													</tr>
													<tr>
														<td align="left"><input type="text" size="18" name="StudentFristName"></td>
														
														<td align="left"><input type="text" size="18" name="StudentLastName"></td>
													</tr>
													
												</table>
											</td>
										</tr> -->
										
										
										<?php if ($_GET["error"]==1) { ?>
											<tr>
												<td align="center" colspan="2"><b>&nbsp;</b></td>
											</tr>
											<tr>
												<td align="left" colspan="2"><font color=#FF0000><b>Error: The email has been used in our system.</b></font></td>
											</tr>
											<tr>
												<td align="center" colspan="2"><b>&nbsp;</b></td>
											</tr>
										<?php } ?>
										<tr>
											<td width="50%" align="Right">First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="StudentFristName"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="StudentLastName"></td>
										</tr>
										
										<tr>
											<td width="50%" align="Right">Chinese Name&nbsp;</td>
											<td><input type="text" size="28" name="StudentChineseName"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Gender<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="studentGender" value="F">Female
												&nbsp;
												<input type="radio" name="studentGender" value="M">Male
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Date of Birth<font color="#FF0000">*</font></td>
											<td><?php include("../common/TimeSpan/TimeSelect_DOBline.php"); ?></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Student Type<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="studentType" onClick="displayme('NewStudentLine');" value="1">New Student
												&nbsp;
												<input type="radio" name="studentType" onClick="displayme('ReturnStudentLine');" value="2">Return Student
											</td>
										</tr>
										<tr id="ReturnStudentLine" style="display:none">
											<td width="50%" align="Right">Last semester your child was in&nbsp;</td>
											<td>
												<SELECT  NAME="ReturnStudentLevel">
													<OPTION VALUE="0">---Select---</OPTION>
													<OPTION VALUE="1">1 &#24180;&#32423; 1 &#29677; (&#26446;&#25102;&#30495;)</OPTION>
													<OPTION VALUE="2">1 &#24180;&#32423; 2 &#29677; (&#21016;&#20070;&#31584;)</OPTION>
													<OPTION VALUE="3">1 &#24180;&#32423; 3 &#29677; (&#26361;&#34164;)</OPTION>
													<OPTION VALUE="4">2 &#24180;&#32423; 1 &#29677; (&#26446;&#29738;)</OPTION>
													<OPTION VALUE="5">2 &#24180;&#32423; 2 &#29677; (&#32834;&#22411;&#38081;)</OPTION>
													<OPTION VALUE="6">2 &#24180;&#32423; 3 &#29677; (&#26472;&#24314;&#26032;)</OPTION>
													<OPTION VALUE="7">3 &#24180;&#32423; 1 &#29677; (&#20613;&#20057;&#20809;)</OPTION>
													<OPTION VALUE="8">3 &#24180;&#32423; 2 &#29677; (&#38047;&#26757;)</OPTION>
													<OPTION VALUE="9">4 &#24180;&#32423; 1 &#29677; (&#33539;&#26195;&#23425;)</OPTION>
													<OPTION VALUE="10">4 &#24180;&#32423; 2 &#29677; (&#38472;&#26391;)</OPTION>
													<OPTION VALUE="11">5 &#24180;&#32423; 1 &#29677; (&#29579;&#23447;&#23195;)</OPTION>
													<OPTION VALUE="12">5 &#24180;&#32423; 2 &#29677; (&#36911;&#24428;)</OPTION>
													<OPTION VALUE="13">6 &#24180;&#32423; 1 &#29677; (&#38472;&#26107;)</OPTION>
													<OPTION VALUE="14">6 &#24180;&#32423; 2 &#29677; (&#36793;&#25991;&#24420;)</OPTION>
													<OPTION VALUE="15">7 &#24180;&#32423; 1 &#29677; (&#26366;&#24314;&#25935;)</OPTION>
													<OPTION VALUE="16">8 &#24180;&#32423; 2 &#29677; (&#26519;&#33459;)</OPTION>
												</SELECT>
											</td>
										</tr>
										<tr id="NewStudentLine" style="display:none">
											<td width="50%" align="Right">Starting Level&nbsp;</td>
											<td>
												<SELECT  NAME="NewStudentLevel">
													<OPTION VALUE="0">---Select---</OPTION>
													<OPTION VALUE="1">Grade 1</OPTION>
													<OPTION VALUE="2">Grade 2</OPTION>
													<OPTION VALUE="3">Grade 3</OPTION>
													<OPTION VALUE="4">Grade 4</OPTION>
													<OPTION VALUE="5">Grade 5</OPTION>
													<OPTION VALUE="6">Grade 6</OPTION>
													<OPTION VALUE="7">Grade 7</OPTION>
													<OPTION VALUE="8">Grade 8</OPTION>
													<OPTION VALUE="9">Grade 9</OPTION>
													<OPTION VALUE="10">Grade 10</OPTION>
													<OPTION VALUE="11">Grade 11</OPTION>
													<OPTION VALUE="12">Grade 12</OPTION>
													
												</SELECT>
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Art Class&nbsp;</td>
											<td align="left">
												<input type="radio" name="ArtChoose" onClick="displayme('ArtClassSelect');" value="1">Yes
												&nbsp;
												<input type="radio" name="ArtChoose" onClick="displayme('ArtClassSelect');"  value="2">No
											</td>
										</tr>
										<tr id="ArtClassSelect" style="display:none">
											<td width="50%" align="Right">Art Class&nbsp;</td>
											<td>
												<SELECT  NAME="ArtClasslevel">
													<OPTION VALUE="0">---Select---</OPTION>
													<OPTION VALUE="Elementary Art">Elementary Art</OPTION>
													<OPTION VALUE="Intermediate Art">Intermediate Art</OPTION>
													<OPTION VALUE="Dancing Class">Dancing Class</OPTION>
													<OPTION VALUE="Elementary Chess">Elementary Chess</OPTION>
													<OPTION VALUE="Parent dancing">Parent dancing</OPTION>
													
													
													
												</SELECT>
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2"><b>Parent Information</b></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Home Phone<font color="#FF0000">*</font></td>
											<td align="left">
												<input size="3" maxlength="3" name="area" onKeyUp="return SSAutoTab(this,'prefix', 3, event);" value="">
												<font size="3">-</font> 
												<input size="3" maxlength="3" name="prefix"  onKeyUp="return SSAutoTab(this,'suffix', 3, event);"  value="">
												<font size="3">-</font> 
												<input size="4" maxlength="4" name="suffix"   value="">
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Cell Phone</td>
											<td align="left">
												<input size="3" maxlength="3" name="Carea" onKeyUp="return SSAutoTab(this,'Cprefix', 3, event);" value="">
												<font size="3">-</font> 
												<input size="3" maxlength="3" name="Cprefix"  onKeyUp="return SSAutoTab(this,'Csuffix', 3, event);"  value="">
												<font size="3">-</font> 
												<input size="4" maxlength="4" name="Csuffix"   value="">
											</td>
										</tr>
										
										<tr>
											<td width="50%" align="Right">Primary Contact First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCFristName"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Primary Contact Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCLastName"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Primary Contact Email<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCEmail"></td>
										</tr>
										<tr>
											<td width="50%" align="Right" valign="top">Choose a Password<font color="#FF0000">*</font></td>
											<td><input type="password" size="28" name="PW"><br><font size="2">(min. 4 characters, letters and/or numbers only)</font></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Retype  Password<font color="#FF0000">*</font></td>
											<td><input type="password" size="28" name="rpw"></td>
										</tr>
										<tr>
											<td width="50%" align="Right" valign="top">Primary Contact Profession</td>
											<td><input type="text" size="28" name="PCProfession"><br><font size="2">(Accountant, computer programmer, etc.)</font></td>
										</tr>
										
										
										<tr>
											<td width="50%" align="Right">Secondary Contact First Name</td>
											<td><input type="text" size="28" name="SCFristName"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Secondary Contact Last Name</td>
											<td><input type="text" size="28" name="SCLastName"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Secondary Contact Email</td>
											<td><input type="text" size="28" name="SCEmail"></td>
										</tr>
										<tr>
											<td width="50%" align="Right" valign="top">Secondary Contact Profession</td>
											<td><input type="text" size="28" name="SCProfession"><br><font size="2">(Accountant, computer programmer, etc.)</font></td>
										</tr>
										
										<tr>
											<td width="50%" align="Right">Address<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="Address"></td>
										</tr>
										
										<tr>
											<td width="50%" align="Right">City<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="city"></td>
										</tr>
										<!-- <tr>
											<td width="50%" align="Right">State<font color="#FF0000">*</font></td>
											<td>
											</td>
										</tr> -->
										<tr>
											<td width="50%" align="Right">Zip Code<font color="#FF0000">*</font></td>
											<td><input type="text" size="5" maxlength="5"  name="zip" ></td>
										</tr>
										
										<tr>
											<td align="center" colspan="2"><hr></td>
										</tr>
										
										<tr>
											<td align="left" colspan="2">I agree, by selecting "yes", that the school might take photos of student activities, which might has my son/daughter's image, and use them on its website and publications.
												<input type="radio" name="studentphoto" checked  value="1">Yes
												&nbsp;
												<input type="radio" name="studentphoto"  value="0">No
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2"><hr></td>
										</tr>
										<tr>
											<td align="left" colspan="2">I agree to put my information in the Yale-New-Haven Community Chinese School directory. I understand if I select No, I cannot access the directory too.
												<input type="radio" name="agreemyinfo"  value="1">Yes
												&nbsp;
												<input type="radio" name="agreemyinfo"  value="0">No
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2"><hr></td>
										</tr>
										<tr>
											<td width="50%" align="Right" >Volunteer Work&nbsp;</td>
											<td>
												<table>
													<tr>
														<td>
															<SELECT  NAME="volunteer" onChange="displayme('VolunteerLine');">
																<OPTION VALUE="0">Please Select</OPTION>
																<OPTION VALUE="1">Board or PTO</OPTION>
																<!-- <OPTION VALUE="2">Special events such as Chinese New Year Party or final ceremony</OPTION> -->
																<OPTION VALUE="2">Special events </OPTION>
																<OPTION VALUE="3">backup  teacher</OPTION>
																<OPTION VALUE="4">Others</OPTION>
															</SELECT>
														</td>
													</tr>
													
													<tr id="VolunteerLine" style="display:none">
														<td>
															Please specify if selecting other: <br><input type="text" size="28"  name="VolunterrOther" >
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2"><hr></td>
										</tr>
										<tr>
											<td align="left" colspan="2">In consideration of the activities at the Southern Connecticut State University Sponsored by Yale-New-Haven Community Chinese School, a non-profit organization, it is understood and agreed that said Yale-New-Haven Community Chinese School or its officials, teachers, or volunteers will not be held responsible for missing of child, any injury, accident, sustained by the member of our party, or for the loss of or damage to any property belonging to a member of our party or anyone else.<br><br>
												<input type="checkbox" name="agreement"  ><font color="#CC0000">I have read and accepted the above release of liability statement and all policies and regulations of Yale-New-Haven Community Chinese School.</font>
												
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2"><hr></td>
										</tr>
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="center" colspan="2">
												<input type="submit" value=" Submit & Continue >>>">
											</td>
										</tr>
										
										</form>
									</table>
								</td>
							</tr>
						</table>
					</td>
					
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>
	
</table>



</body>
</html>
