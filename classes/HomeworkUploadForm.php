<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to log in as a teacher' ) ;
 exit();
}
if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] != 25)
{
 echo ( 'you need to log in as a teacher' ) ;
 exit();
}

include("../common/DB/DataStore.php");

?>
					<?php


						$SQLstring = "select *  from tblClass where CurrentClass='Yes' AND TeacherMemberID=".$_SESSION['memberid'] .
						             " AND GradeOrSubject='".$_GET[grade] ."' AND ClassNumber='".$_GET[number] ."' ";

						//echo "see111: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						$RSA1=mysqli_fetch_array($RS1);
						//$family_id=$RSA1[family_id];
						//$MemberType=$RSA1[MemberType];
						//echo "<br>see: ".$RSA1[HomePhone];

						if ( !isset($RSA1[ClassID]) || $RSA1[ClassID] == "" ) {
						  echo "Sorry, you are not a teacher of any class, so you are not allowed to upload homework files<br>";
						  echo '<a href="HomeworkList.php">See Homework List</a>';
						  mysqli_close($conn);
						  exit;
						}

                      if ( isset($_GET[ClassHomeworkID]) ) {
						$SQLstring2 = "select *  from tblClassHomework where ClassHomeworkID=".$_GET['ClassHomeworkID'];

						//echo "see111: ".$SQLstring;
						$RS2=mysqli_query($conn,$SQLstring2);
						$RSA2=mysqli_fetch_array($RS2);
				      }
					?>




<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Homework Upload</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
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
					<td width="6%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<td align="center" valign="top">
						<table width="100%">
 							<tr>
								<td align="center">&nbsp;</td>
							</tr>
                        <?php if ( $_GET[update] == "1") { ?>
							<tr>
								<td align="center"><font><b>Upload a New Version of a Homework File </b></font></td>
							</tr>
                        <?php } else { ?>
							<tr>
								<td align="center"><font><b>Upload a New Homework File </b></font></td>
							</tr>
                        <?php } ?>
 							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form enctype="multipart/form-data" name="NewHW" action="HomeworkUpload.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="ClassID" value="<?php echo $RSA1[ClassID];?>">
                                        <input type="hidden" name="origname" value="<?php echo $RSA1[OriginalFilename];?>">
                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />

										<tr>
											<td width="30%" align="Right">Class Grade: </td>
											<td width="70%" align="Left"><?php echo $RSA1[GradeOrSubject];?></td>
										</tr>
										<tr>
											<td width="30%" align="Right">Class Number: </td>
											<td width="70%" align="left"><?php echo $RSA1[ClassNumber];?></td>
										</tr>


										<tr>
											<td width="30%" align="Right">Class Room: </td>
											<td width="70%" align="left"><?php echo $RSA1[Classroom];?></td>
										</tr>
										<tr>
											<td width="30%" align="Right" valign="top">Homework Description: </td>
											<td width="70%" align="left"><textarea rows="1" cols="60" name="hwdescription" ><?php if ($_GET[vererror] == 1) { echo $_SESSION[hwdesc]; } else { echo $RSA2[Description];} ?></textarea></td>
										</tr>
                                        <tr>
											<td width="30%" align="Right">Due Date: </td>
											<td width="70%" align="left"><input type="text" size="19" maxlength="19" name="hwduedate" value="<?php echo $_SESSION[hwduedate];?>">
											(in any common date format, e.g. March 2, 2008)
											</td>
										</tr>

										<?php if ($_GET[update] == "1") { ?>
										<tr>
											<td width="30%" align="Right">Version: </td>
											<td width="70%" align="left"><input type="text" size="3" maxlength="3" name="hwversion" value="<?php echo $RSA1[Version];?>"></td>
										</tr>
										<?php } ?>



										<tr>
											<td width="50%" align="Right"  valign="top">Homework File: </td>
											<td><input type="file" size="80" maxlength="150"  name="hwfile"  >
											(file name should not contain Space or other special charaters, dash or underscore is OK; a good file name can be, e.g. hw20080313.doc or hw_03_13_2008.pdf)
											</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="right">
												<input type="submit" value="Upload">
											</td>
											<td align="center">
												<input type="button" width="18"  onClick="window.location.href='HomeworkListDetail.php?grade=<?php echo $_GET[grade].'&number='.$_GET[number]; ?>'" value="Cancel">
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
		<?php //include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

<?php mysqli_close($conn); ?>