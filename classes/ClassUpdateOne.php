<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
 exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] >= 25)
//{
 //echo ( 'you need to log in as a school admin' ) ;
// exit();
//}

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

////////////////////////////////////////////
// 1. get all variables
// 2. insert into DB
// 3. Send email out
// 4. create necessary session
// 5. redirect page to new location
///////////////////////////////////////////


////////  1. load all variables/////////////////////

$TeacherMemberID =$_POST[MemberID];
$ClassCode=$_POST[ClassCode];
$GradeOrSubject=$_POST[GradeOrSubject];
$ClassNumber=$_POST[ClassNumber];
$Classroom=$_POST[Classroom];
$ClassFee=$_POST[ClassFee];
$CurrentClass=$_POST[CurrentClass];
$Year=$_POST[Year];
$Term=$_POST[Term];
$Period=$_POST[Period];
$Seats=$_POST[Seats];
$IsLanguage=$_POST[IsLanguage];
$ClassID=$_POST[ClassID];
$Description=$_POST[Description];
#echo $Description;

////////  update a record in Class table ////////////////////
// We do not allow to update Current Class stands here.

$SQLstring = "update tblClass set TeacherMemberID='". $TeacherMemberID ."', ClassCode='".$ClassCode."', GradeOrSubject='". $GradeOrSubject ."', ClassNumber='". $ClassNumber ."', Classroom='". $Classroom ."', Year='". $Year ."', Term='". $Term ."', Period='". $Period ."', Seats='". $Seats ."', ClassFee ='". $ClassFee ."', CurrentClass='".$CurrentClass."',IsLanguage='".$IsLanguage."', Description='".$Description."'  where ClassID=".$ClassID;


//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

//mysqli_query($conn,$SQLstring);


////  create session variable classid //////////////
//session_save_path("c:/WebServer/Apache2/htdocs/phpsessions");
//session_start();
// store session data
$_SESSION['ClassID']=$ClassID;

//header( 'Location: ClassList.php' ) ;
echo "<a href=\"ClassList.php\">Continue</a>";

mysqli_close($conn);

?>
