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

$today = getdate();
$mon = $today[mon];
//if ( $mon > 6) {
//	$term = "Fall";
//} else {
//	$term = "Spring";
//}
$term=$_GET[term];
$year=$_GET[year];
if (!isset($year) || $year =="") 
{
    $year = $today[year];
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Safety Patrol Form</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
</head>

<body>
 <?php
    $SQLstring="SELECT Date from tblCalendar where (Year='" . $CurrentYear ."' and Term='". $CurrentTerm . "') or (Year='". $NextYear ."' and Term='". $NextTerm ."')";  
//  echo $SQLstring;
    $RS1=mysqli_query($conn,$SQLstring) ;
?>

<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" >

			<?php
if (isset($_GET[sdate]) && $_GET[sdate] != "" )
{
   $sdate = $_GET[sdate];
}
if (isset($_GET[nf]) && $_GET[nf] != "" )
{
   $nf = $_GET[nf];
}
if (isset($_GET[pd]) && $_GET[pd] != "" )
{
   $pd = $_GET[pd];
}
?>
<table width="100%">
<tr><td align="left" ><a href="ManageSafetyPatrol.php">Manage Safety Patrol</a></td></tr>

<tr>
<td align="center"><BR>Assign Safety Patrol  for a Day</td>
</tr>

<tr>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td>
<form action="AssignSafetyPatrol_save.php" method="post">
  <table  >
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
<!--  <tr><td align=right>Scheduled Date: </td><td><input type="text" name="sdate" value="<?php echo $sdate; ?>"> (YYYY-MM-DD) </td></tr> -->
  <tr><td align=right>Scheduled Date: </td><td>
          <SELECT            name="sdate" > 
  <?php 
    while($RSA1=mysqli_fetch_array($RS1)) {
      if ($sdate != "" && $sdate == $RSA1[Date] ) {
       echo "   <OPTION value='".$RSA1[Date] . "' SELECTED>". $RSA1[Date] . "</OPTION>";
      } else {
       echo "   <OPTION value='".$RSA1[Date] . "'>". $RSA1[Date] . "</OPTION>";
      }
    } ?>
          </SELECT>
     </td></tr> 
  <tr><td align=right>Period: </td><td><input type="text" name="period" value="<?php echo $pd; ?>"> (1 or 3)  </td></tr>
  <tr><td align=right>Number of Families: </td><td><input type="text" name="nf" value="<?php echo $nf; ?>">  </td></tr>
							
</table> <br><br><br>
<input type="submit" value="View Output">
<input type="submit"   name="save" value="Save">
<input type="button"   onClick="window.location.href='ManageSafetyPatrol.php'" value="Cancel">
</form>
</td>
</tr>
</table>
</td>
</tr>

</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
