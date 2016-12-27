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

	//echo "wow: ";						
							//echo "SUD: ".$_POST[SID0];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit Student Info</title>
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
								<td align="center"><font><b>Student Information<br></b></font></td>
							</tr>
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							
							<?php
								$sid="SID".$_POST[Container];
								//echo "sid: ".$sid;
								//$SQLstring = "select *  from student where student_id=".$_POST[SID0];
								$SQLstring = " SELECT * FROM student WHERE student_id=".$_POST[$sid];
								$SQLstring = "select MB.*   from tblMember MB where   MB.MemberID=".$_POST[$sid];
								//echo "see: ".$SQLstring;
								$RS1=mysqli_query($conn,$SQLstring);
								$RSA1=mysqli_fetch_array($RS1);
								//$family_id=$RSA1[family_id];
								//$MemberType=$RSA1[MemberType];

							?>
							
							
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										
										<form name="NewStudent" action="UpdaeOneStudentProcess.php" method="post" onSubmit="return Validate(this);">


										
										<tr>
											<td width="30%" align="Right"> First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="StudentFristName" value="<?php echo $RSA1[FirstName  ];?>"></td>
										</tr>
										<tr>
											<td width="30%" align="Right">Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="StudentLastName" value="<?php echo $RSA1[LastName  ];?>"></td>
										</tr>
										
										<tr>
											<td width="30%" align="Right">Chinese Name&nbsp;</td>
											<td><input type="text" size="28" name="StudentChineseName" value="<?php echo $RSA1[ChineseName  ];?>"></td>
										</tr>
										<tr>
											<td width="30%" align="Right">Gender<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="studentGender" <?php if ( $RSA1[Gender]=="F") {?> checked <?php }?>  value="F">Female
												&nbsp;
												<input type="radio" name="studentGender" <?php if ( $RSA1[Gender]=="M") {?> checked <?php }?> value="M">Male
											</td>
										</tr>
										<tr>
											<td width="30%" align="Right">Date of Birth<font color="#FF0000">*</font></td>
											<td><?php include("../common/TimeSpan/TimeSelect_DOBline2.php");
											//echo $RSA1[DateOfBirth]
											?>
											</td>
										</tr>

										<!-- -----------------Hidden variables--------------------- -->
										<input type="hidden" name="StudentID" value="<?php  echo $_POST[$sid] ?>">
										<input type="hidden" name="ClassidFlag" value="<?php  echo $RSA1[class_id] ?>">

										<!-- --------- class_id ----------------------------------- -->
										 <?php if ( $RSA1[class_id]=="0") {?>
										<tr>
											<td width="30%" align="Right">Student Type<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="studentType" onClick="displayme('NewStudentLine');" <?php if ( $RSA1[StudentType]=="1") {?> checked <?php }?> value="1">New Student
												&nbsp;
												<input type="radio" name="studentType" onClick="displayme('ReturnStudentLine');" <?php if ( $RSA1[StudentType]=="2") {?> checked <?php }?> value="2">Return Student
											</td>
										</tr>
										<tr id="ReturnStudentLine" style="display:<?php if ( $RSA1[StudentType] =="2") {?> <?php } else {?>none <?php }?>">
											<td width="30%" align="Right">Last semester your child was in&nbsp;</td>
											<td>
												<SELECT  NAME="ReturnStudentLevel">
													<OPTION <?php if ( $RSA1[ClassLastYear] =="0") {?> selected <?php }?> VALUE="0">---Select---</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="1") {?> selected <?php }?> VALUE="1">1 &#24180;&#32423; 1 &#29677; (&#26446;&#25102;&#30495;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="2") {?> selected <?php }?> VALUE="2">1 &#24180;&#32423; 2 &#29677; (&#21016;&#20070;&#31584;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="3") {?> selected <?php }?> VALUE="3">1 &#24180;&#32423; 3 &#29677; (&#26361;&#34164;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="4") {?> selected <?php }?> VALUE="4">2 &#24180;&#32423; 1 &#29677; (&#26446;&#29738;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="5") {?> selected <?php }?> VALUE="5">2 &#24180;&#32423; 2 &#29677; (&#32834;&#22411;&#38081;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="6") {?> selected <?php }?> VALUE="6">2 &#24180;&#32423; 3 &#29677; (&#26472;&#24314;&#26032;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="7") {?> selected <?php }?> VALUE="7">3 &#24180;&#32423; 1 &#29677; (&#20613;&#20057;&#20809;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="8") {?> selected <?php }?> VALUE="8">3 &#24180;&#32423; 2 &#29677; (&#38047;&#26757;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="9") {?> selected <?php }?> VALUE="9">4 &#24180;&#32423; 1 &#29677; (&#33539;&#26195;&#23425;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="10") {?> selected <?php }?> VALUE="10">4 &#24180;&#32423; 2 &#29677; (&#38472;&#26391;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="11") {?> selected <?php }?> VALUE="11">5 &#24180;&#32423; 1 &#29677; (&#29579;&#23447;&#23195;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="12") {?> selected <?php }?> VALUE="12">5 &#24180;&#32423; 2 &#29677; (&#36911;&#24428;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="13") {?> selected <?php }?> VALUE="13">6 &#24180;&#32423; 1 &#29677; (&#38472;&#26107;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="14") {?> selected <?php }?> VALUE="14">6 &#24180;&#32423; 2 &#29677; (&#36793;&#25991;&#24420;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="15") {?> selected <?php }?> VALUE="15">7 &#24180;&#32423; 1 &#29677; (&#26366;&#24314;&#25935;)</OPTION>
													<OPTION <?php if ( $RSA1[ClassLastYear] =="16") {?> selected <?php }?> VALUE="16">8 &#24180;&#32423; 2 &#29677; (&#26519;&#33459;)</OPTION>
												</SELECT>
											</td>
										</tr>
										<tr id="NewStudentLine" style="display:<?php if ( $RSA1[StudentType] =="1") {?> <?php } else {?>none <?php }?>">
											<td width="30%" align="Right">Starting Level&nbsp;</td>
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
											<td width="30%" align="Right">Art Class&nbsp;</td>
											<td align="left">
												<input type="radio" name="ArtChoose" onClick="displayme('ArtClassSelect');" <?php if ( $RSA1[Art_Class] !="" && $RSA1[Art_Class] !="0") {?> checked <?php }?> value="1">Yes
												&nbsp;
												<input type="radio" name="ArtChoose" onClick="displayme('ArtClassSelect');" <?php if ( $RSA1[Art_Class] =="" && $RSA1[Art_Class] =="0") {?> checked <?php }?> value="2">No
											</td>
										</tr>
										<tr id="ArtClassSelect" style="display:<?php if ( $RSA1[Art_Class] !="" && $RSA1[Art_Class] !="0") {?> <?php } else {?>none <?php }?>">
											<td width="30%" align="Right">Art Class&nbsp;</td>
											<td>
												<SELECT  NAME="ArtClasslevel">
													<OPTION VALUE="0">---Select---</OPTION>
													<OPTION <?php if ( $RSA1[Art_Class] =="Elementary Art") {?> selected <?php }?> VALUE="Elementary Art">Elementary Art</OPTION>
													<OPTION <?php if ( $RSA1[Art_Class] =="Intermediate Art") {?> selected <?php }?> VALUE="Intermediate Art">Intermediate Art</OPTION>
													<OPTION <?php if ( $RSA1[Art_Class] =="Dancing Class") {?> selected <?php }?> VALUE="Dancing Class">Dancing Class</OPTION>
													<OPTION <?php if ( $RSA1[Art_Class] =="Elementary Chess") {?> selected <?php }?> VALUE="Elementary Chess">Elementary Chess</OPTION>
													<OPTION <?php if ( $RSA1[Art_Class] =="Parent dancing") {?> selected <?php }?> VALUE="Parent dancing">Parent dancing</OPTION>
													
													
													
												</SELECT>
											</td>
										</tr>
										<?php }?>
										<!-- -------------------------------------- -->
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
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
											<td align="center" >
												<input type="submit" value=" Submit & Update >>>">
											</td>
											<td align="center" >
												<input type="button" onClick="window.location.href='MemberAccountMain.php'" value="                Exit                ">
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
