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

if ( isset($_GET[show]) && $_GET[show] == "all" ) {
  echo "<a href=\"creditSelectionListing.php?show=unprocessed\">Show Unprocessed Families Only</a>";
  $SQLstring = "SELECT *  FROM tblRefundRequest                                   ";
} else {
  echo "<a href=\"creditSelectionListing.php?show=all\">Show All Families Including Processed</a>";
  $SQLstring = "SELECT *  FROM tblRefundRequest where Process is null or Process !='Yes' ";
}
//echo $SQLstring;
	$RS1=mysqli_query($conn,$SQLstring) or die("Error run query " .$SQLstring );
  if ( ! $RS1 ) { echo "Error running query ... "; exit; }

echo "&nbsp; | &nbsp;";

if ( isset($_GET[gencsv]) && $_GET[gencsv] == "yes" ) {
  $csvfile="sccs-refunds-" . date("Ymd-his", time()) .".csv";
        print "<a href=\"./temp/" . $csvfile . "\" download target=\"_blank\">Download the CSV File</a><br>";
  $myfile = fopen("./temp/$csvfile", "w") or die("Unable to open file!");
  fwrite($myfile, "FamilyID,CreditChoice,RequestDate,Amount,Name,Address,Phone,Email,RequestID\n");
} else {
  echo "<a href=\"creditSelectionListing.php?show=".$_GET[show]."&gencsv=yes\">Generate Downloadable CSV File</a>";
}
?>

<br>
<br>
<table border=1>
<tr>
<th>RequestID</th>
<th>FamilyID</th>
<th>Credit Choice</th>
<th>Payment Choice</th>
<th>Dispute Note</th>
<th>Request Date</th>
<th>Amount</th>
<th>Processed</th>
<th>Process Date</th>
<th>PrimaryContact</th>
<th>Address</th>
<th>Phone</th>
<th>Email</th>
</tr>
<?php 
  while ($RSA1=mysqli_fetch_array($RS1) ) {
        $SQLb="select * from viewFamiliesBalance where FamilyID=". $RSA1[FamilyID] ." limit 1";
	$RSb=mysqli_query($conn,$SQLb) or die("Error run query " .$SQLb );
        $RSAb=mysqli_fetch_array($RSb)  ;
   if ( $RSAb[Balance] < 0 ) {
     echo "<tr><td>"; echo        $RSA1[RequestID ]; echo "</td>";
     echo "    <td>"; echo        $RSA1[FamilyID ]; echo "</td><td>";
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
           echo        $RSAb[Balance];
           echo "</td><td>&nbsp;";
         if (isset($RSA1[Process]) && $RSA1[Process] =="Yes" ) {
           echo        $RSA1[Process];
         } else {
           echo "<a href=\"creditRequestProcess.php?done=yes&RequestID=" . $RSA1[RequestID] ."&FamilyID=" . $RSA1[FamilyID] ."\">set as processed</a>";
         }
           echo "</td><td>&nbsp;";
           echo        $RSA1[ProcessDate];
           echo "</td><td>&nbsp;";
        $SQLf="select LastName,FirstName,HomeAddress,HomeCity,HomeState,HomeZip,CellPhone,HomePhone,Email from tblMember where FamilyID=".$RSA1[FamilyID] . " and PrimaryContact='Yes' limit 1";
	$RSf=mysqli_query($conn,$SQLf) or die("Error run query " .$SQLf );
        $RSAf=mysqli_fetch_array($RSf)  ;
           echo        $RSAf[FirstName]." ".$RSAf[LastName];
           echo "</td><td>&nbsp;";
           echo   $RSAf[HomeAddress].", ".$RSAf[HomeCity].", ".$RSAf[HomeState]." ".$RSAf[HomeZip];
           echo "</td><td>&nbsp;";
           echo        $RSAf[Email];
           echo "</td><td>&nbsp;";
           echo        $RSAf[CellPhone]."; ". $RSAf[HomePhone];
           echo "</td>";
     echo "</tr>";
if ( $RSA1[CreditChoice] != "K" ) {
//fwrite($myfile, "FamilyID,CreditChoice,RequestDate,Amount,Name,Address,Phone,Email,RequestID\n");
if ( isset($_GET[gencsv]) && $_GET[gencsv] == "yes" ) {
fwrite($myfile,
$RSA1['FamilyID'] .",".
$RSA1['CreditChoice'] .",".
$RSA1['Date'] .",".
$RSAb['Balance'] .",".
$RSAf[FirstName]." ".$RSAf[LastName].",".
"\"".$RSAf[HomeAddress].", ".$RSAf[HomeCity].", ".$RSAf[HomeState]." ".$RSAf[HomeZip]."\",".
$RSAf[CellPhone]."; ". $RSAf[HomePhone].",".
$RSAf['Email'] . ",".
$RSA1['RequestID'] ."\n"
);
}
}
     }
        }

mysqli_close($conn);

if ( isset($_GET[gencsv]) && $_GET[gencsv] == "yes" ) {
fclose($myfile);
}

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

