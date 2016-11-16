<?php

session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start(); 

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

$spid=$_GET[spid];
$fid=$_GET[fid];
$year=$_GET[year];
$term=$_GET[term];
$sdate=$_GET[sdate];
$vdate=$_GET[vdate];

if ( $fid =="") {
  echo "missing FID";
  exit;
}
if ( $year =="") {
  echo "missing year";
  exit;
}
if ( $term =="") {
  echo "missing term";
  exit;
}
if ( $sdate =="" && $vdate =="") {
  echo "missing date";
  exit;
}

if ( $sdate =="" ) {
  $sdate_sql = 'null';
}else{
  $sdate_sql = "'" .$sdate."'";
}
if ( $vdate =="" ) {
  $vdate_sql = 'null';
}else{
  $vdate_sql = "'" .$vdate."'";
}

if ( $spid != "" ) {
$SQLstring = "update      `tblSafetyPatrol` set  `ScheduledDate`=".$sdate_sql." , `ServedDate`=".$vdate_sql. " where ID=".$spid;

} else {

$SQLstring = "insert into `tblSafetyPatrol` ( `FamilyID` , `Year` , `Term` , `ChildClass` , `ScheduledDate` , `ServedDate` ) values(".$fid. ", ". $year.", '". $term."', null, ". $sdate_sql.", ".$vdate_sql. ")";
}





//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring)) { die('Error: ' . mysqli_error($conn)); }

header( 'Location: ViewSafetyPatrol.php?fid=' . $fid ) ;

mysqli_close($conn);

?>
