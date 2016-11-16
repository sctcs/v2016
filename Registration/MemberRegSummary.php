<?php session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
 session_start(); 
		unset($_SESSION['family_id']);
?> 


<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Memeber Reg Summary</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../../common/ynhc.css" rel="stylesheet" type="text/css">
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
					<td width="26%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>
						
						
					</td>
					
					<td align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr><td >Thanks you for register with us. Your registration has been complete.</td></tr>
							<!-- <tr><td><?php 
							echo "fid: ".$_SESSION['family_id'];  ?>
							</td></tr> -->
						</table>
					</td>
					<td  width="16%">
						<?php include("../Advertisment/ad2.php"); ?>
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
