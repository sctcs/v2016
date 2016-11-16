<?php
//session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
//session_start();
//only for principal 
//if(! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 10 ) {
//   echo "You don't sufficient authroization to access this page";
//   exit();
//}

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
 	 		
 	 		<form method="post" action=assignlangstudents.php>
 	 		
<!--start content  -->

<?php
//common parameters
include("../common/CommonParam/params.php");
//database connection 
include("../common/DB/DataStore.php");

$ClassID = $_GET['ClassID'];

$btdone = $_POST['done'];
if( $btdone=='Done'){
	header("location:listcurrentclasses.php");
	exit();	
}

$btassign = $_POST['assign'];
if( $btassign=='Assign Students'){
	$hdclassid=$_POST['hdclassid'];
	$ckstudentids=$_POST['ckstudentid']; 
	if(!empty($ckstudentids)){
		foreach($ckstudentids as $ckstudentid ){
			$insertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year) values(".$ckstudentid.",".$hdclassid.",".$CurrentYear.")";
			mysqli_query($conn,$insertQuery);
		}
	}
	$ClassID = $hdclassid;
	header("location:assignlangstudents.php?ClassID=".$ClassID );
	exit();
}

//do unassign action
$btunassign = $_POST['unassign'];
if( $btunassign=='Unassign Students'){
	$hdclassid=$_POST['hdclassid'];
	$ckstudentids=$_POST['uckstudentid']; 
	if(!empty($ckstudentids)){
		foreach($ckstudentids as $ckstudentid ){
			$deleteQuery = "delete from tblClassRegistration where StudentMemberID=".$ckstudentid." and  ClassID=".$hdclassid." and Year='".$CurrentYear."'";
			mysqli_query($conn,$deleteQuery);
		}
	}
	$ClassID = $hdclassid;
	header("location:assignlangstudents.php?ClassID=".$ClassID );
	exit();	
}
?>
		<table border="0" cellspacing="0">
		<tr>
		    <td>
<!-- display class inforamtion -->		    
<?php
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
			</table>
			</td>
		</tr>


		<tr>
		    <td>
<!-- display assigned students  -->		    		
			<table border="1" cellspacing="0">
				<tr>
					<td bgcolor='powderBlue' colspan='4' class='textlargeBoldBrown'>Assigned Students</td>
				</tr>
				<tr>
				    <td bgcolor='silver' class='textsmallheadBrown'>No.</td>
					<td bgcolor='silver' class='textsmallheadBrown'>Select</td>
					<td bgcolor='silver' class='textsmallheadBrown'>Student Name</td>
					<td bgcolor='silver' class='textsmallheadBrown'>Student Chinese Name</td>
				</tr>
<?php
//get assigned students
//query string for assigned students
$query = "SELECT ClassID,
                 StudentMemberID,
                 FirstName,
                 LastName,
                 ChineseName
           FROM tblClassRegistration join tblMember on tblMember.MemberID=tblClassRegistration.StudentMemberID 
           WHERE ClassID=".$ClassID;
//do query 
$rs = mysqli_query($conn,$query);
$assignedcount=0;
//display result
while ($row=mysqli_fetch_array($rs)) {
	$assignedcount++;
?>
				<tr class='textsmallblack'>
				    <td><?php echo $assignedcount;?>&nbsp;</td>
					<td><input type="checkbox" name="uckstudentid[]" value="<?php echo $row[StudentMemberID];?>"/>&nbsp;</td>
					<td><?php echo $row[FirstName]. " " .$row[LastName];?>&nbsp;</td>
					<td><?php echo $row[ChineseName];?>&nbsp;</td>

				</tr>
<?php
}
if($assignedcount==0){
?>
				<tr class='textsmallblack'>
					<td colspan='4'>No student assigned</td>
				</tr>
				<tr class='textsmallblack'>
					<td colspan='4'><input type="submit" name="unassign" value="Unassign Students" disabled/></td>
				</tr>				
<?php
}else{
?>
				<tr class='textsmallblack'>
					<td colspan='4'><input type="submit" name="unassign" value="Unassign Students"/></td>
				</tr>
<?php
}
?>				
			</table>
			</td>
		</tr>
		<tr>
			<td>
