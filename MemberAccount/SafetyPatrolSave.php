<?php

session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start(); 

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

$spid=$_POST[spid];
$fid=$_POST[fid];
$year=$_POST[year];
$term=$_POST[term];
$period=$_POST[period];
$cclass=$_POST[cclass];
$sdate=$_POST[sdate];
$vdate=$_POST[vdate];

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

if ( $period =="") {
  echo "missing period";
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
  if ( $vdate =="" ) {
     $SQLstring = "update      `tblSafetyPatrol` set  `ScheduledDate`=".$sdate_sql." , `ServedDate`=".$vdate_sql. " , ChildClass='".$cclass."',Year='". $year ."', Term='". $term . "', Period='". $period . "', Status='not Served' where ID=".$spid;
  } else {
     $SQLstring = "update      `tblSafetyPatrol` set  `ScheduledDate`=".$sdate_sql." , `ServedDate`=".$vdate_sql. " , ChildClass='".$cclass."',Year='". $year ."', Term='". $term . "', Period='". $period . "', Status='Served' where ID=".$spid;
  }
// echo "<br>SQLstring:  ".$SQLstring;

   if (!mysqli_query($conn,$SQLstring)) { die('Error: ' . mysqli_error($conn)); }

} else {
 $ifid = split(',', $fid);
       $SQLstring="";
       for ($i=0;$i<count($ifid); $i++) {
          if ( trim($ifid[$i]) != "") {

            if ( $vdate =="" ) {
             $SQLstring = "insert into `tblSafetyPatrol` ( `FamilyID` , `Year` , `Term` , Period, `ChildClass` , `ScheduledDate`                ) values(". trim($ifid[$i]) . ", ". $year.", '". $term."', '". $period ."','".$cclass."', ". $sdate_sql.                 ');';
            } else {
             $SQLstring = "insert into `tblSafetyPatrol` ( `FamilyID` , `Year` , `Term` , Period, `ChildClass` , `ScheduledDate` , `ServedDate`, `Status` ) values(". trim($ifid[$i]) . ", ". $year.", '". $term."', '". $period ."','".$cclass."', ". $sdate_sql.", ".$vdate_sql. ", 'Served');";
            }
//           echo "<br>SQLstring:  ".$SQLstring;

             if (!mysqli_query($conn,$SQLstring)) { die('Error: ' . mysqli_error($conn)); }
          }
       }
}






 header( 'Location: ViewSafetyPatrol.php?fid=' . $fid ) ;

mysqli_close($conn);

?>
