<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
$action=$_POST[waiver];
//$memberid=$_SESSION[memberid];
//echo "$action";

if ($action == "accept") {
    include("../common/DB/DataStore.php");
	      $sql="update tblMember set Waiver='Yes' where MemberID=".$_SESSION['memberid'];
//echo $sql;
	      if (!mysqli_query($conn,$sql))      {
		  	            die('Error: ' . mysqli_error($conn));
	      }
    mysqli_close($conn);

    header( 'Location: FamilyChildList.php' );
  } else {

    //header( 'Location: ParentsWaiver.php' );
  }

?>
