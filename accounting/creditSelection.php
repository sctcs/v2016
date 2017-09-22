<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

if ( isset($_GET[FamilyID]) && $_GET[FamilyID] !="" ) {
   $fid= $_GET[FamilyID];
} else {
   $fid     =$_SESSION['family_id'];
}

if ( isset($_GET[selection]) && $_GET[selection] !="" ) {
   $sel= $_GET[selection];
} else {
   $sel     = "RP";
}

	$SQLstring = " SELECT CreditChoice FROM `tblRefundRequest` WHERE Process != 'Yes' and `FamilyID`=".$fid;

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
        $current_sel=  $RSA1[CreditChoice];

        if ( ! isset($current_sel) ) {
	   $SQLstring = " insert into tblRefundRequest(FamilyID,CreditChoice) values(".$fid .", '". $sel . "')";
   	   $RS1=mysqli_query($conn,$SQLstring) or die ("died while insert into tblRefundRequest <br>Debug info: $SQLstring <br>\n");

        } if ( $current_sel != $sel ) {
           $SQLstring = " update tblRefundRequest set CreditChoice='". $sel ."', Date=now() WHERE `FamilyID`=".$fid;
           $RS1=mysqli_query($conn,$SQLstring) or die ("died while deleting receivable <br>Debug info: $SQLstring <br>\n");
           if ( ! $RS1 ) {
             exit();
           }
        }

        echo "<a href=\"../MemberAccount/MemberAccountMain.php\">My Account</a><br><br>";
        echo "<a href=\"familyAccountSummary.php#balance\">Account Summary</a><br><br>";

?>
<br><br>

<?php if ($sel == "D" ) { ?>
Thank you for your donation and support to our school. You may now print a <a href="familyDonationReceipt.php?FamilyID=<?php echo $fid; ?>">receipt</a> to bring to school office to get an official signature. Or you don't need to do anything now, school office will print and sign the receipt for you to pick up or mail to you.
<?php } ?>

<?php if ($sel == "RP" ) { ?>
You may now click here to print a <a href="familyRefund.php?FamilyID=<?php echo $fid; ?>&selection=RP">Refund Request Form</a> to bring to school office to get processed. 
<?php } ?>

<?php if ($sel == "RM" ) { ?>
You may now click here to print a <a href="familyRefund.php?FamilyID=<?php echo $fid; ?>&selection=RM">Refund Request Form</a> to bring to school office to get processed. Or you don't need to do anything now, school office will process your request and mail the refund check to you. Please make sure the address on the form is correct.
<?php } ?>
