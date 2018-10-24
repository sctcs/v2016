<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

if ( isset($_GET[RequestID]) && $_GET[RequestID] !="" ) {
   $rid= $_GET[RequestID];
} 
if ( isset($_GET[FamilyID]) && $_GET[FamilyID] !="" ) {
   $fid= $_GET[FamilyID];
} 

if ( isset($_GET[done]) && $_GET[done] =="yes" ) {
           $SQLstring = " update tblRefundRequest set Process='Yes', ProcessDate=now() WHERE `RequestID`=".$rid;
           $RS1=mysqli_query($conn,$SQLstring) or die ("died while deleting receivable <br>Debug info: $SQLstring <br>\n");
           if ( ! $RS1 ) {
             exit();
           }
}
        echo "Back to <a href=\"creditSelectionListing.php?show=all\">Credit Selection Listing</a><br><br>";

mysqli_close($conn);
?>
