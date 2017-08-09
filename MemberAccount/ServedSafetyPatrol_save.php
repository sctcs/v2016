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


<?php

 $SQLstring = "update tblSafetyPatrol set ServedDate='". $sdate . "', Status='Served' where FamilyID in (". $fids . ") and ScheduledDate='". $sdate . "'";

   mysqli_query($conn,$SQLstring);



?>

<?php
    mysqli_close($conn);

 ?>
  <a href="ManageSafetyPatrol.php">Continue</a>
