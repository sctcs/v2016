<?php

require_once("../common/DB/DataStore.php");
require_once("../common/CommonParam/params.php");

if ( $_GET[Confirmed] == "Cancel" ) 
{
echo "<a href=\"index.php?view=ViewFamilyAccount&familyid=". $_GET['FamilyID']."&mainmenu=off\">View Account History</a>";
}
else 
if ( $_GET[Confirmed] == "No" ) 
{
   echo "<a href=\"deletePayment.php?FamilyID=" . $_GET[FamilyID] . "&PaymentID=" . $_GET[PaymentID] . "&Confirmed=Yes\">Yes</a><BR><BR>";
   echo "<a href=\"deletePayment.php?FamilyID=" . $_GET[FamilyID] . "&PaymentID=" . $_GET[PaymentID] . "&Confirmed=Cancel\">No</a>";
} else { // yes
  $updatecmd="delete from tblPayment where PaymentID=" . $_GET[PaymentID];
  //echo $updatecmd;
  $result = mysqli_query($conn,$updatecmd) or die ("died while deleting receivable <br>Debug info: $updatecmd <br>\n");

  echo "<a href=\"index.php?view=ViewFamilyAccount&familyid=". $_GET['FamilyID']."&mainmenu=off\">View Account History</a>";
}

?>
