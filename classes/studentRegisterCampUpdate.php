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

/*
$SQLstring = "select *   from tblMember where MemberID=".$stuid." limit 1";
$RS0=mysqli_query($conn,$SQLstring);
$RSA0=mysqli_fetch_array($RS0);

$firstname=$RSA0[FirstName];
$lastname=$RSA0[LastName];
$campclassid=$_POST[campclassid]; //echo $campclassid;
$campextclassid= $_POST[campextclassid]; //echo $campextclassid;
$camp= $_POST[camp]; //echo $camp;
$campext= $_POST[campext]; //echo $campext;
*/
$stuid=$_GET[stuid];
$firstname=$_GET[firstname];
$lastname=$_GET[lastname];
$campclassid=$_GET[campclassid]; //echo $campclassid;
$campextclassid= $_GET[campextclassid]; //echo $campextclassid;
$camp= $_GET[camp]; //echo $camp;
$campext= $_GET[campext]; //echo $campext;


?>
<br><BR>
<h2>Your camp registration has been completed successfully!</h2>
<br><BR>
Student Name: <?php echo $firstname." ".$lastname." [".$stuid."]"; ?> <br>
<?php 
if (isset($camp)) { 
  echo "Camp session: Yes";
}
  echo "<br>";
if (isset($campext)) { ?>
  Camp Extended Care session: Yes
        <?php } 

echo "<BR><BR><BR><BR>";
if (isset($camp) && $camp=="on") { 
   $sql2 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$stuid.", ". $campclassid. ", '".$NextYear."',  now(), 'OK')";
// echo $sql2;
       if (!mysqli_query($conn,$sql2))    {
          echo "Note: you have already registered the regular Camp session!" ;
          //                     die('insert language Error: ' . mysqli_error($conn));
       }
}

if (isset($campext) && $campext=="on") { 
   $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$stuid.", ". $campextclassid. ", '".$NextYear."',  now(), 'OK')";
// echo $sql3;
       if (!mysqli_query($conn,$sql3))    {
          echo "<br>Note: you have already registered the Camp Extended Care!" ;
       }
}
/*
*/

echo "<BR><BR><BR><BR>";
echo "<a href=\"../MemberAccount/MemberAccountMain.php\">My Account</a> | ";
echo "<a href=\"../MemberAccount/FeePaymentVoucher.php\">Payment VOucher</a>";

mysqli_close($conn);

?>
