<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

//echo $_SESSION['logon'];
//echo $_SESSION[membertype];

if( !isset($_SESSION['logon']) || !isset($_SESSION[membertype]) ||  $_SESSION[membertype] != 25  )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a> as the teacher who created the homework' ) ;
 echo '<br><br><a href="HomeworkList.php">back</a>';
 exit();
}

if ( ! isset($_GET[hwid]) ||  $_GET[hwid] =="" )
{
  echo 'you need to provide a valid HW ID';
  exit;
}

if ( ! isset($_GET[hwmembid]) ||  $_GET[hwmembid] =="" )
{
  echo 'you need to provide a valid teacher ID';
  exit;
}

$hwid=$_GET[hwid];
$hwmembid=$_GET[hwmembid];

if( !isset($_SESSION['memberid']) ||  $_SESSION[memberid] != $hwmembid  )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a> as the teacher who created the homework' ) ;
 echo '<br><br><a href="HomeworkList.php">back</a>';
 exit();
}

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
						$SQLstring = "update tblClassHomework set Status='Deleted' where ClassHomeworkID=".$hwid;
						$RS1=mysqli_query($conn,$SQLstring);
						if (! $RS1 ) {
						  echo mysqli_error($conn);
						  exit;
						}

                        $SQLstring = "select Filepath,ClassID,Filename,Filetype from tblClassHomework where ClassHomeworkID=".$hwid .' limit 1';
						$RS1=mysqli_query($conn,$SQLstring);
						if (! $RS1 ) {
						  echo mysqli_error($conn);
						  exit;
						}
						$row=mysqli_fetch_array($RS1);

					?>

					<td align="center" valign="top">
						<br>Homework Deletion<br><br>
						<table width="100%" border="0">
                        <?php
                            echo 'Homework ID '. $hwid . ' has been deleted successfully<br>';
                            $oldfile=$row[Filepath].'/'.$row[ClassID].'_'.$row[Filename].'.'.$row[Filetype];
                            $newfile=$oldfile.'_deleted_'.date("YmdHis");
                          //  echo "renaming ".$oldfile. " to ". $newfile;
                            if ( ! rename($oldfile, $newfile)) {
                               echo "failed to delete file ". $oldfile;
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