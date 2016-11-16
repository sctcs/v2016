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

	$SQLstring = " SELECT Balance FROM `viewFamiliesBalance` WHERE `FamilyID`=".$fid;

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
        $balance=(0.00  - $RSA1[Balance]);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Payment Request Form</title>
</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr >
             <td>
                 <img src="./sccs.png">
             </td>
        </tr>
					<?php


						$SQLstring = "select DISTINCT MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  "
						            ."where   MB.FamilyID=".$fid;
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);

						$SQLpc = "select *   from tblMember  where tblMember.FamilyID=".$fid." and PrimaryContact='Yes'";
						$RS2=mysqli_query($conn,$SQLpc);
						$RSA2=mysqli_fetch_array($RS2);

					?>
	<tr>
		<td align="center"><h2>Payment Request Form</h2></td>
	</tr>
	<tr>
		<td align="center"><h3>Payment Purpose (Check One): 
		 <input type="checkbox">Reimbursement
		 <input type="checkbox">Invoices
		 <input type="checkbox" checked>Refund
		 <input type="checkbox">Payroll
                </h4></td>
	</tr>


	<tr>
	<td align="center"><h4>Vendor Name: <span style="text-decoration: underline;">
	<?php 
             $name = $RSA2[FirstName]." ".$RSA2[LastName];
             $nlen = strlen($name);
             $uline = $name;
             for ($i=1;$i<(45 - $nlen);$i++ ){
              $uline .= "_";
             }

        echo $uline . "</span><br>";
        echo "</td></tr>";
        ?> 
	<tr><td align="center"><h4>Vendor Address: <span style="text-decoration: underline;">
        <?php 
	$address =  $RSA2[HomeAddress].", " . 
		$RSA2[HomeCity].",  ".$RSA2[HomeState]." ".$RSA2[HomeZip]."";
             $nlen = strlen($address);
             $uline = $address;
             for ($i=1;$i<(50 - $nlen);$i++ ){
              $uline .= "_";
             }

        echo $uline . "</span><br>";
         ?>

	</td> </tr>
	<tr> <td>
         <i>Signing bellow validating the information on this request for payment is correct and the appropriate funding is available for this payment.</i><br>
	</td> </tr>

	<tr> <td>
         <h3>Requester:________________________(Print)________________________(Signature)____________(Date)
         </h3>
	</td> </tr>
	<tr> <td>
	<h3>Expense Details</h3>
	</td> </tr>
								
	<tr> <td>
	<table  cellpadding=1 cellspacing=1  border="1" width="100%">
	<tr align=center>
	<th>Date</th>
	<th>Item Description</th>
	<th>Code</th>
        <th>Amount</th>
	</tr>
	<tr align=center>
            <td><?php echo date("m/d/Y");?></td>
            <td>Tuition refund to Family ID 
	<?php	echo  $fid;?></td>
            <td>&nbsp;</td>
            <td>$ <?php echo $balance; ?></td>
        </tr>
    <?php for ($i=1;$i<=7;$i++) { ?>
	<tr align=center>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
    <?php } ?>
        </table>
	</td> </tr>

	<tr> <td align=right>
	<table  cellpadding=0 cellspacing=0  border="0" width="80%">
	<tr> <td align=left><h4>Total</h4></td><td align=right><span style="text-decoration: underline;">$ <?php echo $balance; ?></span></td>
        <tr> <td aligh=left><h4>Principal Approval</h4></td>
             <td align=left>______________________________________</td></tr>
        <tr> <td align=left><h4>Second Officer Approval</h4></td>
             <td align=left>______________________________________<br>
 (Required for Payment &gt; $3,000)</td></tr>
             </tr>
        </table>
	</td> </tr>

	<tr> <td align=right><br>
	</td> </tr>

	<tr> <td align=center>
	<table  cellpadding=0 cellspacing=0  border="0" width="100%">
          <tr><th align=left>Additional Information:</th>
              <th align=left>Note from Finance officer:</th>
          </tr>
<?php $rp=""; $rm="";
      if ($_GET[selection] == "RM") { $rm="CHECKED"; } else { $rp = "CHECKED"; } ?>
          <tr> <td>
                    <input type=checkbox <?php echo $rp; ?>>Pickup from office<br> 
                    <input type=checkbox <?php echo $rm; ?>>Mail to home address</td>
               <td></td>
        </table>
	</td> </tr>
        
</table>
</body>
</html>

<?php
    mysqli_close($conn);
 ?>
