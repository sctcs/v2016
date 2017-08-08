<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

$action=$_GET[yorn];

    include("../common/DB/DataStore.php");

if ($action == "Y") {
	      $sql="update tblMember set ReceiveSchoolEmail='Y'   where Email='".$_GET[email] . "'";
  } else {
	      $sql="update tblMember set ReceiveSchoolEmail='N'   where Email='".$_GET[email] . "'";
  }
  
	      if (!mysqli_query($conn,$sql))      {
		  	            die('Error: ' . mysqli_error($conn));
	      }
    mysqli_close($conn);

  header('Location: ' . $_SERVER['HTTP_REFERER']);

?>
