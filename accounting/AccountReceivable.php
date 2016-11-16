<?php


require_once("../common/DB/DataStore.php");

function SearchReceivable()
{
        $ShowNotPaid="";
        $ShowAll="checked";
        $ShowPaid="";
if ($_POST['paymentstatus']=="Paid Only" ){$ShowPaid="checked";$ShowNotPaid="";$ShowAll=""; }
if ($_POST['paymentstatus']=="Not Paid" ){$ShowPaid="";$ShowNotPaid="checked";$ShowAll=""; }
if ($_POST['paymentstatus']=="All") {$ShowPaid="";$ShowNotPaid="";$ShowAll="checked";}
	?>
<hr>
<table border=0>
	<tr><td><form action="<?php  echo $_SERVER['PHP_SELF'] ?>?view=SearchReceivable" method="post">
<BR> By Last Name<input type=text name=searchLastName value="<?php echo $_POST['searchLastName'] ?>">
<BR>By FamilyID <input type=text name=searchFamilyID value="<?php echo $_POST['searchFamilyID'] ?>">

		<!-- br>Option :
		<input type=radio name=paymentstatus value="Paid Only" <?php echo $ShowPaid; ?>>Paid Only
		<input type=radio name=paymentstatus value="Not Paid" <?php echo $ShowNotPaid; ?> >Not Paid
		<input type=radio name=paymentstatus value="All" <?php echo $ShowAll; ?>>All  -->
		<BR><input type=submit name=submit value=Search>
    </form></td></tr>
</table><hr>
	<?php
	$paymentstatusfilter="1=1";
        // default: $ShowNotPaid=="checked";
	//$paymentstatusfilter="not exists (select rpr.receivableid from tblReceivablePayRecord rpr where rpr.ReceivableID=i.incomeid ) ";
	$searchfilter="1=1";
	if ( $ShowAll =="checked")
	{
		$paymentstatusfilter="1=1";
	}elseif ( $ShowPaid=="checked")
	{
		$paymentstatusfilter="  exists (select rpr.receivableid from tblReceivablePayRecord rpr where rpr.ReceivableID=i.incomeid )   ";
		}

 if ( (!isset($_POST['searchLastName']) ||  $_POST['searchLastName']== "") &&
      (!isset($_POST['searchFamilyID']) ||  $_POST['searchFamilyID']== "") ) {
      return;
 }

	if ( $_POST['searchLastName']  != "")
	{
		$searchfilter="  lastname='".$_POST['searchLastName']." ' ";
		}

        if ( $_POST['searchFamilyID']  != "")
	{
		$searchfilter=" t.FamilyID=".$_POST['searchFamilyID']." ";
	}

include("../common/CommonParam/params.php");

	$query="SELECT t.MemberID, FirstName, LastName,t.FamilyID, sum(amount) amount, ic.IncomeCategory Description
FROM tblMember t
left outer join tblReceivable  i on t.MemberID= i.MemberID
left outer join tblIncomeCategory ic on ic.IncomeCategoryID=i.IncomeCategory
where i.DateTime>'".$PAST_BALANCE_DATE."' and  $paymentstatusfilter  and ".$searchfilter."
group by t.MemberID, FirstName, LastName,t.FamilyID, ic.IncomeCategory
order by LastName,t.FamilyID,FirstName LIMIT 0,2000";
//  left outer join tblReceivablePayRecord rpr on i.incomeID= rpr.ReceivableID

//print $query;
//familyid in (SELECT distinct FamilyID from tblMember where ".$searchfilter.")

	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query  ".$query);
	?>
		<table border=1>
		<tr>
		    <th align="left" >Action</th>
		    <th align="left" >LastName</th>
			<th align="left" >FirstName</th>
			<th align="left" >Member ID</th>
			<th align="left" >Family ID</th>
			<th align="left" >Amount</th>
			<th align="left" >Description</th>
                     <!-- th>PaymentID</th -->
			</tr>
	<?php
//	include("../common/CommonParam/params.php");
	$prevfamily="";
	while($row = mysqli_fetch_array($result)){
		?>
		<tr>
			<td nowrap>
			<?php if ($prevfamily!=$row['FamilyID']){
				$prevfamily=$row['FamilyID'];
			?>
<a href="<?php  echo "../MemberAccount/FeePaymentVoucher_byadmin.php"; ?>?fid=<?php echo $row['FamilyID'];?>" >[Payment Voucher]</a><br>
<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewAdd&FamilyID=<?php echo $row['FamilyID'];?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE;?>" >[Make Payment]</a><br>
<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewFamily&FamilyID=<?php echo $row['FamilyID'];?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE;?>" >[Receivables]</a><br>

			<?php  }else {?>
			&nbsp;
			<?php  } ?>
			</td>
		    <td align="left" >&nbsp;<?php echo $row['LastName'];?></td>
			<td align="left" >&nbsp;<?php echo $row['FirstName'];?></td>
			<td align="left" >&nbsp;<?php echo $row['MemberID'];?></td>
			<td align="left" >&nbsp;<?php echo $row['FamilyID'];?></td>
			<td align="left" >&nbsp;<?php echo $row['amount'];?></td>
			<td align="left">&nbsp;<?php echo $row['Description'];?></td>
			<!-- td align="left">&nbsp;<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewOne&PaymentID=<?php echo $row['paymentid'];?>">
<?php echo $row['paymentid'];?></a></td -->
			</tr>
		<?php
		}
	CloseTable();
	?>

<?php
}

