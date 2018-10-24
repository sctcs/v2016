<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 'On');

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
if(isset($_SESSION['family_id']))
{
   //echo "OK";
}
else
{
 header( 'Location: Logoff.php' ) ;
 exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);
//$whose="student";

//echo $whose;

//exit();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>
<?php echo " $NextYear"; ?> Summer Camp Registration
</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
  <meta http-equiv="Expires" CONTENT="0">
  <meta http-equiv="Cache-Control" CONTENT="no-cache">
  <meta http-equiv="Pragma" CONTENT="no-cache">
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
<body>
<center>
<a href="../MemberAccount/MemberAccountMain.php">Back to My Account</a>
<br>
<br>
<br>
<h1>
<?php echo " $NextYear"; ?> Summer Camp Registration
</h1>
<br>
<br>
<br>
<table >

<form name="NewMember" action="studentRegisterCampConfirm.php" method="POST" >
<input type="hidden" name="updtmemberid" value="<?php echo $RSA1[MemberID];?>">
<input type="hidden" name="whose" value="<?php echo $whose;?>">
<tr>
<?php
$stuid=$_GET[stuid];
$firstname=$_GET[FirstName];
$lastname=$_GET[LastName];
$campclassid=$_GET[campclassid]; //echo $campclassid;
$campextclassid= $_GET[campextclassid]; //echo $campextclassid;
$camp= $_GET[camp]; //echo $camp;
$campext= $_GET[campext]; //echo $campext;

if ( isset($stuid) && $stuid != "" )
{
$SQLcamp   = "select *   from tblClassRegistration where StudentMemberID=".$stuid;
$RSc=mysqli_query($conn,$SQLcamp);
while ( $RSAc=mysqli_fetch_array($RSc))
{ 
  $camps[$RSAc[ClassID]]=1;
}
}

$SQLstring = "select *   from tblMember where tblMember.FamilyID=".$_SESSION['family_id'];
$RS0=mysqli_query($conn,$SQLstring);
?>
<td width="50%" align="left">Student Name:&nbsp;</td><td>
<select name=stuid>
<?php
while ( $RSA0=mysqli_fetch_array($RS0))
{ 
  if ($RSA0[MemberID] == $stuid ) { ?>
  <option value=<?php echo $RSA0[MemberID]; ?> SELECTED>
  <?php } else { ?>
  <option value=<?php echo $RSA0[MemberID]; ?>         >
  <?php } ?>
<?php echo $RSA0[FirstName];?> <?php echo $RSA0[LastName];?> </option>
<?php } ?>
</select>
</td></tr>
<tr><td>&nbsp;</td><td>&nbsp;</td> </tr>

<?php
$SQLstring1= "select *   from tblClass where Year='".$NextYear."' and Term='Summer'";
$RS1=mysqli_query($conn,$SQLstring1);

while ( $RSA1=mysqli_fetch_array($RS1))
{ 
  if ( strpos($RSA1[GradeOrSubject] ,"Extended" ) > 0       )
  {
      if (isset($campext) && $campext=="on" ) { $checkede="CHECKED"; } else { $checkede="";}
      if ($camps[$RSA1[ClassID]] == 1       ) { $checkede="CHECKED"; } 
   ?>
<tr><td > <?php echo "[".$RSA1[ClassID]."] ".$RSA1[GradeOrSubject]; ?> : </td><td><input type=checkbox name=campext <?php echo $checkede; ?>></td></tr>
<input type="hidden" name="campextclassid" value="<?php echo $RSA1[ClassID];?>">
   <?php } else { 
      if (isset($camp) && $camp=="on" ) { $checked="CHECKED"; } else { $checked="";}
      if ($camps[$RSA1[ClassID]] == 1       ) { $checked="CHECKED"; } 
?>
<tr><td > <?php echo "[".$RSA1[ClassID]."] ".$RSA1[GradeOrSubject]; ?> : </td><td><input type=checkbox name=camp <?php echo $checked; ?>></td></tr>
<input type="hidden" name="campclassid" value="<?php echo $RSA1[ClassID];?>">
   <?php } ?>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>
<?php } ?>

<tr><td>&nbsp;</td><td>&nbsp;</td> </tr>
<tr><td>&nbsp;</td><td>&nbsp;</td> </tr>
<tr><td align="right">
<input type="submit" value="Update">
</td>
<td align="left">
<input type="button" width="18"  onClick="window.location.href='../MemberAccount/MemberAccountMain.php'" value="Cancel">
</td></tr>

</table>
</form>
<center>
</body>
</html>

<?php
    mysqli_close($conn);
 ?>
