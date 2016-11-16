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


$family_id=$_POST[family_id];
$family_id=str_replace("'", "''",$family_id);
$family_id=str_replace("\n", " ",$family_id);
$family_id=trim($family_id);




//echo "<br>family_id:  ".$family_id;


$cn_name=$_POST[StudentChineseName];
$FirstName=$_POST[StudentFristName];
$LastName=$_POST[StudentLastName];
$gender=$_POST[studentGender];
$StudentType=$_POST[studentType];
$ClassLastYear=$_POST[ReturnStudentLevel];
$StartingLevel=$_POST[NewStudentLevel];
$DateOfBirth=$_POST[DateOfBirth];

$Art_Class=$_POST[ArtClasslevel];

////////  insert a record in tblMember table ////////////////////

$SQLstring = "INSERT INTO tblMember (FamilyID, ChineseName,FirstName,LastName,gender,DateOfBirth,MostRecentUpdateDate  ) VALUES (". $family_id .", '". $cn_name ."','". $FirstName ."','". $LastName ."','". $gender ."', '". $DateOfBirth."','". date("Y/m/d") ."' ) ";

//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }
 


//// get student id   ////////////////
$student_id=mysqli_insert_id($conn);

//echo "<br>Member id:  ".$student_id;

////////  insert a record in tblLogin table ////////////////////
$SQLstring = "INSERT INTO tblLogin (MemberID,MemberTypeID)  VALUES (".$student_id.", 5)"; 

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }


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
