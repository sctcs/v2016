<?php
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
//echo $_SESSION['membertype'];
if( ! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 20 ) {
   echo "You have to login with sufficient authroization to see the member list";
   exit;
}
if( ! isset($_SESSION[lastName]) || trim($_SESSION[lastName]) == "" ) {
   // last name needs to be specified to avoid loading whole list of members more than 600
   exit;
}

include("../common/DB/DataStore.php");
//mysqli_select_db($dbName, $conn);

//if( ! isset($_SESSION[lastName]) || trim($_SESSION[lastName]) != "" )
   $SQLstring = "SELECT `MemberID` , `FirstName` , `LastName` , `ChineseName` FROM `tblMember` where LastName='".$_SESSION[lastName]."' order by FirstName";
//else
//   $SQLstring = 'SELECT `MemberID` , `FirstName` , `LastName` , `ChineseName` FROM `tblMember` order by LastName';
$RS1=mysqli_query($conn,$SQLstring);
$rc=0;

echo "<select name=\"memberDropDown\" onChange=\"fillForm(this.parent);\">";
echo "<option value=\"0\">Choose a member</option>";
   while ($row=mysqli_fetch_array($RS1)) {
     $rc = $rc + 1;
     if (isset($_SESSION[memberID]) && $_SESSION[memberID] == $row[MemberID]) {
      if (isset($row[ChineseName]) && trim($row[ChineseName]) != "" )
       echo "<option SELECTED value=\"".$row[MemberID]."\">".$row[LastName].", ".$row[FirstName]."; ".$row[ChineseName]."</option>\n";
      else
       echo "<option SELECTED value=\"".$row[MemberID]."\">".$row[LastName].", ".$row[FirstName]."</option>\n";
     } else {
      if (isset($row[ChineseName]) && trim($row[ChineseName]) != "" )
       echo "<option          value=\"".$row[MemberID]."\">".$row[LastName].", ".$row[FirstName]."; ".$row[ChineseName]."</option>\n";
      else
       echo "<option          value=\"".$row[MemberID]."\">".$row[LastName].", ".$row[FirstName]."</option>\n";
     }
   }
   ?>
   </select>

   <?php


mysqli_close($conn);
?>