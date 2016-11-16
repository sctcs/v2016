<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
 $seclvl = $_SESSION['membertype'];
if ( $seclvl > 20 && $seclvl !=55 ) 
{
  echo "not allowed";
  exit();
}

$familyid = $_GET[fid];
if (!isset($familyid) || $familyid =="")
{
 echo "target FID not valid";
 exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

$SQLstring = "select ID, DateTime,FamilyID  from tblReceivable   "
	."where   FamilyID=".$familyid . " AND DateTime > '". $PAST_BALANCE_DATE ."'";
$SQLstring = "delete  from tblReceivable   "
	."where   FamilyID=".$familyid . " AND DateTime > '". $PAST_BALANCE_DATE ."'";
//	echo "see: ".$SQLstring;
	$RS1=mysqli_query($conn,$SQLstring);

echo "<a href=\"index.php\">Continue</a>";

    mysqli_close($conn);
 ?>
