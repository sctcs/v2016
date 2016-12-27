<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(!isset($_SESSION['family_id']) && !isset($_POST[newmember]) )
{
 header( 'Location: ../main.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

////////////////////////////////////////////
// 1. get all variables
// 2. insert into DB
// 3. Send email out
// 4. create necessary session
// 5. redirect page to new location
///////////////////////////////////////////


////////  1. load all variables/////////////////////


$PrimaryCP_FirstName=$_POST[PCFristName];
$PrimaryCP_FirstName=str_replace("'", "''",$PrimaryCP_FirstName);
$PrimaryCP_FirstName=str_replace("\n", " ",$PrimaryCP_FirstName);
$PrimaryCP_FirstName=trim($PrimaryCP_FirstName);

$PrimaryCP_LastName=$_POST[PCLastName];
//$LoginPW=$_POST[PW];
$PrimaryCP_ChineseName=$_POST[PCChineseName];

$PrimaryCP_Profession=$_POST[PCProfession];

$PrimaryCP_email=$_POST[PCEmail];
$PrimaryCP_email=str_replace("'", "''",$PrimaryCP_email);
$PrimaryCP_email=str_replace("\n", " ",$PrimaryCP_email);
$PrimaryCP_email=trim($PrimaryCP_email);

$SecondaryCP_FirstName=$_POST[SCFristName];
$SecondaryCP_LastName=$_POST[SCLastName];
$SecondaryCP_email=$_POST[SCEmail];
$SecondaryCP_Profession=$_POST[SCProfession];
$area=$_POST[area];
$prefix=$_POST[prefix];
$suffix=$_POST[suffix];
$home_phone=$area."-".$prefix."-".$suffix;

$Carea=$_POST[Carea];
$Cprefix=$_POST[Cprefix];
$Csuffix=$_POST[Csuffix];
$cell_phone=$Carea."-".$Cprefix."-".$Csuffix;

$Oarea=$_POST[Oarea];
$Oprefix=$_POST[Oprefix];
$Osuffix=$_POST[Osuffix];
$office_phone=$Oarea."-".$Oprefix."-".$Osuffix;

$address=$_POST[Address];
$city=$_POST[city];
$state=$_POST[state];
$zip=$_POST[zip];

$PrimaryContact=$_POST[PrimaryContact];
$gender=$_POST[gender];
$org=$_POST[org];
$hobbies=$_POST[hobbies];
$secondemail=$_POST[SecondEmail];
if ( $_POST[dir] == "no dir" ) {
   $is_dir_ok="No";
}
if ( $_POST[pic] == "no pic" ) {
   $is_pic_ok="No";
}

if ( $_POST[password1] != "") {
 if (  $_POST[password1] == $_POST[password2] ) {
  $pw = $_POST[password1];
 } else {
  die ("New Passwords do not match, try again");
 }
}

$ethnicity=$_POST[ethnicity];
$yob=$_POST[yob];
$dobbs=$_POST[dobbs];
//if (isset($dob) && strlen($dob) == 10) {
//   list($mm,$dd,$yyyy) = explode("/",$dob);
//   $dob=$yyyy."-".$mm."-".$dd;
//}
if ( $_POST[whose]=="student" ) {
 if ( isset($yob) ) {
  if ( strlen($yob) == 4) {
   //list($mm,$dd,$yyyy) = explode("/",$dob);
  // $dob=$yyyy."-".$mm."-".$dd;
  //list($yyyy,$mm,$dd) = explode("-",$dob);

   // Convert dates to Julian Days
   //$start_date = gregoriantojd($mm, $dd, $yyyy);
   //$end_date = gregoriantojd(12, 31, ($CurrentYear - $AGE_TO_START));

   // Return difference
   $age = $CurrentYear - $yob;
   if ( $age < $AGE_TO_START || ($age == $AGE_TO_START && $dobbs != 'Y') ) {
     echo "yob: ".$yob;
     echo "age ".$age;
     echo "Age to start: ".$AGE_TO_START;
     echo "Sorry! Your child is too young for school this year. Must be born on or before September 1, ". ($CurrentYear - 6). " to qualify. Please come back next year.";
     mysqli_close($conn);
     exit;
   }

  } else {
   echo "ERROR: please enter a valid Year of Birth (YOB) in the format of yyyy";
   mysqli_close($conn);
   exit;
  }
 } else {
   echo "ERROR: please enter a valid Year of Birth (YOB) in the format of yyyy";
   mysqli_close($conn);
   exit;

 }
}

//echo "<br>address:  ".$address;

//$MemberRegistrationDate=date("j, n, Y");
$MemberUpdateDate=date("Y/m/d");

if ( isset($_POST[newmember]) )
{
 //////// 2. insert a record in member table ///////////////

 $SQLstring ="INSERT INTO member (HomePhone,FirstName,LastName,ChineseName,Email,Profession,CellPhone,HomeAddress,HomeCity,HomeState, HomeZip,"
            ."PrimaryContact,SecondEmail,OfficePhone,Organization,Hobbies,Directory,Picture, MostRecentUpdateDate) VALUES ("
            .$MemberType.",'". $home_phone ."','". $PrimaryCP_FirstName ."','". $PrimaryCP_LastName ."','". $PrimaryCP_email ."','"
            .$LoginPW ."','". $PrimaryCP_Profession ."','". $SecondaryCP_FirstName ."','". $SecondaryCP_LastName ."','".  $SecondaryCP_email ."','"
            . $SecondaryCP_Profession ."','". $cell_phone ."','". $address ."','". $city ."','". $zip ."',". $disclaimer .",". $is_dir_ok .","
            . $is_pic_ok .",". $volunteer .",'". $volunteer_other  ."','". $MemberRegistrationDate ."') ";

 //echo "<br>SQLstring:  ".$SQLstring;
 //mysqli_query($conn,$SQLstring);
} else {
 ////////  update a record in member table ////////////////////



 $SQLstring = "update tblMember set HomePhone='". $home_phone
           . "', ChineseName='". $PrimaryCP_ChineseName ."', Email='". $PrimaryCP_email  ."', Profession='". $PrimaryCP_Profession  ."', CellPhone='". $cell_phone ."', HomeAddress='". $address
           . "', HomeCity='". $city . "', HomeState='". $state  ."', HomeZip='". $zip  ."', MostRecentUpdateDate='". $MemberUpdateDate
           . "', Gender='". $gender. "', Ethnicity='". $ethnicity
           . "', SecondEmail='". $secondemail
           . "', OfficePhone='". $office_phone
           . "', Organization='". $org
           . "', Hobbies='". $hobbies
           . "', Directory='". $is_dir_ok
           . "', Picture='". $is_pic_ok;
 if ( strlen($yob) == 4 ) {
   $SQLstring .=  "', DOBYear='". $yob;
   $SQLstring .=  "', DOBBeforeSept='". $dobbs;
 }
 if ( $pw != "" ) {
   $SQLstring .=  "', Password='". $pw;
 }
 $SQLstring .= "'  where MemberID=".$_POST['updtmemberid'];
} // if newmember

//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }



if ( $_POST[whose]=="student" ) {
  $sql = "update tblStudent set PrimaryHomeLanguage='".$_POST[PrimaryHomeLanguage] . "', NumChSpeakParents=".$_POST[NumChSpeakParents]. " where MemberID=".$_POST['updtmemberid'];
  //echo $sql;
  if (!mysqli_query($conn,$sql))
  {
    die('Error: ' . mysqli_error($conn));
  }

echo "<center><br><br>";

echo "Profile updated successfully, click here to <br><a href=\"studentProfile.php?whose=student&stuid=".$_POST['updtmemberid']."\">continue</a>";
echo "<br>or  <br><a href=\"FamilyChildList.php\">Child List</a>";
echo "</center>";
} else {
echo "<center><br><br>";
echo "Profile updated successfully, click here to <a href=\"MemberAccountMain.php\">continue</a>";
echo "</center>";

}

mysqli_close($conn);

?>
