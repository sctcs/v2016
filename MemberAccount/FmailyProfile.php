<?php
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: ../Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Fmaily Profile</title>
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

					<?php
						$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND  MB.FamilyID=".$_SESSION['family_id'];

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
					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>Family Profile</b></font></td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>

							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form name="NewMember" action="UpdaeMemberInfoProcess.php" method="post" onSubmit="return Validate(this);">





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
											<td width="50%" align="Right">Primary Contact First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCFristName" value="<?php echo $RSA1[FirstName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Primary Contact Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCLastName" value="<?php echo $RSA1[LastName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Primary Contact Email<font color="#FF0000">*</font></td>
											<td><input  type="text" size="28" name="PCEmail" value="<?php echo $RSA1[Email];?>"></td>
										</tr>

										<tr>
											<td width="50%" align="Right" valign="top">Primary Contact Profession</td>
											<td><input type="text" size="28" name="PCProfession" value="<?php echo $RSA1[Profession];?>"><br><font size="2">(Accountant, computer programmer, etc.)</font></td>
										</tr>


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
											<td width="50%" align="Right">Address<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="Address" value="<?php echo $RSA1[HomeAddress ];?>"></td>
										</tr>

										<tr>
											<td width="50%" align="Right">City<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="city" value="<?php echo $RSA1[HomeCity  ];?>"></td>
										</tr>
										<!-- <tr>
											<td width="50%" align="Right">State<font color="#FF0000">*</font></td>
											<td>
											</td>
										</tr> -->
										<tr>
											<td width="50%" align="Right">Zip Code<font color="#FF0000">*</font></td>
											<td><input type="text" size="5" maxlength="5"  name="zip" value="<?php echo $RSA1[HomeZip  ];?>" ></td>
										</tr>


										<tr>
											<td align="center" colspan="2"><hr></td>
										</tr>
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
												<input type="submit" value=" Submit & Update >>>">
											</td>
											<td align="center">
												<input type="button" width="1800"  onClick="window.location.href='MemberAccountMain.php'" value="                Exit                ">
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
