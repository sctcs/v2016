<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
include("../common/CommonParam/params.php");

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Parent Agreement</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />

<link href="../../common/ynhc.css" rel="stylesheet" type="text/css">

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
												<b>Parent Agreement</b>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php if ($_GET["error"]==1) { ?>
										<tr>
											<td colspan=2>
											<font color=#FF0000><b><b>Can not empty space in LoginID or Password Field.</b></font>
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
											<font color=#FF0000><b><b>Either the Login ID or the Password that you supplied was incorrect.</b></font>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php } ?>

										<tr>
											<td colspan=2>&nbsp;
                                                                                        <a href="../public/SCCS_safety_rules_07-31-09.pdf">Safty Rules (in PDF)</a> <BR><BR>
											</td>
										</tr>

										<form action="WaiverAction.php" method="post">

										<tr align="center">
											<td align="right">
											<table border=1>
											<tr><td>
											I (We) have read and acknowledge the <?php echo $SCHOOLNAME; ?> Guidelines for Parents, Responsibilities for POD and Children Safety, regulations and other procedures on the <?php echo $SCHOOLNAME; ?> web site (http://www.ynhchineseschool.org) and will abide by it. I (we) understand that the above terms are subject to change and <?php echo $SCHOOLNAME; ?> will post the amendment on the school's web site.  I understand that <?php echo $SCHOOLNAME; ?> will notify me (us) once any change that has been entered and the change will be effective from the date it is posted online or notified on paper, whichever is earlier.
											<BR><BR>
											I understand that if my child or I (We) displays inappropriate behavior, my child may be dismissed from the program and no refunds will be given, or I (We) may be suspended for membership.  My child, a student of <?php echo $SCHOOLNAME; ?>, have read and acknowledge the <?php echo $SCHOOLNAME; ?> Student Code of Conduct, Fires Emergency Preparedness rule, the school rules and regulations and will abide by it.

											</td></tr>
											</table>


											</td>
										</tr><tr>

											<td align="left"><BR>
											<input type="radio" name="waiver" value="accept">I have read and agree<br>
											<input type="radio" name="waiver" value="reject" checked>I have not read or do not agree
											</td>

										</tr>



										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<tr align="center">
											<td colspan=2>
											<input type="submit" value="Continue" >
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
