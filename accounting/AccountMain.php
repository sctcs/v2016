<?php

require_once("../common/DB/DataStore.php");
require_once("Tools.php");

function AccountingMenu()
{
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
// session_save_path("/var/www/phpsessions");
	// session_start();
	$SessionUserName=$_SESSION['logon'];
	$CollectorID=$_SESSION['memberid'];
	     $seclvl = $_SESSION['membertype'];
	$secdesc= $_SESSION['MemberTypes'][$seclvl];

	if( $seclvl == 45 or $seclvl==10 or $seclvl==20 or $seclvl==55  )  // treasurer access
        {
            //notusedmenu();
        }
       ?>


<h3> Payment Management</h3>
<hr>
<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=SearchReceivable">Receivable Lookup and Pay </a><br>
<a href="paymentviewsetup.php?cid=<?php echo $CollectorID; ?>">View&nbsp;Payments&nbsp;you collected</a><br>
<a href="paymentviewsetup.php">View&nbsp;all Payments&nbsp;collected</a><br><br>

<a href="balancelisting.php">View&nbsp;Balances&nbsp;of all Families</a><br>
<a href="creditSelectionListing.php">Credit and Payment Selection</a><br><br>

<a href="balanceHistory.php">Balance&nbsp;History of all Families</a><br>

<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=UpdateReceivable">Create or Update Receivables</a> (This action takes a while to complete)<br>


<?php

}

function notusedmenu()
{
	?><hr><h1>Extended Account Access function</h1>
		<table align="center" width="100%" cellpadding="3" cellspacing="0" style="border: 1px solid;">
		<tr>
			<td width="100%" align="left" valign="top" style="border-right: 1px solid;">
			<ul>
			<li>Receivable Item Adjustment: <?php  echo ReceivableAddLink();?></li>
			<li>View Payments: <a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewList">View&nbsp;Payment</a></li>
			<li>Payment Item Adjustment: <a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=PaymentViewAdd">Add Payment</a></li>
			</ul>
			</td>

		</tr>

	</table>
			<!--
			</ul>
			<ul>
			</td>
			<td width="50%" align="left" valign="top" style="border-right: 1px solid;">
<a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewList">View&nbsp;Receivable</a>
			<li><a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewList&paymentid=NONE">View&nbsp;Unpaid&nbsp;Receivable</a></li>
			<li><a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=ReceivableViewList">View&nbsp;All</a></li>
			<li><a href="<?php  echo $_SERVER['PHP_SELF'] ?>?view=SearchReceivable">Receivable Lookup/Search </a></li>
-->
	<?php
	}
?>
