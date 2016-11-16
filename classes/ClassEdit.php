<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
 exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] >= 25)
//{
 //echo ( 'you need to log in as a school admin' ) ;
// exit();
//}

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit Class Information</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
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

					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>

							<tr>
								<td align="center"><font><b>Class Information<br></b></font></td>
							</tr>
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>

							<?php
								$sid="SID".$_POST[Container];
								$SQLstring = " SELECT * FROM tblClass WHERE ClassID=".$_POST[$sid];
								$RS1=mysqli_query($conn,$SQLstring);
								$RSA1=mysqli_fetch_array($RS1);
							?>


							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form id="UpdateClass" action="ClassUpdateOne.php" method="post" onSubmit="return Validate(this);">

										<tr>
											<td width="80%" align="Right">Teacher Name<font color="#FF0000">*</font></td>
											<td width="80%">

										<?php
										$sqleth="select tblMember.MemberID, Concat(LastName, ', ', FirstName) as Name from tblMember inner join tblTeacher on tblTeacher.MemberID = tblMember.MemberID where CurrentTeacher = 'Yes' order by Name";
										$rseth=mysqli_query($conn,$sqleth);
										echo "<select name=\"MemberID\">";
						                     	while ($rweth=mysqli_fetch_array($rseth) ) {
						                       		if ( $rweth[MemberID] == $RSA1[TeacherMemberID] ) {
						                          	echo "<option SELECTED value=\"". $rweth[MemberID] ."\">". $rweth[Name]. "</option>\n";
						                       			} else {
						                          		echo "<option          value=\"". $rweth[MemberID] ."\">". $rweth[Name]. "</option>\n";
						                       			}
						                     		}
						                     	?>

											</td>

										</tr>


										<tr>
											<td width="80%" align="Right">Class Code<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="ClassCode" value="<?php echo $RSA1[ClassCode];?>"></td>
										</tr>
										<tr>
											<td width="80%" align="Right">Grade or Subject<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="GradeOrSubject" value="<?php echo $RSA1[GradeOrSubject];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Class Number<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="ClassNumber" value="<?php echo $RSA1[ClassNumber];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Classroom<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="Classroom" value="<?php echo $RSA1[Classroom];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Current Class<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="CurrentClass" value="<?php echo $RSA1[CurrentClass];?>"></td>
										</tr>


										<tr>
											<td width="80%" align="Right">Class Fee<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="ClassFee" value="<?php echo $RSA1[ClassFee];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Year<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="Year" value="<?php echo $RSA1[Year];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Term<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="Term" value="<?php echo $RSA1[Term];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Period<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="Period" value="<?php echo $RSA1[Period];?>"></td>
										</tr>

										<tr>
											<td width="80%" align="Right">Seats<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="Seats" value="<?php echo $RSA1[Seats];?>"></td>
										</tr>
		
										<tr>
											<td width="80%" align="Right">Language?<font color="#FF0000">*</font></td>
											<td><input type="text" size="40" name="IsLanguage" value="<?php echo $RSA1[IsLanguage];?>"></td>
										</tr>
										<tr>
											<td width="80%" align="Right">Description<br>(limited to 4000 bytes)</td>
											<td><textarea form="UpdateClass" cols="60" rows="10" name="Description"><?php echo $RSA1[Description];?> </textarea> </td>
										</tr>




										<!-- -----------------Hidden variables--------------------- -->
										<input type="hidden" name="ClassID" value="<?php  echo $RSA1[ClassID]; ?>">
										<!-- --------- class_id ----------------------------------- -->

										<tr>
											<td align="center" >
												<input type="submit" value=" Submit & Update >>>">
											</td>
										</form>
										<form name="DeleteClass" action="ClassDeleteOne.php" method="post" onSubmit="return Validate(this);">
										<input type="hidden" name="ClassID" value="<?php  echo $RSA1[ClassID]; ?>">

											<td align="center" >
												<input type="submit" value="   Delete   ">
											</td>
										</form>

											<td align="center" >
												<input type="button" onClick="window.location.href='ClassList.php'" value="     Exit      ">
											</td>
										</tr>
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
