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
<title>Student Attendance</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />

</head>

<body>


<a href="javascript:window.history.back();">Back</a>
<a href="MemberAccountMain.php">My Account</a>
<br><br>

<?php
			echo "ClassID:	" . $classid ."  "; 
			echo "Teacher:	" . $_GET[firstname]." ".$_GET[lastname] .""; 
?>
  <form method="POST" name="attendance" action="updateAttendanceAll.php">
			<table width="100%" CELLSPACING="0" CELLPADDING="0" border="1">
			<tr>
			<th>ID</th><th>Eng. Name</th><th>Chi. Name</th>
                      
<?php
$sqlatt="SELECT * from tblCalendar where Year='". $_GET[year] ."' and Term='".$_GET[term]."'";
                    $RSATT=mysqli_query($conn,$sqlatt);
		while ( $rowatt=mysqli_fetch_array($RSATT) ){
		echo "	<th nowrap>". $rowatt[Date]. "</th>";
	}
              echo "  </tr>";

     $SQLstring = "select *   from viewClassStudents v, tblMember m where v.MemberID=m.MemberID "
                                                            ." and v.ClassID='".$classid."'"
                                                            ."                           order by v.LastName";//.$_SESSION[memberid];
    if ($DEBUG) { echo "see111: ".$SQLstring; }
    $RS1=mysqli_query($conn,$SQLstring);
    while ( $row=mysqli_fetch_array($RS1) ){
?>

                      <tr>
                <?php 
			echo "  <td>". $row[MemberID]. "</td>";
                        $sid = $row[MemberID];
			echo "  <td>". $row[LastName].", ".$row[FirstName]. "</td>";
			echo "  <td>". $row[ChineseName]. "&nbsp;</td>";
?>
<input type="hidden" name="classid" value="<?php echo $classid;?>">
<input type="hidden" name="studentid[]" value="<?php echo $row[MemberID];?>">
<?php 
// Attendance:
$sqlatt="SELECT * from tblAttendance where ClassID='". $_GET[classid] ."' and StudentID='".$row[MemberID]."'";
                    $RSAT1=mysqli_query($conn,$sqlatt);
  unset($attended);
		while ( $rowat1=mysqli_fetch_array($RSAT1) ){
                     $attended[$rowat1[CalendarID]]=1;
}

$sqlatt="SELECT * from tblCalendar where Year='". $_GET[year] ."' and Term='".$_GET[term]."'";
                    $RSATT=mysqli_query($conn,$sqlatt);
//                    $rowatt=mysqli_fetch_array($RSATT);
		while ( $rowatt=mysqli_fetch_array($RSATT) ){
                  if ( $attended[$rowatt[ID]] == 1 ) {
                    echo "<td><input type=\"checkbox\" CHECKED name=\"chk_attendance_".$sid."[]\" value=\"". $rowatt[ID]."\" />".  "</td>";
                  } else {
                    echo "<td><input type=\"checkbox\" name=\"chk_attendance_".$sid."[]\" value=\"". $rowatt[ID]."\" />".  "</td>";
                  }
		}

						echo "	</tr>";


		}	
					?>

			</table>
<br>
 <input type="submit" style="font-size : 20px; font-weight: bold;" value="Update">
</form>

</body>
</html>
<?php mysqli_close($conn); ?>
