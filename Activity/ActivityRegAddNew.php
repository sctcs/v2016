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
								<td align="center"><font><b>Register One Activity<br></b></font></td>
							</tr>

							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>

							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<form name="ActivityRegAddOne" action="ActivityRegAddOne.php" method="post" onSubmit="return Validate(this);">

										<tr>
											<td width="80%" align="Right">Number of Adults<font color="#FF0000">*</font></td>
											<td><input type="text" size="58" name="NumberOfAdult"></td>
										</tr>
										<tr>
											<td width="80%" align="Right">Number of Children<font color="#FF0000">*</font></td>
											<td><input type="text" size="58" name="NumberOfChild"></td>
										</tr>

									      <tr>
											<td width="80%" align="Right">Things to Bring<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="ThingsToBring" cols=30 rows=5></TEXTAREA> </td>
										</tr>

											<td width="80%" align="Right">Suggestions<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="Suggestion" cols=30 rows=5></TEXTAREA> </td>
										</tr>

										<tr>
											<td width="80%" align="Right">Cancel Activity<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="Cancel" Value="Yes">Yes
												&nbsp;
												<input type="radio" name="Cancel" Value="No" Checked>No
											</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;

												<!--<input type="hidden" name="activityid" value="<?php echo $_SESSION['activityid']; ?>">-->
												<input type="hidden" name="ActivityID" value="<?php echo $atid; ?>">

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

