<html>
<head>
<title>
</title>
</head>
<body>
<?php

 require_once("../common/DB/DataStore.php");

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

                case 'ReceivableViewEdit':
                        ReceivableViewEdit();
                break;

                case 'PaymentViewAdd':
                        PaymentViewAdd();
                break;

                case 'PaymentViewEdit':
                        PaymentViewEdit();
                break;

				case 'PaymentViewOne':
						PaymentViewOne();
				break;

				case 'ReceivableViewOne':
						ReceivableViewOne();
				break;

                case 'ReceivableViewAdd':
                        ReceivableViewAdd();
                break;
				case 'SearchReceivable':
					SearchReceivable();
				break;

                                case 'UpdateReceivable':
				//	UpdateIncomeInfo("all");
                                       // SearchReceivable();
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
<?
}
?>
</body>
</html>
