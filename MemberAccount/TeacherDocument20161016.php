<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Teacher Manual</title>
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
	<tr>
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td align="center" valign="top">
						<table>
							<tr>
								<td>&nbsp;
<div class=Section1>

<H3>Teacher Manual</H3>
<p>
<p class=MsoNormal><a href=../classes/TeachingMaterials/sub-application.doc>Application for Teacher Substitution</a></p>
<p class=MsoNormal><a href=../Files/Documents/Teachers/contact.htm>School Employee Directory</a></p>
<p class=MsoNormal><a href=../Files/Documents/Teachers/evaluationsample.xls>Student Attendance and Score</a></p>
<p class=MsoNormal><a href=../Files/Documents/Teachers/standard.htm>Student Evaluation Standard</a></p>
<p class=MsoNormal><a href=../classes/TeachingMaterialsListDetail.php>Teaching Material Sharing</a></p>
<p class=MsoNormal><a href=../Files/Documents/Teachers/token.htm>Token</a></p>
<p class=MsoNormal><a href=../classes/HomeworkList.php>Upload Homework</a></p>
<p></p>
<p></p>
<p></p>
<p></p>

</div>

								</td>
							</tr>

						</table>



					</td>
					<td  width="8%">
						<?php //include("../Advertisment/ad2.php"); ?>
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
