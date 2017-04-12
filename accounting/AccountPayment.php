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
		    <th align="left" >ID</th>
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

	$payment_beg_date="2010-07-01";
    if ( isset($_GET[beg_date]) && strlen($_GET[beg_date]) == 10 ) {
        $payment_beg_date=$_GET[beg_date];
    }

    $payment_end_date="2011-07-01";
	    if ( isset($_GET[end_date]) && strlen($_GET[end_date]) == 10 ) {
	        $payment_end_date=$_GET[end_date];
    }
        print "<center><hr><h3>All Payment Collected <br>between $payment_beg_date and $payment_end_date <br>";
        if (strlen ($_GET[cid]) > 0 ) {
           print " by collector ".$_GET[cid];
        } else {
           print "by all collectors";
        }
        print "</h3><hr>";
    //    print "<br>Your information:";
    //    print "<br>session user: $SessionUserName";
    //    print "<br>MemberID: $CollectorID<hr>";
	$query="SELECT `PaymentID` , `Date` ,PaymentDate, `FamilyID`,`PaymentType` , `PaymentMethod` , `PaymentIdentifier` , `PayerInfo` ,
		`Amount`, `PaymentNote` , `CollectorID` , `PaymentStatus` FROM `tblPayment` where `Date`>'".$payment_beg_date.
		"' and Date < '".$payment_end_date."'";
	if ( strlen ($_GET[cid]) > 0 ) {
		$query .= " and CollectorID =".$_GET[cid];
	}
		$query .= " order by `CollectorID`,`Date`";
	//echo $query;
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query $query ");
	$TotalAmount=0;
		?>
		<table border=1>
		<tr>
		    <th align="left" >&nbsp;</th>
		    <th align="left" >ID</th>
			<th align="left" >Entry Date</th>
			<th align="left" >Receive Date</th>
			<th align="left" >Payer</th>
			<th align="left" >Family</th>
			<th align="left" >Type</th>
			<th align="left" >Check #</th>
			<th align="left" >Amount</th>
			<th align="left" >Method</th>
            <th align="left" >Note</th>
            <th align="left" >Collector</th>
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
			<td align="left" ><?php  echo $row['PaymentDate'] ;?></td>
			<td align="left" ><?php echo $row['PayerInfo'];?></td>
		        <td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['PaymentType'];?></td>
			<td align="left" ><?php echo $row['PaymentIdentifier'];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php echo $row['PaymentMethod'];?></td>
                        <td align="left" ><?php  echo $row['PaymentNote'];?></td>
            <td align="left" ><?php  echo $row['CollectorID'];?></td>
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
