<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();


include("../common/DB/DataStore.php");


$membertypeid=$_POST[MemberTypeID];
$ParentPC=$_POST[ParentPC]; // value=primary
$ParentSP=$_POST[ParentSP]; // value=both
//$Students=$_POST[Students]; // value=student
$Teachers=$_POST[Teachers]; // value=teachers
$Admins=$_POST[Admins];     // value=admins
$Alumni=$_POST[Alumni];     // value=alumni
$Subject=$_POST[Subject];
$Message=$_POST[Message];
$Preview=$_POST[Preview];
$Send=$_POST[Send];
$From=$_POST[From];

?>
<!DOCTYPE html>
<html>

<head>
<title>Send Email</title>
<meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>

<script>
function goBack() {
    window.history.back()
}
</script>
</head>
<?php 
  echo "<a href=\"MemberAccountMain.php\">My Account</a>";
if (isset($Preview)) 
{
echo $membertypeid."<BR>";
echo $From."<BR>";
echo $ParentPC."<BR>";
echo $ParentSP."<BR>";
//echo $Students."<BR>";
echo $Teachers."<BR>";
echo $Admins."<BR>";
echo $Alumni."<BR>";
echo $Subject."<BR>";
echo $Message ."<BR>";
echo $Preview ."<BR>";
echo $Send ."<BR>";
echo "<BR>";
}

$SQLstring="";
if ( !isset($Alumni) && ( $ParentPC == "primary" || $ParentSP == "both" ))
{
$SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
WHERE Email is not null ";
  $SQLstring .= " and tblMember.FamilyID  in (select a.FamilyID from tblMember a, tblClassRegistration b ,tblClass c
                  where a.MemberID=b.StudentMemberID and b.ClassID=c.ClassID and c.CurrentClass='Yes' and b.Status='OK' )";

  if ( $ParentPC == "primary" && $ParentSP != "both" ) {
      $SQLstring .=" and tblMember.PrimaryContact='Yes' ";
  }
}

if (isset($Alumni))
{
$SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
WHERE Email is not null ";
}

if ($SQLstring != "" )
{
if (isset($Preview)) 
{
   echo "Parents: <BR>";
}
//echo $SQLstring;
echo "<BR>";
$RS1=mysqli_query($conn,$SQLstring);
while ($row=mysqli_fetch_array($RS1) ) {
  $emails[$row[Email]]=1;
if (isset($Preview)) 
{
  echo $row[Email];
  echo "<BR>";
}
}
}


$SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
WHERE Email is not null ";
if ( $Teachers == "teachers" )
{
  $SQLstring .= " and tblMember.MemberID in (select distinct MemberID from tblTeacher where CurrentTeacher='Yes')";

if (isset($Preview)) 
{
echo "<BR><BR>Teachers:<BR>";
}
//echo $SQLstring;
echo "<BR>";
$RS1=mysqli_query($conn,$SQLstring);
while ($row=mysqli_fetch_array($RS1) ) {
  $emails[$row[Email]]=1;
if (isset($Preview)) 
{
  echo $row[Email];
  echo "<BR>";
}
}
}

if ( $Admins == "admins" )
{
  $emails["adminteam@ynhchineseschool.org"]=1;
if (isset($Preview)) 
{
  echo "<BR><BR>Admins:<BR>";
  echo "adminteam@ynhchineseschool.org";
  echo "<BR>";
}
}

if ( isset($emails))
{
   echo "<BR>";
//foreach(array_keys($emails) as $email)
//{
//   echo $email;
//   echo "<BR>";
//}
} else {
   echo "No email address found";
   echo "<BR>";
   echo "<BR>";
}


if (isset($Send) && isset($emails))
{
  echo "Sending ......<BR>";
  foreach(array_keys($emails) as $email)
  {
     echo $email . "<BR>";
     $to      = $email;
     $headers = 'From: '. $_SESSION['firstname'] .' '.$_SESSION['lastname'] .'<'.$From . ">\r\n" .
		'Reply-To: ' . $From                     . "\r\n" .
		'X-Mailer: PHP/' . phpversion();

     mail($to, $Subject, $Message, $headers);

     sleep(2);
  } 
  echo "Done.<BR>";
} else {
 if (isset($Preview)) {
?>
<button onclick="goBack()">Go Back & Edit</button>
<?php
}
}

mysqli_close($conn);

?>
</body>
</html>
