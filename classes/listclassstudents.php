<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
	session_start();
	//only for principal
	if(! isset($_SESSION['membertype']) || ($_SESSION['membertype'] != 10 && $_SESSION['membertype'] != 55 && $_SESSION['membertype'] != 20) ) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Yale New Haven Community Chinese School Class Management</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
</head>
<body>
	<table>
 	 	<tr><td>&nbsp;</td></tr>
 	 	<tr><?php include("classesmenu.php");?>
 	 		<td valign='top'>
 	 		<div class=Section1 style="layout-grid:15.6pt 0pt" align="left">
<!--start content  -->

<!-- display class inforamtion -->
<?php
$ClassID = $_GET['ClassID'];
//database connection
include("../common/DB/DataStore.php");

//get class information
//query string for class information
$classQuery = "SELECT ClassID,
                 TeacherMemberID,
                 FirstName,
                 LastName,
                 ChineseName,
                 GradeOrSubject,
                 ClassNumber,
                 ClassRoom,
                 CurrentClass,
                 Year
           FROM tblClass left outer join tblMember on MemberID=TeacherMemberID
           WHERE tblClass.ClassID=".$ClassID;

//do query
$classRs = mysqli_query($conn,$classQuery);
$classRow=mysqli_fetch_array($classRs);
$ClassLevel =$classRow[GradeOrSubject];
?>
			<table border="1" cellspacing="0">
				<tr>
					<td bgcolor='powderBlue' colspan=6 class='textlargeBoldBrown'>Class Information<input type="hidden" name="hdclassid" value="<?php echo $ClassID;?>"/></td>
				</tr>
				<tr>
					<td bgcolor='silver' align='right' class='textsmallheadBrown'>Year:</td><td class='textsmallhead'><?php echo $classRow[Year];?>&nbsp;</td>
					<td bgcolor='silver' align='right' class='textsmallheadBrown'>Grade &amp; Class:</td><td class='textsmallhead'><?php echo $classRow[GradeOrSubject];?>&nbsp;-&nbsp;<?php echo $classRow[ClassNumber];?>&nbsp;</td>
					<td bgcolor='silver' align='right' class='textsmallheadBrown'>Classroom:</td> <td class='textsmallhead'><?php echo $classRow[ClassRoom];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' align='right' class='textsmallheadBrown'>Teacher Name:</td><td class='textsmallhead'><?php echo $classRow[FirstName]. " " .$classRow[LastName];?>&nbsp;</td>
					<td bgcolor='silver' align='right' class='textsmallheadBrown'>Teacher Chinese Name:</td><td class='textsmallhead'><?php echo $classRow[ChineseName];?>&nbsp;</td>
					<td bgcolor='silver' align='right' class='textsmallheadBrown'>Current Class:</td><td class='textsmallhead'><?php echo $classRow[CurrentClass];?>&nbsp;</td>
				</tr>

				<tr>
					<td  bgcolor='powderblue' class='textlargeBoldBrown' colspan='6'>List of the Students</td>
				</tr>
				<tr class='textsmallheadBrown' bgcolor='silver'>
					<td>No.</td>
					<td>Student ID</td>
					<td>Family ID</td>
					<td>Student Name</td>
					<td colspan='2'>Student Chinese Name</td>
				</tr>

<?php


//query string
$query = "SELECT ClassID,
                 StudentMemberID,
                 FirstName,
                 LastName,
                 ChineseName,
                 FamilyID
           FROM tblClassRegistration left outer join tblMember on tblMember.MemberID=tblClassRegistration.StudentMemberID
           WHERE (ClassID=".$ClassID." and Status='OK') ORDER BY LastName, FirstName" ;

//do query
$rs = mysqli_query($conn,$query);
$studentcount=0;
//display result
while ($row=mysqli_fetch_array($rs)) {
	$studentcount++;
?>
				<tr class='textsmallblack'>
					<td><?php echo $studentcount;?> &nbsp; </td>
					<td><?php echo $row[StudentMemberID];?>&nbsp;</td>
				    <td><?php echo $row[FamilyID];?>&nbsp;</td>
					<td><?php echo $row[FirstName]. " " .$row[LastName];?>&nbsp;</td>
					<td colspan='2'><?php echo $row[ChineseName];?>&nbsp;</td>
				</tr>
<?php
}
if($studentcount==0){
?>
				<tr class='textsmallblack'>
					<td colspan='6'>No student</td>
				</tr>
<?php
}
mysqli_close($conn);
?>
			</table>
<!--end of content  -->

			</div>
			</td>
		</tr>
	</table>
</body>
</html>
