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
	$SQLstring = "UPDATE tblClassRegistration set Status='Dropped',DateTimeRegistered=now() where ClassRegistrationID=".$_GET[regid];
	//echo $SQLstring;
	if (!mysqli_query($conn,$SQLstring))
    {
       die($SQLstring .'; Error: ' . mysqli_error($conn));
    }

if ( $_GET[action] == "Drop" ) {
  echo "<a href=\"studentClassesRegistered.php?stuid=".$_GET[stuid]."\">Classes Registered</a>";
  header( 'Location: studentClassesRegistered.php?stuid='.$_GET[stuid] );
} else {
  echo "<a href=\"studentRegisterClass.php?stuid=".$_GET[stuid]."\">Register Class</a>";
  header( 'Location: studentRegisterClass.php?stuid='.$_GET[stuid] );
}
?>
</body>
</html>
