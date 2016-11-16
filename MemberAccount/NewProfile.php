<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
//if(isset($_SESSION['family_id']))
//{  }
//else
//{header( 'Location: ../Logoff.php' ) ;
// exit();
//}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
//mysql_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Profile</title>
<meta name="keywords" content="Southern Connecticut Chinese School, Chinese School">
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
					<?php
					   if ( $_GET[newmembertype]=="student" || $_GET[newmembertype]=="spouse" ) {
						$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND  MB.FamilyID=".$_SESSION['family_id'] ." LIMIT 1";
					   } else {
						$SQLstring = "select MB.*   from tblMember MB where MB.MemberID=0";//.$_SESSION['memberid'];
					   }

						//$SQLstring = "select *  from tblMember where PrimaryContact='Yes' and FamilyID=".$_SESSION['family_id'];

						//echo "see111: ".$SQLstring;
						$RS1=mysqli_query($conn, $SQLstring);
						$RSA1=mysqli_fetch_array($RS1);
						//$family_id=$RSA1[family_id];
						//$MemberType=$RSA1[MemberType];
						//echo "<br>see: ".$RSA1[HomePhone];

						$PhoneArrary=explode("-",$RSA1[HomePhone]);
						//$x=$PhoneArrary[0];
						//echo "<br>see22: ".$PhoneArrary[0];
						$CPhoneArrary=explode("-",$RSA1[CellPhone ]);
                        $OPhoneArrary=explode("-",$RSA1[OfficePhone]);
					?>
					<td align="center" valign="top">
