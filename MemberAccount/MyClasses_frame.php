<?php
//session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to log in' ) ;
 exit();
}
if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
{
 echo ( 'you need to log in as a teacher or school admin' ) ;
 exit();
}
include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>My Classes</title>

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

					<?php
					     //echo $_SESSION[memberid];
						$SQLstring = "select *   from tblClass where CurrentClass='Yes' and TeacherMemberID=".$_SESSION[memberid];

						$RS1=mysqli_query($conn,$SQLstring);

					?>
					<td align="center" valign="top">
					My Classes
						<table width="100%" border=1>
						<tr><th>Grade</th><th>Number</th><th>Room</th><th>Term</th><th>Year</th><th nowrap>Students</th></tr>
                    <?php
					  while ( $row=mysqli_fetch_array($RS1) ){
						echo "	<tr>";
						echo "		<td align=center>" . $row[GradeOrSubject] ."</td><td align=center>". $row[ClassNumber] . "</td><td nowrap align=center>". $row[Classroom] ."</td><td nowrap align=center>". $row[Term] ."</td><td nowrap align=center>". $row[Year] ."</td>" ;
						echo "      <td align=center><a href=\"MyStudents.php?teacherid=".$row[TeacherMemberID]."&classid=".$row[ClassID]."&classname=".$row[GradeOrSubject].".".$row[ClassNumber]."&classroom=".$row[Classroom]."&year=".$row[Year]."&term=".$row[Term]."&showattendance=no\">Students</a></td><td>".$pphones."</td><td>".$pemails."</td>";
						echo "	</tr>";
					  }
						?>
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
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>
<?php mysqli_close($conn); ?>
