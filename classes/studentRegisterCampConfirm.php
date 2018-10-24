<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
 exit();
}

include("../common/DB/DataStore.php");

$stuid=$_POST[stuid];
$SQLstring = "select *   from tblMember where MemberID=".$stuid." limit 1";
$RS0=mysqli_query($conn,$SQLstring);
$RSA0=mysqli_fetch_array($RS0);

$firstname=$RSA0[FirstName];
$lastname=$RSA0[LastName];
$campclassid=$_POST[campclassid]; //echo $campclassid;
$campextclassid= $_POST[campextclassid]; //echo $campextclassid;
$camp= $_POST[camp]; //echo $camp;
$campext= $_POST[campext]; //echo $campext;

?>
<br><BR>
<h2>Confirm your camp registration:</h2>
<br><BR>
<b>Student Name</b>: <?php echo $firstname." ".$lastname; ?> <br>
<?php 
if (isset($camp)) { 
  echo "<b>Camp session</b>: Yes";
}
echo "<br>";
if (isset($campext)) { ?>
  <b>Camp Extended Care session</b>: Yes
        <?php } 
if (!isset($camp)  && !isset($campext)) 
{
  echo "<BR><BR><BR><font color=red>Wait! You did not check any camp session, please click on Back and check at least the regular camp session.</font><BR>";
  echo "<br>";
echo "<a href=\"studentRegisterCamp.php?firstname=".$firstname."&lastname=".$lastname."&campclassid=".$campclassid."&campextclassid=".$campextclassid."&stuid=".$stuid."&camp=".$camp."&campext=".$campext."\">&lt;&lt;Back</a>";
} elseif (!isset($camp)  && isset($campext)) 
{
  echo "<BR><BR><BR><font color=red>Wait! It is not allowed to take the camp extended care session only, please click on Back and add the regular camp session.</font><BR>";
  echo "<br>";
echo "<a href=\"studentRegisterCamp.php?firstname=".$firstname."&lastname=".$lastname."&campclassid=".$campclassid."&campextclassid=".$campextclassid."&stuid=".$stuid."&camp=".$camp."&campext=".$campext."\">&lt;&lt;Back</a>";
} else {
echo "<BR><BR><BR><b>Instructions</b>:<BR>";
echo "
If the above info is correct, please click on Continue to complete your camp registration for the student.<br>
If the above info is incorrect, please click on Back to change.
";
echo "<BR><BR><BR><BR>";
echo "<a href=\"studentRegisterCamp.php?firstname=".$firstname."&lastname=".$lastname."&campclassid=".$campclassid."&campextclassid=".$campextclassid."&stuid=".$stuid."&camp=".$camp."&campext=".$campext."\">&lt;&lt;Back</a>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<a href=\"studentRegisterCampUpdate.php?firstname=".$firstname."&lastname=".$lastname."&campclassid=".$campclassid."&campextclassid=".$campextclassid."&stuid=".$stuid."&camp=".$camp."&campext=".$campext."\">&gt;&gt;Continue</a>";
}

mysqli_close($conn);

?>
