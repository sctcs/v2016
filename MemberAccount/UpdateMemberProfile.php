<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if (!isset($_SESSION['logon']) || $seclvl > 25 && $seclvl != 40) 
 {  
    echo ("You cannot update member") ;
    exit();
 }


$mid = $_POST["mid"];
//echo "member id: ". $mid;

if(!isset($mid) || $mid =="")
{
 header( 'Location: MemberAccountMain.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

////////////////////////////////////////////
// 1. get all variables
// 2. insert into DB
// 3. redirect page to new location
///////////////////////////////////////////


////////  1. load all variables/////////////////////


$FirstName=$_POST[PCFristName];
$FirstName=str_replace("'", "''",$FirstName);
$FirstName=str_replace("\n", " ",$FirstName);
$FirstName=trim($FirstName);

$LastName=trim($_POST[PCLastName]);
//$LoginPW=$_POST[PW];
$ChineseName=$_POST[PCChineseName];

$email=$_POST[PCEmail];
$email=str_replace("'", "''",$email);
$email=str_replace("\n", " ",$email);
$email=trim($email);

$secondemail=$_POST[SCEmail];

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

//echo "<br>address:  ".$address;

//$MemberRegistrationDate=date("j, n, Y");
$MemberUpdateDate=date("Y/m/d");


 ////////  update a record in member table ////////////////////



 $SQLstring = "update tblMember set ChineseName='". $ChineseName. "', Gender='". $gender
           . "', HomePhone='". $home_phone ."', Email='". $email  . "', CellPhone='". $cell_phone ."', HomeAddress='". $address
           . "', HomeCity='". $city . "', HomeState='". $state  ."', HomeZip='". $zip  ."', MostRecentUpdateDate='". $MemberUpdateDate
           . "', PrimaryContact='". $PrimaryContact
           . "', SecondEmail='". $secondemail
           . "', OfficePhone='". $office_phone ;
 
 $SQLstring .= "'  where MemberID=".$mid;


//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }
?>
<div class="container" style="background: #D9D9D9; height: 300px; width: 400px;">
    <h3>Profile Updated Successfully</h3>
    <p class="text-center lead"><a href="MemberLookupByID.php?memid=<?php echo $mid ;?>">View Member Detail</a><p>
    <p class="text-center lead"> <a href="MemberAccountMain.php">Go To Main Account</a></p>
</div>
<?php
mysqli_close($conn);

?>
