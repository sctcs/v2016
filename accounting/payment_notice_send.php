<?php
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
 session_start();
  $login=$_SESSION[logon];
  if ( ! isset($_SESSION[logon]) || $login == "" || $login != 'xg2001' ) {
     echo "You are not authorized to run this function.";
     exit;
  }

  if ( isset($_GET[familyid]) && trim($_GET[familyid]) != "") {
    $fid=$_GET[familyid];
  }

  if ( isset($_GET[useremail]) && trim($_GET[useremail]) != "") {
    $useremail=$_GET[useremail];
  }

  if ( isset($_GET[fname]) && trim($_GET[fname]) != "") {
    $fname=$_GET[fname];
  }

  if ( isset($_GET[lname]) && trim($_GET[lname]) != "") {
    $lname=$_GET[lname];
  }

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Account Login Retrieval Summary</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
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

							if ( isset($useremail) && $useremail != "") {

							 //$loginids = $_SESSION['loginIDs'];

							 echo "Payment notice has been sent to ".$useremail."<br><br>";
							 $message = "Dear ".$fname." ".$lname.",\n\n";
							 $message .= "Happy New Year!\n\n";
							 $message .= "The YNHCS Spring 2008 Term will start on Jan. 20, 2008. To save the school and teachers time for the first day of class, so that teachers can concentrate on teaching from day-one, ";
							 $message .= "please mail your payment of tuition to the following address as soon as you can.\n\n";

                             $message .= "Please remember to:\n";
							 $message .= "1, write down your family ID, ".$familyid.", and student name(s) on your check.\n";
							 $message .= "2, make your check payable to: Yale-New Haven Community Chinese School\n";
							 $message .= "3, mail your check along with this payment notice before Jan 15, 2008 to:\n\n";

							 $message .= "Yale-New Haven Community Chinese School\n";
							 $message .= "P.O.Box  207105\n";
							 $message .= "Yale Station\n";
							 $message .= "New Haven, CT 06520\n\n";
							 //$message .= "Re: Tuition Fee Spring 2008\n";

							 $message .= "Note: The fee is $120 per student for all Chinese classes and $70 for all Art classes (including chess class). If you want to add or drop an art class, please write down at the end of this notice. You can use a single check for all children you have.\n";
							 $message .= "If you or your spouse is a teacher at our school, the tuition fee of $120 for your first child will be waived. You are responsible to pay tuition fee for all art classes and any class other children take. This policy is different from the past, so please mark so on your check if you still have a non-zero balance to school.\n";
							 $message .= "If you have any question regarding the change of tuition fee policy, please visit our website: www.ynhchineseschool.org to read the letter from the Principal.\n\n";

							 $message .= "If you have any other questions, please email support@ynhchineseschool.org.\n\n";

							 $message .= "Thank you for your prompt payment.\n\n";

							 $message .= "YNH Chinese School";

							 $to      = $useremail;
							 $subject = 'YNHCS Tuition Fee for Spring 2008';

							 $headers = 'From: support@ynhchineseschool.org' . "\r\n" .
							     'Reply-To: support@ynhchineseschool.org' . "\r\n" .
							     'X-Mailer: PHP/' . phpversion();

							 mail($to, $subject, $message, $headers);


							} else {
							  echo "Nothing sent.";
							}
                            ?>
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
