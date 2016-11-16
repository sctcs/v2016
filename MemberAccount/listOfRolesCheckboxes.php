<?php
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
//echo $_SESSION['membertype'];
if( ! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 20 ) {
   echo "You have to login with sufficient authroization to see the member list";
   exit;
}
//echo $_GET[10];
include("../common/DB/DataStore.php");
//mysqli_select_db($dbName, $conn);

// -- load assigned roles -------------
//
if ( isset($_SESSION[memberID]) && trim($_SESSION[memberID]) != "") {
  $memberID=$_SESSION[memberID];

  $SQLstring = "SELECT tblMemberType.MemberType,tblMemberType.SecurityLevel,tblLogin.LoginID FROM tblLogin,tblMemberType WHERE tblLogin.MemberTypeID=tblMemberType.MemberTypeID and tblLogin.MemberID='".$memberID. "'";
  //echo "see: ".$SQLstring;
  $RS1=mysqli_query($conn,$SQLstring);
  $rc=0;


  while ($row=mysqli_fetch_array($RS1)) {
    $seclevel=$row[SecurityLevel];
    $membertypes[$seclevel]=$row[MemberType];
    $rc = $rc + 1;

  }
}


// ----- list all available roles ------------
//
$SQLstring = 'SELECT `MemberTypeID` , `MemberType` , `SecurityLevel`  FROM `tblMemberType` order by SecurityLevel';
$RS1=mysqli_query($conn,$SQLstring);
$rc=0;
$membertypescurr="";

   while ($row=mysqli_fetch_array($RS1)) {

     $rc = $rc + 1;
     if ( isset($membertypes[$row[SecurityLevel]]) && trim($membertypes[$row[SecurityLevel]]) != "" ) {
        $membertypescurr .= $row[MemberTypeID] . ",";
        echo "<input CHECKED type=\"checkbox\" name=\"roles[]\" value=\"".$row[MemberTypeID]."\" />  ".$row[MemberType]."<br/>";
     } else {
        echo "<input         type=\"checkbox\" name=\"roles[]\" value=\"".$row[MemberTypeID]."\" />  ".$row[MemberType]."<br/>";
     }
   }
   echo "<input type=\"hidden\" name=\"membertypescurr\" value=\"".$membertypescurr."\"/>";
   ?>


   <?php
//print_r($membertypes);

mysqli_close($conn);
?>