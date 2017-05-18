<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
 echo "<center>";
 echo ( 'you need to <a href="MemberLoginForm.php">login</a> first' ) ;
 exit();
}
if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
{
 echo "<center>";
 echo ( 'you need to <a href="MemberAccountMain.php">login as Principal, PTA President, or Chairman of Board of Directors</a>' ) ;
 exit();
}

 $seclvl = $_SESSION['membertype'];
$secdesc = $_SESSION['MemberTypes'][$seclvl];
$firstname = $_SESSION['firstname'];
 $lastname = $_SESSION['lastname'];

include("../common/DB/DataStore.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Send Email</title>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
<body>

<a href="MemberAccountMain.php">My Account</a>

<table  background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php //include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td >
			<table >
				<tr>
                  <?php
                     $SQLstring = "select *  from tblMemberType";
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);
					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>Send a School Wide Email</b></font></td>

							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td>
									<table >

<form name="emailform" action="SendEmailToMembersAction.php" method="POST" >

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
<td width="50%" align="Right">From: </td>
<td><?php echo $firstname . " " . $lastname .", "; echo $secdesc; 
if ( $seclvl == 10 )
{
  echo ", principal@ynhchineseschool.org";
  $from = "principal@ynhchineseschool.org";
} else if  ( $seclvl == 11 )
{
  echo ", boardchairman@ynhchineseschool.org";
  $from ="boardchairman@ynhchineseschool.org";
} else if  ( $seclvl == 12 )
{
  echo ", ptachair@ynhchineseschool.org";
  $from ="ptachair@ynhchineseschool.org";
} else {
  echo "Invalid login";
  exit;
}
?>
<input type="hidden" name="From" value="<?php echo $from;?>">
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
<td width="50%" align="Right" valign="Top">To: </td>

		<td><input type="checkbox" name="ParentPC" value="primary" checked>Primary Contact Parents<BR>
		    <input type="checkbox" name="ParentSP" value="both">Second Parents<BR>
<!--		    <input type="checkbox" name="Students" value="student">Students</td> -->
										</tr>

										<tr>
		<td width="50%" align="Right" valign="Top"> </td>
		<td><input type="checkbox"  name="Teachers" value="teachers">Teachers<BR>
		    <input type="checkbox"  name="Admins" value="admins">School Administrators<BR>
		    <input type="checkbox"  name="Alumni" value="alumni">Alumni (all former members)<BR>
											</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
<td width="50%" align="Right" valign="Top">Subject: </td>
		<td><input type="text" name="Subject" value="" size=60>
										</tr>
										<tr>
<td width="50%" align="Right" valign="Top">Message: </td>
		<td><textarea cols=60 rows=30 name="Message" value=""></textarea>
										</tr>





										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="right">
												<input type="submit" name="Preview" value="Previev">
											</td>
											<td align="center">
												<input type="submit" name="Send" value="Send">
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
		<?php //include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>
