<?php

require_once("../common/DB/DataStore.php");
require_once("AccountReceivable.php");

function PaymentViewList()
{
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
	session_start();
        $SessionUserName=$_SESSION['logon'];
	$CollectorID=$_SESSION['memberid'];

        print "<center><hr><h2>Payment You collected</h2><hr>";
        print "<br>Your information:";
        print "<br>session user: $SessionUserName";
        print "<br>MemberID: $CollectorID<hr>";
	$query="SELECT `PaymentID` , `Date` ,PaymentDate, `FamilyID`,`PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` ,
		`Amount`, `PaymentNote` , `CollectorID` , `PaymentStatus` FROM `tblPayment` WHERE  CollectorID=$CollectorID  and `Date`>'2008-07-01' order by `Date`";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query $query ");
	$TotalAmount=0;
		?>
		<table border=1>
		<tr>
		    <th align="left" >&nbsp;</th>
		    <th align="left" >Payment ID</th>
			<th align="left" >Entry Date</th>
			<th align="left" >Receive Date</th>
			<th align="left" >Payer</th>
			<th align="left" >Family</th>
			<th align="left" >Type</th>
			<th align="left" >Check #</th>
			<th align="left" >Amount</th>
			<th align="left" >Method</th>
                        <th align="left" >Note</th>
			</tr>
		<?php
		while($row = mysqli_fetch_array($result))
		{
			$TotalAmount= $TotalAmount + $row['Amount'];
		?>
			<tr>
			<td>&nbsp;<?php  showViewlink($row['PaymentID']);?></td>
		        <td align="left" ><?php echo $row['PaymentID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['Date'] ));?></td>
			<td align="left" ><?php  echo date( 'Y-m-d',strtotime($row['PaymentDate'] ));?></td>
			<td align="left" ><?php echo $row['PayerInfo'];?></td>
			<td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['PaymentType'];?></td>
			<td align="left" ><?php echo $row['PaymentIdentifier'];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php echo $row['PaymentMethod'];?></td>
                        <td align="left" ><?php  echo $row['PaymentNote'];?></td>
			</tr>
<?php
       }
?>
			<tr>
			<th colspan=7 align=right>Total&nbsp;&nbsp;</th>
			<td>&nbsp;<?php  echo $TotalAmount; ?></td>
			</tr>
	</table></center>
<?php
}

