<?php session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
 session_start(); 
if( ! isset($_SESSION['family_id']))  
{header( 'Location: MemberRegistration.php' ) ;
	exit();
}
 //echo "Session is empty"; 
							?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Add More Student Registration</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
<script language="JavaScript">
	
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
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							
							<tr>
								<td align="center"><font><b>Add More Student<br></b></font></td>
							</tr>
							
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							<tr>
								<td align="left"><font>If you have another student to register under your family, please fill out the form and submit it. </font></td>
							</tr>
							
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<tr>
											<td align="center" colspan="2"><b>Student Information</b></td>
										</tr>
										<form name="NewStudent" action="AddOneStudentProcess.php" method="post" onSubmit="return Validate(this);">


										
										<tr>
											<td width="30%" align="Right"><?php echo $ii; ?> First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="StudentFristName"></td>
										</tr>
										<tr>
											<td width="30%" align="Right">Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="StudentLastName"></td>
										</tr>
										
										<tr>
											<td width="30%" align="Right">Chinese Name&nbsp;</td>
											<td><input type="text" size="28" name="StudentChineseName"></td>
										</tr>
										<tr>
											<td width="30%" align="Right">Gender<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="studentGender" value="F">Female
												&nbsp;
												<input type="radio" name="studentGender" value="M">Male
											</td>
										</tr>
										<tr>
											<td width="30%" align="Right">Date of Birth<font color="#FF0000">*</font></td>
											<td><?php include("../common/TimeSpan/TimeSelect_DOBline.php"); ?></td>
										</tr>
										
										
										

										
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="center" colspan="2">&nbsp;
											
												<input type="hidden" name="family_id" value="<?php echo $_SESSION['family_id']; ?>">
											</td>
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
