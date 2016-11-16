<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

//echo $_SESSION['membertype'];
//echo $_SESSION['memberid'];
//exit();

// signed the waiver as a parent
if ( $_SESSION['membertype'] == 50 ) {

	$SQLstring = "select MB.*   from tblMember MB  "
				."where   MB.MemberID=".$_SESSION['memberid'];

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);

  if ($RSA1[Waiver] != "Yes") {

    //header( 'Location: FamilyChildList.php' );
  //} else {
    header( 'Location: ParentsWaiver.php' );
  }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Temporary Registration Form</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

<script language="JavaScript">

	function sendme(who)
	{
		//alert("here ");
		document.all.Container.value=who;

	}
</script>
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
			<table height="36" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="1%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php
						//$SQLstring = "select * from viewClassStudents  where FamilyID=".$_SESSION['family_id'];

						$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  "
						            ."where Login.MemberTypeID =5 AND  MB.FamilyID=".$_SESSION['family_id'];
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);

					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr> <td><br><BR><font color=red>Dear Students and Parents, class online self registration for <?php echo $SchoolYear;?> school year is closed. <BR><BR>
If you need to make any adjustment to your class registrtion please email support@ynhchineseschool.org or visit school office in room A107 between 1:30pm and 4:30pm on any open school day. <BR><BR>
<a href="../Registration/Registration_and_Refund_Policies.php">Please read the refund policies if you have any questions on refund.</a>
<!-- Registration dates for the 2010-2011 school year (2010 Fall and 2011 Spring) will be announced during summer.-->
</font><br><BR></td></tr>
							<tr>
								<td align="center"> <input type="button" value="Return to Main Menu" onClick="window.location.href='MemberAccountMain.php'">
								</td>
							</tr>
							<tr>
								<td align="center"></td>
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

<?php
    mysqli_close($conn);
 ?>
