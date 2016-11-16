<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
$action=$_POST[action];
$membertype=$_POST[membertype];

if ($action == "setrole") {
  if ($membertype == "0") {
    header( 'Location: chooseRole.php' );
  } else {
    $_SESSION['membertype'] = $_POST[membertype];
    //echo $_SESSION['membertype'];
    header( 'Location: MemberAccountMain.php' );
  }
}
?>