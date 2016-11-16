<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
// echo ( '<center>you need to login, <a href="MemberLoginForm.php">login now<a/></center>' ) ;
 //header( 'Location: MemberLoginForm.php');
// exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
//{
if ( isset($_SESSION[membertype]) ) {
if ( $_SESSION[membertype] == 10 ||
     $_SESSION[membertype] == 15 ||
     $_SESSION[membertype] == 25 ||
     $_SESSION[membertype] == 20 ||
     $_SESSION[membertype] == 40 ||
     $_SESSION[membertype] == 55
   ) {  
   ;
} } else {
 echo ( 'you need to log in as a teacher or school admins' ) ;
//header( 'Location: MemberLoginForm.php' );
 exit();
}
//if(! isset($_GET[teacherid]) )
//{
// echo ( 'you need to enter  a valid teacher memberID' ) ;
// exit();
//}
if(! isset($_GET[classid]) )
{
 echo ( 'you need to enter  a valid class ID' ) ;
 exit();
} else {
 $classid = $_GET[classid];
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
//mysql_select_db($dbName, $conn);
$seclvl = $_SESSION[membertype];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SCCS Students in a Class</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />

</head>

<body>


<a href="javascript:window.history.back();">Back</a>
<center>

					<tr>
					</tr>
			</table>
  <form method="POST" name="attendance" action="updateAttendance.php">
			<table width="90%" CELLSPACING="0" CELLPADDING="0" border="1">
			<tr>
				<th>ClassID</th><th>studentID</th><th>Name</th><th>Attendance</th>
                      
                      </tr><tr>
                <?php 
			echo "	<td>" . $classid ."</td>";
			echo "  <td>". $_GET[MID]. "</td>";
			echo "  <td>". $_GET[lastname].", ".$_GET[firstname]. "</td>";
?>
<input type="hidden" name="classid" value="<?php echo $classid;?>">
<input type="hidden" name="studentid" value="<?php echo $_GET[MID];?>">
<?php 
// Attendance:
 echo "<td>";
$sqlatt="SELECT * from tblAttendance where ClassID='". $_GET[classid] ."' and StudentID='".$_GET[MID]."'";
                    $RSAT1=mysqli_query($conn,$sqlatt);
		while ( $rowat1=mysqli_fetch_array($RSAT1) ){
                     $attended[$rowat1[CalendarID]]=1;
}

$sqlatt="SELECT * from tblCalendar where Year='". $_GET[year] ."' and Term='".$_GET[term]."'";
                    $RSATT=mysqli_query($conn,$sqlatt);
//                    $rowatt=mysqli_fetch_array($RSATT);
		while ( $rowatt=mysqli_fetch_array($RSATT) ){
                  if ( $attended[$rowatt[ID]] == 1 ) {
                    echo "<input type=\"checkbox\" CHECKED name=\"chk_attendance[]\" value=\"". $rowatt[ID]."\" />". $rowatt[Date]. "<br />";
                  } else {
                    echo "<input type=\"checkbox\" name=\"chk_attendance[]\" value=\"". $rowatt[ID]."\" />". $rowatt[Date]. "<br />";
                  }
			}
 echo "<input type=\"submit\" value=\"Update\">";
 echo "</td>";

						echo "	</tr>";


			
					?>

			</table>
</form>

</center>
</body>
</html>
<?php mysqli_close($conn); ?>
