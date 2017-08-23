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
<title>All Safety Patrol Schedule</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

<script language="JavaScript">

	function sendme(who)
	{
		//alert("here ");
		document.all.Container.value=who;

	}
</script>
</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" bgcolor="#993333"> 
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="1%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php

						$SQLstring = "select sp.FamilyID,sp.Year,sp.Term,sp.ChildClass,sp.Period,sp.ScheduledDate,sp.ServedDate,sp.Status   from tblSafetyPatrol sp, tblMember m  "
						            ."where sp.FamilyID=m.FamilyID  and m.PrimaryContact='Yes' and sp.Year>2014 ";
                                      if ( $date != "" ) {
         					$SQLstring .= " and sp.ScheduledDate='". $date ."' ";
 					}
//echo $SQLstring;
 if ( $date !="") {
						$SQLstring .=" order by sp.ChildClass,sp.FamilyID, sp.ID";
 } else {
						$SQLstring .=" order by sp.FamilyID, sp.ID";
 }
						//echo $SQLstring;
						//$RS1=mysqli_query($conn,$SQLstring);

					?>
					<td align="center" valign="top">
						<table width="100%">
					<tr><td align="left" ><a href="ManageSafetyPatrol.php">Manage Safety Patrol</a></td></tr>
							<tr>
								<td align="center"><BR>Safety Patrol Schedule</td>
							</tr>


							<tr>
								<td align="center">&nbsp;<a href="SafetyPatrolForm.php">Add New Schedule</a></td>
							</tr>
							<tr>
								<td align="center">&nbsp; 
<?php
if ($date != "" ) {
   echo $date;
        echo "<a href=\"ViewAllSafetyPatrol.php\">All Dates</a>";
} else {
   $sqlstr="select distinct Year, Term, ScheduledDate from tblSafetyPatrol where Year>2014 order by Year, Term, ScheduledDate";
   $rs=mysqli_query($conn,$sqlstr);
   ?>
   <table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">
   
   <?php
     echo "<tr><td>";
   $i=0;
   while($rsa=mysqli_fetch_array($rs)) {
     $i++;
//   echo "<tr><td>".$rsa[Year]."</td>";
//   echo "    <td>".$rsa[Term]."</td>";
        echo "<a href=\"ViewAllSafetyPatrol.php?date=".$rsa[ScheduledDate]."\">". $rsa[ScheduledDate] . "</a>&nbsp;";
//   if ( ($i % 8) ==0 ) { echo "<br>"; }
     if ( ($y0 != "" && $rsa[Year] != $y0) || ($t0!="" && $rsa[Term] != $t0) ) {
        echo "</td></tr>";
        echo "<tr><td>";
     }
     $y0 = $rsa[Year];
     $t0 = $rsa[Term];
   }
   echo "</table>";
}

?>
</td>
							</tr>
<?php
if ($bydate != "yes" ) {
?>
							<tr>
								<td>
									<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">
                                                                        <th>FamilyID</th><th>Year</th><th>Term</th><th>ChildClass</th><th>Period</th><th>Scheduled Date</th><th>Served Date</th><th>Status</th><th>Action</th>
                                                                        <?php 
																		mysqli_query($conn,"SET SQL_BIG_SELECTS=1");
																		$RES1=mysqli_query($conn, $SQLstring) ;
																		if (! $RES1 ) {
    die ('Cannot use '.$dbName.' : ' . mysqli_error($conn));
}
																		while($RSA1=mysqli_fetch_array($RES1)) {
                                                                                 echo "<tr><td align=center>". $RSA1[FamilyID] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[Year] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[Term] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[ChildClass] ."</td>";
if ($RSA1[Period] =="1") {$period=$SPPERIOD1;}else{$period=$SPPERIOD3;}
                                                                                 echo "    <td align=center>". $period ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[ScheduledDate] ."</td>";
                                                                                 echo "    <td align=center>&nbsp;". $RSA1[ServedDate] ."</td>";
                                                                                 echo "    <td align=center>&nbsp;". $RSA1[Status] ."</td>";
                                                                           //    if ( $RSA1[ServedDate] != null ) {
                                                                           //       echo "<td align=center>Served</td>";
                                                                           //    } else {
                                                                           //       echo "<td align=center>not Served</td>";
                                                                           //    }
echo "<td><a href=\"ViewSafetyPatrol.php?fid=". $RSA1[FamilyID] ."\">View</td>";
                                                                                 echo "</tr>";
                                                                               } ?>
									</table>
								</td>
							</tr>
<?php } ?>
						</table>
					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>

		</td>
	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