function ReceivableViewAdd()
{
	OpenTable();
	$ClassID=$_GET['ClassID'];
	$CRegID=$_GET['CRegID'];
	if ( !isset($ClassID) || strlen($ClassID) ==0 ) {
	   $ClassID = '0';
	}
	if ( !isset($CRegID) || strlen($CRegID) ==0 ) {
		   $CRegID = '0';
	}

	include("../common/CommonParam/params.php");

	$query="SELECT IncomeCategoryID, IncomeCategory from tblIncomeCategory order by IncomeCategory";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query ");
	//$row = mysqli_fetch_array($result);

	?>
	<form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post">
	<input type="hidden" name="op" value="ReceivableDoAdd">
	<input type="hidden" name="ReceivableID" value="">
	<TR><th align="right">Receivable Type</th>
	<td>
        <?php 
	     while($row = mysqli_fetch_array($result))
             {
	        echo "<INPUT TYPE=\"RADIO\" NAME=\"ReceivableType\" VALUE=\"$row[IncomeCategoryID]:$row[IncomeCategory]\" checked>$row[IncomeCategory]<BR>";
             }
         ?>
<!--
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_Language" checked>Tuition - Language<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_Art" >Tuition - Art<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_Dance" >Tuition - Dance<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_Chess" >Tuition - Chess<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_Math" >Tuition - Math<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_MartialArts" >Tuition - Martial Arts<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Tuition_PerformanceArts" >Tuition - Performance Arts<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Membership">Membership<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Registration">Registration<BR>
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="SafetyPatrol">Safety Patrol<BR>
-->
	<INPUT TYPE="RADIO" NAME="ReceivableType" VALUE="Other">
	<INPUT TYPE="TEXT"   NAME="ReceivableTypeValue"   value="Specify" >Other<BR>
	</td>
	</tr>

	<TR><th align="right">MemberID</th>
	<td><input type=text name="MemberID" value="<?php  echo $_GET['MemberID']; ?>"></td></tr>

	<TR><th align="right">Amount</th>
	<td><input type=text name="Amount" value="<?php  echo (0 - $_GET['Amount']); ?>"></td></tr>

	<TR><th align="right">Family ID</th>
	<td><input type=text name="FamilyID" value="<?php  echo $_GET['FamilyID']; ?>"></td></tr>

	<TR><th align="right">Class ID</th>
	<td><input type=text name="ClassID" value="<?php  echo $ClassID; ?>"><a href="../MemberAccount/OpenSeats.php" target=_blank> (Classes List)</a></td></tr>
	<TR><th align="right">Class Reg ID</th>
	<td><input type=text name="ClassRegID" value="<?php  echo $CRegID; ?>"></td></tr>

	<TR><th align="right">Description</th>
	<td><input type=text name="Description" value="<?php  echo $_GET['Desc']; ?>"></td></tr>

	<TR><td colspan=2><input type=reset name=reset value=clear>
	<input type=submit name=submit value=Save>
	<input type=button name=cancel value=Cancel onclick="window.location.href='index.php?view=ReceivableViewFamily&FamilyID=<?php echo $_REQUEST[FamilyID]; ?>&mainmenu=off&date=<?php echo $PAST_BALANCE_DATE; ?>'"></td></tr>
    </td></tr>
    </form>
	<?php
	CloseTable();
}

