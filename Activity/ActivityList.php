<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['memberid']))
{  }
else
{header( 'Location: ../Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Activity List</title>
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
						$SQLstring = "select * from tblActivity ";

						$RS1=mysqli_query($conn,$SQLstring);
					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>Activity List for Manager</b></font></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="1" width="100%">

										<tr bgcolor="#990000">
											<td><font color="#FFFFFF">Activity Name</font></td>
											<td><font color="#FFFFFF">Activity Description</font></td>
											<td><font color="#FFFFFF">Date and Time</font></td>
											<td><font color="#FFFFFF">Location</font></td>
											<td><font color="#FFFFFF">Main Contact</font></td>
											<td><font color="#FFFFFF">Other Contacts</font></td>

										</tr>
										<form action="ActivityEdit.php" method="post">
										<?php
											$i=0;
											while($RSA1=mysqli_fetch_array($RS1))

										{ ?>
										<tr>
											<td><?php echo $RSA1[ActivityName];?></td>
											<td><?php echo $RSA1[Activity];?></td>
											<td><?php echo $RSA1[DateAndTime];?></td>
											<td><?php echo $RSA1[Location];?></td>
											<td><?php echo $RSA1[MainContact];?></td>
											<td><?php echo $RSA1[OtherContacts];?></td>

											<td>

												<input type="hidden" value="<?php echo $RSA1[ActivityID ];?>"  name="SID<?php echo $i;?>">

												<input type="submit" value="Edit " onClick="sendme(<?php echo $i;?>);">

											</td>

										</tr>
										<?php
											$i++;
										} ?>

										<input type="hidden" name="Container">
										</form>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><input type="button" value="Add New Activity " onClick="window.location.href='ActivityAddNew.php'"></td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
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

