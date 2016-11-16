<?php
session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
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
// 3. create necessary session
// 4. redirect page to new location
///////////////////////////////////////////


////////  1. load all variables/////////////////////

$TeacherMemberID=$_POST[MemberID];
$GradeOrSubject=$_POST[GradeOrSubject];
$ClassNumber=$_POST[ClassNumber];
$Classroom=$_POST[Classroom];
$ClassFee=$_POST[ClassFee];
$CurrentClass=$_POST[CurrentClass]; // we don't update current class here. Only default value "Yes" from the database is allowed
$Year=$_POST[Year];
$Term=$_POST[Term];
$Period=$_POST[Period];
$Seats=$_POST[Seats];
$IsLanguage=$_POST[IsLanguage];

////////  insert a record in tblMember table ////////////////////

$SQLstring = "INSERT INTO tblClass (TeacherMemberID,GradeOrSubject,ClassNumber,Classroom,ClassFee,Year,Term,Period,Seats,IsLanguage) VALUES ('". $TeacherMemberID ."','". $GradeOrSubject ."','". $ClassNumber ."','". $Classroom ."', '". $ClassFee."', '". $Year."', '". $Term."', '". $Period."' , '". $Seats."', '". $IsLanguage."'  ) ";

//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }
 
////  create session variable classid //////////////
 session_save_path("c:/WebServer/Apache2/htdocs/phpsessions");
session_start();
// store session data
$_SESSION['Classid']=$classid;

header( 'Location: ClassList.php' ) ;

mysqli_close($conn);

?>
