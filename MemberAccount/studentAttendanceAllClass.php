<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
   echo ( '<center>you need to login, <a href="MemberLoginForm.php">login now<a/></center>' ) ;
   header( 'Location: MemberLoginForm.php');
   exit();
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
//if(! isset($_GET[classid]) )
//{
// echo ( 'you need to enter  a valid class ID' ) ;
// exit();
//} else {
// $classid = $_GET[classid];
//}

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

Show those students attended no 
<a href="studentAttendanceAllClass.php?ATT=0&show_all=No&year=<?php echo $_GET[year]; ?>&term=<?php echo $_GET[term]; ?>" > sessions in <?php echo $_GET[year]." ".$_GET[term]; ?> </a><br> 

Show those students attended no more than 
<a href="studentAttendanceAllClass.php?ATT=2&show_all=No&year=<?php echo $_GET[year]; ?>&term=<?php echo $_GET[term]; ?>" >2 sessions in <?php echo $_GET[year]." ".$_GET[term]; ?> </a><br> 

Show those students attended no more than 
<a href="studentAttendanceAllClass.php?ATT=3&show_all=No&year=<?php echo $_GET[year]; ?>&term=<?php echo $_GET[term]; ?>" >3 sessions in <?php echo $_GET[year]." ".$_GET[term]; ?> </a><br> 

Show all students attended  
<a href="studentAttendanceAllClass.php?ATT=0&show_all=Yes&year=<?php echo $_GET[year]; ?>&term=<?php echo $_GET[term]; ?>" >no or any sessions in <?php echo $_GET[year]." ".$_GET[term]; ?> </a><br> 


<br><br>
<?php
// MID=2972&classid=1057&year=2016&term=Fall&lastname=qiao&firstname=xianliang
$sqlclass="SELECT * from tblClass where Year='". $_GET[year] ."' and Term='".$_GET[term]."'";
$RSAclass=mysqli_query($conn,$sqlclass);
while ( $rowclass=mysqli_fetch_array($RSAclass) ){
 $classid=$rowclass[ClassID];
			echo "ClassID: <font color=BLUE>" . $rowclass[ClassID] ."</font>, "; 
			echo "GradeOrSubject: <font color=BLUE>" . $rowclass[GradeOrSubject] ."</font>, "; 
			echo "ClassNumber: <font color=BLUE>" . $rowclass[ClassNumber] ."</font>, "; 
   
$sqlteacher="SELECT Firstname,Lastname from tblMember where MemberID=". $rowclass[TeacherMemberID] ;
$RSAteacher=mysqli_query($conn,$sqlteacher);
$rowteacher=mysqli_fetch_array($RSAteacher);
			echo "Teacher: <font color=BLUE>" . $rowteacher[Firstname] . " " . $rowteacher[Lastname]."</font>"; 
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
                 ." and v.Status in ('OK','Taken')   order by v.LastName";//.$_SESSION[memberid];
    if ($DEBUG) { echo "see111: ".$SQLstring; }
    $RS1=mysqli_query($conn,$SQLstring);
    while ( $row=mysqli_fetch_array($RS1) ){
?>

                      <tr>
                <?php 
// Attendance:
$sqlatt="SELECT * from tblAttendance where ClassID='". $classid ."' and StudentID='".$row[MemberID]."'";
                    $RSAT1=mysqli_query($conn,$sqlatt);
  unset($attended);
  $attd=0;
		while ( $rowat1=mysqli_fetch_array($RSAT1) ){
                     $attended[$rowat1[CalendarID]]=1;
  $attd++;
}
if (( $attd <= $_GET[ATT] ) || $_GET[show_all] !="No" ) {
			echo "  <td>". $row[MemberID]. "</td>";
                        $sid = $row[MemberID];
               if ( $attd <= $_GET[ATT] ) {
			echo "  <td><font color=RED>". $row[LastName].", ".$row[FirstName]. "</font></td>";
               } else {
			echo "  <td>                ". $row[LastName].", ".$row[FirstName]. "       </td>";
               }
			echo "  <td>". $row[ChineseName]. "&nbsp;</td>";
?>
<?php 
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
}
						echo "	</tr>";


} //end-loop-class	
					?>

			</table>
</form>
<?php 
$sqlnotes="SELECT * from tblAttendanceNote where ClassID=". $classid ;
$RSnotes=mysqli_query($conn,$sqlnotes);
$rownotes=mysqli_fetch_array($RSnotes);
$notes = $rownotes[Notes];
if ( isset($notes) && $notes !="" ) {
  echo "<B> Notes: </b>";
  echo $notes; 
  echo "<br>";
}
echo "<br>";
} //end-loop-classed ?>

</body>
</html>
<?php mysqli_close($conn); ?>
