<?php
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


$PrimaryCP_email=$_POST[PCEmail];
$PrimaryCP_email=str_replace("'", "''",$PrimaryCP_email);
$PrimaryCP_email=str_replace("\n", " ",$PrimaryCP_email);
$PrimaryCP_email=trim($PrimaryCP_email);

if ($PrimaryCP_email=="")
{header( 'Location: ../main.php' ) ;
 exit();
 }

$SQLstring = "select count(*) as C from family where FamilyAcctStatus=1 and PrimaryCP_email='".$PrimaryCP_email."' ";
///echo "see: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
$Match=mysqli_fetch_array($RS1);

////  if email has been used then return back to the previous page
if ($Match[C]>0)
	{	header( 'Location: MemberRegistration.php?error=1' ) ;
		exit();
	}


//echo "<br>number find: ". $Match[C];
//echo "<br>size array: ".mysqli_fetch_array($RS1);

$MemberType=10;
$PrimaryCP_FirstName=$_POST[PCFristName];
$PrimaryCP_FirstName=str_replace("'", "''",$PrimaryCP_FirstName);
$PrimaryCP_FirstName=str_replace("\n", " ",$PrimaryCP_FirstName);
$PrimaryCP_FirstName=trim($PrimaryCP_FirstName);

$PrimaryCP_LastName=$_POST[PCLastName];
$LoginPW=$_POST[PW];
$PrimaryCP_Profession=$_POST[PCProfession];
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


$address=$_POST[Address];
$city=$_POST[city];
$zip=$_POST[zip];

if ($_POST[agreement]=="on" )
	{ $disclaimer=1;}
else
	{ $disclaimer=0;}

$is_dir_ok=$_POST[agreemyinfo];
$is_image_ok=$_POST[studentphoto];
$volunteer=$_POST[volunteer];
$volunteer_other=$_POST[VolunterrOther];
$comments;
//$MemberRegistrationDate=date("j, n, Y");
$MemberRegistrationDate=date("Y/m/d");

//////// 2. insert a record in family table ///////////////

$SQLstring ="INSERT INTO family (MemberType,home_phone,PrimaryCP_FirstName,PrimaryCP_LastName,PrimaryCP_email,LoginPW,PrimaryCP_Profession,SecondaryCP_FirstName,SecondaryCP_LastName,SecondaryCP_email,SecondaryCP_Profession,cell_phone,address,city,zip,disclaimer,is_dir_ok,is_image_ok,volunteer,volunteer_other,MemberRegistrationDate) VALUES (".$MemberType.",'". $home_phone ."','". $PrimaryCP_FirstName ."','". $PrimaryCP_LastName ."','". $PrimaryCP_email ."','". $LoginPW ."','". $PrimaryCP_Profession ."','". $SecondaryCP_FirstName ."','". $SecondaryCP_LastName ."','".  $SecondaryCP_email."','". $SecondaryCP_Profession ."','". $cell_phone ."','". $address ."','". $city ."','". $zip ."',". $disclaimer .",". $is_dir_ok .",". $is_image_ok .",". $volunteer .",'". $volunteer_other  ."','". $MemberRegistrationDate ."') ";

//echo "<br>SQLstring:  ".$SQLstring;
mysqli_query($conn,$SQLstring);
/////////// get family id  /////////////////
$family_id=mysqli_insert_id($conn);
//echo "<br>insert id: ".mysqli_insert_id($conn);

/////////// get family id  /////////////////
/*$SQLstring = "select family_id  from family where PrimaryCP_email='".$PrimaryCP_email."' ";
///echo "see: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
$RSA1=mysqli_fetch_array($RS1);
$family_id=$RSA1[family_id];
*/

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
$SQLstring = "INSERT INTO student (family_id, cn_name,FirstName,LastName,gender,StudentType,ClassLastYear,StartingLevel,DateOfBirth,Art_Class,FirstRegistrationDate ) VALUES (". $family_id .", '". $cn_name ."','". $FirstName ."','". $LastName ."','". $gender ."',". $StudentType .",". $ClassLastYear .",". $StartingLevel .",'". $DateOfBirth ."','". $Art_Class ."','". date("Y/m/d") ."' ) ";

//echo "<br>SQLstring:  ".$SQLstring;
mysqli_query($conn,$SQLstring);




//if (!mysql_query($sql,$con))
/*$SQLstring = "INSERT INTO test1 (FirstName, LastName) VALUES ('$_POST[firstname]', '$_POST[lastname]')";
if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

mysqli_close($conn);
*/

//////// 3. Sending Registration email ///////////////
$PrimayContactPersonalName=$PrimaryCP_FirstName." ".$PrimaryCP_LastName;
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
$message=$message."Since you registered after our deadline, there will be an additional $2.00 charge to your account. You will receive an e-mail about the class assignment. If you did not receive such e-mail before the school starts, please visit the www.ynhchineseschool.org.\n\n";
$message=$message."**********  Please do not reply this email   \n\n\n\n";
$message=$message."Best wishes,\n\n";
$message=$message."Yale-New-Haven Community Chinese School at SCSU";

$to = $PrimaryCP_email;
//$bcc="yhuo@hotmail.com;junqi_ding@yahoo.com;ling.mu@yale.edu";
$bcc="junqi_ding@yahoo.com;ling.mu@yale.edu";
$subject = "Registration confirmation from Yale-New-Haven Community Chinese School:".$StudentName;
$from = "registration@ynhchineseschool.org";
//$headers = "From: ".$from."\n Bcc: ".$bcc."\n";
$headers = "From: $from\r\n"."Bcc: $bcc\r\n";
//$headers = "Bcc: $bcc";
mail($to,$subject,$message,$headers);
//echo "header: ".$headers;



//// 4. create session variable family_id //////////////
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
// store session data
$_SESSION['family_id']=$family_id;
$_SESSION['logon']=1;
$_SESSION['MemberType']=$MemberType;


//echo "view seesion: ".$_SESSION['family_id'];
//header( 'Location: MemberRegSummary.php' ) ;
header( 'Location: AddMoreStudent.php' ) ;


mysqli_close($conn);

?>
