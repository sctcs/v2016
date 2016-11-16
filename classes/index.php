<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
	session_start();
	//only for principal
	if(! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 20 ) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Southern Connecticut Chinese School Class Management</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>
<body>
	<table>
 	 	<tr><td>&nbsp;</td></tr>
 	 	<tr><?php include("classesmenu.php");?>
 	 		<td  valign='top'>
 	 		<div class=Section1 style="layout-grid:15.6pt 0pt" align="left">
<!--start content  -->

<!--end of content  -->

			</div>
			</td>
		</tr>
	</table>
</body>
</html>
