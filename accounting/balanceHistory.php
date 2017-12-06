<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
{
            echo "access denied";
            exit();
}
if ( isset($_GET[begdate]) && strlen($_GET[begdate]) == 10 ){
   $begd = $_GET[begdate];
} else {
   $begd = "2017-07-01";
}
if ( isset($_GET[enddate]) && strlen($_GET[enddate]) == 10 ){
   $endd = $_GET[enddate];
} else {
   $endd = "2018-06-30"  ;
}
?>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a>
<a href="index.php?view=SearchReceivable">Payment Management Home</a>
<BR>
Account Balance History
<BR>
<form action="balanceHistory.php">
From <input type=text name="begdate" value="<?php echo $begd; ?>">
To   <input type=text name="enddate" value="<?php echo $endd; ?>">
<input type="submit" value="Go">
</form>

<html>
<body>
<?php

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
include("balance_lib.php");

//mysql_select_db($dbName, $conn);

$fsql = "select distinct FamilyID from tblReceivable order by FamilyID";
$RSF = mysqli_query($conn, $fsql);
$i=1;
while ($RSAF = mysqli_fetch_array($RSF)) {
   $fids[$i] = $RSAF[FamilyID];
   $i++;
}

$sql3 = "SELECT distinct FamilyID,FirstName,LastName,Email " .
        ", HomePhone,CellPhone from tblMember where PrimaryContact ='Yes'";
$RS3 = mysqli_query($conn, $sql3);
while ($RSA3 = mysqli_fetch_array($RS3)) {
    $firstname[$RSA3[FamilyID]] = $RSA3[FirstName];
    $lastname[$RSA3[FamilyID]] = $RSA3[LastName];
}

$sql2 = "SELECT distinct m.FamilyID FROM tblMember m, tblClass c, tblClassRegistration r where m.MemberID=r.StudentMemberID and " .
        "r.ClassID=c.ClassID                          and r.Status in ('Taken','OK') and r.DateTimeRegistered >= '$begd' and r.DateTimeRegistered <= '$endd' ";
//      "r.ClassID=c.ClassID and c.CurrentClass='Yes' and r.Status='OK' ";
//echo $sql2;

$RS2 = mysqli_query($conn, $sql2);
while ($RSA2 = mysqli_fetch_array($RS2)) {
    $registered[$RSA2[FamilyID]] = 'yes';
    //echo $RSA2[FamilyID].": ".$registered[$RSA2[FamilyID]]."<BR>";
}

$SQLstringP= "select FReceivable.FamilyID,PayableAmount,COALESCE(PaymentAmount,0) PaymentAmount,PayableAmount-COALESCE(PaymentAmount,0) Balance " .
        " from
(select FamilyID , sum(Amount) PayableAmount
   from tblReceivable where DateTime< '". $begd . "' group by FamilyID
) FReceivable
left join
(select FamilyID, sum(Amount) PaymentAMount
   from tblPayment where Date< '" . $begd . "' group by FamilyID
) FamilyPayment
on FReceivable.FamilyID=FamilyPayment.FamilyID";
$RSP = mysqli_query($conn, $SQLstringP);
while ($RSAP = mysqli_fetch_array($RSP)) {
   $pbal[$RSAP[FamilyID]] = $RSAP[Balance];
}

$SQLstring = "select FReceivable.FamilyID,PayableAmount,COALESCE(PaymentAmount,0) PaymentAmount,PayableAmount-COALESCE(PaymentAmount,0) Balance " .
        " from
(select FamilyID , sum(Amount) PayableAmount
   from tblReceivable where DateTime <= '" . $endd ."' and DateTime >='" . $begd . "' group by FamilyID
) FReceivable
left join
(select FamilyID, sum(Amount) PaymentAMount
   from tblPayment where Date <= '" . $endd . "' and Date >='" . $begd . "' group by FamilyID
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

<table border=1 >
                    <tr>
                        <th>FamilyID</th>
                        <th>Cur<br>Reg</th>
                        <th>Name</a></th>
                        <th>Past<br>Balance</th> 
                        <th>Charge</th><th>Payment</th><th>Diff.</th><th>End<br>Balance</th>
                    </tr>
                    <?php
                    
                    $totalBalance = 0;
                    while ($RSA1 = mysqli_fetch_array($RS1)) {
                            $fid =            $RSA1[FamilyID]          ;
                            $RA[$fid] =    $RSA1[PayableAmount]               ;
                            $PmtA[$fid] =  $RSA1[PaymentAmount] ;
                    }
        $T_pbal=0;
        $T_Rec =0;
        $T_Pay =0;
        $T_diff=0;
        $T_ebal=0;
                for ($j=1; $j< $i; $j++ ) {
                     $fd = $fids[$j];
                            echo "<tr><td>" . $fd . "</td>";
                            echo "<td>&nbsp;" . $registered[$fd] . "</td>";
                            echo "<td>" . $lastname[$fd] . ", " . $firstname[$fd] . "</td>";
                            echo "<td>" . ($pbal[$fd] - 0) . "</td>";
                            echo "<td>" . ($RA[$fd] - 0) . "</td>";
                            echo "<td>" . ($PmtA[$fd] - 0) . "</td>";
                            echo "<td>". ($RA[$fd] - $PmtA[$fd]) ."</td>";
                            echo "<td>" . ($RA[$fd] - $PmtA[$fd] + $pbal[$fd]) ;
                            echo "</td>";
                            echo "</tr>\n";
                            
        $T_pbal +=$pbal[$fd];
        $T_Rec  +=$RA[$fd];
        $T_Pay  +=$PmtA[$fd];
        $T_diff +=$RA[$fd] - $PmtA[$fd];
        $T_ebal +=$RA[$fd] - $PmtA[$fd] + $pbal[$fd];
                        }
       echo "<td>&nbsp;</td><td>&nbsp;</td><td>Total</td><td>".$T_pbal ."</td><td>" . $T_Rec . "</td><td>".$T_Pay."</td><td>".$T_diff."</td><td>".$T_ebal."</td></tr>";
                    
                    ?> 
</table>
</body>
</html>

<?php
mysqli_close($conn);
?>
