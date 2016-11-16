<?php
session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
 exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] >= 25)
//{
 //echo ( 'you need to log in as a school admin' ) ;
// exit();
//}

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

////////  1. load all variables/////////////////////

$CID=$_POST['ClassID'];

////////  Delete a record from Class table ////////////////////

$SQLstring = "delete from tblClass where ClassID=".$CID;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

//mysqli_query($conn,$SQLstring);

////  create session variable activityid //////////////
session_save_path("c:/WebServer/Apache2/htdocs/phpsessions");
session_start();
// store session data
$_SESSION['ClassID']=$ClassID;

header( 'Location: ClassList.php' ) ;
mysqli_close($conn);

?>
