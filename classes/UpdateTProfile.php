<?php

ini_set('display_errors', 1);
error_reporting (E_ALL);

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
 exit();
}

if(! isset($_SESSION['membertype']) ||  $_SESSION['membertype'] >= 25)
{
 echo ( 'you need to log in as a school admin' ) ;
 exit();
}


include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//Get variables

$PCChineseName = $_POST["PCChineseName"];
$PCEmail = $_POST["PCEmail"];
$PCEmail=str_replace("'", "''",$PCEmail);
$PCEmail=str_replace("\n", " ",$PCEmail);
$PCEmail=trim($PCEmail);

//Home phone
$area = $_POST["area"];
$prefix = $_POST["prefix"];
$suffix = $_POST["suffix"];
$home_phone = $area."-".$prefix."-".$suffix;

//Cell phone
$Carea = $_POST["Carea"];
$Cprefix = $_POST["Cprefix"];
$Csuffix = $_POST["Csuffix"];
$cell_phone = $Carea."-".$Cprefix."-".$Csuffix;

//Office phone
$Oarea = $_POST["Oarea"];
$Oprefix = $_POST["Oprefix"];
$Osuffix = $_POST["Osuffix"];
$office_phone = $Oarea."-".$Oprefix."-".$Osuffix;

//Address
$address = $_POST["Address"];
$city = $_POST["city"];
$state = $_POST["state"];
$zip = $_POST["zip"];
$mid = $_POST['updtmemberid'];

//Update teacher profile in tblMember
$SQLstring = "Update tblMember set ChineseName='".$PCChineseName."', Email = '".$PCEmail
            ."', HomePhone = '".$home_phone . "', CellPhone = '".$cell_phone 
            ."', OfficePhone = '".$office_phone 
            ."', HomeAddress = '". $address
            ."', HomeCity = '" . $city 
            . "', HomeState = '". $state 
            ."', HomeZip = '" . $zip 
            ."' WHERE MemberID =" .$mid;
    

if(!mysqli_query($conn, $SQLstring)) {
    die ('Error: '. mysqli_error($conn));
} 

echo "<div>";
echo "<p>Profile updated successfuly, <span><a href=\"TeacherList.php\">Continue</a></span></p>";
echo "</div>";

mysqli_close($conn);
?>