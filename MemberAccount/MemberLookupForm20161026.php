<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

//if( ! isset($_SESSION['logon']) ) {
//  echo "You need to <a href=\"MemberLoginForm.php\">login</a>";
//  exit();
//}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SCCS Member Lookup</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<!--
<link href="../../common/ynhc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
<script language="javascript" src="../common/JS/MainValidate.js"></script>
-->
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
												<b>Please enter Last Name and First Name of the member.</b>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php if ($_GET["error"]==1) { ?>
										<tr>
											<td colspan=2>
											<font color=#FF0000><b><b>Can not empty space in Last Name field.</b></font>
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
											<font color=#FF0000><b><b>Either the Last Name or First Name that you supplied was incorrect.</b></font>
											</td>
										</tr>
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<?php } ?>


										<form action="MemberLookup.php" method="post" ">

										<tr align="center">
											<td align="right">
												<b>Last Name:</b>
											</td>
											<td align="left">
											<input type="text" name="lname" size="20"> (required)
											</td>

										</tr>


										<tr align="center">
											<td align="right">
												<b>First Name:</b>
											</td>
											<td align="left">
											<input type="text" name="fname" size="20"> (optional)
											</td>
										</tr>

										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
										<tr align="center">
											<td colspan=2>
											<input type="submit" value="Lookup" >
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
