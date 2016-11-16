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
if ( isset($_GET[choose]) && $_GET[choose]=="spring" ) 
{
  $fsql = "update tblFamily set PaymentChoice='S' where FamilyID=". $_SESSION['family_id'];
  $RSF = mysqli_query($conn, $fsql);
  echo "<BR><BR>";
  echo "You have chosen to pay your fall due along with spring payment. ";
} else {

  $fsql = "update tblFamily set PaymentChoice='F' where FamilyID=". $_SESSION['family_id'];
  $RSF = mysqli_query($conn, $fsql);

  echo "<BR><BR>";
  echo "You have chosen to pay your fall due in fall.";
} 

mysqli_close($conn);
?>

<html>
<body>
