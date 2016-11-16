<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

?>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br>
<a href="familyAccountSummary.php#balance">Account Summary</a>
<?php

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
include("balance_lib.php");

//echo $_POST[dispnote];
if ( isset($_GET[delete]) && $_GET[delete]=="true" ) 
{
  $fsql = "update tblFamily set PaymentChoice='N',DisputeNote='" . $_POST[dispnote] . "' where FamilyID=". $_SESSION['family_id'];
  $RSF = mysqli_query($conn, $fsql);
  echo "<BR><BR>";
  echo "You have canceled your dispute. Go back to <a href=\"disputeBalance.php\">Dispute</a> form.";
} else {

  $fsql = "update tblFamily set PaymentChoice='D',DisputeNote='" . $_POST[dispnote] . "' where FamilyID=". $_SESSION['family_id'];
  $RSF = mysqli_query($conn, $fsql);

  echo "<BR><BR>";
  echo "You note has been saved. Go back to <a href=\"disputeBalance.php\">Dispute</a> form.";
} 

mysqli_close($conn);

?>

<html>
<body>
