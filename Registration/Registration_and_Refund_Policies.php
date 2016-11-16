<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
//include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

echo "<a href=\"../MemberAccount/MemberAccountMain.php\">My Account</a> ";
echo "<BR><BR>";
echo "$REGISTRATION_POLICIES";

?>