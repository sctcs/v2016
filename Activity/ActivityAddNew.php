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
								<td align="center"><font><b>Add One Activity<br></b></font></td>
							</tr>

							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>

							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<form name="ActivityAddOne" action="ActivityAddOne.php" method="post" onSubmit="return Validate(this);">

										<tr>
											<td width="80%" align="Right"> Activity<font color="#FF0000">*</font></td>
											<td><input type="text" size="58" name="ActivityName"></td>
										</tr>
   									      <tr>
											<td width="80%" align="Right">Activity Description<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="Activity" cols=30 rows=5></TEXTAREA> </td>
										</tr>

										<tr>
											<td width="80%" align="Right">Date and Time<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="DateAndTime"</td>
										</tr>
										<tr>
											<td width="80%" align="Right">Location<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="Location"</td>
   									      <tr>
											<td width="80%" align="Right">Main Contact<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="MainContact" cols=30 rows=5></TEXTAREA> </td>
										</tr>
   									      <tr>
											<td width="80%" align="Right">Other Contacts<font color="#FF0000">*</font></td>
											<td valign=top><TEXTAREA name="OtherContacts" cols=30 rows=5></TEXTAREA> </td>
										</tr>

										</tr>

										<tr>
											<td width="80%" align="Right">Active Activity<font color="#FF0000">*</font></td>
											<td align="left">
												<input type="radio" name="Active" Value="Y" Checked>Yes
												&nbsp;
												<input type="radio" name="Active" Value="N">No
											</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;

												<input type="hidden" name="activityid" value="<?php echo $_SESSION['activityid']; ?>">
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

