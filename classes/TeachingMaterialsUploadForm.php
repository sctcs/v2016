<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to log in as a teacher' ) ;
 exit();
}

if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
{
 echo ( 'you need to log in as a teacher or administrator' ) ;
 exit();
}

include("../common/DB/DataStore.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Teaching Material Upload Form</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
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
					<td width="6%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>Upload a New Teaching Material </b></font></td>
							</tr>
 							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#FFFFFF">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form enctype="multipart/form-data" name="NewTM" action="TeachingMaterialsUpload.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="MAX_FILE_SIZE" value="2000000" />

										<tr>
											<td width="30%" align="Right">File Description: </td>
											<td width="70%" align="Left"> <input type="text" size="40" maxlength="100" name="FileDescription"></td>
										</tr>
										
										<tr>
											<td width="30%" align="Right">Àà±ð: </td>
											<td width="70%" align="Left"> 
											
											<SELECT NAME="MaterialType">
											<OPTION VALUE="½Ì°¸">½Ì°¸
											<OPTION VALUE=" ½ÌÑ§Ìå»á ">½ÌÑ§Ìå»á
											<OPTION VALUE=" ½ÌÑ§¶¯Ì¬ ">½ÌÑ§¶¯Ì¬
											<OPTION VALUE=" ¿ÎÌÃ½ÌÑ§¼¼ÇÉ "> ¿ÎÌÃ½ÌÑ§¼¼ÇÉ
											<OPTION VALUE="²¹³ä²ÄÁÏ">²¹³ä²ÄÁÏ
											<OPTION VALUE="ÆäËü">ÆäËü
											</SELECT>
											</td>
										</tr>

										<tr>
											<td width="30%" align="Right">ÊµÓÃÄê¼¶: </td>
											<td width="70%" align="Left"> <input type="text" size="20" maxlength="20" name="MaterialGrade"></td>
										</tr>

										<tr>
											<td width="50%" align="Right"  valign="top">Teaching Material File: </td>
											<td><input type="file" size="60" maxlength="150"  name="tmfile"  >
											(File name should not contain Space or other special charaters, dash or underscore is OK; a good file name can be, e.g. tm20080313.doc or tm_03_13_2008.pdf. Chinese characters are not allowed in the file name.)
											</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="right">
												<input type="submit" value="Upload">
											</td>
											<td align="center">
												<input type="button" width="18"  onClick="window.location.href='TeachingMaterialsListDetail.php'" value="Cancel">
											</td>
										</tr>

										</form>
									</table>
								</td>
							</tr>
						</table>
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
		<?php //include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

<?php mysqli_close($conn); ?>