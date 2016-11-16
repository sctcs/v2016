<?php
if ( strstr($_SERVER["REQUEST_URI"] , "Staging/Development" ) ) {
   echo "<font color=red>WARNING: this appears to be the staging site, your input will be lost or won't be saved into production system.
   <br><br>
   This is OK if you are testing the function. Otherwise, make sure you login to the production site.</font>";
}
// disable temporarily in staging
// echo "This is staging, make sure you login to production system";
// exit;
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
//echo $_SESSION['memberid'];
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Account Receivable Payment</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
</head>

<body>
<table  background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="100%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="1%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>
					</td>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="left"><font><b>&nbsp</b></font></td>
							</tr>
							<tr>
								<td align="left">
								<?php  include ("indexmain.php"); ?>
								</td>
							</tr>
					<!--	<tr>
								<td align="center"><hr>To open A simple and clean version in a new window,<br> <a href="noframe.php" target=_blank>click here. Yes, right here :D</a><hr></td>
							</tr>-->
						</table>
					</td>

				</tr>
			</table>
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
