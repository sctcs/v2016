<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(! isset($_SESSION['family_id']))
{
 header( 'Location: Logoff.php' ) ;
 exit();
}

$seclvl = $_SESSION['membertype'];
if ( $seclvl == 50 ) { //parent
   $fid=$_SESSION[family_id]; 
} else { // admins
  $fid = $_GET[fid];
  if ($fid =="") {
    echo "FamilyID missing";
    exit();
  }
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");


//mysql_select_db($dbName, $conn);

//echo $_SESSION['membertype'];
//echo $_SESSION['memberid'];
//exit();


?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Safety Patrol Schedule</title>
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
					<td width="1%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php

						$SQLstring = "select *   from tblSafetyPatrol   "
						            ."where FamilyID=".$fid . " order by ID";
						$RS1=mysqli_query($conn,$SQLstring);

					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><BR>Safety Patrol Schedule<br>FamilyID: <?php echo $fid; ?></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td>
									<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">
                                                                        <th>Year</th><th>Term</th><th>Period</th><th>ChildClass</th><th>Scheduled Date</th><th>Served Date</th><th>Status</th>
<?php if ($seclvl ==10 || $seclvl ==20 || $seclvl==40 ) {
  echo "<th>Action</th>";
} ?>
                                                                        <?php while($RSA1=mysqli_fetch_array($RS1)) {
$spid = $RSA1[ID];
                                                                                 echo "<tr><td align=center>". $RSA1[Year] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[Term] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[Period] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[ChildClass] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[ScheduledDate] ."</td>";
                                                                                 echo "    <td align=center>&nbsp;". $RSA1[ServedDate] ."</td>";
                                                                                 echo "    <td align=center>&nbsp;". $RSA1[Status] ."</td>";
                                                                             //  if ( $RSA1[ServedDate] != null ) {
                                                                             //     echo "<td align=center>Served</td>";
                                                                              // } else {
                                                                             //     echo "<td align=center><font color=\"red\">to be Served</font></td>";
                                                                             //  }
      if ($seclvl ==10 || $seclvl ==20 || $seclvl==40 ) {
  echo "<td>";
  echo "<a href=\"SafetyPatrolForm.php?fid=".$fid. "&spid=". $spid. "\">Update</a>";
  echo "&nbsp;&nbsp;";
  echo "<a href=\"SafetyPatrolDelete.php?fid=".$fid. "&spid=". $spid. "\">Delete</a>";
  echo "</td>";
} 
                                                                                 echo "</tr>";
                                                                               } ?>
									</table>
								</td>
							</tr>
<?php if ($seclvl ==10 || $seclvl ==20  || $seclvl==40 ) { ?>
<tr><td>
<a href="SafetyPatrolForm.php?fid=<?php echo $fid; ?>">Schedule a New Patrol Date</a>
<a href="ManageSafetyPatrol.php">Manage Safety Patrol Home</a>

</td></tr>
<?php } ?>
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
