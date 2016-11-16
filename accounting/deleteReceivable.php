<?php

require_once("../common/DB/DataStore.php");
require_once("../common/CommonParam/params.php");

if ( $_GET[Confirmed] == "Cancel" ) 
{
echo "<a href=\"index.php?view=ReceivableViewFamily&FamilyID=". $_GET['FamilyID']."&mainmenu=off&date=".$PAST_BALANCE_DATE."\">[View Receivables since ".$PAST_BALANCE_DATE."]</a>";
}
else 
if ( $_GET[Confirmed] == "No" ) 
{
   echo "<a href=\"deleteReceivable.php?FamilyID=" . $_GET[FamilyID] . "&ReceivableID=" . $_GET[ReceivableID] . "&Confirmed=Yes\">Yes</a><BR><BR>";
   echo "<a href=\"deleteReceivable.php?FamilyID=" . $_GET[FamilyID] . "&ReceivableID=" . $_GET[ReceivableID] . "&Confirmed=Cancel\">No</a>";
} else { // yes
  $updatecmd="delete from tblReceivable where ID=" . $_GET[ReceivableID];
  //echo $updatecmd;
  $result = mysqli_query($conn,$updatecmd) or die ("died while deleting receivable <br>Debug info: $updatecmd <br>\n");
  echo "<a href=\"index.php?view=ReceivableViewFamily&FamilyID=". $_GET['FamilyID']."&mainmenu=off&date=".$PAST_BALANCE_DATE."\">[View Receivables since ".$PAST_BALANCE_DATE."]</a>";
}

?>