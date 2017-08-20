<?php

// require_once("../common/DB/DataStore.php");

require_once("AccountMain.php");
require_once("AccountReceivable.php");
require_once("AccountPayment.php");
require_once("Tools.php");
getdbconnection();
if (CheckAccess()==1)
{
if ($_REQUEST['mainmenu']=='off')
{
  print "";
}else
{
  AccountingMenu();
}
$msg="";
     switch($_REQUEST['op'])
	{
		case 'ReceivableDoEdit':
                        ReceivableDoEdit();
                break;

                case 'PaymentDoEdit':
                        PaymentDoEdit();
                break;

                case 'PaymentDoDelete':
                        PaymentDoDelete();
                break;

                case 'ReceivableDoAdd':
                        $msg=ReceivableDoAdd();
			echo $msg;
                break;

                case 'PaymentDoAdd':
                        $msg=PaymentDoAdd();
                break;
		}
		echo $msg;
     switch($_REQUEST['view'])
        {
                case 'ReceivableViewList':
                        ReceivableViewList();
                break;

                case 'PaymentViewList':
                        PaymentViewList();
                break;

                case 'PaymentViewListAll':
if ($_REQUEST['mainmenu']=='off')
{
  print "<a href=\"index.php\">Payment Management</a>";
}
                        PaymentViewListAll();
                break;
                case 'PaymentViewListAllExt':
if ($_REQUEST['mainmenu']=='off')
{
  print "<a href=\"index.php\">Payment Management</a>";
}
                        PaymentViewListAllExt();
                break;


                case 'ReceivableViewEdit':
                        ReceivableViewEdit();
                break;

                case 'PaymentViewAdd':
                     echo "<a href=\"index.php\">[Payment Management]</a>";
                        PaymentViewAdd();
                break;

                case 'PaymentViewEdit':
                        PaymentViewEdit();
                break;

                case 'PaymentViewDelete':
                        PaymentViewDelete();
                break;

		case 'PaymentViewOne':
			PaymentViewOne();
		break;

		case 'ReceivableViewOne':
			ReceivableViewOne();
		break;

                case 'ReceivableViewAdd':
                     echo "<a href=\"index.php\">[Payment Management]</a>";
                        ReceivableViewAdd();
                break;
				case 'SearchReceivable':
					SearchReceivable();
				break;

                case 'UpdateReceivable':
					UpdateIncomeInfo2014("all");
      //            SearchReceivable();
				break;

				case 'ViewFamilyAccount':
					ViewFamilyAccount($_GET['familyid']);
                break;

				case 'ReceivableViewFamily':
					ReceivableViewFamily();
				break;


                default:
                        OpenTable();
						// TestDB();
						CloseTable();
                break;
        }
 //print "<div>".$msg."</div>\n";
//print "POST View: ".$_POST['view'];
//print "GET View: ".$_GET['view'];
}else
{
?>
<center>
<h2>Access Denied</h2>
<hr>
You do not have access to the function at this page. Please Go back.
<br>
If you need access. Please contact a proper person to get your permission.

</center>
<?php
}
?>
