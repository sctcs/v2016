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

//mysql_select_db($dbName, $conn);

$sql3 = "SELECT distinct FamilyID,FirstName,LastName,Email " .
        ", HomePhone,CellPhone from tblMember where PrimaryContact ='Yes'";
$RS3 = mysqli_query($conn, $sql3);
while ($RSA3 = mysqli_fetch_array($RS3)) {
    $firstname[$RSA3[FamilyID]] = $RSA3[FirstName];
    $lastname[$RSA3[FamilyID]] = $RSA3[LastName];
    $email[$RSA3[FamilyID]] = $RSA3[Email];
    $homephone[$RSA3[FamilyID]] = $RSA3[HomePhone];
    $cellphone[$RSA3[FamilyID]] = $RSA3[CellPhone];
}


$sql2 = "SELECT distinct m.FamilyID FROM tblMember m, tblClass c, tblClassRegistration r where m.MemberID=r.StudentMemberID and " .
        "r.ClassID=c.ClassID and c.CurrentClass='Yes' and r.Status='OK' ";
//echo $sql2;

$RS2 = mysqli_query($conn, $sql2);
while ($RSA2 = mysqli_fetch_array($RS2)) {
    $registered[$RSA2[FamilyID]] = 'yes';
    //echo $RSA2[FamilyID].": ".$registered[$RSA2[FamilyID]]."<BR>";
}


//Query for families who have credits with SCCS before 8/1/2016
$sql13 = "SELECT M.FamilyID, amountPaid, amountReceived, (amountPaid-amountReceived) creditTotal 
    FROM 
    (SELECT FamilyID FROM tblClassRegistration c, tblMember m 
    WHERE c.StudentMemberID = m.MemberID AND Year = '2016' 
    AND Status = 'OK' GROUP BY FamilyID) M
JOIN (SELECT FamilyID, sum(Amount) amountPaid FROM tblPayment WHERE DATE < '2016-07-31 00:00:00'
    GROUP BY FamilyID) AP ON M.FamilyID = AP.FamilyID
JOIN (SELECT FamilyID, SUM(Amount) amountReceived FROM tblReceivable 
    WHERE DATETIME < '2016-07-31 00:00:00' GROUP BY FamilyID) AR ON M.FamilyID = AR.FamilyID
   ";

//echo $sql13;


$RS1 = mysqli_query($conn, $sql13);
//while ($RSA1 = mysqli_fetch_array($RS1)) {
//    $registered[$fwc[$RSA1[FamilyID]]] = 'yes';   //familly with credits before Aug 1
//}

if ($_GET[sortBy] == "name") {
    //$SQLstring .= " order by tblm.LastName,tblm.FirstName";
} else {
    $SQLstring .= " order by AP.FamilyID";
}

if ($DEBUG) {
    echo $SQLstring;
}

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
                <li><a href="balancelisting_p.php">Registered Families Having Credits Before Aug 1, 2016</a>
                    &nbsp;&nbsp;||&nbsp;&nbsp;
                    <a href="balancelisting_negative.php">Registered Families Having Negative Balance Before Aug 1, 2016</a>
                </li>
            </ul>
        <table class="table table-condensed table-bordered payment_management">
            <thead>
            <tr>
                <th><a href="balancelisting.php?sortBy=familyid">FamilyID</a></th>
                <th>Currently<br>Registered</th>
                <th><a href="balancelisting.php?sortBy=name">Primary Contact</a></th>
                <th>Email</th><th>Home Phone</th><th>Cell Phone</th>
                <th>Receivable</th><th>Payment</th><th>Balance</th><th>View Transactions</th>
                <th>Payment Voucher</th>
            </tr>
            </thead>
            <?php
            $i = 0;
            $familiesTotal = 0;
            $totalCredits = 0;
            while ($RSA1 = mysqli_fetch_array($RS1)) {
                if (($_GET[registered_only] == "Yes" && $registered[$RSA1[FamilyID]] == "yes") || $_GET[registered_only] != "Yes") {
                    if($RSA1[creditTotal] > 0) {
                    echo "<tr><td>" . $RSA1[FamilyID] . "</td>";
                    echo "<td>&nbsp;" . $registered[$RSA1[FamilyID]] . "</td>";
                    echo "<td>" . $lastname[$RSA1[FamilyID]] . ", " . $firstname[$RSA1[FamilyID]] . "</td>";
                    echo "<td>" . $email[$RSA1[FamilyID]] . "</td>";
                    echo "<td>" . $homephone[$RSA1[FamilyID]] . "</td>";
                    echo "<td>" . $celphone[$RSA1[FamilyID]] . "</td>";
                    //echo "<td>".$RSA1[Email]."</td>";
                    //echo "<td>".$RSA1[HomePhone]."</td>";
                    //echo "<td>".$RSA1[CellPhone]."</td>";
                    echo "<td>" . ($RSA1[amountReceived] - 0) . "</td>";
                    echo "<td>" . ($RSA1[amountPaid] - 0) . "</td>";
                    //echo "<td>". ($RSA1[amountReceived] - $RSA1[amountPaid]) ."</td>";
                    echo "<td>" . ($RSA1[creditTotal] - 0) . "</td>";
                    echo "<td align=center><a href=\"index.php?view=ViewFamilyAccount&FamilyID=" . $RSA1[FamilyID] . "&familyid=" . $RSA1[FamilyID] . "&mainmenu=off\" target=_blank>view</a></td>";
                    echo "<td><a href=\"../MemberAccount/FeePaymentVoucher_byadmin.php?fid=" . $RSA1[FamilyID] . "\" target=_blank>Payment Voucher</a></td>";
                    echo "</tr>\n";
                    $i++;
                    $familiesTotal++;
                    $totalCredits += $RSA1[creditTotal];
                  }
                }
            }
            setlocale(LC_MONETARY, 'en_US');
            echo "<p style='color: Green;' class='center lead'><bold>There are <span style='color: red'>" . $familiesTotal . "</span> Registered Families Having Credits Before August 1, 2016<br />";
            echo "Total Credits Before August 1, 2016 is: " . money_format('%i', $totalCredits) . "</p>";
            //echo "rows=".$i;
            ?> 
        </table>
            </div>
    </body>
</html>

<?php
mysqli_close($conn);
?>
