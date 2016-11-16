<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
 session_start();
  $login=$_SESSION[logon];
  if ( ! isset($_SESSION[logon]) || $login == "" ) {
     echo "You are not authorized to run this function.";
     exit;
  }
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Yale-New Haven Community Chinse School Payment Notice</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../../common/ynhc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
<script language="javascript" src="../common/JS/MainValidate.js"></script>

</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr>
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="28%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>
					</td>
					<td align="center" valign="top" >
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td bgcolor="#993333">
									<table height="60%" border="0" width=100% bgcolor="white">
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<tr align="left">
											<td colspan=2>
												<b>Please enter a valid Family ID.</b>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php if ($_GET["error"]==1) { ?>
										<tr>
											<td colspan=2>
											<font color=#FF0000><b><b>Can not leave blank in Family ID field.</b></font>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php } ?>

										<?php if ($_GET["error"]==2) { ?>
										<tr>
											<td colspan=2>
											<font color=#FF0000><b>Entered Family ID is not valid, enter a valid one.</b></font>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php } ?>


										<form action="payment_notice_create.php" method="post" onSubmit="return Validate(this);">

										<tr align="center">
											<td align="right">
												<b>Family ID:</b>
											</td>
											<td align="left">
											<input type="text" name="familyid" size="40">
											</td>

										</tr>




										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<tr align="center">
											<td colspan=2>
											<input type="submit" value="Go" >
											</td>
										</tr>
										<tr>
											<td>&nbsp;

											</td>
										</tr>
										<tr>
											<td>&nbsp;

											</td>
										</tr>
										</form>
									</table>

								</td>
							</tr>

						</table>
					</td>
					<!-- <td  width="6%">
						<?php include("Advertisment/ad1.php"); ?>
					</td> -->
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
