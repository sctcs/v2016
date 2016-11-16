<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['memberid']))
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
<title>Edit Student Info</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
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
								<td align="center"><font><b>Activity Information<br></b></font></td>
							</tr>
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>

							<?php
								$sid="SID".$_POST[Container];
								$SQLstring = " SELECT * FROM tblActivity WHERE ActivityID=".$_POST[$sid];
								$RS1=mysqli_query($conn,$SQLstring);
								$RSA1=mysqli_fetch_array($RS1);
							?>


							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form name="UpdateActivity" action="ActivityUpdateOne.php" method="post" onSubmit="return Validate(this);">

										<tr>
											<td width="80%" align="Right"> Activity<font color="#FF0000">*</font></td>
											<td><input type="text" size="50" name="ActivityName" value="<?php echo $RSA1[ActivityName];?>" ></td>
										</tr>
										<tr>
											<td width="80%" align="Right">Activity Description<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="Activity" cols=48 rows=5><?php echo $RSA1[Activity];?></TEXTAREA> </td>
										</tr>

										<tr>
											<td width="80%" align="Right">Date and Time<font color="#FF0000">*</font></td>
											<td><input type="text" size="50" name="DateAndTime" value="<?php echo $RSA1[DateAndTime];?>"></td>
										</tr>
										<tr>
											<td width="80%" align="Right">Location<font color="#FF0000">*</font></td>
											<td><input type="text" size="50" name="Location" value="<?php echo $RSA1[Location];?>"></td>

											</td>
										</tr>
										<tr>
											<td width="80%" align="Right">Main Contact<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="MainContact" cols=48 rows=5><?php echo $RSA1[MainContact];?></TEXTAREA> </td>
										</tr>
										<tr>
											<td width="80%" align="Right">Other Contacts</td>
											<td valign=top><TEXTAREA name="OtherContacts" cols=48 rows=5><?php echo $RSA1[OtherContacts];?></TEXTAREA> </td>
										</tr>


										<tr>
											<td width="80%" align="Right">Active Activity<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="Active" <?php if ( $RSA1[Active]=="Y") {?> checked <?php }?>  value="Y">Yes
												&nbsp;
												<input type="radio" name="Active" <?php if ( $RSA1[Active]=="N") {?> checked <?php }?> value="N">No
											</td>
										</tr>

										<!-- -----------------Hidden variables--------------------- -->
										<input type="hidden" name="ActivityID" value="<?php  echo $_POST[$sid] ?>">
										<!-- --------- class_id ----------------------------------- -->

										<!-- -------------------------------------- -->
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="center" >
												<input type="submit" value=" Submit & Update >>>">
											</td>

										</form>
										<form name="DeleteActivity" action="ActivityDeleteOne.php" method="post" onSubmit="return Validate(this);">
										<input type="hidden" name="ActivityID" value="<?php  echo $RSA1[ActivityID]; ?>">

											<td align="center" >
												<input type="submit" value="   Delete   ">
											</td>
										</form>
											<td align="center" >
												<input type="button" onClick="window.location.href='ActivityList.php'" value="     Exit      ">
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

