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
if ( $_POST[dir] == "no dir" ) {
   $dir="No";
} else {
   $dir="Yes";
}

if ( $_POST[pic] == "no pic" ) {
   $pic="No";
} else {
   $pic="Yes";
}

$ethnicity=$_POST[ethnicity];

$yob=$_POST[yob];
$dobbs=$_POST[dobbs];

if ( $_POST[password1] != "") {
 if (  $_POST[password1] == $_POST[password2] ) {
  $pw = $_POST[password1];
 } else {
  die ("New Passwords do not match, try again");
 }
}

//echo "<br>address:  ".$address;
echo "<center>";
//$MemberRegistrationDate=date("j, n, Y");
//$MemberUpdateDate=date("Y/m/d");

if ( isset($_POST[newmember]) ) {
 // 1. check and see if there is a record for the new member
 $sql = "select count(*) as count from tblMember where  FirstName='". $PrimaryCP_FirstName ."' and LastName='". $PrimaryCP_LastName."'";
 $rs=mysqli_query($conn, $sql);
 $row=mysqli_fetch_array($rs);
 if ( $row[count] > 0 ) {
   echo "ERROR: A record that matches your name ($PrimaryCP_FirstName $PrimaryCP_LastName) is found to be in the system already, please use <a href=\"retrieveLoginID.php\">retrieve login function</a> to retrieve your existing login or contact school tech support for help. Thanks.";
   exit;
 }

 // 2. decide login or UserName for new member
 $fni=strtolower($PrimaryCP_FirstName);
 $lni=strtolower($PrimaryCP_LastName);
 $ni=$fni[0] . $lni[0];
 if ( strlen($ni) <= 0 ) {
   echo "ERROR: name initial not built";
   exit;
 }
 $sql="SELECT max( SUBSTRING(UserName FROM 3)) as curr_login_no FROM `tblMember` WHERE UserName like '".$ni."20%'";
 $rs=mysqli_query($conn, $sql);
 $row=mysqli_fetch_array($rs);
 if ( isset($row[curr_login_no]) && $row[curr_login_no] != null ) {
   $login_no=$row[curr_login_no] + 1;
 } else {
   $login_no="2000";
 }

 $login=$ni.$login_no;
 if ( !isset($pw) || $pw == "" ) {
   $pw="scsu";
 }

 //////// 2. insert a record in member table ///////////////
if ( $_POST[newmembertype]=="student"  ) {
 $SQLstring ="INSERT INTO tblMember (FamilyID,HomePhone,FirstName,LastName,ChineseName,Email,UserName,Password,Profession,CellPhone,HomeAddress,HomeCity,HomeState, HomeZip,"
            ."Gender,DOBYear,DOBBeforeSept,Ethnicity,PrimaryContact,SecondEmail,OfficePhone,Organization,Hobbies,Directory,Picture,MostRecentUpdateDate) VALUES ("
            ."'". $_SESSION['family_id'] ."','". $home_phone ."','". $PrimaryCP_FirstName ."','". $PrimaryCP_LastName ."','". $PrimaryCP_ChineseName ."','". $PrimaryCP_email
            ."','". $login ."','". $pw ."','". $SecondaryCP_Profession ."','". $cell_phone ."','". $address ."','". $city ."','". $state ."','". $zip ."','". $gender  ."','". $yob ."','".$dobbs ."','". $ethnicity
            ."','". $PrimaryContact ."','". $secondemail ."','". $office_phone ."','". $org ."','". $hobbies  ."','". $dir  ."','". $pic  ."',". "date(now()) ) ";

} else if ( $_POST[newmembertype]=="spouse" ) {
 $SQLstring ="INSERT INTO tblMember (FamilyID,HomePhone,FirstName,LastName,ChineseName,Email,UserName,Password,Profession,CellPhone,HomeAddress,HomeCity,HomeState, HomeZip,"
            ."Gender,PrimaryContact,SecondEmail,OfficePhone,Organization,Hobbies,Directory,Picture,MostRecentUpdateDate) VALUES ("
            ."'". $_SESSION['family_id'] ."','". $home_phone ."','". $PrimaryCP_FirstName ."','". $PrimaryCP_LastName ."','". $PrimaryCP_ChineseName ."','". $PrimaryCP_email
            ."','". $login ."','". $pw ."','". $SecondaryCP_Profession ."','". $cell_phone ."','". $address ."','". $city ."','". $state ."','". $zip ."','". $gender
            ."','". $PrimaryContact ."','". $secondemail ."','". $office_phone ."','". $org ."','". $hobbies  ."','". $dir  ."','". $pic  ."',". "date(now()) ) ";

} else {
 $SQLstring ="INSERT INTO tblMember (HomePhone,FirstName,LastName,ChineseName,Email,UserName,Password,Profession,CellPhone,HomeAddress,HomeCity,HomeState, HomeZip,"
            ."Gender,PrimaryContact,SecondEmail,OfficePhone,Organization,Hobbies,Directory,Picture, MostRecentUpdateDate) VALUES ("
            ."'". $home_phone ."','". $PrimaryCP_FirstName ."','". $PrimaryCP_LastName ."','". $PrimaryCP_ChineseName ."','". $PrimaryCP_email ."','". $login ."','". $pw
            ."','". $SecondaryCP_Profession ."','". $cell_phone ."','". $address ."','". $city ."','". $state ."','". $zip ."','". $gender ."','". $PrimaryContact
            ."','". $secondemail ."','". $office_phone ."','". $org ."','". $hobbies  ."','". $dir  ."','". $pic  ."',". "date(now()) ) ";
}
 //echo "<br>SQLstring:  ".$SQLstring;
 //mysqli_query($conn,$SQLstring);
} else {
 ////////  update a record in member table ////////////////////



 $SQLstring = "update tblMember set HomePhone='". $home_phone ."', FirstName='". $PrimaryCP_FirstName ."', LastName='". $PrimaryCP_LastName
           . "', ChineseName='". $PrimaryCP_ChineseName ."', Email='". $PrimaryCP_email  ."', Profession='". $PrimaryCP_Profession  ."', CellPhone='". $cell_phone ."', HomeAddress='". $address
           . "', HomeCity='". $city . "', HomeState='". $state  ."', HomeZip='". $zip  ."', MostRecentUpdateDate='". $MemberUpdateDate
           . "', Gender='". $gender
           . "', PrimaryContact='". $PrimaryContact
           . "', SecondEmail='". $secondemail
           . "', OfficePhone='". $office_phone
           . "', Organization='". $org
           . "', Hobbies='". $hobbies
           . "', Directory='". $dir;
 if ( $pw != "" ) {
   $SQLstring .=  "', Password='". $pw;
 }
 $SQLstring .= "'  where MemberID=".$_SESSION['memberid'];
}

