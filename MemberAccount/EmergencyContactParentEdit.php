<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
if($_GET[whose] == "student" )
{
  header( 'Location: studentProfile.php?stuid='.$_GET[stuid] ) ;
}

if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

if ( $_GET[whose] == "spouse") {
	$SQLstring = "SELECT count(*) as cnt FROM `tblMember`,tblLogin WHERE tblMember.MemberID=tblLogin.MemberID and FamilyID=".$_SESSION['family_id']." and MemberTypeID=15 and tblLogin.MemberID != ".$_SESSION['memberid'];
    $RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
	if ( $RSA1[cnt] <= 0 ) {
	   header('Location: NewProfile.php?newmembertype=spouse');
	}
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Profile</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Southern Connecticut Chinese School, Chinese School">
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
					<td width="0%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php // include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php
						//$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND  MB.FamilyID=".$_SESSION['family_id'];
						if ( $_GET[whose] == "spouse") {
						  //$SQLstring = "select MB.*   from tblMember MB where MB.MemberID !=".$_SESSION['memberid']. " and FamilyID=".$_SESSION['family_id'];;
						  $SQLstring = "SELECT * FROM `tblMember`,tblLogin WHERE tblMember.MemberID=tblLogin.MemberID and FamilyID=".$_SESSION['family_id']." and MemberTypeID=15 and tblLogin.MemberID != ".$_SESSION['memberid'];
						} else if ( $_GET[whose] == "student") {
						  $SQLstring = "select *   from tblMember left join tblEthnicity  on tblMember.Ethnicity=tblEthnicity.Ethnicity where tblMember.MemberID=".$_GET['stuid'];

                          // primary contact parent
						  $SQLparent = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND MB.PrimaryContact='Yes' AND MB.FamilyID=".$_SESSION['family_id'] ." LIMIT 1";
						  $RSp=mysqli_query($conn,$SQLparent);
						  $RSAp=mysqli_fetch_array($RSp);

						} else {
						  $SQLstring = "select MB.*   from tblMember MB where MB.MemberID=".$_SESSION['memberid'];
						}

						//$SQLstring = "select *  from tblMember where PrimaryContact='Yes' and FamilyID=".$_SESSION['family_id'];

						//echo "see111: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						$RSA1=mysqli_fetch_array($RS1);
						//$family_id=$RSA1[family_id];
						//$MemberType=$RSA1[MemberType];
						//echo "<br>see: ".$RSA1[HomePhone];

						$PhoneArrary=explode("-",$RSA1[HomePhone]);
						//$x=$PhoneArrary[0];
						//echo "<br>see22: ".$PhoneArrary[0];
						$CPhoneArrary=explode("-",$RSA1[CellPhone ]);
                        $OPhoneArrary=explode("-",$RSA1[OfficePhone]);

                        if (strlen($RSA1[DateOfBirth])>0) {
							list($y,$m,$d)=explode("-",$RSA1[DateOfBirth]);
							$dob=$m."/".$d."/".$y;
							if ( $dob == "00/00/0000" ) {
							   $dob="01/01/2002";
							}
						}
					?>
					<td align="center" valign="top">
						<table width="100%">
                        <?php if ( $_GET[whose] == "spouse") { ?>
							<tr>
								<td align="center"><font><b>Spouse Profile</b></font></td>
							</tr>
                        <?php } else if ( $_GET[whose] == "student") { ?>
							<tr>
								<td align="center"><font><b>Student Profile</b></font></td>
							</tr>
 							<tr>
								<td align="left"><a href="FamilyChildList.php">[Back to Childlist]
								                 <a href="FeePaymentVoucher.php">[Print Payment Voucher]</a>
								</td>
							</tr>
                        <?php } else { ?>
							<tr>
								<td align="center"><font><b>Emergency Contact Form</b></font></td>
							</tr>
                        <?php } ?>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form name="NewMember" action="UpdateEmergencyContactParentEdit.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="updtmemberid" value="<?php echo $RSA1[MemberID];?>">
                                        <input type="hidden" name="whose" value="<?php echo $_GET[whose];?>">

										<tr>
											<td width="50%" align="Right">MemberID: </td>
											<td width="50%" align="Left"><?php echo $RSA1[MemberID];?></td>
										</tr>
										<tr>
											<td width="50%" align="Right">FamilyID: </td>
											<td width="50%" align="left"><?php echo $RSA1[FamilyID];?></td>
										</tr>

                    <tr>
                    <td width="50%" align="Right">Your First Name:  </td>
                    <td width="50%" align="Left"><?php echo $RSA1[FirstName];?></td>
                    </tr>

                    <tr>
                    <td width="50%" align="Right">Your Last Name:  </td>
                    <td width="50%" align="Left"><?php echo $RSA1[LastName];?></td>
                    </tr>
                    
                    <tr><td width="50%" align="center" colspan="2">----------------------------------------</td></tr>
                    <tr><td width="50%" align="right">Emergency Contact</td>
                          <td width="50%" align="left">Information</td></tr>
                    <tr><td width="50%" align="center" colspan="2">----------------------------------------</td></tr>
                    
	<tr><td width="50%" align="Right">First Contact Name<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="FirstContactName" value="<?php echo $RSA1[FirstContactName];?>"></td>
	</tr>
 
	<tr><td width="50%" align="Right">First Contact Relationship<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="FirstContactRelation" value="<?php echo $RSA1[FirstContactRelation];?>"></td>
	</tr>


	<tr><td width="50%" align="Right">First Contact Phone<font color="#FF0000">*</font></td>			       <td><input type="text" size="15" name="FirstContactPhone" value="<?php echo $RSA1[FirstContactPhone];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Second Contact Name<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="SecondContactName" value="<?php echo $RSA1[SecondContactName];?>"></td>
	</tr>
 
	<tr><td width="50%" align="Right">Second Contact Relationship<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="SecondContactRelation" value="<?php echo $RSA1[SecondContactRelation];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Second Contact Phone<font color="#FF0000">*</font></td>			       <td><input type="text" size="15" name="SecondContactPhone" value="<?php echo $RSA1[SecondContactPhone];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Doctor Name<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="DoctorName" value="<?php echo $RSA1[DoctorName];?>"></td>
	</tr>
 
	<tr><td width="50%" align="Right">Doctor City<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="DoctorCity" value="<?php echo $RSA1[DoctorCity];?>"></td>
	</tr>


	<tr><td width="50%" align="Right">Doctor Phone<font color="#FF0000">*</font></td>			       <td><input type="text" size="15" name="DoctorPhone" value="<?php echo $RSA1[DoctorPhone];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Dentist Name<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="DentistName" value="<?php echo $RSA1[DentistName];?>"></td>
	</tr>
 
	<tr><td width="50%" align="Right">Dentist City<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="DentistCity" value="<?php echo $RSA1[DentistCity];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Dentist Phone<font color="#FF0000">*</font></td>			       <td><input type="text" size="15" name="DentistPhone" value="<?php echo $RSA1[DentistPhone];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Hospital Preference<font color="#FF0000">*</font></td>			       <td><input type="text" size="28" name="HospitalPreference" value="<?php echo $RSA1[HospitalPreference];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Allergies or Special Medical Conditions: </td>			       <td><input type="text" size="50" name="SpecialMedicalConditions" value="<?php echo $RSA1[SpecialMedicalConditions];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Insurance Company Name: </td>			       
                          <td><input type="text" size="50" name="InsuranceName" value="<?php echo $RSA1[InsuranceName];?>"></td>
	</tr>

	<tr><td width="50%" align="Right">Insurance Policy Number: </td>			       
                          <td><input type="text" size="28" name="InsurancePolicyNumber" value="<?php echo $RSA1[InsurancePolicyNumber];?>"></td>
	</tr>

	<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

                <tr><td align = "center" colspan="2"><B>Waiver and Release</B></td></tr>
	<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>


                <tr>
                <td align = "left" colspan="2">I, the undersigned parent or legal guardian of the above child(ren), do give my permission and approval for his/her participation in Southern Connecticut Chinese School program(s) and therefore, assume all risks and hazards incidental to such participation. On behalf of my child(ren) and family, I freely and voluntarily agree to release, indemnify and hold harmless, the Southern Connecticut Chinese School, its directors, officers, administrators, teachers, and volunteers from any liabilities arising from any injury, mental or physical, arising from my child(ren)'s involvement and participation in the school's program(s). In the event that my child becomes ill or injured during any Southern Connecticut Chinese School activity, its officers, teachers, or volunteers have my permission to arrange for adequate medical attentions and treatment, including the transportation of my child to an appropriate emergency medical facility. I have read and accepted the above Release, and I understand and agree fully with its provisions.</td>
                </tr>

	<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
	<tr>
											<td align="center">
												<input type="submit" value="Save and Sign Your Form">
											</td>
											<td align="center">
												<input type="button" width="18"  onClick="window.location.href='FamilyChildList.php'" value="Cancel">
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
