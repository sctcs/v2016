<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

$seclvl = $_SESSION['membertype'];
//if ( $seclvl != 10 && $seclvl !=20 && $seclvl != 35 && $seclvl != 40  && $seclvl != 55) { //principal, DBA, Board Member, School Admin, Collector
//    echo "not authorized";
//    exit();
  
//}

if (isset($_GET[date]) && $_GET[date] != "") {
$date = $_GET[date];
} else {
$date="";
}

// bydate=yes, list dates without detail schedules
if (isset($_GET[bydate]) && $_GET[bydate] != "") {
$bydate = $_GET[bydate];
} else {
$bydate="no";
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Safety Patrol Sign-in Sheet</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>

<body>
<a href="ManageSafetyPatrol.php">Manage Safety Patrol</a>

<?php


$SQLstring = "select sp.FamilyID,sp.Year,sp.Term,sp.ChildClass,sp.Period,sp.ScheduledDate,sp.ServedDate,sp.Status,concat_ws(', ', m.LastName, m.FirstName) as Name   from tblSafetyPatrol sp, tblMember m  "
."where sp.FamilyID=m.FamilyID  and m.PrimaryContact='Yes' ";
                                      if ( $date != "" ) {
         					$SQLstring .= " and sp.ScheduledDate='". $date ."' ";
 					}
//echo $SQLstring;
						$SQLstring .=" order by sp.ScheduledDate,sp.Period, m.LastName, m.FirstName";
						$RS1=mysqli_query($conn,$SQLstring);

	?>
<h3>Safety Patrol Sign-in Sheet<br>
Sunday <?php echo $date; ?></h3>
<h4>On-Duty Safety Leaders:</h4>
<table   cellpadding=1 cellspacing=1  border="1" width="100%">
<th>Date</th><th>Period</th><th>Child Class</th><th>FamilyID</th><th>Name</th><th>---Post---</th><th>Signature</th><th>Sign-in Time</th><th>Jacket out</th><th>Walky Talky out</th><th>Jacket in</th><th>Walky Talky in</th><th>Sign-out Time</th><th>-----Notes-----</th>
<?php 
while($RSA1=mysqli_fetch_array($RS1)) {
  echo "<tr>";
  echo "    <td align=center>". $RSA1[ScheduledDate] ."</td>";
  if ($RSA1[Period] =="1") {$period=$SPPERIOD1;}else{$period=$SPPERIOD3;}
  echo "    <td align=center>". $period ."</td>";
  echo "    <td align=center>". $RSA1[ChildClass] ."</td>";
  echo "    <td align=center>". $RSA1[FamilyID] ."</td>";
  echo "    <td align=left>". $RSA1[Name] ."</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "<td>&nbsp;</td>";
  echo "</tr>";
} ?>
</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
