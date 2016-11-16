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
$year = $today[year];
$mon = $today[mon];
//if ( $mon > 6) {
//	$term = "Fall";
//} else {
//	$term = "Spring";
//}
$term=$_GET[term];

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
<tr>
<td align="center"><BR>Served Safety Patrol for a Day</td>
</tr>

<tr>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td>
<form action="ServedSafetyPatrol_save.php" method="post">
  <table  >
  <tr><td align=right>Scheduled Date: </td><td><input type="text" name="sdate" value="<?php echo $sdate; ?>"> (YYYY-MM-DD) </td></tr>
  <tr><td align=right>Families: </td><td><input type="text" name="fids" value="<?php echo $fids; ?>">  </td></tr>
							
</table> <br><br><br>
<input type="submit"   name="save" value="Save">
<input type="button"   onClick="window.location.href='ServedSafetyPatrol_form.php'" value="Cancel">
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