<!--					    <a href="FamilyChildList.php">[Back to Childlist] -->
						<table width="100%">
						 <?php if ( $_GET[newmembertype]!="student"  ) { ?>
							<tr>
								<td align="left">Before proceed, please use <a href="MemberLookupForm.php">Member Lookup</a> to verify that you are not a registered member yet. If you are a member already, please use <a href="retrieveLoginID.php">retrieve login function</a> to retrieve your existing login.</td>
							</tr>
						  <?php } ?>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
							<?php if ( $_GET[newmembertype]=="student"  ) { ?>
								<td align="center"><font><b>New Student Profile</b></font></td>
							<?php } else if ( $_GET[newmembertype]=="spouse" ) { ?>
								<td align="center"><font><b>New Spouse Profile</b></font></td>
							<?php } else { ?>
								<td align="center"><font><b>New Member Profile</b></font></td>
							<?php } ?>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form name="NewMember" action="UpdateNewProfile.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="newmember" value="1">
                                        <input type="hidden" name="newmembertype" value="<?php echo $_GET[newmembertype];?>">

                                     <?php if ( $_GET[newmembertype]=="student" || $_GET[newmembertype]=="spouse" ) { ?>
										<tr>
											<td width="50%" align="Right">Family ID<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="FamilyID" value="<?php echo $RSA1[FamilyID];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCFristName" value=""></td>
										</tr>

                                     <?php } else { ?>
										<tr>
											<td width="50%" align="Right">First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCFristName" value="<?php echo $RSA1[FirstName];?>"></td>
										</tr>
									 <?php } ?>
										<tr>
											<td width="50%" align="Right">Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCLastName" value="<?php echo $RSA1[LastName];?>"></td>
										</tr>
                                        <tr>
											<td width="50%" align="Right">Chinese Name<font color="#FF0000"></font></td>
											<td><input type="text" size="28" name="PCChineseName" value="<?php //echo $RSA1[ChineseName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Gender<font color="#FF0000"></font></td>
										    <?php	if ( $RSA1[Gender] == "M" ) {
											    $male="checked";
											    $female="";
											} else if ( $RSA1[Gender] == "F" ){
											    $male="";
											    $female="checked";
											} else {
											    $male="";
											    $female="";
											} ?>
											<td><input type="radio" name="gender" value="M" <?php echo $male;?> >Male
											    <input type="radio" name="gender" value="F" <?php echo $female;?> >Female</td>
										</tr>
										<?php if ( $_GET[newmembertype] =="student" ) { ?>
                                        

										
										<tr>
											<td width="50%" align="Right">Year of Birth<font color="#FF0000"></font></td>
											<td align="left" ><input type="text" size="10" name="yob" value="<?php echo $yob; ?>"> (yyyy)</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Is Date of Birth before Sept 1?<font color="#FF0000"></font></td>
										    <?php	
											    $bs="checked";
											    $as="";
											    
											  ?>
											<td><input type="radio" name="dobbs" value="Y" <?php echo $bs;?> >Yes
											    <input type="radio" name="dobbs" value="N" <?php echo $as;?> >No 
											    </td>
										</tr>
                                        <tr>
											<td width="50%" align="Right">Ethnicity<font color="#FF0000"></font></td>
											<td>
										<?php
										     $sqleth="select Ethnicity,Explanation from tblEthnicity";
										     $rseth=mysqli_query($conn, $sqleth);
										     echo "<select name=\"ethnicity\">";
						                     while ($rweth=mysqli_fetch_array($rseth) ) {
						                       if ( $rweth[Ethnicity] == $RSA1[Ethnicity] ) {
						                          echo "<option SELECTED value=\"". $rweth[Ethnicity] ."\">". $rweth[Explanation]. "</option>\n";
						                       } else {
						                          echo "<option          value=\"". $rweth[Ethnicity] ."\">". $rweth[Explanation]. "</option>\n";
						                       }
						                     }
						                     ?>
											</td>
										</tr>

										<tr>
																					<td width="50%" align="Right">Primary Home Language</td>
																					<td>

																					<select name="PrimaryHomeLanguage">

																					  <option value="Chinese">Chinese</option>

																					  <option value="English">English</option>

																					  <option value="Other">Other</option>


																					</select>
																					</td>
																				</tr>

										                                        <tr>
																					<td width="50%" align="Right">Chinese Speaking Parents<font color="#FF0000"></font></td>

																					<td><input type="radio" name="NumChSpeakParents" value="0"  >None
																					    <input type="radio" name="NumChSpeakParents" value="1"  >One
																					    <input type="radio" name="NumChSpeakParents" value="2" CHECKED >Both</td>
																					    <input type="hidden" name="NumChSpeakParentsOld" value="<?php echo $rw['NumChSpeakParents'];?>">
										</tr>
										<?php } ?>

                                      <?php if ( $_GET[newmembertype] !="student"  ) { ?>
										<tr>
											<td width="50%" align="Right">Primary Contact<font color="#FF0000"></font></td>
											<?php if ( $_GET[newmembertype] != "spouse" ) {
											    $PCParentYes="checked";
											    $PCParentNo="";
											} else {
											    $PCParentYes="";
											    $PCParentNo="checked";

											} ?>
											<td><input type="radio" name="PrimaryContact" value="Yes" <?php echo $PCParentYes;?> >Yes
											<?php if ( $_GET[newmembertype] =="spouse"  ) { ?>
											    <input type="radio" name="PrimaryContact" value="No" <?php echo $PCParentNo;?> >No
											<?php } ?>
											</td>
										</tr>


									  <?php } ?>

										<?php if ( $_GET[newmembertype] =="student"  ) { ?>
										<!--
										<tr>
											<td width="50%" align="Right">Primary Home Language</td>
											<td>

											<select name="PrimaryHomeLanguage">
											  <option value="Chinese">Chinese</option>
											  <option value="English">English</option>
											  <option value="Other">Other</option>
											</select>
											</td>
										</tr>

										<tr>
											<td width="50%" align="Right">Starting Language Class Level</td>
											<td>

											<select name="StartingLevel">
											  <option value="1">1</option>
											  <option value="2">2</option>
											  <option value="3">3</option>
											  <option value="4">4</option>
											  <option value="5">5</option>
											  <option value="6">6</option>
											  <option value="7">7</option>
											  <option value="8">8</option>
											  <option value="9">9</option>
											  <option value="10">10</option>
											  <option value="11">11</option>
											  <option value="12">12</option>
											</select>
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Preferred Language Class Level</td>
											<td>

											<select name="PreferredClassLevel">
											  <option value="1">1</option>
											  <option value="2">2</option>
											  <option value="3">3</option>
											  <option value="4">4</option>
											  <option value="5">5</option>
											  <option value="6">6</option>
											  <option value="7">7</option>
											  <option value="8">8</option>
											  <option value="9">9</option>
											  <option value="10">10</option>
											  <option value="11">11</option>
											  <option value="12">12</option>
											</select>(1:20-3:00)

											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Preferred Extra Class 1 (3:10-3:55)</td>
											<td>

											<select name="PreferredExtraClass1">
											  <option value="Math Level One">Math Level One (3,4,5 graders)</option>
											  <option value="Math Level Two">Math Level Two (6,7,8,9 graders)</option>
											  <option value="Elementary Dancing">Elementary Dancing</option>
											  <option value="Intermediate Dancing">Intermediate Dancing</option>
											  <option value="Elementary Art">Elementary Art</option>
											  <option value="Intermediate Chess">Intermediate Chess</option>
											  <option value="Singing">Singing</option>
											  <option value="Drama Group">Drama Group</option>
											 </select>
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Preferred Extra Class 2 (4:05-5:50)</td>
											<td>

											<select name="PreferredExtraClass2">
											  <option value="Math Level One">Math Level One (3,4,5 graders)</option>
											  <option value="Math Level Two">Math Level Two (6,7,8,9 graders)</option>
											  <option value="Elementary Dancing">Elementary Dancing</option>
											  <option value="Intermediate Dancing">Intermediate Dancing</option>
											  <option value="Intermediate Art">Intermediate Art</option>
											  <option value="Elementary Chess">Elementary Chess</option>
											  <option value="Orchestra">Orchestra</option>
											 </select>
											</td>
										</tr> -->
									<?php } ?>

										<tr>
											<td width="50%" align="Right">Email<font color="#FF0000">*</font></td>
											<td><input  type="text" size="28" name="PCEmail" value="<?php echo $RSA1[Email];?>"></td>
										</tr>
								<!--
										<tr>
											<td width="50%" align="Right">2nd Email</td>
											<td><input  type="text" size="28" name="SecondEmail" value="<?php echo $RSA1[SecondEmail];?>"></td>
										</tr> -->


										<!-- <tr>
											<td width="50%" align="Right">Secondary Contact First Name</td>
											<td><input type="text" size="28" name="SCFristName" value="<?php echo $RSA1[SecondaryCP_FirstName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Secondary Contact Last Name</td>
											<td><input type="text" size="28" name="SCLastName" value="<?php echo $RSA1[SecondaryCP_LastName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Secondary Contact Email</td>
											<td><input type="text" size="28" name="SCEmail" value="<?php echo $RSA1[SecondaryCP_email];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right" valign="top">Secondary Contact Profession</td>
											<td><input type="text" size="28" name="SCProfession" value="<?php echo $RSA1[SecondaryCP_Profession];?>"><br><font size="2">(Accountant, computer programmer, etc.)</font></td>
										</tr> -->
										<tr>
											<td width="50%" align="Right">Home Phone<font color="#FF0000">*</font></td>
											<td align="left">
												<input size="3" maxlength="3" name="area" onKeyUp="return SSAutoTab(this,'prefix', 3, event);" value="<?php echo $PhoneArrary[0];?>">
												<font size="3">-</font>
												<input size="3" maxlength="3" name="prefix"  onKeyUp="return SSAutoTab(this,'suffix', 3, event);"  value="<?php echo $PhoneArrary[1];?>">
												<font size="3">-</font>
												<input size="4" maxlength="4" name="suffix"   value="<?php echo $PhoneArrary[2];?>">
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Cell Phone</td>
											<td align="left">
												<input size="3" maxlength="3" name="Carea" onKeyUp="return SSAutoTab(this,'Cprefix', 3, event);" value="<?php echo $CPhoneArrary[0];?>">
												<font size="3">-</font>
												<input size="3" maxlength="3" name="Cprefix"  onKeyUp="return SSAutoTab(this,'Csuffix', 3, event);"  value="<?php echo $CPhoneArrary[1];?>">
												<font size="3">-</font>
												<input size="4" maxlength="4" name="Csuffix"   value="<?php echo $CPhoneArrary[2];?>">
											</td>
										</tr>
