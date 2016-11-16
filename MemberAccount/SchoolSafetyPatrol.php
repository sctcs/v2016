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
<table width="70%" background="" bgcolor="" border="0" align="center">
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


						$SQLstring = "select sp.FamilyID,sp.Year,sp.Term,sp.ChildClass,sp.Period,sp.ScheduledDate,sp.ServedDate,sp.Status,concat_ws(', ', m.LastName, m.FirstName) as Name   from tblSafetyPatrol sp, tblMember m  "
						            ."where sp.FamilyID=m.FamilyID  and m.PrimaryContact='Yes' ";
                                if ( $_GET[year] != "" ) {
                                      if ( $_GET[year] != "" ) {
         					$SQLstring .= " and sp.Year='". $_GET[year] ."' ";
 					}
                                      if ( $_GET[term] != "" ) {
         					$SQLstring .= " and sp.Term='". $_GET[term] ."' ";
 					}
                                } else {
         					$SQLstring .= " and ((sp.Year ='". $CurrentYear ."' and sp.Term ='". $CurrentTerm ."') or (sp.Year ='". $NextYear ."' and sp.Term ='". $NextTerm ."'))";
                                }
                                      if ( $date != "" ) {
         					$SQLstring .= " and sp.ScheduledDate='". $date ."' ";
 					}
$myname=$_POST[myname];
 					if ($_POST[myname] != "" )
 					{

 					  $SQLstring .= " and (m.FirstName like '%" .$myname . "%' or m.LastName like '%" .$myname . "%')";
 					}
//echo $SQLstring;
						$SQLstring .=" order by sp.ScheduledDate,sp.Period,Name";
						$RS1=mysqli_query($conn,$SQLstring);

					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="left">&nbsp;
<h2>Safety Patrol Schedule for <?php echo $SchoolYear; ?> School Year </h2>
<h3>Note to Parents: </h3>
<ul>
  <li> You are assigned the school safety patrol duty either from 1:00 pm to 3:00 pm or from 3:00 pm to 5:00 pm depending on in which period your child is taking the language class.  Your additional help is always appreciated if you child is attending enrichment class(es).  Please arrive at the Chinese school at 1:00 pm or 3:00 pm on Sunday and report to the Safety Desk at the front door. One of the safety patrol lead will assist you with your duty.
<li> If you cannot serve the date or time assigned, you should contact support@ynhchineseschool.org in advance to pick another date or time, or you can switch with another family if you can find one who is willing to do so.
  <li>
Please read the <a href="../public/SafetyPatrolGuideLine.ppt">School Guidelines for Parents on Duty and Fire Emergency Responses </a>to refresh your memory.  For the school and our children's safety, please review the document carefully.  When you are on duty, make sure to get yourself familiar with the nearest emergency exits.  In case of fire emergency or drill, direct and help teachers, students and parents to evacuate the building quickly to a designated safe place (front parking lot, 300 ft away from our building). </li>

</ul>
<ul>
  <li> You can use the Find function here or of your browser (Control-F for Windows or Command-F for Mac) to find your name and scheduled date/time, or
   you can view your patrol schedule after login as parent, My Account -> My Safety Patrol Schedule.
</ul>

<?php
if ($date != "" ) {
   echo $date;
        echo "<a href=\"SchoolSafetyPatrol.php\">All Dates</a>";
////} else {
   $sqlstr="select distinct Year, Term, ScheduledDate from tblSafetyPatrol order by Year, Term, ScheduledDate";
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
<td align=right>
<form action="SchoolSafetyPatrol.php" method="post">
My First or Last Name: <input type="text" name="myname" value="<?php echo $myname; ?>">
         <input type="submit" value="Find">
</form>

</td>
</tr>
							<tr>
								<td>
									<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">
<th>Scheduled Date</th><th>Period</th><th>Name</th><th>FamilyID</th><th>ChildClass</th><th>Detail</th>
                                                                        <?php while($RSA1=mysqli_fetch_array($RS1)) {
                                                                                  echo "<tr>";
                                                                                 echo "    <td align=center>". $RSA1[ScheduledDate] ."</td>";
if ($RSA1[Period] =="1") {$period=$PERIOD1;}else{$period=$PERIOD3;}
                                                                                 echo "    <td align=center>". $period ."</td>";
                                                                                 echo "    <td align=left>&nbsp;&nbsp;". $RSA1[Name] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[FamilyID] ."</td>";
                                                                                 echo "    <td align=center>". $RSA1[ChildClass] ."</td>";
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
