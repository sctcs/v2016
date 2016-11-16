<?php

 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start(); 
if(isset($_SESSION['family_id']))  
{  }
else 
{header( 'Location: ../main.php' ) ;
 exit();
}
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


$family_id=$_SESSION['family_id'];
$family_id=str_replace("'", "''",$family_id);
$family_id=str_replace("\n", " ",$family_id);
$family_id=trim($family_id);




//echo "<br>family_id:  ".$family_id;


$cn_name=$_POST[StudentChineseName];
$FirstName=$_POST[StudentFristName];
$LastName=$_POST[StudentLastName];
$gender=$_POST[studentGender];
$DateOfBirth=$_POST[DateOfBirth];

$student_id=$_POST[StudentID];
$ClassidFlag=$_POST[ClassidFlag];

if ($ClassidFlag=="0")
{
	
	$StudentType=$_POST[studentType];
$ClassLastYear=$_POST[ReturnStudentLevel];
$StartingLevel=$_POST[NewStudentLevel];
$Art_Class=$_POST[ArtClasslevel];
//echo "<br>  update with class info";
}
/*else
{
echo "<br> can not update class info";

}
*/

////////  update a record in Student table ////////////////////


$SQLstring = "update tblMember set ChineseName='". $cn_name ."', FirstName='". $FirstName ."', LastName='". $LastName  ."', Gender='". $gender ."', DateOfBirth='". $DateOfBirth ."', MostRecentUpdateDate='". date("Y/m/d") ."' where MemberID=".$student_id;






//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

//mysqli_query($conn,$SQLstring);




////  create session variable family_id //////////////
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
// store session data
$_SESSION['family_id']=$family_id;

//echo "view seesion: ".$_SESSION['family_id'];
//header( 'Location: MemberRegSummary.php' ) ;
header( 'Location: FamilyChildList.php' ) ;


mysqli_close($conn);

?>
