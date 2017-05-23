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

<?php
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
        {
            echo "access denied";
            exit();
        }
?>

<?php
  $familyids = $_POST[valid_fids];
//echo $familyids;
  $fids = explode(",", $familyids);
  $count = 0; 
    foreach ($fids as $key => $value) 
    { 
            $count++; 
//      echo $value ."<br>";
  $valid_fids .= $value . ",";
    } 
  
//echo "Total: ". $count;
//if (!date_default_timezone_get('date.timezone')) {
    // insert here the default timezone
    date_default_timezone_set('America/New_York');
//}
// echo date('Y-m-d'); 
?>
<br>
<br>
<br>
<br>
<form action="enterPaymentBatchSave.php" method="POST">
    <input  type="hidden" name="valid_fids" value="<?php echo $valid_fids; ?>" >
 <table border=1>
  <tr>
   <th>No</th>
   <th>Family ID</th>
   <th>PaymentType</th>
   <th>PaymentMethod</th>
   <th>Identifier/ Check #</th>
   <th>Payer</th>
   <th>Amount</th>
   <th>Date Received<br> (yyyy-mm-dd)</th>
   <th>Note</th>
   <th>Status</th>
   <th>Collector</th>
   </tr>
<?php
  $count = 0; 
    foreach ($fids as $key => $fid) 
    { 
            $count++; 
     echo "<tr>";
     echo "<td>".$count ."</td>";
     echo "<td>".$fid ;
     echo "<input type=hidden name=\"FID[]\" value=\"" . $fid . "\">";
     echo "</td>";
?>
     <td>
	<INPUT TYPE=radio NAME=PaymentType<?php echo $fid; ?> VALUE="Fees" checked>Fees<br>
	<INPUT TYPE=radio NAME=PaymentType<?php echo $fid; ?> VALUE="Donation">Donation
	</td>
	
	<td>
	<INPUT TYPE=radio NAME=PaymentMethod<?php echo $fid; ?> VALUE="Check" checked>Check<br>
	<INPUT TYPE=radio NAME=PaymentMethod<?php echo $fid; ?> VALUE="Cash">Cash<br>
	</td>

	<td><input type=text name="PaymentIdentifier<?php echo $fid; ?>" value=""></td>

	<td><input type=text name="PayerInfo<?php echo $fid; ?>" value=""></td>

	<td><input type=text name="Amount<?php echo $fid; ?>" value=""></td>

	<td><input type=text name="PaymentDate<?php echo $fid; ?>" value="<?php echo date('Y-m-d'); ?>"> </td>

	<td><input type=text name="PaymentNote<?php echo $fid; ?>" value=""></td>

	<td><input type=text name="PaymentStatus<?php echo $fid; ?>" value="Received"></td>
	<td><?php echo $_SESSION[memberid]; ?></td>

     </tr>
<?php
    }
?>
 </table>
<BR><BR>
    <input type="submit" value="Save Payments">
</form>

</body>
</html>
