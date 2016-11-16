<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
if(! isset($_SESSION['family_id']))
{
 echo "You need to login first";
 exit();
}
if(! isset($_GET[regid]) || $_GET[regid] =="" )
{
 echo "You need to specify a valid class registration id";
 exit();
}
if(! isset($_GET[stuid]) || $_GET[stuid] =="" )
{
 echo "You need to specify a valid student id";
 exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Drop a Class</title>
<meta name="keywords" content="Southern Connecticut Chinese School, Chinese School">

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>
<body>
<?php
	echo "Are you sure you want to drop the class?<br><br>";
?>
<a href="studentRegisterClassDrop.php?action=Drop&regid=<?php echo $_GET[regid];?>&stuid=<?php echo $_GET[stuid];?>">Yes</a>
<BR><BR>
<a href="studentClassesRegistered.php?stuid=<?php echo $_GET[stuid];?>">No</a>


</body>
</html>