//echo "<br>SQLstring:  ".$SQLstring;

if (!mysqli_query($conn, $SQLstring))
  {
  die('Error: ' . mysqli_error($conn));
  }

//mysqli_query($conn,$SQLstring);


if ( isset($_POST[newmember]) && $PrimaryContact == "Yes" ) {
  $sql="update tblMember set FamilyID=MemberID where UserName='".$login."'";
  mysqli_query($conn, $sql);
}

// create membertype record in tblLogin
$sql="select MemberID from tblMember where UserName='".$login."'";

$rs=mysqli_query($conn, $sql);
$row=mysqli_fetch_array($rs);
if ( isset($row[MemberID]) && $row[MemberID] > 0 ) {
   $newmembid=$row[MemberID];
   if ( $_POST[newmembertype]=="student" ) {
     $newmembtypeid=5; // student
       $sql="insert into tblStudent (MemberID, FirstRegistrationDate,StartingLevel,PrimaryHomeLanguage,NumChSpeakParents,StudentType,StudentStatus,PreferredClassLevel,PreferredExtraClass1,PreferredExtraClass2) "
	      ." values (".$newmembid.", date(now()),'".$_POST[StartingLevel]."','".$_POST[PrimaryHomeLanguage]."', '".$_POST[NumChSpeakParents]."', '2','1','".$_POST[PreferredClassLevel]."','".$_POST[PreferredExtraClass1]."','".$_POST[PreferredExtraClass2]."')";
      // echo $sql;
	   if (!mysqli_query($conn, $sql))
       {
         die('Error: ' . mysqli_error($conn));
       }


   //} else if ( $PrimaryContact == "Yes" || $_POST[newmembertype]=="spouse" ) {
   } else if (  $_POST[newmembertype]=="spouse" ) {
     $newmembtypeid=15; //parent
   } else {
     $newmembtypeid=14; //new member
   }
   $sql="insert into tblLogin (MemberID, MemberTypeID) values ($newmembid, $newmembtypeid)";
   mysqli_query($conn, $sql);
}

//echo "<center>";

if ( isset($_POST[newmember]) && $newmembtypeid == 14 ) {
echo " Welcome, $PrimaryCP_FirstName $PrimaryCP_LastName;";
echo "<br><br>Your new login is: $login";
echo "<br><br>and password is: $pw";
echo "<br><br>Your membership application will be processed as soon as possible, check your email within the following 1-2 days. <BR>You will be able to login when it is approved. <a href=\"MemberAccountMain.php\">continue</a>";
//echo "<br><br>Now you can <a href=\"MemberLoginForm.php\">login</a>";

// main tech support for new membership processing
$message .="\nNew Member ID: ". $newmembid ."\nFirstName: ".$PrimaryCP_FirstName."\nLast Name: ".$PrimaryCP_LastName
           . "\n ChineseName: ". $PrimaryCP_ChineseName ."\n Email: ". $PrimaryCP_email ."\n HomePhone: ". $home_phone ."\n CellPhone: ". $cell_phone ."\n HomeAddress: ". $address
           . "\n HomeCity: ". $city . "\n HomeState: ". $state  ."\n HomeZip: ". $zip  ."\n";
							 $to      = "support@ynhchineseschool.org";
							 $subject = 'New ' . $SCHOOLNAME_ABR . ' Member ('.$newmembid.') Registration received';

							 $headers = 'From: support@ynhchineseschool.org' . "\r\n" .
							     'Reply-To: support@ynhchineseschool.org' . "\r\n" .
							     'X-Mailer: PHP/' . phpversion();
//echo $message;
//echo $to;
//echo $subject;
//echo $headers;
     if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
							 mail($to, $subject, $message, $headers);
     }
} else {
echo " Profile for $PrimaryCP_FirstName $PrimaryCP_LastName has been created,";
echo "<br>the new login ID is: $login";
echo "<br>and password is: $pw";
echo "<br><br>please write them down.";

  if ( $_POST[newmembertype]=="student" ) {
    echo "<br><br>You can now <a href=\"studentRegisterClass.php?stuid=". $newmembid. "\">register classes</a>";
  } else {
    echo "<br><br>Click <a href=\"MemberAccountMain.php\">here</a> to continue";
  }
}

//header( 'Location: MemberAccountMain.php' ) ;

echo "</center>";
mysqli_close($conn);


?>
