<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
{
            echo "access denied";
            exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>
<html>
<body>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br>
<a href="index.php?view=SearchReceivable">Payment Management Home</a>
<br>
<br>

<?php 
//$SQLstring = "SELECT FamilyID, CreditChoice,Process FROM tblFamily where Process is null or Process !='Yes' ";

if ( isset($_GET[show]) && $_GET[show] == "all" ) {
  echo "<a href=\"creditSelectionListing.php?show=unprocessed\">Show unprocessed families only</a>";
  $SQLstring = "SELECT *                              FROM tblFamily                                          ";
} else {
  echo "<a href=\"creditSelectionListing.php?show=all\">Show all families</a>";
  $SQLstring = "SELECT *                              FROM tblFamily where Process is null or Process !='Yes' ";
}
//echo $SQLstring;
	$RS1=mysqli_query($conn,$SQLstring) or die("Error run query " .$SQLstring );
  if ( ! $RS1 ) { echo "Error running query ... "; exit; }

?>

<br>
<br>
<table border=1>
<tr>
<th>FamilyID</th>
<th>Credit Choice</th>
<th>Payment Choice</th>
<th>Dispute Note</th>
<th>Request Date</th>
<th>Processed</th>
<th>Process Date</th>
</tr>
<?php 
  while ($RSA1=mysqli_fetch_array($RS1) ) {
     echo "<tr><td>";
           echo        $RSA1[FamilyID ];
           echo "</td><td>";
        if ( isset($RSA1[CreditChoice]) && $RSA1[CreditChoice] =="D" )
        {
           echo "<a href=\"familyDonationReceipt.php?FamilyID=" .$RSA1[FamilyID] ."\" target=blank>" . $RSA1[CreditChoice] . "</a>";
        } else if ( isset($RSA1[CreditChoice]) && $RSA1[CreditChoice] =="RP" )
        {
           echo "<a href=\"familyRefund.php?FamilyID=" .$RSA1[FamilyID] ."&selection=RP\" target=blank>" . $RSA1[CreditChoice] . "</a>";
        } else if ( isset($RSA1[CreditChoice]) && $RSA1[CreditChoice] =="RM" )
        {
           echo "<a href=\"familyRefund.php?FamilyID=" .$RSA1[FamilyID] ."&selection=RM\" target=blank>" . $RSA1[CreditChoice] . "</a>";
        } else {
          echo $RSA1[CreditChoice];
        }
           echo "</td><td>&nbsp;";
           echo        $RSA1[PaymentChoice];
           echo "</td><td>&nbsp;";
           echo        $RSA1[DisputeNote];
           echo "</td><td>&nbsp;";
           echo        $RSA1[Date];
           echo "</td><td>&nbsp;";
         if (isset($RSA1[Process]) && $RSA1[Process] =="Yes" ) {
           echo        $RSA1[Process];
         } else {
           echo "<a href=\"creditRequestProcess.php?done=yes&FamilyID=" . $RSA1[FamilyID] ."\">set as processed</a>";
         }
           echo "</td><td>&nbsp;";
           echo        $RSA1[ProcessDate];
           echo "</td><td>";
     echo "</tr>";
        }

mysqli_close($conn);


?>
</table>
<pre>
Credit Choice Code:

RM = Refund and Mail to family
RP = Refund and Pick up from office
 D = Donate to school
 K = Keep in account for future use

Payment Choice Code:

 F = Pay fall due in Fall
 S = Pay fall due with spring payment
 D = Dispute balance
</pre>

</body>
</html>