<!--display unassigned students -->
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderBlue' colspan='9' class='textlargeBoldBrown'>Unassigned Students</td></tr>
				<tr class='textsmallheadBrown'>
					<td colspan='4' align='center' bgcolor='silver'>Student Info</td>
					<td colspan='1' align='center' bgcolor='darkgray'>This Year Preferred</td>
					<td colspan='4' align='center'  bgcolor='lightgrey'>Last Year Class</td>
				</tr>

				<tr class='textsmallheadBrown'>
					<td align='center' bgcolor='silver'>No.</td>
					<td align='center' bgcolor='silver'>Select</td>
					<td align='center' bgcolor='silver'>Student Name</td>
					<td align='center' bgcolor='silver'>Chinese Name</td>
					<td align='center' bgcolor='darkgray'>Preferred Grade</td>
					<td align='center'  bgcolor='lightgrey'>Grade</td>
					<td align='center'  bgcolor='lightgrey'>Class</td>
					<td align='center'  bgcolor='lightgrey'>Teacher Name</td>
					<td align='center'  bgcolor='lightgrey'>Chinese Name</td>
				</tr>


<?php
//query string for unassigned student  
$query = "select a.MemberID,
                 b.FirstName as sfn,
                 b.LastName as sln,
                 b.ChineseName as scn,
                 a.PreferredClassLevel,
                 f.GradeOrSubject,
                 f.ClassNumber,
                 f.FirstName as tfn,
                 f.LastName as tln,
                 f.ChineseName as tcn
          from (tblStudent A join tblMember B on a.memberID=b.memberID)  left outer join 
               (select e.studentmemberID,
                       c.classID,
                       c.Gradeorsubject,
                       c.classnumber,
                       d.firstname,
                       d.lastname,
                       d.chinesename
                from tblClassRegistration e join tblClass c on e.classid=c.classid join tblMember d on c.teachermemberID=d.memberID
                where c.year='".$LastYear. "'
                      and c.Gradeorsubject REGEXP '[[:digit:]]+'
                ) f
                on f.studentmemberid = a.memberid
          WHERE b.registered='yes' 
            and a.PreferredClassLevel=".$ClassLevel. "
            and a.MemberID not in (SELECT StudentMemberID FROM tblClassRegistration join tblClass on tblClass.ClassID=tblClassRegistration.ClassID WHERE tblClass.Gradeorsubject REGEXP '[[:digit:]]+' and  tblClass.Year='".$CurrentYear."')
           ORDER BY f.GradeOrSubject, f.ClassNumber";     

//do query 
$rs = mysqli_query($conn,$query);

//unassigned student count
$unassignedcount=0;

//display result
while ($row=mysqli_fetch_array($rs)) {
	$unassignedcount++;
?>
				<tr class='textsmallblack'>
					<td><?php echo $unassignedcount;?>&nbsp;</td>
					<td><input type="checkbox" name="ckstudentid[]" value="<?php echo $row[MemberID];?>"/> &nbsp; </td>
					<td><?php echo $row[sfn]. " " .$row[sln];?>&nbsp;</td>
					<td><?php echo $row[scn];?>&nbsp;</td>
					<td><?php echo $row[PreferredClassLevel];?>&nbsp;</td>
					<td><?php echo $row[GradeOrSubject];?>&nbsp;</td>
					<td><?php echo $row[ClassNumber];?>&nbsp;</td>
					<td><?php echo $row[tfn]. " " .$row[tln];?>&nbsp;</td>					
					<td><?php echo $row[tcn];?>&nbsp;</td>					
				</tr>
<?php
}
mysqli_close($conn);
if($unassignedcount==0){
?>
				<tr class='textsmallblack'>
					<td colspan='9'>No student unassigned</td>
				</tr>
				<tr class='textsmallblack'>
					<td colspan='9'><input type="submit" name="assign" value="Assign Students" disabled /></td>
				</tr>				
<?php
}else{
?>
				<tr class='textsmallblack'>
					<td colspan='9'><input type="submit" name="assign" value="Assign Students"/></td>
				</tr>
<?php
}
?>
			</table>
			</td>
			</tr>
			<tr>
				<td>
					<input type="submit" name="done" value="Done"/>
				</td>
			</tr>
		</table>			
	</form>
	
<!--end of content  -->
			</div>
			</td>
		</tr>
	</table>
</body>
</html>
