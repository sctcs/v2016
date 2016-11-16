<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if( ! isset($_SESSION['memberid']))
{header( 'Location: MemberRegistration.php' ) ;
	exit();
}
 //echo "Session is empty";
include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

if ( ! isset($_GET[atid]) ||  $_GET[atid] =="" )
{
  echo 'you need to provide a valid Activity ID';
  exit;
}

$atid=$_GET[atid];

?>



<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Add More Activity Registration</title>
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
								<td align="center"><font><b>Edit Activity Registration<br></b></font></td>
							</tr>

							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>

							<?php
								$sid=$atid;
								$mid=$_SESSION['memberid'];
								$SQLstring = "SELECT * FROM tblActivityRegistration WHERE (ActivityID=$sid and RegistrationMemberID=$mid)";
								$RS1=mysqli_query($conn,$SQLstring);
								$RSA1=mysqli_fetch_array($RS1);
							?>

							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<form name="ActivityRegUpdateOne" action="ActivityRegUpdateOne.php" method="post" onSubmit="return Validate(this);">

										<tr>
											<td width="80%" align="Right">Number of Adults<font color="#FF0000">*</font></td>
											<td><input type="text" size="58" name="NumberOfAdult" value="<?php echo $RSA1[NumberOfAdult];?>" ></td>
										</tr>
										<tr>
											<td width="80%" align="Right">Number of Children<font color="#FF0000">*</font></td>
											<td><input type="text" size="58" name="NumberOfChild" value="<?php echo $RSA1[NumberOfChild];?>" ></td>
										</tr>

									      <tr>
											<td width="80%" align="Right">Things to Bring<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="ThingsToBring" cols=30 rows=5><?php echo $RSA1[ThingsToBring];?> </TEXTAREA> </td>
										</tr>

											<td width="80%" align="Right">Suggestions<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="Suggestion" cols=30 rows=5><?php echo $RSA1[Suggestion];?></TEXTAREA> </td>
										</tr>

										<tr>
											<td width="80%" align="Right">Cancel Activity<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="Cancel" <?php if ( $RSA1[Cancel]=="Yes") {?> checked <?php }?> value="Yes">Yes
												&nbsp;
												<input type="radio" name="Cancel" <?php if ( $RSA1[Cancel]=="No") {?> checked <?php }?> value="No">No

											</td>
										</tr>

										<tr>
										</tr>
										<tr>
											<td align="right" colspan="1">
												<input type="submit" value=" Submit Your Edit">
											</td>
											<td align="center" colspan="1">
												<input type="button" onClick="window.location.href='ActivityListForMember.php'" value="     Exit      ">
											</td>
										<input type="hidden" name="ActivityID" value="<?php echo $RSA1[ActivityID];?>" >
										<input type="hidden" name="RegistrationMemberID" value="$mid">
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