function ReceivableViewEdit()
{
	//	$PaymentID=$_GET['PaymentID'];
	$ReceivableID=$_GET['ReceivableID'];
	$query="SELECT `ReceivableID` , `DateTime` , `MemberID`,`ReceivableType` , `FamilyID` , `ClassID` ,
`Amount` , `Description` FROM `tblReceivable` WHERE `ReceivableID`=$ReceivableID LIMIT 1";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query ");
	$row = mysqli_fetch_array($result);
	$ReceivableID=$row['ReceivableID'];
	$DateTime=$row['DateTime'];
	$MemberID=$row['MemberID'];
	$ReceivableType=$row['ReceivableType'];
	$FamilyID=$row['FamilyID'];
	$ClassID=$row['ClassID'];
	$Amount=$row['Amount'];
	$Description=$row['Description'];

		$TuitionChecked="";
	if ($ReceivableType == "Tuition")
	{$TuitionChecked="checked";
		}
	$MembershipChecked="";
	if ($ReceivableType == "Membership")
	{$MembershipChecked="checked";
		}
		OpenTable();
	?>
	<form action="<?php  echo $_SERVER['PHP_SELF'] ?>" method="post">
	<input type="hidden" name="op" value="ReceivableDoEdit">
	<input type="hidden" name="ReceivableID" value="<?php  echo $ReceivableID;?>">
	<TR><th align="right">Member ID</th>
	<td><input type=text name="MemberID" value="<?php  echo $MemberID;?>"></td>
	<td><input type=text name="FamilyID" value="<?php  echo $FamilyID;?>"></td>
	</tr>
	<TR><th align="right" valign="top">Receivable Type</th>
	<td valign="top">
	<INPUT TYPE=radio NAME=ReceivableType VALUE="Tuition" <?php  echo $TuitionChecked;?>>Tuition<br>
	<INPUT TYPE=radio NAME=ReceivableType VALUE="Membership" <?php  echo $MembershipChecked;?>>Membership
	</td>
	</tr>

	<TR><th align="right">Family ID</th>
	<td><input type=text name="StudentID" value="<?php  echo $FamilyID;?>"></td></tr>

	<TR><th align="right">Class ID</th>
	<td><input type=text name="ClassID" value="<?php  echo $ClassID;?>"></td></tr>

	<TR><th align="right">Amount</th>
	<td><input type=text name="Amount" value="<?php  echo $Amount;?>"></td></tr>

	<TR><th align="right">Description</th>
	<td><input type=text name="Description" value="<?php  echo $Description;?>"></td></tr>

	<TR><td colspan=2><input type=reset name=reset value=clear>
	<input type=submit name=submit value=Save></td></tr>
    </form>
	<?php
	CloseTable();
}
function ReceivableViewOnly($ReceivablesToPay)
{ 	// echo "<br>".$ReceivablesToPay."<br>\n";
      	if ( strlen($ReceivablesToPay)>0)
	{
		$query="SELECT r.`ID` ReceivableID , r.`DateTime` ,r. `MemberID`,r.`FamilyID`,FirstName,LastName,`Amount` , `Description`
			FROM `tblReceivable` r
  			join tblMember t on  t.MemberID=r.MemberID
			WHERE  r.ID in ($ReceivablesToPay) ";

  			// left outer join tblReceivablePayRecord rpr on r.ReceivableID= rpr.ReceivableID

	$result = mysqli_query(GetDBConnection(),$query) or Die  ("<br>Failed to query  $query<br>\n");
	?>
	<table border=1>

		<tr>
		    <th align="left" >ID</th>
			<th align="left" >Date</th>
			<th align="left" >Member ID</th>
			<th align="left" >Family ID</th>
			<th align="left" >Name</th>
			<th align="left" >Amount</th>
			<th align="left" >Description</th>
			</tr>
			<?php
			while($row = mysqli_fetch_array($result))
		{
		?>
			<tr>
		    <td align="left" ><?php echo $row['ReceivableID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="left" ><?php echo $row['MemberID'];?></td>
			<td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['FirstName']."  ".$row["LastName"];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php echo $row['Description'];?></td>
			<td align="left" >&nbsp;<?php echo $row['paymentid'];?></td>
			</tr>
		<?php
		}
			CloseTable();
	}
}

function PaymentViewOnlyFamily($ViewFamilyID)
{
	if (! FamilyAccessCheck())
	{
		echo "<h1>Invalid Account info Access</h1>\n";
		return 0;
	}
        $query=  "SELECT p.`PaymentID` ID, p.`Date` DateTime,p.`FamilyID` FamilyID,PayerInfo ,p.`Amount`, `PaymentNote` Description  FROM `tblPayment` p
  WHERE p.FamilyID='".$ViewFamilyID."' and p.date>'2008-07-01'   order by ID ";

	$result = mysqli_query(getdbconnection(),$query)  or Die ("Failed to query  $query ");
		?>
		<h2>Payment for Family <?php  echo $ViewFamilyID; ?></h2>
		<table border=1>
		<tr>
		    <th align="center" >PaymentID</th>
			<th align="left" >Date</th>
			<th align="left" >Family ID</th>
			<th align="left" >Member ID</th>
			<th align="left" >Payer</th>
			<th align="left" >Amount</th>
			<th align="left" >Description</th>
			</tr>
		<?php
		$TotalAmount=0;
		while($row = mysqli_fetch_array($result))
		{
			$TotalAmount +=$row['Amount'];
		?>
			<tr>
		        <td align="right" ><?php echo $row['ID'];?>
			<?php   showViewlink($row['ID']); ?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="right" ><?php echo $row['FamilyID'];?></td>
			<td align="right" >&nbsp;</td>
			<td align="left" ><?php echo $row['PayerInfo'];?></td>
			<td align="right" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php  echo $row['Description'];?></td>
			</tr>

		<?php
	       }
		?>
	<TR><td  colspan=4>&nbsp;</td>
	<td> Total: </td><td colspan=2 align="right"><?php echo $TotalAmount ?></td>
	</tr>
	<?php
	CloseTable();
}

function ViewFamilyAccount($ViewFamilyID)
{
	if (! FamilyAccessCheck())
	{
		echo "<h1>Invalid Account info Access</h1>\n";
		return 0;
	} ?>
    <a href="index.php?view=SearchReceivable">[Payment Management Home]</a>
	<a href="index.php?view=SearchReceivable">[Another Family]</a>
	<?php
    echo "<a href=\"". $_SERVER['PHP_SELF']."?view=ReceivableViewFamily&FamilyID=". $ViewFamilyID ."&mainmenu=off\">[View All Receivables]</a>";
    ?>
		<h2>Family Account Summary for <?php  echo $ViewFamilyID; ?></h2>
		<table border=1>
		<tr>
		    <th align="right" >ID</th>
			<th align="left" >Date Recorded</th>
			<th align="left" >Date Received</th>
			<th align="left" >FID</th>
			<th align="left" >MID</th>
			<th align="left" >Name/Info</th>
			<th align="left" >Bill</th>
			<th align="left" >Payment</th>
			<th align="left" >Desc</th>
			<th align="right" >Running Balance</th>
			</tr>
<?php
	$TotalAmount=0;
        $running_balance = 0.00;
        $query=  "SELECT r.`ID` , r.`DateTime` ,r. `MemberID`,t.`FamilyID` FamilyID,FirstName,LastName,r.`Amount`, `Description`  FROM `tblReceivable` r
  join tblMember t on  t.MemberID=r.MemberID
  WHERE t.FamilyID='".$ViewFamilyID."'      order by LastName,FirstName,r.DateTime,Description ";

	$result = mysqli_query(getdbconnection(),$query)  or Die ("Failed to query  $query ");
		while($row = mysqli_fetch_array($result))
		{
			$TotalAmount +=$row['Amount'];
                        $running_balance += $row['Amount'];
		?>
			<tr>
		        <td align="right" ><?php echo $row['ID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td>&nbsp;</td>
			<td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['MemberID'];?></td>
			<td align="left" ><?php echo $row['FirstName']." ".$row['LastName'];?></td>
			<td align="right" ><?php  echo $row['Amount'];?></td>
			<td align="right" >&nbsp;</td>
			<td align="left" ><?php  echo $row['Description'];?></td>
			<td align="right" ><?php  echo $running_balance;?></td>
			</tr>

		<?php
	       }
        $query=  "SELECT p.`PaymentID` ID, p.`Date` DateTime,p.PaymentDate, p.`FamilyID` FamilyID,PayerInfo ,p.`Amount`, `PaymentNote` Description  FROM `tblPayment` p
  WHERE p.FamilyID='".$ViewFamilyID."'      order by ID ";

	$result = mysqli_query(getdbconnection(),$query)  or Die ("Failed to query  $query ");
		while($row = mysqli_fetch_array($result))
		{
			$TotalAmount -=$row['Amount'];
                        $running_balance -= $row['Amount'];
		?>
			<tr>
		        <td align="right" > <?php echo $row[ID]."<br>";  showViewlink($row['ID']); //showeditlink($row['ID']);?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="left" ><?php  if ( $row['PaymentDate'] != "0000-00-00" ) { echo $row['PaymentDate'];} else { echo "&nbsp;"; } ?></td>
			<td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" >&nbsp;</td>
			<td align="left" ><?php echo $row['PayerInfo'];?></td>
			<td align="right" >&nbsp;</td>
			<td align="right" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php  echo $row['Description'];?></td>
			<td align="right" ><?php  echo $running_balance; //showdeletelink($row['ID']);?></td>
			</tr>

		<?php
	       }
		?>
	<TR><td  colspan=5>&nbsp;</td>
	<td>Balance: </td><td colspan=2 align="right"><?php echo $TotalAmount ?></td>
	</tr>
	<?php
	CloseTable();
}

function ReceivableViewOnlyFamily($ViewFamilyID)
{
	if (! FamilyAccessCheck())
	{
		echo "<h1>Invalid Account info Access</h1>\n";
		return 0;
	}
        $query=  "SELECT r.`ID` , r.`DateTime` ,r. `MemberID`,t.`FamilyID` FamilyID,FirstName,LastName,r.`Amount`, `Description`  FROM `tblReceivable` r
  join tblMember t on  t.MemberID=r.MemberID
  WHERE t.FamilyID='".$ViewFamilyID."'    order by LastName,FirstName,Description ";

	$result = mysqli_query(getdbconnection(),$query)  or Die ("Failed to query  $query ");
		?>
		<h2>Receivable for Family <?php  echo $ViewFamilyID; ?></h2>
		<table border=1>
		<tr>
		    <th align="left" >Receivable ID</th>
			<th align="left" >Date</th>
			<th align="left" >Family ID</th>
			<th align="left" >Member ID</th>
			<th align="left" >Name</th>
			<th align="left" >Amount</th>
			<th align="left" >Description</th>

			</tr>
		<?php
		$TotalAmount=0;
		while($row = mysqli_fetch_array($result))
		{
			$TotalAmount +=$row['Amount'];
		?>
			<tr>
		        <td align="right" ><?php echo $row['ID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="right" ><?php echo $row['FamilyID'];?></td>
			<td align="right" ><?php echo $row['MemberID'];?></td>
			<td align="left" ><?php echo $row['FirstName']." ".$row['LastName'];?></td>
			<td align="right" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php  echo $row['Description'];?></td>
			</tr>

		<?php
	       }
		?>
	<TR><td  colspan=4>&nbsp;</td>
	<td> Total: </td><td colspan=2 align="right"><?php echo $TotalAmount ?></td>
	</tr>
	<?php
	CloseTable();
}


function ReceivableViewFamily()
{
include("../common/CommonParam/params.php");
	if (! FamilyAccessCheck())
	{
		echo "<h1>Invalid Account info Access</h1>\n";
		return 0;
	}
	if ( isset($_GET[date]) && $_GET[date] != "" ) {
	  $date = " and r.DateTime>'".$_GET[date]."' ";
	  $dates= " since ".$_GET[date];
	} else {
	  $date = "";
	  $dates="";
	}
	//echo "date=$date";
    $query=  "SELECT r.`ID` , r.`DateTime` ,r. `MemberID`,t.`FamilyID` FamilyID,FirstName,LastName,r.`Amount`, `Description`, r.ClassID, r.ClassRegistrationID,r.createdByMemberID
        FROM `tblReceivable` r   join tblMember t on  t.MemberID=r.MemberID
       WHERE t.FamilyID='".$_GET['FamilyID']."' ".$date."    order by LastName,FirstName,r.DateTime, Description";
  // left join tblPayment p on p.FamilyID=r.FamiliID

	$result = mysqli_query(getdbconnection(),$query)  or Die ("Failed to query  $query ");
		?>
		<SCRIPT LANGUAGE="JavaScript">
        function checkAll(form){
		      for (var i = 0; i < 100; ++i) {
		         form.elements[i].checked = true;
		      }
        }
        function uncheckAll(form){
		      for (var i = 0; i < 100; ++i) {
		         form.elements[i].checked = false;
		      }
        }


     /*
		function checkAll(field)
		{
		for (i = 0; i < field.length; i++)
			field[i].checked = true ;
		}

		function uncheckAll(field)
		{
		for (i = 0; i < field.length; i++)
			field[i].checked = false ;
		}
       */
		</script>

        <a href="index.php?view=SearchReceivable">[Payment Management Home]</a>
		<a href="index.php?view=SearchReceivable">[Another Family]</a>
		<?php
		echo "<a href=\"". $_SERVER['PHP_SELF']."?view=ViewFamilyAccount&familyid=". $_GET['FamilyID']."&mainmenu=off\">[View Family Account Summary]</a>";
		?>
		<h3>Receivables for Family <?php  echo $_GET['FamilyID'].$dates; ?></h3>

		<table border=1>
		<tr>
		    <th align="center" >&nbsp;</th>
		    <th align="left" >Receiv. ID</th>
			<th align="left" >Date</th>
			<th align="left" >Member ID</th>
			<th align="left" >Family ID</th>
			<th align="left" >Name</th>
			<th align="left" >Amount</th>
			<th align="left" >Description</th>
			<th align="left" >ClassID</th>
			<th align="left" >CRegID</th>
			<th align="left" >By</th>
            <th align="left" >Adjust</th>
			</tr>
			<form name="ViewReceivable" action="<?php  echo $_SERVER['PHP_SELF'] ;?>?view=PaymentViewAdd&mainmenu=<?php echo $_REQUEST['mainmenu'];?>" method="post">

		<?php
		$TotalAmount=0;
		$saveamember="";
		while($row = mysqli_fetch_array($result))
		{
		    $saveamember=$row['MemberID'];
		?>
			<tr>
			<td align="center">
			<?php  if ($row['paymentid']>0) {?>
			Paid <?php  echo $row['paymentid'];?>
			<?php   showViewlink($row['paymentid']); }else{ $TotalAmount +=$row['Amount']; ?>
			<input type=checkbox name="ReceivableID[]" value=<?php echo $row['ID'];?> >
			<?php } ?>
			
			
			</td>
		    <td align="center" ><?php echo $row['ID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="center" ><?php echo $row['MemberID'];?></td>
			<td align="center" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['FirstName']." ".$row['LastName'];?></td>
			<td align="right" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php  echo $row['Description'];?></td>
			<td align="center" ><?php  echo $row['ClassID'];?>&nbsp;</td>
			<td align="center" ><?php  echo $row['ClassRegistrationID'];?>&nbsp;</td>
			<td align="center" ><?php  echo $row['createdByMemberID'];?>&nbsp;</td>
			<TD><a href="<?php  echo $_SERVER['PHP_SELF'];?>?view=ReceivableViewAdd&FamilyID=<?php echo $_GET['FamilyID']; ?>&MemberID=<?php echo $row['MemberID']; ?>&ClassID=<?php echo $row['ClassID']; ?>&CRegID=<?php echo $row['ClassRegistrationID']; ?>&Amount=<?php echo $row['Amount']; ?>&Desc=changed&mainmenu=<?php  echo $_GET['mainmenu']; ?>">Adjust</a>
			<a href="deleteReceivable.php?FamilyID=<?php echo $_GET['FamilyID'];?>&ReceivableID=<?php echo $row['ID'];?>&Confirmed=No">Delete</a>
			</td>
			</tr>

		<?php
	       }
		?>
	<TR><td  colspan=4>
			<input type=hidden name="FamilyID" value=<?php  echo $_GET['FamilyID']; ?> >
	<input type="button" name="CheckAll" value="Check All"
	onClick="checkAll(document.ViewReceivable)">
	<input type="button" name="UnCheckAll" value="Uncheck All"
	onClick="uncheckAll(document.ViewReceivable)">

	<!--<input type=reset name=reset value=clear>-->
	<input type=submit name=submit value=Pay></td>
	<td> Total: </td><td colspan=2 align="right"><?php echo $TotalAmount ?></td>
	<TD><a href="<?php  echo $_SERVER['PHP_SELF'];?>?view=ReceivableViewAdd&FamilyID=<?php echo $_GET['FamilyID']; ?>&MemberID=<?php echo $saveamember; ?>&mainmenu=<?php  echo $_GET['mainmenu']; ?>">Add Receivable Adjustment</a>
	</tr>
	</form>
	<?php
	CloseTable();
	echo "<p>Receivables are listed here. Selected item will be used to calculate payment total. Uncheck an item if not paying for now.</p>";
	if ($date != "" ) {
	echo "<a href=\"". $_SERVER['PHP_SELF']."?view=ReceivableViewFamily&FamilyID=". $_GET['FamilyID']."&mainmenu=off\">[View All Receivables]</a>";
    } else {
    echo "<a href=\"". $_SERVER['PHP_SELF']."?view=ReceivableViewFamily&FamilyID=". $_GET['FamilyID']."&mainmenu=off&date=".$PAST_BALANCE_DATE."\">[View Receivables since ".$PAST_BALANCE_DATE."]</a>";
    }
    //ViewFamilyAccount($_GET['familyid']);
    echo "<a href=\"". $_SERVER['PHP_SELF']."?view=ViewFamilyAccount&familyid=". $_GET['FamilyID']."&mainmenu=off\">[View Family Account Summary]</a>";
}

function ReceivableViewList()
{
$query="SELECT i.IncomeID ReceivableID, i.IncomeDate DateTime, i.PayeeMemberID MemberID, FirstName,LastName,i.Amount Amount , ic.IncomeCategory Description
FROM tblIncome i
join tblMember t on  t.MemberID=i.PayeeMemberID
LEFT JOIN tblIncomeCategory  ic ON ic.IncomeCategoryID = i.IncomeCategory
where i.IncomeDate>'2008-07-01'
order by LastName,FirstName,Description ";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query  ");
		?>
		<table border=1>
		<tr>
		    <th align="left" >&nbsp;</th>
		    <th align="left" >ID</th>
			<th align="left" >Date</th>
			<th align="left" >Member ID</th>
			<th align="left" >FirstName</th>
			<th align="left" >LastName</th>
			<th align="left" >Amount</th>
			<th align="left" >Description</th>
			</tr>
			<form action="<?php  echo $_SERVER['PHP_SELF'] ;?>?view=PaymentViewAdd" method="post">

		<?php
		while($row = mysqli_fetch_array($result))
		{
		?>
			<tr>
			<!-- <td><?php  echo ReceivableEditLink($row['ReceivableID']); ?>&nbsp;<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewOne&ReceivableID=<?php echo $row['ReceivableID'];?>">View</a></td> -->
			<td align="center"><input type=checkbox name="ReceivableID[]" value=<?php echo $row['ReceivableID'];?>></td>
		    <td align="left" ><?php echo $row['ReceivableID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="left" ><?php echo $row['MemberID'];?></td>
			<td align="left" ><?php echo $row['FirstName'];?></td>
			<td align="left" ><?php echo $row['LastName'];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
			<td align="left" ><?php  echo $row['Description'];?></td>

			</tr>

<?php
       }
	?>
	<TR><td ><input type=reset name=reset value=clear>
	<input type=submit name=submit value=Pay></td></tr>
	</form>
	<?php
	CloseTable();
	}

function ReceivableViewList_o()
{	$query="SELECT `ReceivableID` , `DateTime` , `MemberID`,`ReceivableType` , `FamilyID` , `ClassID` ,
`Amount` , `PaymentID`, `Description` FROM `tblReceivable` ";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query  ");
		?>
		<table border=1>
		<tr>
		    <th align="left" >&nbsp;</th>
		    <th align="left" >ID</th>
			<th align="left" >Date</th>
			<th align="left" >Member ID</th>
			<th align="left" >Type</th>
			<th align="left" >FamilyID</th>
			<th align="left" >ClassID</th>
			<th align="left" >PaymentID</th>
			<th align="left" >Amount</th>
			<th align="left" >PayNow</th>
			</tr>
			<form action="<?php  echo $_SERVER['PHP_SELF'] ;?>?view=PaymentViewAdd" method="post">

		<?php
		while($row = mysqli_fetch_array($result))
		{
		?>
			<tr>
			<td><?php  echo ReceivableEditLink($row['ReceivableID']); ?>&nbsp;<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewOne&ReceivableID=<?php echo $row['ReceivableID'];?>">View</a></td>
		    <td align="left" ><?php echo $row['ReceivableID'];?></td>
			<td align="left" ><?php  echo date( 'Y-m-d H:i',strtotime($row['DateTime'] ));?></td>
			<td align="left" ><?php echo $row['MemberID'];?></td>
			<td align="left" ><?php echo $row['ReceivableType'];?></td>
			<td align="left" ><?php echo $row['FamilyID'];?></td>
			<td align="left" ><?php echo $row['ClassID'];?></td>
			<td align="left" ><?php echo $row['PaymentID'];?></td>
			<td align="left" ><?php  echo $row['Amount'];?></td>
			<td align="center"><input type=checkbox name="ReceivableID[]" value=<?php echo $row['ReceivableID'];?>></td>
			</tr>

<?php
       }
	?>
	<TR><td ><input type=reset name=reset value=clear>
	<input type=submit name=submit value=Pay></td></tr>
	</form>
	<?php
	CloseTable();
	}

function ReceivableViewOne()
{

	$ReceivableID=$_GET['ReceivableID'];
	$query="SELECT `ReceivableID` , `DateTime` , `MemberID`,`ReceivableType` , `FamilyID` , `ClassID` ,
`Amount` , `PaymentID`, `Description` FROM `tblReceivable` WHERE `ReceivableID`=$ReceivableID LIMIT 1";
	$result = mysqli_query(GetDBConnection(),$query) or Die ("Failed to query ");
	$row = mysqli_fetch_array($result);
	$ReceivableID=$row['ReceivableID'];
	$DateTime=$row['DateTime'];
	$MemberID=$row['MemberID'];
	$ReceivableType=$row['ReceivableType'];
	$FamilyID=$row['FamilyID'];
	$ClassID=$row['ClassID'];
	$PaymentID=$row['PaymentID'];
	$Amount=$row['Amount'];
	$Description=$row['Description'];

	OpenTable();
	?>
	<TR><th  align="right">Receivable ID</th><td><?php  echo $ReceivableID?></td></tr>
	<TR><th align="right">Date Time</th><td><?php  echo $DateTime?></td></tr>
	<TR><th align="right">MemberID</th><td><?php  echo $MemberID;?></td></tr>
	<TR><th align="right">Receivable Type</th><td><?php  echo $ReceivableType?></td></tr>
	<TR><th align="right">FamilyID</th><td><?php  echo $FamilyID;?></td></tr>
	<TR><th align="right">ClassID</th><td><?php  echo $ClassID;?></td></tr>
	<TR><th align="right">Description</th><td><?php  echo $Description;?></td></tr>
	<TR><th align="right">Amount</th><td><?php  echo $Amount?></td></tr>
	<TR><th align="right">PaymentID</th><td><?php  echo $PaymentID?></td></tr>
	<?php
	CloseTable();
}

function ReceivableDoEdit()
{
	$PaymentID=$_POST['PaymentID'];
	$ReceivableID=$_POST['ReceivableID'];
	$DateTime=$_POST['DateTime'];
	$MemberID=$_POST['MemberID'];
	$ReceivableType=$_POST['ReceivableType'];
	$FamilyID=$_POST['FamilyID'];
	$ClassID=$_POST['ClassID'];
	$Amount=$_POST['Amount'];
	$Description=$_POST['Description'];

 $query = "UPDATE `tblReceivable` SET `DateTime` = NOW(),`MemberID`='$MemberID',`ReceivableType`='$ReceivableType' , `FamilyID`='$FamilyID' , `ClassID` ='$ClassID', `Description` ='$Description', `Amount` = '$Amount'  WHERE `tblReceivable`.`ReceivableID` ='$ReceivableID' LIMIT 1 ";

	$result = mysqli_query(GetDBConnection(),$query) or die ("died while inserting to table<br>Debug info: $query");
	$msg = "Entry was successfully Edited.";
	return $msg;
}

function ReceivableDoAdd()
{
	$ReceivableID=$_POST['ReceivableID'];
	$DateTime=$_POST['DateTime'];
	$ReceivableType=$_POST['ReceivableType'];
	$MemberID=$_POST['MemberID'];
	$FamilyID=$_POST['FamilyID'];
	$ClassID=$_POST['ClassID'];
	$CRegID=$_POST['ClassRegID'];
	$Amount=$_POST['Amount'];
	$Description=$_POST['Description'];
	if ($ReceivableType == "Other" )
	{
		$ReceivableType=$_POST['ReceivableTypeValue'];
            $rtype=$ReceivableType;
	}
            $incomecategory='0';
/*
	if ($ReceivableType == "Tuition_Languae" )
	{
            $incomecategory='2';
	}
	if ($ReceivableType == "Tuition_Art" )
	{
            $incomecategory='3';
	}
	if ($ReceivableType == "Tuition_Dance" )
	{
            $incomecategory='4';
	}
	if ($ReceivableType == "Tuition_Chess" )
	{
            $incomecategory='5';
	}
	if ($ReceivableType == "Tuition_Math" )
	{
            $incomecategory='9';
	}
	if ($ReceivableType == "Tuition_MartialArts" )
	{
            $incomecategory='10';
	}
	if ($ReceivableType == "Tuition_PerformaceArts" )
	{
            $incomecategory='11';
	}
	if ($ReceivableType == "Membership" )
	{
            $incomecategory='1';
	}
	if ($ReceivableType == "Registration" )
	{
            $incomecategory='14';
	}
	if ($ReceivableType == "SafetyPatrol" )
	{
            $incomecategory='15';
	}
	if ($ReceivableType == "BookFee" )
	{
            $incomecategory='12';
	}
*/
 if ( strpos($ReceivableType,":") > 0 ) 
 {
     list($incomecategory,$rtype) = split(":", $ReceivableType);
 }

 $query = "insert into  `tblReceivable`(`DateTime`,`MemberID`,`ReceivableType` , `FamilyID` , `ClassID` ,`ClassRegistrationID`, `Description` ,IncomeCategory, `Amount`, `createdByMemberID`) values (now(),	'$MemberID','$rtype','$FamilyID',	'$ClassID',	'$CRegID', '$Description','$incomecategory',	$Amount, ". $_SESSION['memberid'].")";
	$result = mysqli_query(GetDBConnection(),$query) or die ("died while inserting to table<br>Debug info: $query");
	//$msg = "Entry was successfully added.";
	//echo $query;
	//return $msg;
	include("../common/CommonParam/params.php");
	header( 'Location: index.php?view=ReceivableViewFamily&FamilyID='.$FamilyID.'&mainmenu=off&date='.$PAST_BALANCE_DATE ) ;
}

function ReceivableAddLink()
{
	if (1 == 1)
	{
		$selfurl=$_SERVER['PHP_SELF'];
		return "<a href=\"$selfurl?view=ReceivableViewAdd\">Add Receivable</a>";
	}else
	{
		return " ";
	}
}

function ReceivableEditLink($ID)
{
	if ( $ID>0)
	{
		$selfurl=$_SERVER['PHP_SELF'];
	    $linkstring= "<a href=\"$selfurl?view=ReceivableViewEdit&ReceivableID=$ID\">Edit</a>";

	}else{
		$linkstring= " &nbsp;";
		}
		return $linkstring;
}
// select distinct ucase(substring(lastname,1,1)) from tblMember order by ucase(substring(lastname,1,1))
?>
