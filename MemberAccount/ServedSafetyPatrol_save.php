<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

$seclvl = $_SESSION['membertype'];
if ( $seclvl != 10 && $seclvl !=20 && $seclvl != 35 && $seclvl != 40  && $seclvl != 55) { //principal, DBA, Board Member, School Admin, Collector
    echo "not authorized";
    exit();

}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

$today = getdate();
$year = $today[year];
$mon = $today[mon];

$sdate=$_POST[sdate];
$fids=$_POST[fids];

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Safety Patrol Form</title>
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
		<td width="98%" >

			<?php

 $SQLstring = "update tblSafetyPatrol set ServedDate='". $sdate . "', Status='Served' where FamilyID in (". $fids . ") and ScheduledDate='". $sdate . "'";
//echo $SQLstring;
   mysqli_query($conn,$SQLstring);



?>
</table>
</body>
</html>

<?php
    mysqli_close($conn);
 ?>
