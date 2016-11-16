<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

$seclvl = $_SESSION['membertype'];

if (isset($_GET[date]) && $_GET[date] != "") {
$date = $_GET[date];
} else {
$date="";
}

$period = $_GET[period];

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>All Safety Patrol Schedule</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>

<body>

<?php


$SQLstring = "SELECT concat_ws( '', m.Email, ';' ) as email
FROM tblMember m, tblSafetyPatrol s
WHERE m.FamilyID = s.FamilyID
AND m.PrimaryContact = 'Yes'
AND s.ScheduledDate = '". $date ."' "
. " AND s.Period = '". $period ."' ";


//echo $SQLstring;

						$RS1=mysqli_query($conn,$SQLstring);

	?>
<?php
while($RSA1=mysqli_fetch_array($RS1)) {

  echo  $RSA1[email] ;

} ?>




</body>
</html>

<?php
    mysqli_close($conn);
 ?>
