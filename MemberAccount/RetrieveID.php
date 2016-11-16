<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
include("../common/CommonParam/params.php");
include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

////////////////////////////////////////////
// 1. get all variables
// 2. query DB and get login id
// 3. create necessary session
// 4. redirect page to new location
///////////////////////////////////////////

////  1. load all variables ////


$userEmail=$_POST[userEmail];
$userEmail=str_replace("'", "''",$userEmail);
$userEmail=str_replace("\n", " ",$userEmail);
$userEmail=trim($userEmail);



if ($userEmail=="")
{
 header( 'Location: retrieveLoginID.php?error=1' ) ;
 exit();
 }



//// 2. get login info  ////

$SQLstring = "SELECT tblMember.UserName,tblMember.Password,tblMember.FamilyID FROM tblMember WHERE tblMember.Email='".$userEmail. "'";
//echo "see: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
$rc=0;

while ($row=mysqli_fetch_array($RS1)) {
  $memberid=$row[MemberID];
  //$useremail=$row[Email];
  $familyid=$row[FamilyID];
  //$membertype=$row[MemberType];
  //$seclevel=$row[SecurityLevel];
  $loginid=$row[UserName];
  $pw=$row[Password];
  $loginids[$loginid]=$pw;
  $rc = $rc + 1;
}

if ($rc == 0)
{
	header( 'Location: retrieveLoginID.php?error=2' ) ;
	exit();
}


//// 3. create session variables ////
// store session data
//$_SESSION['family_id']=$familyid;
//$_SESSION['logon']=$loginID;

$_SESSION[UserEmail]=$userEmail;

$_SESSION[loginIDs]=$loginids;


//header( 'Location: retrieveLoginSummary.php?useremail='.$userEmail.'&id='.$loginid.'&pw='.$pw ) ;
  header( 'Location: retrieveLoginSummary.php' ) ;

mysqli_close($conn);

?>