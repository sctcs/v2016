<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if( ! isset($_SESSION['memberid']))
{header( 'Location: MemberRegistration.php' ) ;
	exit();
}
 //echo "Session is empty";
include("../common/DB/DataStore.php");


//mysqli_select_db($dbName, $conn);
$mid = $_SESSION['memberid'];

$SQLstring = "select * from tblActivityRegistration ";
$RS1=mysqli_query($conn,$SQLstring);


if ( ! isset($_GET[atid]) ||  $_GET[atid] =="" )
{
  echo 'you need to provide a valid Activity ID';
  exit;
}

$atid=$_GET[atid];


$flag=0;

while($RSA1=mysqli_fetch_array($RS1)){
  if ($RSA1[RegistrationMemberID]==$mid && $RSA1[ActivityID]==$atid){
     $flag = 1;
  }
}


if ($flag == 1){
     include("ActivityRegEdit.php");}
else {
      include("ActivityRegAddNew.php");
}


?>

