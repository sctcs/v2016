<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

?>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a>
<BR>
<a href="familyAccountSummary.php#balance">Account Summary</a><br>
<BR>
Dispute Account Balance 
<BR>
<BR>
<?php

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
include("balance_lib.php");

$fsql = "select PaymentChoice,DisputeNote from tblFamily where FamilyID=". $_SESSION['family_id'];
//echo $fsql;

$RSF = mysqli_query($conn, $fsql);
if ($RSF) {
   $RSAF = mysqli_fetch_array($RSF);
}
   $dspnote  = $RSAF[DisputeNote];
?>

Enter or update your balance dispute note:<br><br>

<form method="POST" action="disputeBalanceUpdate.php">
<textarea rows="10" cols="50" name="dispnote"><?php echo $dspnote; ?>
</textarea>
<BR>
<input type="submit" value="Submit">
</form>

<BR>
<?php if ($RSAF[PaymentChoice] && $RSAF[PaymentChoice] == "D") { ?>
OR, you can <a href="disputeBalanceUpdate.php?delete=true">Cancel this dispute</a>
<?php } ?>

<html>
<body>

<?php

mysqli_close($conn);

?>
