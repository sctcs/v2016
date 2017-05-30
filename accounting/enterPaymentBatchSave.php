<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

?>
<html>
<head>
<title>Enter Payment Batch</title>
<script>
function goBack() {
    window.history.back()
}
</script>
</head>

<body>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br>
<a href="index.php">Payment Management</a><br>

<?php
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
        {
            echo "access denied";
            exit();
        }

// if DEBUG
$debug=0;
if ($debug) {
// loop through every form field
while ( list( $field, $value ) = each( $_POST )) {
   // display values
   if ( is_array( $value )) {
      // if checkbox (or other multiple value fields)
      while ( list( $arrayField, $arrayValue ) = each( $value )) {
       if ( is_array( $arrayValue )) {
       while ( list( $arrayField1, $arrayValue1 ) = each( $arrayValue )) {
     echo "<p>" . $arrayField1 . "</p>\n";
     echo "<p>" . $arrayValue1 . "</p>\n";
       }
       } else {
     echo "<p>" . $arrayField . "</p>\n";
     echo "<p>" . $arrayValue . "</p>\n";
       }
      }
   } else {
  echo "<p>" . $field . "</p>\n";
  echo "<p>" . $value . "</p>\n";
   }
}
}

?>

<?php

function mail_notice($fid,$useremail,$fname,$lname,$amount,$check)
{

//echo "Payment notice has been sent to ".$useremail."<br><br>";
$message = "Dear ".$fname." ".$lname.",

Your recent payment of \$$amount (FID $fid check #$check) has been received, thank you. It has been recorded and is ready for you to review. If you think this is an error or you find anything incorrect, please let us know by replying this email as soon as possible.

Best Regards,
Min Li
SCCS Financial Manager
";

//echo $message;

$to      = $useremail;
$subject = 'Your payment to SCCS for fees and/or tuition has been recevied';

$headers = 'From: finance@ynhchineseschool.org' . "\r\n" .
'Reply-To: finance@ynhchineseschool.org' . "\r\n" .
'X-Mailer: PHP/' . phpversion() . "\r\n";
$headers .= 'Bcc: finance@ynhchineseschool.org' . "\r\n";

mail($to, $subject, $message, $headers);

}


  $familyids = $_POST[valid_fids];
//  echo $familyids;
  $fids = explode(",", $familyids);
  $count = 0; 
  $payments="";
    
    foreach ($_POST[FID] as $key => $fid) 
    { 
     if (isset($fid))
     {
            $count++; 
if ($debug) {
        echo $fid ."<br>";
       echo "PaymentType: " . $_POST["PaymentType".$fid] . "<br>";
       echo "PaymentMethod: " . $_POST["PaymentMethod".$fid] . "<br>";
       echo "PaymentIdentifier: " . $_POST["PaymentIdentifier".$fid] . "<br>";
       echo "PayerInfo: " . $_POST["PayerInfo".$fid] . "<br>";
       echo "Amount: " . $_POST["Amount".$fid] . "<br>";
       echo "PaymentDate: " . $_POST["PaymentDate".$fid] . "<br>";
       echo "PaymentNote: " . $_POST["PaymentNote".$fid] . "<br>";
       echo "PaymentStatus: " . $_POST["PaymentStatus".$fid] . "<br>";
             $collectorid = $_SESSION['memberid'];
       echo "CollectorID: " . $_SESSION['memberid']      . "<br>";
}
       $payments .= "('". $fid ."', '" 
                       . $_POST["PaymentType".$fid] . "','"
                       . $_POST["PaymentMethod".$fid] . "','" 
                       . $_POST["PaymentIdentifier".$fid] . "','" 
                       . $_POST["PayerInfo".$fid] . "','" 
                       . $_POST["Amount".$fid] . "','" 
                       . $_POST["PaymentDate".$fid] . "','" 
                       . $_POST["PaymentNote".$fid] . "','" 
                       . $_POST["PaymentStatus".$fid] . "','" ;
       if ( $count == count($_POST[FID]) )
       {
          $payments .=   $_SESSION['memberid'] . "')";
       } else {
          $payments .=   $_SESSION['memberid'] . "'),";
       }
                       
       if ($count ==1) 
       { 
         $valid_fids =  $fid ;
       } else {
         $valid_fids .= "," . $fid ;
       }
     }
    }
 if ( $payments != "" )
{
  $payments = "INSERT INTO tblPayment(FamilyID,PaymentType,PaymentMethod,PaymentIdentifier,PayerInfo,Amount,PaymentDate,PaymentNote,PaymentStatus,CollectorID) VALUES " . $payments;
if ($debug) {
  echo $payments; 
}
  include("../common/DB/DataStore.php");

  mysqli_query($conn,$payments) or die ("died while inserting to table<br>Debug info: $payments");

  # send email notice to payers
  #
  $SQLstring = "select FamilyID, FirstName, LastName, Email from tblMember where PrimaryContact='Yes' and FamilyID in ($valid_fids) ";
//echo $SQLstring;
  echo "<br>";
  $RS1=mysqli_query($conn,$SQLstring) or die ("died while querying db <br> Debug info: $SQLstring");
  while ($row=mysqli_fetch_array($RS1))
  {
     $fid = $row[FamilyID];
     echo "<BR>mailing to ...... " . $fid .", " .$row[Email] .", " .$row[FirstName] ." ".$row[LastName] .", ". $_POST["Amount".$fid] .", ".$_POST["PaymentIdentifier".$fid];
     mail_notice($fid,$row[Email],$row[FirstName],$row[LastName],$_POST["Amount".$fid],$_POST["PaymentIdentifier".$fid]) ;
  }

  mysqli_close($conn);
}
//echo "Total: ". $count;
?>
<br>
<br>
Payments have been successfully saved!
<br>
<br>
<a href="enterPaymentBatchIDForm.php">Continue to enter more payments &gt;&gt;&gt;</a>
</body>
</html>
