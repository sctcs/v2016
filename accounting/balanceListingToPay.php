<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
$seclvl = $_SESSION['membertype'];
//echo $seclvl;

if ($seclvl != 10 && $seclvl != 20 && $seclvl != 45 && $seclvl != 55) {  // treasurer access
    echo "access denied";
    exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
include("balance_lib.php");

//mysql_select_db($dbName, $conn);


$sql3 = "SELECT distinct FamilyID,FirstName,LastName,Email " .
        ", HomePhone,CellPhone from tblMember where PrimaryContact ='Yes'";
$RS3 = mysqli_query($conn, $sql3);
while ($RSA3 = mysqli_fetch_array($RS3)) {
    $firstname[$RSA3[FamilyID]] = $RSA3[FirstName];
    $lastname[$RSA3[FamilyID]] = $RSA3[LastName];
    $email[$RSA3[FamilyID]] = $RSA3[Email];
    $homephone[$RSA3[FamilyID]] = $RSA3[HomePhone];
    if ($RSA3[CellPhone] != "--") {
        $cellphone[$RSA3[FamilyID]] = $RSA3[CellPhone];
    }
}

$sql2 = "SELECT distinct m.FamilyID FROM tblMember m, tblClass c, tblClassRegistration r where m.MemberID=r.StudentMemberID and " .
        "r.ClassID=c.ClassID and c.CurrentClass='Yes' and r.Status='OK' ";
//echo $sql2;

$RS2 = mysqli_query($conn, $sql2);
while ($RSA2 = mysqli_fetch_array($RS2)) {
    $registered[$RSA2[FamilyID]] = 'yes';
    //echo $RSA2[FamilyID].": ".$registered[$RSA2[FamilyID]]."<BR>";
}

$SQLstring = "select FReceivable.FamilyID,PayableAmount,COALESCE(PaymentAmount,0) PaymentAmount,PayableAmount-COALESCE(PaymentAmount,0) Balance " .
        " from
(select FamilyID , sum(Amount) PayableAmount
   from tblReceivable group by FamilyID
) FReceivable
left join
(select FamilyID, sum(Amount) PaymentAMount
   from tblPayment group by FamilyID
) FamilyPayment
on FReceivable.FamilyID=FamilyPayment.FamilyID";

//$SQLstring .= " where PayableAmount > PaymentAMount            ";

if ($_GET[sortBy] == "name") {
    //$SQLstring .= " order by tblm.LastName,tblm.FirstName";
} else {
    $SQLstring .= " order by FReceivable.FamilyID";
}

if ($DEBUG) {
    echo $SQLstring;
}

//echo $SQLstring;
$RS1 = mysqli_query($conn, $SQLstring);
?>
<html>
    <head>
        <title>Balance to Pay</title>
        <link href="../common/bootstrap.min.css" rel="stylesheet">
        <link href="../common/ynhc_addoncss.css" rel="stylesheet">
    </head>
<script language="JavaScript">

 function doAll(){
   var x = document.mainform.elements["doall"];
   if(x.checked){
//     alert(x.name + " is Checked!");
//     document.mainform.elements["fids"].checked = true;
var inputs = document.getElementsByTagName('input');
for(var i = 0; i<inputs.length; i++){
    inputs[i].checked = true;
  }

         }
   else {
//      alert(x.name + " is UnChecked!");
//     document.mainform.elements["fids"].checked = false;
var inputs = document.getElementsByTagName('input');
for(var i = 0; i<inputs.length; i++){
    inputs[i].checked = false;
  }
         }
    };

function findhead1()
{
    var tag, tags;
    // or you can use var allElem=document.all; and loop on it
    tags = "The tags in the page are:"
    for(i = 0; i < document.all.length; i++)
    {
        tag = document.all(i).tagName;
        tags = tags + "\r" + tag;
    }
    document.write(tags);
}

function findhead2()
{
var elemArray = document.mainform.elements;
        for (var i = 0; i < elemArray.length;i++)
        {
            var element = elemArray[i];

            var elementName= element.name;
            var elementValue= element.value;
            document.write(elementName + "\r" + elementValue + "\r");

        }
}

</script>

    <body >
        <div class="col-sm-12">
            <h3 class="center">Balance to Pay</h3>
            <ul class="payment">
                <li><a href="index.php?view=SearchReceivable">Payment Management Home</a></li>
                <li><a href="balanceListingToPay.php?registered_only=Yes">Balance Listing of Currently Registered Families only</a>
                </li>
                <li> <a href="balanceListingToPay.php?registered_only=Unr&show_last_reg=No">Balance Listing of Currently Un-Registered Families only</a>
                </li>
                <li><a href="balanceListingToPay.php?registered_only=No">Balance Listing of All Families</a></li>
            </ul>
<form method="POST" name="mainform" action="payment_noticeS_create.php">

            <table class="table table-bordered table-condensed payment_management">
                <thead>
                    <tr>
                        <th><a href="balancelisting.php?sortBy=familyid">FamilyID</a></th>
                        <th>Currently<br>Registered</th>
                        <th><a href="balancelisting.php?sortBy=name">Primary Contact</a></th>
                        <th>Email</th><th>Home Phone</th><th>Cell Phone</th>
                        <?php
                        if ($_GET[show_last_reg] == "Yes") {
                            echo "  <th>Last Reg </th>";
                        }
                        ?>
                        <th>Receivable</th><th>Payment</th><th>Balance</th><th>Spring Tuition</th>
                        <th align="center">Check/Uncheck All<input type=checkbox name="doall" onclick="doAll()"></th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $totalBalance = 0;
                    while ($RSA1 = mysqli_fetch_array($RS1)) {
                if ( $RSA1[Balance] > 0 ) {
                      if (($_GET[registered_only] == "Yes" && $registered[$RSA1[FamilyID]] == "yes") || 
                          ($_GET[registered_only] == "Unr" && !isset($registered[$RSA1[FamilyID]])) || 
                          ($_GET[registered_only] != "Yes" && $_GET[registered_only] != "Unr")) {

                            echo "<tr><td>" . $RSA1[FamilyID] . "</td>";
                            echo "<td>&nbsp;" . $registered[$RSA1[FamilyID]] . "</td>";
                            echo "<td>" . $lastname[$RSA1[FamilyID]] . ", " . $firstname[$RSA1[FamilyID]] . "</td>";
                            echo "<td>" . $email[$RSA1[FamilyID]] . "</td>";
                            echo "<td>" . $homephone[$RSA1[FamilyID]] . "</td>";
                            echo "<td>" . $cellphone[$RSA1[FamilyID]] . "</td>";
                            if ($_GET[show_last_reg] == "Yes") {
                                echo "<td>" . last_reg($conn, $RSA1[FamilyID]) . "</td>";
                            }
                            //echo "<td>".$RSA1[Email]."</td>";
                            //echo "<td>".$RSA1[HomePhone]."</td>";
                            //echo "<td>".$RSA1[CellPhone]."</td>";
                            echo "<td>" . ($RSA1[PayableAmount] - 0) . "</td>";
                            echo "<td>" . ($RSA1[PaymentAmount] - 0) . "</td>";
                            //echo "<td>". ($RSA1[PayableAmount] - $RSA1[PaymentAmount]) ."</td>";
                            echo "<td>" . ($RSA1[Balance] - 0) ;
                if ( $RSA1[Balance] < 0 ) {
                            $cs =     credit_selection($conn, $RSA1[FamilyID] ) ;
                            if ( isset( $cs ) ) { echo "(".$cs.")"; }
                }
                            echo "</td>";
                echo "<td>&nbsp;";
                if ( $RSA1[Balance] > 0 ) {
                            $sd =     spring_due($conn, $RSA1[FamilyID] ) ;
                            if ( isset( $sd ) && $RSA1[Balance] > $sd ) { echo $sd; }
                }
                            echo "</td>";
//                          echo "<td align=center><a href=\"index.php?view=ViewFamilyAccount&FamilyID=" . $RSA1[FamilyID] . "&familyid=" . $RSA1[FamilyID] . "&mainmenu=off\" target=_blank>view</a></td>";
                            echo "<td><input type=checkbox name=fids[] value=". $RSA1[FamilyID] ."></td>";
//                          echo "<td><a href=\"../MemberAccount/FeePaymentVoucher_byadmin.php?fid=" . $RSA1[FamilyID] . "\" target=_blank>Payment Voucher</a></td>";
//                          echo "<td><a href=\"payment_notice_create.php?familyid=" . $RSA1[FamilyID] . "\" target=_blank>Send</a></td>";
                            echo "</tr>\n";
                            $i++;
                            $totalBalance += $RSA1[Balance];
                        }
                    }}
//                  setlocale(LC_MONETARY, 'en_US');
//                  echo "<p style=''color: Green;' class='center lead'>";
//                  echo ($_GET['registered_only'] == "Yes" ? "Registered families " : "All families ");
//                  echo " <bold>total =  <span style='color: red'>" . $i . "</span><br />";
//                  echo "Balance total = " . money_format('%i', $totalBalance) . "</p>";

                    //echo "rows=".$i;
                    ?> 
                </tbody>
            </table>
Subject: <input type="text" name="msgsubj" size="80" value="Please pay your SCCS balance"><br>
Content:<br> <textarea rows="10" cols="80" name="msgbody">
Dear SCCS Parent or Student,

Our school system shows that you still have unpaid balance. Please login to your account to check if there is any error. If there is no error, please make a payment at your earliest convenience and mail it along with your payment voucher to: 

Southern Connecticut Chinese School
P.O. Box 8296
New Haven, CT 06530 

If you have any questions, please contact support@ynhchineseschool.org or come to school office at A107 for further assistance.

Best Regards,
Min Li
SCCS Financial Manager
</textarea>
<input type="submit" value="Send to all Checked">
<?php if ( $_GET[error] == "1" ) {
    echo "<font color=red>Check at lease one entry before you click on this button.</font>";
 } ?>

</form>
        </div>
    </body>
</html>

<?php
mysqli_close($conn);
?>
