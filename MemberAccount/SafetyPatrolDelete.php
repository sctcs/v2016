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
$fid = $_GET[fid];
$spid = $_GET[spid];
$ans = $_GET[ans];

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>

<html>
<body>

<?php if ($ans != "yes" ) { ?>
Are you sure?
<br>
<a href="SafetyPatrolDelete.php?fid=<?php echo $fid; ?>&spid=<?php echo $spid; ?>&ans=yes">Yes</a>
<br>
<a href="ViewSafetyPatrol.php?fid=<?php echo $fid; ?>">No</a>

<?php }  else {

 if ( $spid != "" ) {
 $SQLstring = "delete from      `tblSafetyPatrol`  where ID=".$spid;


 //echo "<br>SQLstring:  ".$SQLstring;

 if (!mysqli_query($conn,$SQLstring)) { die('Error: ' . mysqli_error($conn)); }
 }
 header( 'Location: ViewSafetyPatrol.php?fid=' . $fid ) ;
} 

?>

</body>
</html>

<?php
mysqli_close($conn);

?>


