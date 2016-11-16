<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if( ! isset($_SESSION['logon']))
{
    echo "You need to login first";
    //header( 'Location: MemberLoginForm.php?error=3' ) ;
	exit();
}
 //echo "Session is empty";
//echo $_SESSION[memberid];
							?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SCCS Member Account choose role</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

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
					<td width="26%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							<tr><td>
							<?php

							if(  isset($_SESSION['logon'])) {
							 include("listOfRoles.php");
							}
                            ?>
                            </td></tr>
                       <!--
							<tr>
								<td align="center"><font><b>Family Account<br></b></font></td>
							</tr>
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>



							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<tr>
											<td align="center" >
												<table>
													<tr>
														<td width="50%">
															<tr>
																<td><a href="FmailyProfile.php">Fmaily Profile</a></td>
															</tr>
															<tr>
																<td><a href="FamilyChildList.php">Children(s) List</a></td>
															</tr>
														</td>
														<td width="50%">
															&nbsp;
														</td>
													</tr>
												</table>
											</td>
										</tr>

									</table>
								</td>
							</tr>
                        -->
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
