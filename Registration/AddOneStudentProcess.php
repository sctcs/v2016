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

////////  insert a record in Student table ////////////////////
$SQLstring = "INSERT INTO student (family_id, cn_name,FirstName,LastName,gender,StudentType,ClassLastYear,StartingLevel,DateOfBirth,Art_Class,FirstRegistrationDate  ) VALUES (". $family_id .", '". $cn_name ."','". $FirstName ."','". $LastName ."','". $gender ."',". $StudentType .",". $ClassLastYear .",". $StartingLevel .", '". $DateOfBirth."','". $Art_Class ."','". date("Y/m/d") ."' ) ";

//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }
 
//mysqli_query($conn,$SQLstring);

//// get student id   ////////////////
$student_id=mysqli_insert_id($conn);

//// get family information  /////////////
$SQLstring = "select student.family_id,family.PrimaryCP_LastName,family.PrimaryCP_FirstName,family.PrimaryCP_email
from student INNER JOIN family on student.family_id= family.family_id
where  student.student_id= ".$student_id;

$RS1=mysqli_query($conn,$SQLstring);
$RSA1=mysqli_fetch_array($RS1);
$family_id=$RSA1[family_id];



//////// 3. Sending Registration email ///////////////
$PrimayContactPersonalName=$RSA1[PrimaryCP_FirstName]." ".$RSA1[PrimaryCP_LastName];
$PrimaryCP_email=$RSA1[PrimaryCP_email];
$StudentName=$FirstName." ".$LastName;




$message = "Dear ". $PrimayContactPersonalName ." :\n\n";
$message =$message."You are successfully registered ". $StudentName ;

if ($StudentType==1)
{$message =$message." to the ".$StartingLevel." grade";}

$message =$message." at Yale-New-Haven Community Chinese School at SCSU";

if ($Art_Class !="0" )
{$message =$message." and Art course:  ".$Art_Class.". ";}
else
{$message =$message.". ";}

$message =$message." If the above information is not correct, please contact support@ynhchineseschool.org.\n\n";
$message=$message."You will receive an e-mail about the class assignment. If you did not receive such e-mail before the school starts, please visit the www.ynhchineseschool.org.\n\n";
$message=$message."**********  Please do not reply this email   \n\n\n\n";
$message=$message."Best wishes,\n\n";
$message=$message."Yale-New-Haven Community Chinese School at SCSU";

$to = $PrimaryCP_email;
$bcc="junqi_ding@yahoo.com;ling.mu@yale.edu";
$subject = "Registration confirmation from Yale-New-Haven Community Chinese School:".$StudentName;
$from = "registration@ynhchineseschool.org";
//$headers = "From: ".$from."\n Bcc: ".$bcc."\n";
$headers = "From: $from\r\n"."Bcc: $bcc\r\n";
//$headers = "From: $from"; 
//$headers = "Bcc: $bcc";
mail($to,$subject,$message,$headers);



//if (!mysql_query($sql,$con))
/*$SQLstring = "INSERT INTO test1 (FirstName, LastName) VALUES ('$_POST[firstname]', '$_POST[lastname]')";
if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

mysqli_close($conn);
*/

////  create session variable family_id //////////////
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
// store session data
$_SESSION['family_id']=$family_id;

//echo "view seesion: ".$_SESSION['family_id'];
//header( 'Location: MemberRegSummary.php' ) ;
header( 'Location: AddMoreStudent.php' ) ;


mysqli_close($conn);

?>
