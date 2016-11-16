<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

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

$loginID=$_POST[loginID];
$loginID=str_replace("'", "''",$loginID);
$loginID=str_replace("\n", " ",$loginID);
$loginID=trim($loginID);

$userPW=$_POST[userPW];
$userPW=str_replace("'", "''",$userPW);
$userPW=str_replace("\n", " ",$userPW);
$userPW=trim($userPW);

if ($loginID=="" || $userPW=="")
{
 header( 'Location: MemberLoginForm.php?error=1' ) ;
 exit();
 }



//// 2. get login info  ////

$SQLstring = "SELECT tblMember.MemberID,tblMember.Email,tblMember.FamilyID,tblMemberType.MemberTypeID,tblMemberType.MemberType,tblMemberType.SecurityLevel,tblLogin.LoginID FROM tblMember,tblLogin,tblMemberType WHERE tblMember.MemberID=tblLogin.MemberID and tblLogin.MemberTypeID=tblMemberType.MemberTypeID and tblMember.UserName='".$loginID. "' and tblMember.Password='".$userPW."'";
//echo "see: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
$rc=0;

while ($row=mysqli_fetch_array($RS1)) {
  $memberid=$row[MemberID];
  $useremail=$row[Email];
  $familyid=$row[FamilyID];
  $membertype=$row[MemberType];
  $seclevel=$row[SecurityLevel];
  $loginid=$row[LoginID];
  $membertypeid=$row[MemberTypeID];

  $membertypes[$seclevel]=$membertype;
  $rc = $rc + 1;
}

if ($loginid == "")
{
	header( 'Location: MemberLoginForm.php?error=2' ) ;
	exit();
}
if ($membertypeid == 14)
{
    echo "<center>";
	echo "Your membership application will be processed as soon as possible, check your email within the following 1-2 days. <BR>You will be able to login when it is approved. <a href=\"MemberAccountMain.php\">continue</a>";
	echo "</center>";
	exit();
}

//// 3. create session variables ////
// store session data

$_SESSION['family_id']=$familyid;
$_SESSION['logon']=$loginID;
$_SESSION['useremail']=$useremail;
$_SESSION['MemberTypes']=$membertypes;
$_SESSION['memberid']=$memberid;


if ($rc > 1)
   $multiple_roles = "yes";
else
   $multiple_roles = "no";

//// 4. redirect to ////
if ($multiple_roles == "yes") {
  header( 'Location: chooseRole.php' ) ;
} else {
  $_SESSION['membertype'] = $seclevel;
  header( 'Location: MemberAccountMain.php' ) ;
}

mysqli_close($conn);

?>