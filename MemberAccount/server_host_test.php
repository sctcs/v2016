<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
 echo "remote server: ".$_SERVER["SERVER_ADDR"].", ".$_SERVER["SERVER_NAME"];
} else {
 echo  "local server: ".$_SERVER["SERVER_ADDR"].", ".$_SERVER["SERVER_NAME"];
}
?>