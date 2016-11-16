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
<?php
//common parameters
include("../common/CommonParam/params.php");
//database connection
include("../common/DB/DataStore.php");

$showType = $_GET['type'];
$queryCondition = "";
if($showType=="cur"){
	//$queryCondition = " WHERE year='".$CurrentYear."' ";
      $queryCondition = " WHERE CurrentClass='Yes' ";
}
?>

			<table border="1" cellspacing="0">
				<tr>
					<td  bgcolor='powderblue' class='textlargeBoldBrown' colspan='10'>List of the classes</td>
				</tr>
				<tr class='textsmallheadBrown' bgcolor='silver'>
					<td>List Students</td>
					<td>Year</td>
					<td>Grade/Subject</td>
					<td>Class Number</td>
					<td>Time Slot</td>
					<td>Teacher Name</td>
					<td>Teacher Chinese Name</td>
					<td>Classroom</td>
					<td>Current Class</td>
				</tr>

<?php

//query string
$query = "SELECT ClassID,
                 TeacherMemberID,
                 FirstName,
                 LastName,
                 ChineseName,
                 GradeOrSubject,
                 ClassNumber,
                 Period,
                 ClassRoom,
                 CurrentClass,
                 Year
           FROM tblClass left outer join tblMember on MemberID=TeacherMemberID" . $queryCondition.
     " ORDER BY year,GradeOrSubject,ClassNumber";

//do query
$rs = mysqli_query($conn,$query);

//display result
while ($row=mysqli_fetch_array($rs)) {
?>
				<tr class='textsmallblack'>
					<td align='center'><a href="listclassstudents.php?ClassID=<?php echo $row[ClassID];?>">Student List</a></td>
					<td><?php echo $row[Year];?>&nbsp;</td>
					<td><?php echo $row[GradeOrSubject];?>&nbsp;</td>
					<td><?php echo $row[ClassNumber];?>&nbsp;</td>
					<td><?php echo $row[Period];?>&nbsp;</td>
					<td><?php echo $row[FirstName]. " " .$row[LastName];?>&nbsp;</td>
					<td><?php echo $row[ChineseName];?>&nbsp;</td>
					<td><?php echo $row[ClassRoom];?>&nbsp;</td>
					<td><?php echo $row[CurrentClass];?>&nbsp;</td>
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
