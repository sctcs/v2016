<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
 session_start();
  $userEmail=$_SESSION[UserEmail];

  include("../common/CommonParam/params.php");
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Account Login Retrieval Summary</title>
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
							<tr><td><?php include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							<tr><td>
							<?php

							if(  isset($_SESSION['loginIDs'])) {

							 $loginids = $_SESSION['loginIDs'];

							 echo "Your login infomation has been sent to your email address: ".$userEmail."<br><br> Please check your mailbox in a little moment.";
							 $message = "Dear $SCHOOLNAME_ABR Member,\n\nHere is the login info you just requested:\n";
							 foreach ($loginids as $id => $pw ) {
							    $message .="   login:".$id." and password:".$pw."\n";
							 }
						     $message .="\nThanks for your support.\n\n$SCHOOLNAME\n";
							 $to      = $userEmail;
							 $subject = "Your $SCHOOLNAME_ABR Member Login Info";

							 $headers = 'From: support@ynhchineseschool.org' . "\r\n" .
							     'Reply-To: support@ynhchineseschool.org' . "\r\n" .
							     'X-Mailer: PHP/' . phpversion();

							 mail($to, $subject, $message, $headers);


							}
                            ?>
                            </td></tr>
                            <tr><td><br>You can go back to <a href="MemberLoginForm.php">login</a> when you have received your login info.
                            </td></tr>

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
