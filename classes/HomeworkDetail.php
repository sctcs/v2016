<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
//echo $_SESSION['logon'];
//echo $_SESSION[membertype];

if( !isset($_SESSION['logon']) || !isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a> as a teacher or school admin' ) ;
 exit();
}

if ( ! isset($_GET[hwid]) ||  $_GET[hwid] =="" )
{
  echo 'you need to provide a valid HW ID';
  exit;
}

$hwid=$_GET[hwid];

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

					<?php
					     //echo $_SESSION[memberid];
						$SQLstring = "select *   from tblClassHomework,tblClass,tblMember where tblClassHomework.ClassID=tblClass.ClassID and tblClass.TeacherMemberID=tblMember.MemberID and tblClassHomework.ClassHomeworkID=".$hwid;
						// and TeacherMemberID=".$_SESSION[memberid];

						$RS1=mysqli_query($conn,$SQLstring);

					?>

					<td align="center" valign="top">
						<br>Homework Detail<br><br>
						<table width="100%" border="0">
                        <?php
                        while ($row=mysqli_fetch_array($RS1) ) {
                           echo '<tr><td align="right">HW ID: </td><td align="left">'. $hwid . '</td><tr>';
                           echo '<tr><td align="right">Grade: </td><td align="left">'. $row[GradeOrSubject] . '</td><tr>';
                           echo '<tr><td align="right">Class: </td><td align="left">'. $row[ClassNumber] . '</td><tr>';
                           echo '<tr><td align="right">Room: </td><td align="left">'. $row[Classroom] . '</td><tr>';
                           echo '<tr><td align="right">Teacher: </td><td align="left">'. $row[LastName].', '.$row[FirstName] . '</td><tr>';
                           echo '<tr><td align="right">HW Desc: </td><td align="left">'. $row[Description] . '</td><tr>';
                           echo '<tr><td align="right">DueDate: </td><td align="left">'. $row[DueDate] . '</td><tr>';
                           echo '<tr><td align="right">File: </td><td align="left">'. $row[Filename].'.'.$row[Filetype] . '</td><tr>';
                           echo '<tr><td align="right">Path: </td><td align="left">'. $row[Filepath] . '</td><tr>';
                           echo '<tr><td align="right">CreatedBy: </td><td align="left">'. $row[CreatedByMemberID] . '</td><tr>';
                           echo '<tr><td align="right">CreatedDate: </td><td align="left">'. $row[CreatedDate] . '</td><tr>';
                        }
                        ?>
						</table>
						<br>
						<a href="HomeworkList.php">other homeworks</a>
						<br>
						<br>
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