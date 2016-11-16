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


$FirstContactName=$_POST[FirstContactName];
$FirstContactRelation=$_POST[FirstContactRelation];
$FirstContactPhone=$_POST[FirstContactPhone];
$SecondContactName=$_POST[SecondContactName];
$SecondContactRelation=$_POST[SecondContactRelation];
$SecondContactPhone=$_POST[SecondContactPhone];
$DoctorName=$_POST[DoctorName];
$DoctorCity=$_POST[DoctorCity];
$DoctorPhone=$_POST[DoctorPhone];
$DentistName=$_POST[DentistName];
$DentistCity=$_POST[DentistCity];
$DentistPhone=$_POST[DentistPhone];


$HospitalPreference=$_POST[HospitalPreference];
$SpecialMedicalConditions=$_POST[SpecialMedicalConditions];
$InsuranceName=$_POST[InsuranceName];
$InsurancePolicyNumber=$_POST[InsurancePolicyNumber];
$SignatureDate=date("Y/m/d");
$EmergencyYes = "Yes";

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
$dob=$_POST[dob];
//if (isset($dob) && strlen($dob) == 10) {
//   list($mm,$dd,$yyyy) = explode("/",$dob);
//   $dob=$yyyy."-".$mm."-".$dd;
//}
if ( $_POST[whose]=="student" ) {
 if ( isset($dob) ) {
  if ( strlen($dob) == 10) {
   //list($mm,$dd,$yyyy) = explode("/",$dob);
  // $dob=$yyyy."-".$mm."-".$dd;
  list($yyyy,$mm,$dd) = explode("-",$dob);

   // Convert dates to Julian Days
   $start_date = gregoriantojd($mm, $dd, $yyyy);
   $end_date = gregoriantojd(12, 31, ($CurrentYear - 6));

   // Return difference
   $age = round(($end_date - $start_date), 0);
   if ( $age < 0 ) {
     echo "Sorry! Your child is too young for school this year. Must be born on or before December 31, ". ($CurrentYear - 6). " to qualify. Please come back next year.";
     mysqli_close($conn);
     exit;
   }

  } else {
   echo "ERROR: please enter a valid Date of Birth (DOB) in the format of mm/dd/yyyy";
   mysqli_close($conn);
   exit;
  }
 } else {
   echo "ERROR: please enter a valid Date of Birth (DOB) in the format of mm/dd/yyyy";
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



 $SQLstring = "update tblMember set  FirstContactName='". $FirstContactName . "', FirstContactRelation='". $FirstContactRelation
           . "', FirstContactPhone='". $FirstContactPhone
           . "', SecondContactName='". $SecondContactName . "', SecondContactRelation='". $SecondContactRelation
           . "', SecondContactPhone='". $SecondContactPhone 
           . "', HospitalPreference='". $HospitalPreference . "', SpecialMedicalConditions='". $SpecialMedicalConditions
           . "', InsuranceName='". $InsuranceName . "', InsurancePolicyNumber='". $InsurancePolicyNumber
           . "', SignatureDate='". $SignatureDate 
           . "', DoctorName='". $DoctorName . "', DoctorCity='". $DoctorCity
           . "', DoctorPhone='". $DoctorPhone
           . "', EmergencyFilled='". $EmergencyYes 
           . "', DentistName='". $DentistName . "', DentistCity='". $DentistCity
           . "', DentistPhone='". $DentistPhone; 

 if ( strlen($dob) == 10 ) {
   $SQLstring .=  "', DateOfBirth='". $dob;
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



if ( $_POST[whose]=="student1" ) {
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
echo "Profile updated successfully, click here to <a href=\"FamilyChildList.php\">continue</a>";
echo "</center>";

}

mysqli_close($conn);

?>
