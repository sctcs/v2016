<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['memberid']))
{  }
else
{header( 'Location: ../main.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

////////////////////////////////////////////
// 1. get all variables
// 2. insert into DB
// 3. Send email out
// 4. create necessary session
// 5. redirect page to new location
///////////////////////////////////////////


////////  1. load all variables/////////////////////

$AID =$_POST['ActivityID'];

////////  Delete a record from Activity table ////////////////////



$SQLstring = "delete from tblActivity where ActivityID=".$AID;


if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

//mysqli_query($conn,$SQLstring);

////  create session variable activityid //////////////
// session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
//session_start();
// store session data
$_SESSION['activityid']=$activityid;

header( 'Location: ActivityList.php' ) ;

mysqli_close($conn);

?>

