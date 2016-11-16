<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(!isset($_SESSION['family_id']) || $_SESSION['family_id']=="")
{
 echo "Need to <a href=\"../MemberAccount/MemberLoginForm.php\">login</a>";
 //header( 'Location: Logoff.php' ) ;
 exit();
}

$fid = $_SESSION['family_id'];

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

echo "<a href=\"../MemberAccount/MemberAccountMain.php\">My Account</a><br><br>";

$sql3 = "SELECT distinct FamilyID,FirstName,LastName,Email ".
	", HomePhone,CellPhone from tblMember where PrimaryContact ='Yes' and FamilyID=". $fid;
$RS3=mysqli_query($conn,$sql3);
while ( $RSA3=mysqli_fetch_array($RS3) ) {
   $firstname[$RSA3[FamilyID]]=$RSA3[FirstName];
   $lastname[$RSA3[FamilyID]]=$RSA3[LastName];
   $email[$RSA3[FamilyID]]=$RSA3[Email];
   $homephone[$RSA3[FamilyID]]=$RSA3[HomePhone];
   $cellphone[$RSA3[FamilyID]]=$RSA3[CellPhone];
}

$sql2 = "SELECT distinct m.FamilyID FROM tblMember m, tblClass c, tblClassRegistration r where m.MemberID=r.StudentMemberID and ".
        "r.ClassID=c.ClassID and c.CurrentClass='Yes' and r.Status='OK' and m.FamilyID=. $fid";
//echo $sql2;

$RS2=mysqli_query($conn,$sql2);
while ( $RS2 && $RSA2=mysqli_fetch_array($RS2) ) {
   $registered[$RSA2[FamilyID]]='yes';
    //echo $RSA2[FamilyID].": ".$registered[$RSA2[FamilyID]]."<BR>";
}

	$SQLstring = "select FReceivable.FamilyID,PayableAmount,COALESCE(PaymentAmount,0) PaymentAmount,PayableAmount-COALESCE(PaymentAmount,0) Balance ".
" from
(select FamilyID , sum(Amount) PayableAmount
   from tblReceivable where FamilyID=" . $fid ." group by FamilyID
) FReceivable
left join
(select FamilyID, sum(Amount) PaymentAMount
   from tblPayment where FamilyID=" . $fid ." group by FamilyID
) FamilyPayment
on FReceivable.FamilyID=FamilyPayment.FamilyID";


if ( $_GET[sortBy] == "name" ) {
  //$SQLstring .= " order by tblm.LastName,tblm.FirstName";
} else {
  $SQLstring .= " order by FReceivable.FamilyID";
}

if ($DEBUG) { echo $SQLstring;}
$RS1=mysqli_query($conn,$SQLstring);

?>
<table >


<?php
  $i=0;
  while ( $RSA1=mysqli_fetch_array($RS1) ) {
    
        echo "<tr>";

        echo "<td>Balance: </td>";
        $bal =       ($RSA1[Balance] - 0) ;
        echo "<td align=left>$ ". ($RSA1[Balance] - 0) ."</td>";
        echo "</tr>";
        echo "<tr>";
        echo "<td >&nbsp;</td>";
        echo "<td >";
      if ( $bal > 0 ) { 
        echo "Please pay the total balance or at least the annual fees and the Fall tuition."; 
      } else if ( $bal < 0 ) {
        echo "You can leave the credit in your account for future use, ";
        echo "<br>or request a fund by filling out a <a href=\"familyRefund.php\" target=_blank>Refund Request</a>,";
        echo "<br>or <a href=\"familyDonate.php\" target=_blank>Donate to School</a>";
      }
        echo "</td>";
        echo "</tr>";
        $i++;
	
  }
     //echo "rows=".$i;
  ?>

</table>



</body>
</html>

<?php

mysqli_close($conn);

?>
