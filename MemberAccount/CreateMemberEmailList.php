<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();


include("../common/DB/DataStore.php");


$membertypeid=$_POST[MemberTypeID];
$parent=$_POST[Parent];
$fname=$_POST[FirstName];
$lname=$_POST[LastName];
$hpone=$_POST[HomePhone];
$email=$_POST[Email];
$format=$_POST[Format];
/*
echo "<center>";
echo $membertypeid."\n";
echo $parent."\n";
echo $fname."\n";
echo $lname."\n";
echo $hpone."\n";
echo $email."\n";
echo $format."\n";
*/

$SQLstring = "SELECT FirstName,LastName,HomePhone,Email FROM tblMember,tblLogin
WHERE tblMember.MemberID=tblLogin.MemberID  and tblLogin.MemberTypeID=".$membertypeid;

if ( $membertypeid == 15 )
{
  $SQLstring .= " and tblMember.FamilyID  in (select distinct a.FamilyID from tblMember a, tblClassRegistration b ,tblClass c
                  where a.MemberID=b.StudentMemberID and b.ClassID=c.ClassID and c.CurrentClass='Yes' and b.Status='OK' )";

  if ( $parent == "primary" ) {
      $SQLstring .=" and tblMember.PrimaryContact='Yes' ";
  }
}

if ( $membertypeid == 4 )
{
  $SQLstring .= " and tblMember.MemberID in (select distinct MemberID from tblTeacher where CurrentTeacher='Yes')";
}

if ( $membertypeid == 5 )
{
  $SQLstring .= " and tblMember.Registered='Yes'";
}

$SQLstring .=" order by LastName, FirstName";
//echo $SQLstring;

$RS1=mysqli_query($conn,$SQLstring);

while ($row=mysqli_fetch_array($RS1) ) {
  if ( $fname != "" ) {
     echo $row[FirstName]."|";
  }
  if ( $lname != "" ) {
     echo $row[LastName]."|";
  }
  if ( $hpone != "" ) {
     echo $row[HomePhone]."|";
  }
  if ( trim($email) != "" ) {
     echo $row[Email];
  }

  if ( $format == "perline" ) {
    echo "<br>";
  } else {
    echo ", ";
  }

}

mysqli_close($conn);

?>