function PaymentViewListAll()
{
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
	session_start();
        $SessionUserName=$_SESSION['logon'];

	$payment_beg_date="$CurrentYear-07-01";
    if ( isset($_GET[beg_date]) && strlen($_GET[beg_date]) == 10 ) {
        $payment_beg_date=$_GET[beg_date];
    }

    $payment_end_date="$NextYear-07-01";
	    if ( isset($_GET[end_date]) && strlen($_GET[end_date]) == 10 ) {
	        $payment_end_date=$_GET[end_date];
    }
        print "<center><hr>All Payments Collected <br>between $payment_beg_date and $payment_end_date<br> ";
        if (strlen ($_GET[cid]) > 0 ) {
           print " by collector ".$_GET[cid];
        } else {
           print "by all collectors";
        }
        print "</center>";

        $csvfile="sccs-payments-" . date("Ymd-his", time()) .".csv";
        print "<a href=\"./temp/" . $csvfile . "\" download target=\"_blank\">Download as CSV</a><br>";

    //    print "<br>Your information:";
    //    print "<br>session user: $SessionUserName";
    //    print "<br>MemberID: $CollectorID<hr>";
	$query="SELECT `PaymentID` , `Date` ,PaymentDate, `FamilyID`,`PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` ,
		`Amount`, `PaymentNote` , `CollectorID` , `PaymentStatus` FROM `tblPayment` where `PaymentDate`>'".$payment_beg_date.
		"' and PaymentDate < '".$payment_end_date."'";
	if ( strlen ($_GET[cid]) > 0 ) {
		$query .= " and CollectorID =".$_GET[cid];
	}

    if ( isset($_GET[orderby_fid]) && $_GET[orderby_fid] == 1 ) {
		$query .= " order by `FamilyID`,`Date`";
    } else {
		$query .= " order by `Date`,FamilyID";
    }
//	echo $query;
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query $query ");
	$TotalAmount=0;
	$CashTotalAmount=0;
	$CheckTotalAmount=0;

$myfile = fopen("./temp/$csvfile", "w") or die("Unable to open file!");
fwrite($myfile, "Payment ID,Received Date,Check No,Payer,Payment,Family,Type,Method,Note,Collector\n");
		?>
		<table border=1>
		<tr>
		    <th align="left" >&nbsp;</th>
		    <th align="left" >Payment ID</th>
			<th align="left" >Entry Date</th>
			<th align="left" >Receive Date</th>
			<th align="left" >Check #</th>
			<th align="left" >Payer</th>
			<th align="left" >Payment</th>
			<th align="left" >FamilyID</th>
			<th align="left" >Type</th>
			<th align="left" >Method</th>
            <th align="left" >Note</th>
            <th align="left" >Collector</th>
			</tr>
		<?php

		while($row = mysqli_fetch_array($result))
		{
			$TotalAmount= $TotalAmount + $row['Amount'];
     if ( $row['PaymentMethod'] == "Check" ) {
	$CheckTotalAmount= $CheckTotalAmount + $row['Amount'];
     } else {
	$CashTotalAmount= $CashTotalAmount + $row['Amount'];
     }
		?>
			<tr>
			<td>&nbsp;<?php  showViewlink($row['PaymentID']);?></td>
		        <td align="left" ><?php echo $row['PaymentID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['Date'] ));?></td>
			<td align="left" ><?php  echo $row['PaymentDate'] ;?></td>
			<td align="left" ><?php echo $row['PaymentIdentifier'];?></td>
			<td align="left" ><?php echo $row['PayerInfo'];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
		        <td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['PaymentType'];?></td>
			<td align="left" ><?php echo $row['PaymentMethod'];?></td>
                        <td align="left" ><?php  echo $row['PaymentNote'];?></td>
            <td align="left" ><?php  echo $row['CollectorID'];?></td>
			</tr>
<?php
fwrite($myfile, 
$row['PaymentID'] .",".
$row['PaymentDate'] .",".
$row['PaymentIdentifier'] .",".
$row['PayerInfo'] .",".
$row['Amount'] .",".
$row['FamilyID'] .",".
$row['PaymentType'] .",".
$row['PaymentMethod'] .",".
$row['PaymentNote'] .",".
$row['CollectorID'] . "\n"
);
       }
fwrite($myfile, "Cash,".$CashTotalAmount . ",Check," . $CheckTotalAmount .",Total," . $TotalAmount ."\n");
fclose($myfile);
?>
<!--tr>
			<th colspan=7 align=right>Total&nbsp;&nbsp;</th>
			<td>&nbsp;<?php  echo $TotalAmount; ?></td>
			</tr> -->
	</table>
&nbsp;Cash: $<?php  echo $CashTotalAmount; ?> <br>
Check: $<?php  echo $CheckTotalAmount; ?> <br>
&nbsp;Total: $<?php  echo $TotalAmount; ?>
<?php
}

function PaymentViewListAllExt()
{
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
	session_start();
        $SessionUserName=$_SESSION['logon'];

	$payment_beg_date="2017-07-01";
    if ( isset($_GET[beg_date]) && strlen($_GET[beg_date]) == 10 ) {
        $payment_beg_date=$_GET[beg_date];
    }

    $payment_end_date="2018-07-01";
	    if ( isset($_GET[end_date]) && strlen($_GET[end_date]) == 10 ) {
	        $payment_end_date=$_GET[end_date];
    }
        print "<center><hr>All Payments Collected <br>between $payment_beg_date and $payment_end_date<br> ";
        if (strlen ($_GET[cid]) > 0 ) {
           print " by collector ".$_GET[cid];
        } else {
           print "by all collectors";
        }
        print "</center>";

        $csvfile="sccs-payments-" . date("Ymd-his", time()) .".csv";
        print "<a href=\"./temp/" . $csvfile . "\" download target=\"_blank\">Download as CSV</a><br>";

    //    print "<br>Your information:";
    //    print "<br>session user: $SessionUserName";
    //    print "<br>MemberID: $CollectorID<hr>";
	$query="SELECT `PaymentID` , `Date` ,PaymentDate, `FamilyID`,`PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` ,
		`Amount`, `PaymentNote` , `CollectorID` , `PaymentStatus` FROM `tblPayment` where `PaymentDate`>'".$payment_beg_date.
		"' and PaymentDate < '".$payment_end_date."'";
	if ( strlen ($_GET[cid]) > 0 ) {
		$query .= " and CollectorID =".$_GET[cid];
	}
		$query .= " order by `CollectorID`,`Date`";
	//echo $query;
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query $query ");
	$TotalAmount=0;
	$CashTotalAmount=0;
	$CheckTotalAmount=0;

$myfile = fopen("./temp/$csvfile", "w") or die("Unable to open file!");
fwrite($myfile, "Payment ID,Receive Date,Check No,Payer,Amount,Family ID,Reg. Fee,Memb. Fee,Safety Deposit,Tuition,Current Charges,Past Credit,Past Balance,Balance\n");
		?>
		<table border=1>
		<tr>
		    <th align="left" >&nbsp;</th>
		    <th align="left" >Payment ID</th>
			<th align="left" >Entry Date</th>
			<th align="left" >Receive Date</th>
			<th align="left" >Check #</th>
			<th align="left" >Payer</th>
			<th align="left" >Payment</th>
			<th align="left" >Family ID</th>
			<th align="left" >Reg. Fee</th>
			<th align="left" >Memb. Fee</th>
			<th align="left" >Safety Deposit</th>
			<th align="left" >Tuition</th>
			<th align="left" >Current Charges</th>
			<th align="left" >Past Credit</th>
			<th align="left" >Past Balance</th>
			<th align="left" >Balance</th>
<!--			<th align="left" >Type</th>
			<th align="left" >Method</th>
            <th align="left" >Note</th>
            <th align="left" >Collector</th>
  -->
			</tr>
		<?php

while($row = mysqli_fetch_array($result))
{
			$TotalAmount= $TotalAmount + $row['Amount'];
     if ( $row['PaymentMethod'] == "Check" ) {
	$CheckTotalAmount= $CheckTotalAmount + $row['Amount'];
     } else {
	$CashTotalAmount= $CashTotalAmount + $row['Amount'];
     }

$fid     = $row[FamilyID];

if ( !isset( $past_credit[$fid]) && !isset( $past_balance[$fid])) 
{
     $sql2 = "SELECT  sum(Amount) as amount FROM `tblReceivable` where  FamilyID=". $row[FamilyID] ." and DateTime < '2017-07-01' ";
//  echo $sql2;
	$result2 = mysqli_query(GetDBConnection(),$sql2) or Die ("Failed to query $sql2 ");
	$row2 = mysqli_fetch_array($result2);
        $past_charges = $row2[amount];

     $sql3 = "SELECT  sum(Amount) as amount FROM `tblPayment` where  FamilyID=". $row[FamilyID] ." and PaymentDate < '2017-07-01' ";
//  echo $sql3;
	$result3 = mysqli_query(GetDBConnection(),$sql3) or Die ("Failed to query $sql3 ");
	$row3 = mysqli_fetch_array($result3);
        $past_payments = $row3[amount];

        if ( !isset($past_credit[$fid]) && ($past_charges < $past_payments) )
        {
          $past_credit[$fid] = ($past_payments - $past_charges);
        } else {
          $past_credit[$fid] = 0.00;
        }
        
         if ( !isset($past_balance[$fid]) && $past_charges > $past_payments)
        {
          $past_balance[$fid]= $past_charges - $past_payments     ;
        } else {
          $past_balance[$fid] = 0.00;
        }
}
        if (isset($balance[$fid]) && $balance[$fid] >0 )
        {
          $past_balance[$fid] = 0.00; //$balance[$fid];
        }
//   $sql1 = "SELECT  IncomeCategory, sum(Amount) as amount FROM `tblReceivable` where DateTime > '".$CurrentYear."-07-01' group by  IncomeCategory";
     $sql1 = "SELECT  IncomeCategory, sum(Amount) as amount FROM `tblReceivable` where DateTime >='2017-07-01' and FamilyID=". $row[FamilyID] ." group by  IncomeCategory";
//    echo $sql1;
	$result1 = mysqli_query(GetDBConnection(),$sql1) or Die ("Failed to query $query ");
                $tuition = 0;
$payment[$fid] = $row[Amount]+$past_credit[$fid];
if (!isset($paid_regfee[$fid])) { $paid_regfee[$fid]=0.00; }
if (!isset($paid_regfee_t[$fid])) { $paid_regfee_t[$fid]=0.00; }
if (!isset($paid_deposit[$fid])) { $paid_deposit[$fid]=0.00; }
if (!isset($paid_membership[$fid])) { $paid_membership[$fid]=0.00; }
if (!isset($paid_tuition[$fid])) { $paid_tuition[$fid]=0.00; }
		while($row1 = mysqli_fetch_array($result1))
		{
                   $ic = $row1[IncomeCategory];
                   if ( $ic == "14" )
                   {
                      $regfee = $row1[amount]; 
                      if ( $payment[$fid] >= ($regfee - $paid_regfee_t[$fid]) )
                      {
                        $paid_regfee[$fid]  = $regfee - $paid_regfee_t[$fid];
                        $paid_regfee_t[$fid] += $regfee - $paid_regfee_t[$fid];
                      } else {
                        $paid_regfee[$fid] = $payment[$fid];
                        $paid_regfee_t[$fid] += $payment[$fid];
                      }
                      $payment[$fid] -= $paid_regfee[$fid];
                   } else if ( $ic == "15" )
                   {
                      $deposit = $row1[amount];
                      if ( $payment[$fid] >= ($deposit - $paid_deposit_t[$fid]) )
                      {
                        $paid_deposit[$fid]  = $deposit - $paid_deposit_t[$fid];
                        $paid_deposit_t[$fid] += $deposit - $paid_deposit_t[$fid];
                      } else {
                        $paid_deposit[$fid] = $payment[$fid];
                        $paid_deposit_t[$fid] += $payment[$fid];
                      }
                      $payment[$fid] -= $paid_deposit[$fid];
                   } else if ( $ic == "1" )
                   {
                      $membership = $row1[amount];
                      if ( $payment[$fid] >= ($membership - $paid_membership_t[$fid]) )
                      {
                        $paid_membership[$fid]  = $membership - $paid_membership_t[$fid];
                        $paid_membership_t[$fid] += $membership - $paid_membership_t[$fid];
                      } else {
                        $paid_membership[$fid]  = $payment[$fid];
                        $paid_membership_t[$fid] += $payment[$fid];
                      }
                      $payment[$fid] -= $paid_membership[$fid];
                   } else {
                      $tuition += $row1[amount];
                   }
		}
                      if ( $payment[$fid] >= ($tuition - $paid_tuition_t[$fid]) )
                      {
                        $paid_tuition[$fid]  = $tuition - $paid_tuition_t[$fid];
                        $paid_tuition_t[$fid] += $tuition - $paid_tuition_t[$fid];
                      } else {
                        $paid_tuition[$fid]  = $payment[$fid];
                        $paid_tuition_t[$fid] += $payment[$fid];
                      }
                      $payment[$fid] -= $paid_tuition[$fid];
        if ( !isset( $charges[$fid]) )
        {
                $charges[$fid] = $regfee + $deposit + $membership + $tuition;
        } else {
                $charges[$fid] = 0.00;
        }
  /*    if ( $past_credit[$fid] >= $charges[$fid] )
        {
          $past_credit[$fid] = $past_credit[$fid] - $charges[$fid];
        } else {
          $past_credit[$fid] = 0.00;
        }
    */
   if (!isset($balance[$fid]))
   {
        $balance[$fid] = $past_balance[$fid] + $charges[$fid] - $past_credit[$fid] - $row[Amount];
   } else {
        $balance[$fid] -=                                                      $row[Amount];
   }
if (!isset($paid_membership[$fid])) { $paid_membership[$fid]=0.00; }
if (!isset($paid_tuition[$fid])) { $paid_tuition[$fid]=0.00; }
		?>
			<tr>
			<td>&nbsp;<?php  showViewlink($row['PaymentID']);?></td>
		        <td align="left" ><?php echo $row['PaymentID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['Date'] ));?></td>
			<td align="left" ><?php  echo $row['PaymentDate'] ;?></td>
			<td align="left" ><?php echo $row['PaymentIdentifier'];?></td>
			<td align="left" ><?php echo $row['PayerInfo'];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
		        <td align="left" ><?php echo $row['FamilyID'];?></td>
		        <td align="left" ><?php echo $paid_regfee[$fid]                       ;?></td>
		        <td align="left" ><?php echo $paid_membership[$fid]                       ;?></td>
		        <td align="left" ><?php echo $paid_deposit[$fid]                        ;?></td>
		        <td align="left" ><?php echo $paid_tuition[$fid]                       ;?></td>
		        <td align="left" ><?php echo $charges[$fid]  ;?></td>
		        <td align="left" ><?php echo $past_credit[$fid];?></td>
		        <td align="left" ><?php echo $past_balance[$fid]   ;?></td>
		        <td align="left" ><?php echo $balance[$fid]  ;?></td>
<!--			<td align="left" ><?php echo $row['PaymentType'];?></td>
			<td align="left" ><?php echo $row['PaymentMethod'];?></td>
                        <td align="left" ><?php  echo $row['PaymentNote'];?></td>
            <td align="left" ><?php  echo $row['CollectorID'];?></td>
 -->
			</tr>
<?php
fwrite($myfile, 
$row['PaymentID'] .",".
$row['PaymentDate'] .",".
$row['PaymentIdentifier'] .",".
$row['PayerInfo'] .",".
$row['Amount'] .",".
$row['FamilyID'] .",".
$paid_regfee[$fid] .",".
$paid_membership[$fid] .",".
$paid_deposit[$fid] .",".
$paid_tuition[$fid] .",".
$charges[$fid] .",".
$past_credit[$fid] .",".
$past_balance[$fid] .",".
$balance[$fid]. "\n"
);
        $past_credit[$fid]=0.00;
} // end-while

fwrite($myfile, "Cash,".$CashTotalAmount . ",Check," . $CheckTotalAmount .",Total," . $TotalAmount ."\n");
fclose($myfile);
?>
<!--tr>
			<th colspan=7 align=right>Total&nbsp;&nbsp;</th>
			<td>&nbsp;<?php  echo $TotalAmount; ?></td>
			</tr> -->
	</table>
&nbsp;Cash: $<?php  echo $CashTotalAmount; ?> <br>
Check: $<?php  echo $CheckTotalAmount; ?> <br>
&nbsp;Total: $<?php  echo $TotalAmount; ?>
<?php
}

function showeditlink($ParamPaymentID)
{
?>
<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewEdit&PaymentID=<?php echo $ParamPaymentID;?>">Edit</a>
<?php
}
function showViewlink($ParamPaymentID)
{
?>
<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewOne&PaymentID=<?php echo $ParamPaymentID;?>&mainmenu=off">View</a>
<?php
}


function PaymentViewOne()
{
	PaymentViewOneByID($_GET['PaymentID']);
}

function PaymentViewOneByID($ParamPaymentID)
{
	# $PaymentID=$_GET['PaymentID'];
	$PaymentID= $ParamPaymentID;
	$query="SELECT `PaymentID` , `Date` ,PaymentDate, `FamilyID` ,`PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` ,
`Amount`, `PaymentNote` , `CollectorID` , `PaymentStatus` FROM `tblPayment` WHERE `tblPayment`.`PaymentID` =$PaymentID LIMIT 1";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query ");
	$row = mysqli_fetch_array($result);
	$PaymentID=$row['PaymentID'];
	$FamilyID=$row['FamilyID'];
	$DateTime=$row['Date'];
	$PaymentDate=$row['PaymentDate'];
	$PaymentType=$row['PaymentType'];
	$PaymentMethod=$row['PaymentMethod'];
	$PaymentIdentifier=$row['PaymentIdentifier'];
	$PayerInfo=$row['PayerInfo'];
	$Amount=$row['Amount'];
	$PaymentNote=$row['PaymentNote'];
	$CollectorID=$row['CollectorID'];
	$PaymentStatus=$row['PaymentStatus'];
	?>
<center>
<table width=500>
	<TR><th colspan=3>Payment Details</th></TR>
        <TR><th colspan=3><hr></th></TR>
	<TR><th align="left">Payment ID</th><td>&nbsp;</td><td><?php  echo $PaymentID?></td></tr>
	<TR><th align="left">Date Time Entered</th><td>&nbsp;</td><td><?php  echo $DateTime?></td></tr>
	<TR><th align="left">Family ID</th><td>&nbsp;</td><td><?php  echo $FamilyID?></td></tr>
	<TR><th align="left">Payment Type</th><td>&nbsp;</td><td><?php  echo $PaymentType?></td></tr>
	<TR><th align="left">Payment Method</th><td>&nbsp;</td><td><?php  echo $PaymentMethod;?></td></tr>
	<TR><th align="left">Payment Identifier<br>(check#)</th><td>&nbsp;</td><td><?php  echo $PaymentIdentifier;?></td></tr>
	<TR><th align="left">Payer Info</th><td>&nbsp;</td><td><?php  echo $PayerInfo;?></td></tr>
	<TR><th align="left">Amount</th><td>&nbsp;</td><td><?php  echo $Amount?></td></tr>
	<TR><th align="left">Date Received</th><td>&nbsp;</td><td><?php  echo $PaymentDate?></td></tr>
	<TR><th align="left">Note</th><td>&nbsp;</td><td><?php  echo $PaymentNote?></td></tr>
	<TR><th align="left">Collector ID</th><td>&nbsp;</td><td><?php  echo $CollectorID?></td></tr>
	<TR><th align="left">Payment Status</th><td>&nbsp;</td><td><?php  echo $PaymentStatus?></td></tr>

	<?php
	CloseTable();
   ?>
    <a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewAdd&FamilyID=<?php echo $row['FamilyID'];?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE;?>" >[Make Another Payment]</a>
    <a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=SearchReceivable&FamilyID=<?php echo $row['FamilyID'];?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE;?>" >[Locate Another Family]</a>
	<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewFamily&FamilyID=<?php echo $row['FamilyID'];?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE;?>" >[Back to Receivables]</a>
   <?php
}


function PaymentViewAdd()
{

	$ReceivablesToPay="";
	//echo $_POST['ReceivableID'];
	if(is_array($_POST['ReceivableID']))
	{
		while (list($key, $val) = each($_POST['ReceivableID']))
		{
			if ($ReceivablesToPay =="")
			{
				$ReceivablesToPay="$val";
			}else{
				$ReceivablesToPay="$val".",".$ReceivablesToPay;
			}
		}
		$query = 'SELECT sum(Amount) PayTotal FROM `tblReceivable` WHERE ID in ('.$ReceivablesToPay.') limit 1';
		if ( $result = mysqli_query(GetDBConnection(),$query) )
		{
			$row = mysqli_fetch_array($result);
			$PayTotal=$row['PayTotal'];
		}
	} else {
	  $box=$_POST['ReceivableID'];

	  while (list ($key,$val) = @each ($ReceivableID)) {
  	      echo "$val,";
      }
	}
	if ( $_REQUEST['AddNextPayment'] =="YES" )
	{
		$PayFamilyID="";
	}else
	{
		$PayFamilyID=$_REQUEST['FamilyID'];
	}

	?>
	<hr><br>Paying for The following Item:
        <?php   ReceivableViewOnly($ReceivablesToPay);  ?>
	<br>Total: <?php  echo $PayTotal;?>
	<?php 	OpenTable(); ?>
	<form action="<?php  echo $_SERVER['PHP_SELF'] ?>?mainmenu=<?php echo $_REQUEST['mainmenu'];?>" method="post">
	<input type="hidden" name="op" value="PaymentDoAdd">
	<input type="hidden" name="ReceivablesToPay" value="<?php echo $ReceivablesToPay?>">
	<tr><td >
	</td></tr>
	<TR><th align="right">Family ID<font color="red">*</font></th>
	<td><input type=text name="FamilyID" value="<?php  echo $PayFamilyID; ?>"></td></tr>
	<TR><th align="right">Payment Type</th>
	<td>
	<INPUT TYPE=radio NAME=PaymentType VALUE="Fees" checked>Fees Due<br>
	<INPUT TYPE=radio NAME=PaymentType VALUE="Donation">Donation
	</td>
	</tr>
	<TR><th align="right">Payment Method</th>
	<td>
	<INPUT TYPE=radio NAME=PaymentMethod VALUE="Check" checked>Check<br>
	<INPUT TYPE=radio NAME=PaymentMethod VALUE="Cash">Cash<br>
	</td>
	</tr>

	<TR><th align="right">Payment Identifier <br>(check number)</th>
	<td><input type=text name="PaymentIdentifier" value=""></td></tr>

	<TR><th align="right">PayerInfo</th>
	<td><input type=text name="PayerInfo" value=""></td></tr>

	<TR><th align="right">Amount<font color="red">*</font></th>
	<td><input type=text name="Amount" value="<?php  echo $PayTotal;?>"></td></tr>

	<TR><th align="right">Received/Postmark Date<font color="red">*</font></th>
	<td><input type=text name="PaymentDate" value=""> (yyyy-mm-dd)</td></tr>


	<TR><th align="right">PaymentNote</th>
	<td><input type=text name="PaymentNote" value=""></td></tr>
	<TR><th align="right">Collector</th>
	<td><?php  echo $_SESSION['logon'];?></td></tr>

	<TR><th align="right">PaymentStatus</th>
	<td><input type=text name="PaymentStatus" value="Received"></td></tr>
<?php
	if ($_REQUEST['FamilyID'] == "" OR $_REQUEST['AddNextPayment'] =="YES" )
	{
?>
	<tr><td colspan=2>Check to add next payment: <input type="checkbox" name="AddNextPayment" value="YES" checked></td></tr>
<?php
	}
?>

	<TR><td colspan=2><input type=reset name=reset value=clear>
	<input type=submit name=submit value=Save>
	<?php if (isset($_REQUEST[FamilyID]) && $_REQUEST[FamilyID] !="") {
	      include("../common/CommonParam/params.php");
	?>
	<input type=button name=cancel value=Cancel onclick="window.location.href='index.php?view=ReceivableViewFamily&FamilyID=<?php echo $_REQUEST[FamilyID]; ?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE; ?>'"></td></tr>
	<?php } else { ?>
	<input type=button name=cancel value=Cancel onclick="window.location.href='index.php?view=SearchReceivable'"></td></tr>
	<?php } ?>
	</td></tr>
    </form>
	<?php
	CloseTable();
}


function PaymentViewEdit()
{
	$PaymentID=$_GET['PaymentID'];
	$query="SELECT `PaymentID` , `FamilyID`,`Date` , PaymentDate, `PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` ,
`Amount`, `PaymentNote` , `CollectorID` , `PaymentStatus` FROM `tblPayment` WHERE `tblPayment`.`PaymentID` =$PaymentID LIMIT 1";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query ");
	$row = mysqli_fetch_array($result);
	$PaymentID=$row['PaymentID'];
	$FamilyID=$row['FamilyID'];
	$DateTime=$row['Date'];
	$PaymentDate=$row['PaymentDate'];
	$PaymentType=$row['PaymentType'];
	$PaymentMethod=$row['PaymentMethod'];
	$PaymentIdentifier=$row['PaymentIdentifier'];
	$PayerInfo=$row['PayerInfo'];
	$Amount=$row['Amount'];
	$PaymentNote=$row['PaymentNote'];
	$CollectorID=$row['CollectorID'];
	$PaymentStatus=$row['PaymentStatus'];
	$feeschecked="";
	if ($PaymentType == "Fees")
	{$feeschecked="checked";
		}
	$donationchecked="";
		if ($PaymentType == "Donation")
	{$donationchecked="checked";
		}
		$CheckChecked="";
	if ($PaymentMethod == "Check")
	{$CheckChecked="checked";
		}
	$CashChecked="";
	if ($PaymentMethod == "Cash")
	{$CashChecked="checked";
		}
		OpenTable();
	?>
	<form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post">
	<input type="hidden" name="op" value="PaymentDoEdit">
	<input type="hidden" name="PaymentID" value="<?php  echo $PaymentID;?>">
	<TR><th align="right">Family ID</th>
	<td><input type=text name="FamilyID" value="<?php  echo $FamilyID;?>"></td></tr>
	<TR><th align="right" valign="top">Payment Type</th>
	<td valign="top">
	<INPUT TYPE=radio NAME=PaymentType VALUE="Fees" <?php  echo $feeschecked;?>>Fees Due<br>
	<INPUT TYPE=radio NAME=PaymentType VALUE="Donation" <?php  echo $donationchecked;?>>Donation
	</td>
	</tr>
	<TR><th align="right" valign="top">Payment Method</th>
	<td valign="top">
	<INPUT TYPE=radio NAME=PaymentMethod VALUE="Check" <?php  echo $CheckChecked;?>>Check<br>
	<INPUT TYPE=radio NAME=PaymentMethod VALUE="Cash" <?php  echo $CashChecked;?>>Cash<br>
	</td>
	</tr>

	<TR><th align="right">Payment Identifier <br>(check number)</th>
	<td><input type=text name="PaymentIdentifier" value="<?php  echo $PaymentIdentifier;?>"></td></tr>

	<TR><th align="right">PayerInfo</th>
	<td><input type=text name="PayerInfo" value="<?php  echo $PayerInfo;?>"></td></tr>

	<TR><th align="right">Amount</th>
	<td><input type=text name="Amount" value="<?php  echo $Amount;?>"></td></tr>
	<TR><th align="right">Received/Postmark Date</th>
	<td><input type=text name="PaymentDate" value="<?php  echo $PaymentDate;?>"> (yyyy-mm-dd)</td></tr>

	<TR><th align="right">PaymentNote</th>
	<td><input type=text name="PaymentNote" value="<?php  echo $PaymentNote;?>"></td></tr>

	<TR><th align="right">CollectorID</th>
	<td><input type=text name="CollectorID" value="<?php  echo $CollectorID;?>"></td></tr>

	<TR><th align="right">PaymentStatus</th>
	<td><input type=text name="PaymentStatus" value="<?php  echo $PaymentStatus;?>"></td></tr>

	<TR><td colspan=2><input type=reset name=reset value=clear>
	<input type=submit name=submit value=Save></td></tr>
    </form>
	<?php
	CloseTable();
}

function PaymentDoAdd()
{
	$FamilyID=$_POST['FamilyID'];
	$PaymentDate=$_POST['PaymentDate'];
	$msg = validatePaymentDate($PaymentDate);
	if ( $msg != "" ) {
	  return $msg . "<A HREF=\"javascript:javascript:history.go(-1)\">Back</A>";
	}

	$PaymentType=$_POST['PaymentType'];
	$PaymentMethod=$_POST['PaymentMethod'];
	$PaymentIdentifier=$_POST['PaymentIdentifier'];
	$PayerInfo=$_POST['PayerInfo'];
	$Amount=$_POST['Amount'];
	$PaymentNote=$_POST['PaymentNote'];
	//$CollectorID=$_POST['CollectorID'];
	$PaymentStatus=$_POST['PaymentStatus'];
	$Receivables=$_POST['ReceivablesToPay'];
        $SessionUserName=$_SESSION['logon'];
$query="select MemberID from tblMember where UserName='$SessionUserName'";
$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query ");
$row = mysqli_fetch_array($result);
$CollectorID=$row['MemberID'];

 $query = "insert into  `tblPayment`(`FamilyID`,`Date`,PaymentDate, `PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` , `Amount`,`PaymentNote` , `CollectorID` , `PaymentStatus` ) "
          ."values ('$FamilyID',now(),'$PaymentDate',	'$PaymentType','$PaymentMethod',	'$PaymentIdentifier',	'$PayerInfo',	'$Amount',	'$PaymentNote',	'$CollectorID',	'$PaymentStatus')";
	$result = mysqli_query(GetDBConnection(),$query) or die ("ERROR inserting into table<br>Debug info: make sure entered values are valid and correct <br><A HREF=\"javascript:javascript:history.go(-1)\">Back</A>\n");
        
        echo "<br><br><a href=\"index.php?view=ViewFamilyAccount&FamilyID=$FamilyID&familyid=$FamilyID&mainmenu=off\">Continue</a>";

//	$PaymentID=mysql_insert_id(GetDBConnection());
//	print "<h2>Payment Entry Result</h2><hr>";
//	print "<br>Payment Entry was successfully added. <br>Paymebt ID: ".$PaymentID."<br>";
	// $query = "insert into  `tblReceivablePayRecord`(`DateTime`,`ReceivableID` , `PaymentID`) select  now(),	IncomeID, $PaymentID from tblIncome where IncomeID in (".$Receivables.")";
	// $result = mysqli_query(GetDBConnection(),$query) or die ("died while inserting to table<br>Debug info: $query");
	// print "Payment Entry Applied to Account.<br>";
//	PaymentViewOneByID($PaymentID);
	if ($_POST['AddNextPayment']=="YES")
	{
		PaymentViewAdd();
	}
	$msg="";
	return $msg;
}

function PaymentDoEdit()
{
	$PaymentID=$_POST['PaymentID'];
	$FamilyID=$_POST['FamilyID'];
	$PaymentType=$_POST['PaymentType'];
	$PaymentDate=$_POST['PaymentDate'];
	$PaymentMethod=$_POST['PaymentMethod'];
	$PaymentIdentifier=$_POST['PaymentIdentifier'];
	$PayerInfo=$_POST['PayerInfo'];
	$Amount=$_POST['Amount'];
	$PaymentNote=$_POST['PaymentNote'];
	$CollectorID=$_POST['CollectorID'];
	$PaymentStatus=$_POST['PaymentStatus'];

 $query = "UPDATE `tblPayment` SET `FamilyID`='$FamilyID',`Date` = NOW(),PaymentDate='$PaymentDate',`PaymentType`='$PaymentType' , `PaymentMethod`='$PaymentMethod' , `PaymentIdentifier` ='$PaymentIdentifier', `PayerInfo` ='$PayerInfo', `Amount` = '$Amount' ,`PaymentNote` ='$PaymentNote',`CollectorID`='$CollectorID',`PaymentStatus`='$PaymentStatus' WHERE `tblPayment`.`PaymentID` =$PaymentID LIMIT 1 ";

	$result = mysqli_query(GetDBConnection(),$query) or die ("died while updating table<br>Debug info: $query");
//msg = "Entry was successfully Edited.";
//eturn $msg;

//  header('Location: index.php?view=ViewFamilyAccount&familyid='. $FamilyID .'&mainmenu=off');
echo "<br><br><a href=\"index.php?view=ViewFamilyAccount&FamilyID=$FamilyID&familyid=$FamilyID&mainmenu=off\">Continue</a>";
}

function validatePaymentDate($date)
{
    // assume $date is "yyyy-mm-dd"
    $year = strtok( $date  , "-"  );
    $mm   = strtok("-");
    $dd   = strtok("-");

    if ( checkdate( $mm  , $dd , $year)  ) {
       return "";
    } else {
       return "payment date is not valid ";
    }
}


?>
