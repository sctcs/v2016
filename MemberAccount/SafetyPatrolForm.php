<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(! isset($_SESSION['family_id']))
{
 header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

//echo $_SESSION['membertype'];
//echo $_SESSION['memberid'];
//exit();


$today = getdate();
$year = $today[year];
$mon = $today[mon];
if ( $mon > 6) {
	$term = "Fall";
} else {
	$term = "Spring";
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Safety Patrol Form</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" >

			<?php

$fid = $_GET[fid];
$spid = $_GET[spid];
 if ( $spid != "" ) {
     $SQLstring = "select *   from tblSafetyPatrol   " ."where ID=".$spid ;
     $RS1=mysqli_query($conn,$SQLstring);
     $RSA1=mysqli_fetch_array($RS1);
  $year = $RSA1[Year];
  $term = $RSA1[Term];
  $period = $RSA1[Period];
  $cclass = $RSA1[ChildClass];
  $fid  = $RSA1[FamilyID];
}

			?>
				<table width="100%">
					<tr>
						<td align="center"><BR>Safety Patrol Schedule</td>
					</tr>


					<tr>
						<td align="center">&nbsp;</td>
					</tr>
					<tr>
						<td>
						<form action="SafetyPatrolSave.php" method="post">
							<table  >
                                                        <tr><td align=right>FamilyID: </td><td><input type="text" name="fid" value="<?php echo $fid; ?>" > <input type="hidden" name="spid" value="<?php echo $spid; ?>"> </td></tr>
                                                        <tr><td align=right>Year: </td><td><input type="text" name="year" value="<?php echo $year; ?>" > (YYYY) </td></tr>
                                                        <tr><td align=right>Term: </td><td><select            name="term"> 
              								<?php if ($term == "Fall") { ?>
                                                                                           <option value="Fall" SELECTED>Fall</option> 
									<?php } else { ?>
                                                                                           <option value="Fall" >Fall</option> 
									<?php }  ?>
              								<?php if ($term == "Spring") { ?>
                                                                                           <option value="Spring" SELECTED>Spring</option> 
									<?php } else { ?>
                                                                                           <option value="Spring">Spring</option> 
									<?php }  ?>
                                                           </td></tr>
                                                        <tr><td align=right>Period: </td><td><input type="text" name="period" value="<?php echo $RSA1[Period]; ?>"> (1 or 3) </td></tr>
                                                        <tr><td align=right>Child Class: </td><td><input type="text" name="cclass" value="<?php echo $RSA1[ChildClass]; ?>"> e.g. 1.2 </td></tr>
                                                        <tr><td align=right>Scheduled Date: </td><td><input type="text" name="sdate" value="<?php echo $RSA1[ScheduledDate]; ?>"> (YYYY-MM-DD) </td></tr>
                                                        <tr><td align=right>Served Date: </td><td><input type="text" name="vdate" value="<?php echo $RSA1[ServedDate]; ?>"> (YYYY-MM-DD) </td></tr>
							
							</table> <br><br><br>
						<input type="submit" value="Save">
						<input type="button"   onClick="window.location.href='SafetyPatrolForm.php'" value="Cancel">
						</form>
						</td>
					</tr>
				</table>
		</td>
	</tr>
	<tr>
		<td>
 <a href="ViewSafetyPatrol.php?fid=<?php echo $fid; ?>">View Safety Patrol Schedule</a>
		</td>
	</tr>
	<tr>
		<td>
		<?php // include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
