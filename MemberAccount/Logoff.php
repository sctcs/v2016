<?php

//unset($_SESSION['logon']);


////////// 4. redirect to ////////////
//header( 'Location: main.php' ) ;

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
session_destroy();
header( 'Location: MemberLoginForm.php' ) ;

//session_destroy();

?>
