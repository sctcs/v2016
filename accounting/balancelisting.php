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

$SQLstringP= "select FReceivable.FamilyID,PayableAmount,COALESCE(PaymentAmount,0) PaymentAmount,PayableAmount-COALESCE(PaymentAmount,0) Balance " .
        " from
(select FamilyID , sum(Amount) PayableAmount
   from tblReceivable where DateTime < '$CurrentYear-07-01' group by FamilyID
) FReceivable
left join
(select FamilyID, sum(Amount) PaymentAMount
   from tblPayment where Date < '$CurrentYear-07-01' group by FamilyID
) FamilyPayment
on FReceivable.FamilyID=FamilyPayment.FamilyID";

$RSP = mysqli_query($conn, $SQLstringP);
while ($RSAP = mysqli_fetch_array($RSP)) {
   $pbal[$RSAP[FamilyID]] = $RSAP[Balance];
}

$SQLstring = "select FReceivable.FamilyID,PayableAmount,COALESCE(PaymentAmount,0) PaymentAmount,PayableAmount-COALESCE(PaymentAmount,0) DiffBalance " .
        " from
(select FamilyID , sum(Amount) PayableAmount
   from tblReceivable where DateTime >= '$CurrentYear-07-01' and DateTime <'$NextYear-07-01' group by FamilyID
) FReceivable
left join
(select FamilyID, sum(Amount) PaymentAMount
   from tblPayment where Date >= '$CurrentYear-07-01' and Date <'$NextYear-07-01' group by FamilyID
) FamilyPayment
on FReceivable.FamilyID=FamilyPayment.FamilyID";


if ($_GET[sortBy] == "name") {
    //$SQLstring .= " order by tblm.LastName,tblm.FirstName";
} else {
    $SQLstring .= " order by FReceivable.FamilyID";
}

if ($DEBUG) {
    echo $SQLstring;
}
$RS1 = mysqli_query($conn, $SQLstring);
?>
<html>
    <head>
        <title>SCCS Payment Management</title>
        <link href="../common/bootstrap.min.css" rel="stylesheet">
        <link href="../common/ynhc_addoncss.css" rel="stylesheet">
    </head>
    <body>
        <div class="col-sm-12">
            <h3 class="center">Payment Management</h3>
            <ul class="payment">
                <li><a href="index.php?view=SearchReceivable">Payment Management Home</a></li>
                <li><a href="balancelisting.php?registered_only=Yes">Balance Listing of Currently Registered Families only</a>
                    &nbsp;&nbsp; ||&nbsp;&nbsp; <a href="balancelisting.php?registered_only=No">Balance Listing of All Families</a>
                </li>
                <li> <a href="balancelisting.php?registered_only=Unr&show_last_reg=No">Balance Listing of Currently Un-Registered Families only</a>
                </li>
                <li><a href="balancelisting.php?registered_only=Unr&show_last_reg=Yes">Balance Listing of Currently Un-Registered Families only with last registration year and term</a>
                </li>
                <li><a href="balancelisting_positive.php">Registered Families Having Positive Balance Before Aug 1, 2016</a>
                    &nbsp;&nbsp;||&nbsp;&nbsp;
                    <a href="balancelisting_negative.php">Registered Families Having Credit Before Aug 1, 2016</a>
                </li>
            </ul>
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
<th>Past Balance</th>     <th>Receivable</th><th>Payment</th><th>Balance</th><th>Spring Tuition</th><th>View Transactions</th>
                        <th>Payment Voucher</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    $totalBalance = 0;
                    while ($RSA1 = mysqli_fetch_array($RS1)) {
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
                            echo "<td>".$pbal[$RSA1[FamilyID]]  ."</td>";
                            echo "<td>" . ($RSA1[PayableAmount] - 0) . "</td>";
                            echo "<td>" . ($RSA1[PaymentAmount] - 0) . "</td>";
                            //echo "<td>". ($RSA1[PayableAmount] - $RSA1[PaymentAmount]) ."</td>";
                            echo "<td>" . ($pbal[$RSA1[FamilyID]] + $RSA1[DiffBalance] - 0) ;
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
                            echo "<td align=center><a href=\"index.php?view=ViewFamilyAccount&FamilyID=" . $RSA1[FamilyID] . "&familyid=" . $RSA1[FamilyID] . "&mainmenu=off\" target=_blank>view</a></td>";
                            echo "<td><a href=\"../MemberAccount/FeePaymentVoucher_byadmin.php?fid=" . $RSA1[FamilyID] . "\" target=_blank>Payment Voucher</a></td>";
                            echo "</tr>\n";
                            $i++;
                            $totalBalance += $RSA1[Balance];
                        }
                    }
                    setlocale(LC_MONETARY, 'en_US');
                    echo "<p style=''color: Green;' class='center lead'>";
                    echo ($_GET['registered_only'] == "Yes" ? "Registered families " : "All families ");
                    echo " <bold>total =  <span style='color: red'>" . $i . "</span><br />";
                    echo "Balance total = " . money_format('%i', $totalBalance) . "</p>";

                    //echo "rows=".$i;
                    ?> 
                </tbody>
            </table>
        </div>
    </body>
</html>

<?php
mysqli_close($conn);
?>
