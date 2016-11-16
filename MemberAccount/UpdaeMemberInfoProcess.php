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


$PrimaryCP_FirstName=$_POST[PCFristName];
$PrimaryCP_FirstName=str_replace("'", "''",$PrimaryCP_FirstName);
$PrimaryCP_FirstName=str_replace("\n", " ",$PrimaryCP_FirstName);
$PrimaryCP_FirstName=trim($PrimaryCP_FirstName);

$PrimaryCP_LastName=$_POST[PCLastName];
//$LoginPW=$_POST[PW];

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


$address=$_POST[Address];
$city=$_POST[city];
$zip=$_POST[zip];

//echo "<br>address:  ".$address;


//$MemberRegistrationDate=date("j, n, Y");
$MemberUpdateDate=date("Y/m/d");

//////// 2. insert a record in family table ///////////////

$SQLstring ="INSERT INTO family (MemberType,home_phone,PrimaryCP_FirstName,PrimaryCP_LastName,PrimaryCP_email,LoginPW,PrimaryCP_Profession,SecondaryCP_FirstName,SecondaryCP_LastName,SecondaryCP_email,SecondaryCP_Profession,cell_phone,address,city,zip,disclaimer,is_dir_ok,is_image_ok,volunteer,volunteer_other,MemberRegistrationDate) VALUES (".$MemberType.",'". $home_phone ."','". $PrimaryCP_FirstName ."','". $PrimaryCP_LastName ."','". $PrimaryCP_email ."','". $LoginPW ."','". $PrimaryCP_Profession ."','". $SecondaryCP_FirstName ."','". $SecondaryCP_LastName ."','".  $SecondaryCP_email."','". $SecondaryCP_Profession ."','". $cell_phone ."','". $address ."','". $city ."','". $zip ."',". $disclaimer .",". $is_dir_ok .",". $is_image_ok .",". $volunteer .",'". $volunteer_other  ."','". $MemberRegistrationDate ."') ";

//echo "<br>SQLstring:  ".$SQLstring;
//mysqli_query($conn,$SQLstring);

////////  update a record in family table ////////////////////

$SQLstring = "update family set home_phone='". $home_phone ."', PrimaryCP_FirstName='". $PrimaryCP_FirstName ."', PrimaryCP_LastName='". $PrimaryCP_LastName  ."', PrimaryCP_email='". $PrimaryCP_email  ."', PrimaryCP_Profession='". $PrimaryCP_Profession  ."', SecondaryCP_FirstName='". $SecondaryCP_FirstName  ."', SecondaryCP_LastName='". $SecondaryCP_LastName  ."', SecondaryCP_email='". $SecondaryCP_email  ."', SecondaryCP_Profession='". $SecondaryCP_Profession ."', cell_phone='". $cell_phone ."', address='". $address  ."', city='". $city  ."', zip='". $zip  ."', MostRecentUpdateDate='". $MemberUpdateDate  ."'  where family_id=".$_SESSION['family_id'];

$SQLstring = "update tblMember set HomePhone='". $home_phone ."', FirstName='". $PrimaryCP_FirstName ."', LastName='". $PrimaryCP_LastName  ."', Email='". $PrimaryCP_email  ."', Profession='". $PrimaryCP_Profession  ."', CellPhone='". $cell_phone ."', address='". $address  ."', city='". $city  ."', zip='". $zip  ."', MostRecentUpdateDate='". $MemberUpdateDate  ."'  where MemberID=".$_SESSION['memberid'];


echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn,$SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

//mysqli_query($conn,$SQLstring);

/////// 3. Sending Registration email ///////////////
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

//$to = $PrimaryCP_email;
$to ="yhuo@hotmail.com"
//$bcc="junqi_ding@yahoo.com;ling.mu@yale.edu";
$subject = "Registration confirmation from Yale-New-Haven Community Chinese School:".$StudentName;
$from = "registration@ynhchineseschool.org";
//$headers = "From: ".$from."\n Bcc: ".$bcc."\n";
$headers = "From: $from\r\n"."Bcc: $bcc\r\n";
//$headers = "From: $from"; 
//$headers = "Bcc: $bcc";
mail($to,$subject,$message,$headers);



////  create session variable family_id //////////////
//// session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
 // session_start();
// store session data
//$_SESSION['family_id']=$family_id;

//echo "view seesion: ".$_SESSION['family_id'];
//header( 'Location: MemberRegSummary.php' ) ;
//header( 'Location: FmailyProfile.php' ) ;


mysqli_close($conn);

?>
