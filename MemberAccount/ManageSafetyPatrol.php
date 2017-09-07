<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

$seclvl = $_SESSION['membertype'];
if ( $seclvl != 10 && $seclvl !=20 && $seclvl != 35 && $seclvl != 40  && $seclvl != 55) { //principal, DBA, Board Member, School Admin, Collector
    echo "not authorized";
    exit();

}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Manage Safety Patrol Schedule</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>

<body>
<a href="MemberAccountMain.php">My Account</a>

 <?php
    $SQLstring="SELECT Date from tblCalendar where (Year='" . $CurrentYear ."' and Term='". $CurrentTerm . "') or (Year='". $NextYear ."' and Term='". $NextTerm ."')";  
//  echo $SQLstring;
    $RS1=mysqli_query($conn,$SQLstring) ;
?>
<table width="780" background="" bgcolor="" border="0" align="center">
 <tr>
   <td>
    <ul>
      <li><a href="ViewAllSafetyPatrol.php" target="_blank">View All Safety Patrol Schedule</a>
      <li><a href="AssignSafetyPatrol_form.php" target="_blank">Assign Safety Patrol for a Day</a>
      <li><a href="SafetyPatrolForm.php" target="_blank">Assign Safety Patrol to a Family</a>
<!--      <li><a href="SchoolSafetyPatrol_email.php?date=2017-09-11&period=1" target="_blank">Safety Patrol Emails (change the date and period in URL)</a> -->
  <li>Email addresses of Safety Patrol families: <BR>
  <?php 
    while($RSA1=mysqli_fetch_array($RS1)) {
       echo "   <a href=\"SchoolSafetyPatrol_email.php?date=".$RSA1[Date] . "&period=1\">". $RSA1[Date] . "P1-2</a>, ";
       echo "   <a href=\"SchoolSafetyPatrol_email.php?date=".$RSA1[Date] . "&period=3\">". $RSA1[Date] . "P3-4</a>, ";
       echo "<BR>";
    } ?>
<!--      <li><a href="SchoolSafetyPatrolSigninSheet.php?date=2017-09-11" target="_blank">Safety Patrol Sign-in Sheet (change the date in URL)</a> -->
  <li>Safety Patrol Sign-in Sheet: <BR>
  <?php 
    $RS1=mysqli_query($conn,$SQLstring) ;
    while($RSA1=mysqli_fetch_array($RS1)) {
       echo "   <a href=\"SchoolSafetyPatrolSigninSheet.php?date=".$RSA1[Date] . "\">". $RSA1[Date] . "</a><BR>";
    } ?>
      <li><a href="ServedSafetyPatrol_form.php" target="_blank">Update Safety Patrol for a Served Day</a>
   </td>
 </tr>
</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
