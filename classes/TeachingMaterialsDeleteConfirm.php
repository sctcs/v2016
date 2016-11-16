<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if( !isset($_SESSION['logon']) || !isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25  )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a> as the person who created the file' ) ;
 echo '<br><br><a href="TeachingMaterialsListDetail.php">back</a>';
 exit();
}

$tmid=$_GET[tmid];

include("../common/DB/DataStore.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Fmaily Profile</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
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
					<td width="0%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>

					</td>


					<td align="center" valign="top">
						<br>Teaching Material Deletion<br><br>
						<table width="100%" border="0">
						<tr><td colspan=2><H3>Are you sure that you want to delete this file permanently?</H3></td></tr>
						<tr><td align="center">
						<?php
						echo '<a href="TeachingMaterialsDelete.php?tmid='.$_GET[tmid]."\">Yes</a></td>";
						?>
						</td><td align="left">
						<a href="TeachingMaterialsListDetail.php">No</a>

						</table>

					</td>

				</tr>
                     </td></tr>
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
<?php mysqli_close($conn); ?>