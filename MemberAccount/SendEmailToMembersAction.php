<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();


include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

$DEBUG=0;

$membertypeid=$_POST[MemberTypeID];
$PCYear=$_POST[PCYear]; // value=primary
$ParentPC=$_POST[ParentPC]; // value=primary
$ParentSP=$_POST[ParentSP]; // value=both
//$Students=$_POST[Students]; // value=student
$Teachers=$_POST[Teachers]; // value=teachers
$Admins=$_POST[Admins];     // value=admins
$NewMembers=$_POST[NewMembers];     // value=newmembers
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
if (isset($Preview) || $DEBUG ) 
{
echo $membertypeid."<BR>";
echo $From."<BR>";
echo $ParentPC."<BR>";
echo $ParentSP."<BR>";
//echo $Students."<BR>";
echo $Teachers."<BR>";
echo $NewMembers."<BR>";
echo $Alumni."<BR>";
echo $Subject."<BR>";
echo $Message ."<BR>";
echo $Preview ."<BR>";
echo $Send ."<BR>";
echo "<BR>";
}

$SQLstring="";
if (  $ParentPC == "primary" || $ParentSP == "both" )
{
$SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
WHERE Email is not null ";
  $SQLstring .= " and tblMember.FamilyID  in (select a.FamilyID from tblMember a, tblClassRegistration b ,tblClass c
                  where a.MemberID=b.StudentMemberID and b.ClassID=c.ClassID ";
  if ( $PCYear =="C-year" ) 
  {
      $SQLstring .= "and c.CurrentClass='Yes' and b.Status='OK' )";
  } else if ( $PCYear =="L-year" )
  {
      $SQLstring .= "and c.CurrentClass!='Yes' and b.Status in ('Taken','OK') and ((c.Year='".$LastYear."' and c.Term='Fall') or (c.Year='".$CurrentYear."' and c.Term='Spring') )  )";
  } else if ( $PCYear =="2-year" )
  {
      $SQLstring .= "and c.CurrentClass!='Yes' and b.Status in ('Taken','OK') and ((c.Year='".$LastYear2."' and c.Term='Fall') or (c.Year='".$LastYear."' and c.Term='Spring') )  )";
  } else if ( $PCYear =="3-year" )
  {
      $SQLstring .= "and c.CurrentClass!='Yes' and b.Status in ('Taken','OK') and ((c.Year='".$LastYear3."' and c.Term='Fall') or (c.Year='".$LastYear2."' and c.Term='Spring') )  )";
  }

  if ( $ParentPC == "primary" && $ParentSP != "both" ) {
      $SQLstring .=" and tblMember.PrimaryContact='Yes' ";
  }
}

if ($SQLstring != "" )
{
 if (isset($Preview)) 
 {
   echo "Parents: <BR>";
 }
 if ($DEBUG) {echo $SQLstring;}
 echo "<BR>";
 $RS1=mysqli_query($conn,$SQLstring);
 while ($row=mysqli_fetch_array($RS1) ) 
 {
   $emails[$row[Email]]=1;
  if (isset($Preview)) 
  {
    echo $row[Email];
    echo "<BR>";
  }
 }
}

echo "<br>";
if ( isset($NewMembers) ) 
{
 $SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
 WHERE Email is not null and MostRecentUpdateDate >= '".$CurrentYear."-05-01'";
 if (isset($Preview)) 
 {
   echo "New Members: <BR>";
 }
 if ($DEBUG) {echo $SQLstring;}
 echo "<BR>";
 $RS1=mysqli_query($conn,$SQLstring);
 while ($row=mysqli_fetch_array($RS1) ) 
 {
   $emails[$row[Email]]=1;
  if (isset($Preview)) 
  {
    echo $row[Email];
    echo "<BR>";
  }
 }
}


echo "<br>";

if ( $Teachers == "teachers" )
{
 $SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
 WHERE Email is not null ";
  $SQLstring .= " and tblMember.MemberID in (select distinct MemberID from tblTeacher where CurrentTeacher='Yes')";

 if (isset($Preview)) 
 {
  echo "<BR><BR>Teachers:<BR>";
 }
 if ($DEBUG) {echo $SQLstring;}
 echo "<BR>";
 $RS1=mysqli_query($conn,$SQLstring);
 while ($row=mysqli_fetch_array($RS1) ) 
 {
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
 if (isset($Preview)) 
 {
  foreach(array_keys($emails) as $email)
  {
     echo $email;
     echo "<BR>";
  }
 }
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
