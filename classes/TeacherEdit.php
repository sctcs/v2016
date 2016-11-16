<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
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

//mysql_select_db($dbName, $conn);


if ( $_GET[act] == "deactivate" ) {
	  $SQLstring = " update tblTeacher set CurrentTeacher='No' WHERE MemberID=".$_GET[MID];
} else if ( $_GET[act] == "delete" ) {
	  $SQLstring = " delete from tblTeacher  WHERE MemberID=".$_GET[MID];
} else {
	  $SQLstring = " update tblTeacher set CurrentTeacher='Yes' WHERE MemberID=".$_GET[MID];
}
								//echo $SQLstring;
	$RS1=mysqli_query($conn,$SQLstring);
								//$RSA1=mysqli_fetch_array($RS1);

mysqli_close($conn);

?>
<a href="TeacherList.php">continue</a>




