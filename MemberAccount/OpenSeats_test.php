<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params_test.php");


// query count by grade and class number
//
$openstsql = "SELECT tblClass.ClassID, count(*) takenseats
                FROM tblClassRegistration, tblClass
               WHERE tblClassRegistration.ClassID=tblClass.ClassID AND tblClassRegistration.Status !='dropped' AND ";

 if ($_GET[Term] != '' && $_GET[Year] != '') {
    $openstsql .= " tblClass.Term='".$_GET[Term]. "' AND tblClass.Year='".$_GET[Year]."'";
 } else {
    $openstsql .= " tblClass.CurrentClass='Yes' AND tblClass.Year='".$CurrentYear."' AND tblClass.Term='".$CurrentTerm."'";
 }
 $openstsql .= " group by tblClass.ClassID";
//              WHERE tblClassRegistration.ClassID=tblClass.ClassID AND tblClass.Year='".$CurrentYear."' AND tblClass.Term='".$CurrentTerm."'  group by tblClass.ClassID";
//echo $openstsql;

$rsos=mysqli_query($conn,$openstsql);

while ( $rwos=mysqli_fetch_array($rsos) ) {
   //echo $rwos[ClassID]. "="; //." , Grade = ". $rwos[GradeOrSubject].'.'.$rwos[ClassNumber]."=".$rwos[takenseats]."<br>";
   $seatstaken[$rwos[ClassID]] = $rwos[takenseats];
   //echo $seatstaken[$rwos[ClassID]]."<br>";

}

// query grade and class number list
//
$sql = "SELECT ClassID, GradeOrSubject,ClassNumber,Seats,Period,IsLanguage 
        FROM   tblClass
        WHERE ";
 //echo $sql;
 if ($_GET[Term] != '' && $_GET[Year] != '') {
    $sql .= " Term='".$_GET[Term]. "' AND Year='".$_GET[Year]."'";
 } else {
    $sql .= " CurrentClass='Yes' AND tblClass.Year='".$CurrentYear."' AND tblClass.Term='".$CurrentTerm."'";
 }
 $sql .= " order by GradeOrSubject,ClassNumber";

 $rs=mysqli_query($conn,$sql);
?>
 <!-- <input type="button" value="Close this window" onclick="self.close()"> -->

<?php
 echo "<center><a href=\"../../../prod_v14/\">[Home]</a><a href=\"MemberAccountMain.php\">[My Account]</a>
 <a href=\"javascript:window.history.back();\">[Back]</a><a href=\"FamilyChildList.php\">[Class Registration]</a><br>";

$sqlty = "select distinct Year, Term from tblClass";
$rsty=mysqli_query($conn, $sqlty);
while ( $rwty=mysqli_fetch_array($rsty) ) {
    echo "<a href=\"OpenSeats_test.php?Year=".$rwty[Year]."&Term=".$rwty[Term]."\">".$rwty[Year]." ".$rwty[Term]."</a>, ";
}
echo "<BR>";

echo "</center>";
 if ($_GET[Term] != '' && $_GET[Year] != '') {
    echo "Year: ".$_GET[Year]." , Term: ".$_GET[Term];
 } else {
    echo "Year: ".$CurrentYear." , Term: ".$CurrentTerm;
 }
 echo "<center>";

 echo "<BR>
  <table border=\"1\">
 <tr>
   <th>ClassID</th><th>GradeOrSubject</th><th>Class Number</th><th>Period/Session</th><th>Total Seats</th><th>Seats Taken</th><th>Remaining Seats</th>
 </tr>";
 while ( $rw=mysqli_fetch_array($rs) ) {
    echo "<tr>";
    echo "<td align=center>".$rw[ClassID]. "</td><td align=center>".$rw[GradeOrSubject]. "</td><td align=center>" . $rw[ClassNumber] . "</td>";
//    if ( $rw[Period] == '1') {
//       echo "<td align=center>$PERIOD1</td>";
//    } else if ( $rw[Period] == '2') {
//       echo "<td align=center>$PERIOD2</td>";
//    } else if ( $rw[Period] == '3') {
//       echo "<td align=center>$PERIOD3</td>";
//    } else if ( $rw[Period] == '4') {
//      echo "<td align=center>$PERIOD4</td>";
//    } else if ( $rw[Period] == '0') {
//      echo "<td align=center>$PERIOD0</td>";
//    }
if ($rw[IsLanguage] == 'Yes' || strpos($rw[GradeOrSubject],"two periods") != false )
{
 if ($rw[Period]=='1') {
                                                                                               $period= $PERIOD1." ".$PERIOD2;
                                                                                            } else if ($rw[Period]=='0') {
                                                                                               $period= $PERIOD0." ".$PERIOD1;
                                                                                            } else if ($rw[Period]=='2') {
                                                                                               $period= $PERIOD2." ".$PERIOD3;
                                                                                            } else if ($rw[Period]=='3') {
                                                                                               $period= $PERIOD3." ".$PERIOD4;
                                                                                            } else if ($rw[Period]=='4') {
                                                                                               $period= $PERIOD4;
 }
}
else {
 if ($rw[Period]=='1') {
                                                                                               $period= $PERIOD1;
                                                                                            } else if ($rw[Period]=='0') {
                                                                                               $period= $PERIOD0;
                                                                                            } else if ($rw[Period]=='2') {
                                                                                               $period= $PERIOD2;
                                                                                            } else if ($rw[Period]=='3') {
                                                                                               $period= $PERIOD3;
                                                                                            } else if ($rw[Period]=='4') {
                                                                                               $period= $PERIOD4;
 }
}
//echo $period;  
      echo "<td align=center>$period</td>";

    echo "<td align=center>".$rw[Seats]. "</td>";
    echo "<td align=center>". $seatstaken[$rw[ClassID]]  . "&nbsp;</td>";
   //echo $rw[GradeOrSubject].'.'.$rw[ClassNumber];
    if ( isset($seatstaken[$rw[ClassID]]) && $seatstaken[$rw[ClassID]] != null ) {
       $avail = ($rw[Seats] - $seatstaken[$rw[ClassID]] );

    } else {
       $avail = $rw[Seats];
    }
    echo "<td align=center>".$avail . "</td></tr>";


 }

echo "</table></center>";


mysqli_close($conn);
?>