<tr>
											<td width="50%" align="Right">Office Phone</td>
											<td align="left">
												<input size="3" maxlength="3" name="Oarea" onKeyUp="return SSAutoTab(this,'Oprefix', 3, event);" value="<?php echo $OPhoneArrary[0];?>">
												<font size="3">-</font>
												<input size="3" maxlength="3" name="Oprefix"  onKeyUp="return SSAutoTab(this,'Osuffix', 3, event);"  value="<?php echo $OPhoneArrary[1];?>">
												<font size="3">-</font>
												<input size="4" maxlength="4" name="Osuffix"   value="<?php echo $OPhoneArrary[2];?>">
											</td>
										</tr>

										<tr>
											<td width="50%" align="Right">Address<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="Address" value="<?php echo $RSA1[HomeAddress ];?>"></td>
										</tr>

										<tr>
											<td width="50%" align="Right">City<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="city" value="<?php echo $RSA1[HomeCity ];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">State<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="state" value="<?php echo $RSA1[HomeState ];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Zip Code<font color="#FF0000">*</font></td>
											<td><input type="text" size="5" maxlength="5"  name="zip" value="<?php echo $RSA1[HomeZip  ];?>" ></td>
										</tr>
										<?php if ( $_GET[newmembertype] !="student" ) { ?>
										<tr>
											<td width="50%" align="Right" valign="top">Profession</td>
											<td><input type="text" size="28" name="PCProfession" value="<?php echo $RSA1[Profession];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Organization</td>
											<td><input type="text" size="28" maxlength="100"  name="org" value="<?php echo $RSA1[Organization];?>" ></td>
										</tr>

										<tr>
											<td width="50%" align="Right">Hobbies</td>
											<td><input type="text" size="28" maxlength="150"  name="hobbies" value="<?php echo $RSA1[Hobbies];?>" ></td>
										</tr>
										<?php } ?>

										<tr>
											<td width="50%" align="Right"></td>
											<?php if ( $RSA1[Directory] == "No" ) {
											    $dir = "checked";
											   } else {
											    $dir = "";
											   }
											 ?>
											<td><input type="checkbox"  name="dir" value="no dir" <?php echo $dir;?> >I do NOT want my name to be listed in school directories.</td>
										</tr>
										<tr>
											<td width="50%" align="Right" valign="top">Picture: </td>
											<?php if ( $RSA1[Picture] == "No" ) {
											    $pic = "checked";
											   } else {
											    $pic = "";
											   }
											 ?>

											<td><input type="checkbox"  name="pic" value="no pic" <?php echo $pic;?> >I do NOT want picture or video to be taken on me.</td>
										</tr>

										<tr>
											<td width="50%" align="Right">New Password</td>
											<td><input type="password" size="20" maxlength="20"  name="password1"  ></td>
										</tr>
										<tr>
											<td width="50%" align="Right">New PW Confirm</td>
											<td><input type="password" size="20" maxlength="20"  name="password2"  ></td>
										</tr>





										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
												<input type="submit" value="Create">
											</td>
											<td align="center">
											<?php if ( $_GET[newmembertype]=="student" || $_GET[newmembertype]=="spouse" ) { ?>
											    <input type="button" width="18"  onClick="window.location.href='FamilyChildList.php'" value="Cancel">
											<?php } else { ?>
												<input type="button" width="18"  onClick="window.location.href='MemberLoginForm.php'" value="Cancel">
											<?php } ?>
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


<?php
mysqli_close($conn);
?>

