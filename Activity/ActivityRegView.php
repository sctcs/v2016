<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Activity Public List</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
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
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>


					<?php
if ( isset($_GET[Container]) )
{
					$sid="SID".$_GET[Container];
$SID=$_GET[$sid];
}
else {
					$sid="SID".$_POST[Container];
$SID=$_POST[$sid];
}
						$sid1=" order by LastName, FirstName";

						$SQLstring0 = "select * from tblActivity where ActivityID =".$SID;

						$RS0=mysqli_query($conn,$SQLstring0);

						$RSA0=mysqli_fetch_array($RS0);

						$SQLstring = "select * from (tblActivity INNER JOIN tblActivityRegistration ON tblActivity.ActivityID = tblActivityRegistration.ActivityID) INNER JOIN tblMember ON tblActivityRegistration.RegistrationMemberID = tblMember.MemberID where active ='Y' and tblActivityRegistration.Cancel='No' and tblActivity.ActivityID=".$SID;
						$SQLstring = $SQLstring.$sid1;
						//echo $SQLstring;

						$RS1=mysqli_query($conn,$SQLstring);
					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>School Activity List</b></font></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="1" width="100%">


										<tr bgcolor="#390000">
											<td><font color="#0FFFFF">Activity Name</font></td>
											<td><font color="#0FFFFF">Activity Description</font></td>
											<td><font color="#0FFFFF">Date and Time</font></td>
											<td><font color="#0FFFFF">Location</font></td>
											<td><font color="#0FFFFF">Main Contact</font></td>
											<td><font color="#0FFFFF">Other Contacts</font></td>

										</tr>

										<tr>
											<td><?php echo $RSA0[ActivityName];?></td>
											<td><?php echo $RSA0[Activity];?></td>
											<td><?php echo $RSA0[DateAndTime];?></td>
											<td><?php echo $RSA0[Location];?></td>
											<td><?php echo $RSA0[MainContact];?></td>
											<td><?php echo $RSA0[OtherContacts];?></td>

										</tr>

<!--										<tr>
											<td> <br> </td>
											<td> <br> </td>
											<td> <br> </td>
											<td> <br> </td>
											<td> <br> </td>
											<td> <br> </td>
											<td> <br> </td>
										</tr>
-->
									</table>

									<table CLASS="page" bgcolor="#FFFFFF" border="1" width="100%">



										<tr bgcolor="#990000">
											<td><font color="#FFFFFF">First Name</font></td>
											<td><font color="#FFFFFF">Last Name</font></td>
											<td><font color="#FFFFFF">Number of Adults</font></td>
											<td><font color="#FFFFFF">Number of Children</font></td>
											<td><font color="#FFFFFF">Things to Bring</font></td>
											<td><font color="#FFFFFF">Suggestion and Help</font></td>

										</tr>

										<?php
											$i=0;
											while($RSA1=mysqli_fetch_array($RS1))

										{ ?>
										<tr>
											<td><?php echo $RSA1[FirstName];?></td>
											<td><?php echo $RSA1[LastName];?></td>
											<td><?php echo $RSA1[NumberOfAdult];?></td>
											<td><?php echo $RSA1[NumberOfChild];?></td>
											<td><?php echo $RSA1[ThingsToBring];?></td>
											<td><?php echo $RSA1[Suggestion];?>
<!--
</td>

											<td>
-->
												<input type="hidden" value="<?php echo $RSA1[ActivityID ];?>"  name="SID<?php echo $i;?>">

											</td>

										</tr>
										<?php
											$TotalAdult = $TotalAdult + $RSA1[NumberOfAdult] ;
											$TotalChild = $TotalChild + $RSA1[NumberOfChild] ;
											$Total = $Total + $RSA1[NumberOfAdult] + $RSA1[NumberOfChild];
											$i++;
										} ?>

										<input type="hidden" name="Container">

									</table>

								</td>
							</tr>
							<tr>

							<td>Total Adults: <?php echo $TotalAdult ?>; Total Children: <?php echo $TotalChild ?>; Total Member: <?php echo $Total ?> </td>

							</tr>
							<tr>

							<td>&nbsp;</td>
							</tr>


							<?php if ( isset ($_SESSION['memberid']) && $_SESSION['memberid'] != "") { ?>
							<td aling="center"> <a href="ActivityListForMember.php">sign up</a> for activities</td>
							<?php } else { ?>
							<td aling="center">Please <a href="../MemberAccount/MemberLoginForm.php">log in</a> to sign up for activities</td>
							<?php } ?>


						</table>

					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>

	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

