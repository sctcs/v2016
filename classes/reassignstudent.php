<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
	session_start();
	//only for principal
	if(! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 10 ) {
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
			<form method="post" action=reassignstudent.php>

			<table>
			<tr><td>
<?php

$StudentMemberID = $_GET['StudentMemberID'];
//common parameters
include("../common/CommonParam/params.php");
//database connection
include("../common/DB/DataStore.php");


$langbtassign = $_POST["reassignLang"];
if( $langbtassign=="Re-Assign Chinese Class"){
	$langhdclassid=$_POST['currentClassLang'];
	$langckstudentid=$_POST['hdstudentmemberid'];
	$langlastclassid=$_POST['lastClassLang'];
	if($langlastclassid==0 && $langhdclassid!=0){
		$langinsertQuery = "INSERT INTO tblClassRegistration (StudentMemberID, ClassID, Year, DateTimeRegistered) VALUES(".$langckstudentid.",".$langhdclassid.",".$CurrentYear.",NOW())";
	}elseif($langhdclassid==0){
		$langinsertQuery = "DELETE FROM tblClassRegistration WHERE ClassID=".$langlastclassid." AND StudentMemberID=".$langckstudentid." and Year='".$CurrentYear."'";
	}else{
		$langinsertQuery = "UPDATE tblClassRegistration SET DateTimeRegistered=NOW(), ClassID=".$langhdclassid." WHERE  ClassID=".$langlastclassid." AND  StudentMemberID=".$langckstudentid." AND Year='".$CurrentYear."'";
	}
//echo $langinsertQuery;
	mysqli_query($conn,$langinsertQuery);
//echo mysql_error($conn);
	$StudentMemberID = $langckstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
	//exit();
}

$extrabtassign = $_POST['reassignExtra1'];
if( $extrabtassign=="Re-Assign Extra Class 1"){
	$extrahdclassid=$_POST['currentClassExtra'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid=$_POST['lastClassExtra'];
	if($extralastclassid==0 && $extrahdclassid!=0){
		$extrainsertQuery = "INSERT INTO tblClassRegistration (StudentMemberID, ClassID, Year, DateTimeRegistered) VALUES(".$extrackstudentid.",".$extrahdclassid.",".$CurrentYear.",NOW())";
	}elseif($extrahdclassid==0){
		$extrainsertQuery = "DELETE FROM tblClassRegistration WHERE ClassID=".$extralastclassid." AND StudentMemberID=".$extrackstudentid." AND Year='".$CurrentYear."'";
	}else{
		$extrainsertQuery = "UPDATE tblClassRegistration SET DateTimeRegistered=NOW(), ClassID=".$extrahdclassid." WHERE ClassID=".$extralastclassid." AND StudentMemberID=".$extrackstudentid." AND Year='".$CurrentYear."'";
	}
	mysqli_query($conn,$extrainsertQuery);
//echo mysql_error($conn);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
	//exit();
}

$extrabtassign2 = $_POST['reassignExtra2'];
if( $extrabtassign2=="Re-Assign Extra Class 2"){
	$extrahdclassid2=$_POST['currentClassExtra2'];
	$extrackstudentid2=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra2'];
	if($extralastclassid2==0 && $extrahdclassid2!=0){
		$extrainsertQuery2 = "INSERT into tblClassRegistration (StudentMemberID, ClassID, Year,DateTimeRegistered) VALUES(".$extrackstudentid2.",".$extrahdclassid2.",".$CurrentYear.",NOW())";
	}elseif($extrahdclassid2==0){
		$extrainsertQuery2 = "DELETE FROM tblClassRegistration WHERE ClassID=".$extralastclassid2." AND StudentMemberID=".$extrackstudentid2." AND Year='".$CurrentYear."'";
	}else{
		$extrainsertQuery2 = "UPDATE tblClassRegistration SET DateTimeRegistered=NOW(), ClassID=".$extrahdclassid2." WHERE ClassID=".$extralastclassid2." AND StudentMemberID=".$extrackstudentid2." AND Year='".$CurrentYear."'";
	}
	mysqli_query($conn,$extrainsertQuery2);
//echo mysql_error($conn);
	$StudentMemberID = $extrackstudentid2;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
	//exit();
}

$query1 = "SELECT b.GradeOrSubject,b.ClassNumber
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='1' and a.StudentMemberID=".$StudentMemberID ." and b.CurrentClass='Yes'";
$rs1 = mysqli_query($conn,$query1);
//echo mysql_error($conn);
//display result
$studentrow1=mysqli_fetch_array($rs1);

$name1 = $studentrow1[gradeorsubject]."-".$studentrow1[classnumber];

$query2 = "SELECT b.GradeOrSubject
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='3' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes'";
$rs2 = mysqli_query($conn,$query2);
//echo mysql_error($conn);
//display result
$studentrow2=mysqli_fetch_array($rs2);
$name2 = $studentrow2[gradeorsubject];

$query3 = "SELECT b.GradeOrSubject
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='4' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes'";
$rs3 = mysqli_query($conn,$query3);
//echo mysql_error($conn);

//display result
$studentrow3=mysqli_fetch_array($rs3);
$name3 = $studentrow3[gradeorsubject];

//query string
$query = "SELECT StudentID,
                 tblStudent.MemberID,
                 FirstName,
                 LastName,
                 ChineseName,
                 FirstRegistrationDate,
                 StartingLevel,
                 StudentType,
                 StudentStatus,
                 PreferredClassLevel,
                 PreferredExtraClass1,
                 c1.GradeOrSubject as cn1,
                 PreferredExtraClass2,
                 c2.GradeOrSubject as cn2,
                 Registered
           FROM tblStudent LEFT JOIN tblClass c1 ON c1.Classid=PreferredExtraClass1 LEFT JOIN tblClass c2 ON c2.Classid=PreferredExtraClass2
           JOIN tblMember ON tblMember.MemberID=tblStudent.MemberID
           WHERE  tblStudent.MemberID=".$StudentMemberID;
//echo $query;
//do query
$rs = mysqli_query($conn,$query);
//echo mysql_error($conn);
//display result
$studentrow=mysqli_fetch_array($rs)

?>
			<table border="1" cellspacing="0">
				<tr>
					<td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2'>Student Information<input type="hidden" name="hdstudentmemberid" value="<?php echo $studentrow[MemberID];?>"/></td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Student Name</td><td class='textsmallblack'><?php echo $studentrow[FirstName]. " " .$studentrow[LastName];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Student Chinese Name</td><td class='textsmallblack'><?php echo $studentrow[ChineseName];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>First Registration Date</td><td class='textsmallblack'><?php echo $studentrow[FirstRegistrationDate];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Starting Level</td><td class='textsmallblack'><?php echo $studentrow[StartingLevel];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Student Type</td><td class='textsmallblack'><?php echo $StudentType[$studentrow[StudentType]];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Student Status</td><td class='textsmallblack'><?php echo $StudentStatus[$studentrow[StudentStatus]];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Registered Class</td><td class='textsmallblack'><?php echo $name1;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Registered Extra Class 1 </td><td class='textsmallblack'><?php echo $name2;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Registered Extra Class 2 </td><td class='textsmallblack'><?php echo $name3;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Registered</td><td class='textsmallblack'><?php echo $studentrow[Registered];?>&nbsp;</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>
<?php
$enabled="";
$noteStr="";
if($studentrow[Registered]!="yes"){
	$enabled ="disabled";
	$noteStr= "<br><font color='red'>Cannot assign class without registration</font>";
}
?>

<!-- Language Class Reassign-->
			<table border="1" cellspacing="0">
			<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Chinese Class</td></tr>

<?php

//query string
$langquery = "SELECT A.StudentMemberID,
                 A.ClassID,
                 B.TeacherMemberID,
                 C.FirstName,
                 C.LastName,
                 C.ChineseName,
                 B.GradeOrSubject,
                 B.ClassNumber,
				 A.Year
           FROM  tblClassRegistration A join tblClass B on A.ClassID=B.ClassID left join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE B.GradeOrSubject REGEXP '[[:digit:]]+' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";
//do query
$langrs = mysqli_query($conn,$langquery);
//display result
$langassignclassrow=mysqli_fetch_array($langrs);

$currentlangID=0;
if($langassignclassrow[ClassID]>0){
	$currentlangID = $langassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassLang" value="<?php echo $langassignclassrow[ClassID];?>" /></td>
		 			<td class='textsmallblack'><?php echo "Class:". $langassignclassrow[GradeOrSubject]."-".$langassignclassrow[ClassNumber]."  Teacher:".$langassignclassrow[FirstName]." ".$langassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassLang" value="0" /></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassLang">
						<option value="0">None</option>
<?php
$langclassQuery = "SELECT ClassID,
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
           WHERE tblClass.Period='1' and tblClass.CurrentClass='Yes'";

//do query

$langclassRs = mysqli_query($conn,$langclassQuery);

while($langclassRow=mysqli_fetch_array($langclassRs)){
	$langselected="";
	if($currentlangID==$langclassRow[ClassID]){
		$langselected="selected";
	}
?>

						<option <?php echo $langselected?> value="<?php echo $langclassRow[ClassID];?>" > <?php echo "Class:". $langclassRow[GradeOrSubject]."-".$langclassRow[ClassNumber]."  Teacher:".$langclassRow[FirstName]." ".$langclassRow[LastName];?></option>
<?php
}
?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignLang" value="Re-Assign Chinese Class"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>

<!-- Extra Class 1 Reassign-->
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Extra Class 1</td></tr>
<?php

//query string
$extraquery = "SELECT A.StudentMemberID,
                 A.ClassID,
                 B.TeacherMemberID,
                 C.FirstName,
                 C.LastName,
                 C.ChineseName,
                 B.GradeOrSubject,
                 B.ClassNumber,
				 A.Year
           FROM  tblClassRegistration A join tblClass B on A.classID=B.ClassID join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE  B.Period='3' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";
           //WHERE not (B.GradeOrSubject REGEXP '[[:digit:]]+') and B.Period='3' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";
//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "Class:". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra">
						<option value="0">None</option>
<?php
$extraclassQuery = "SELECT ClassID,
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
                      WHERE   tblClass.Period='3' and tblClass.CurrentClass='Yes'";
           //WHERE not (tblClass.GradeOrSubject REGEXP '[[:digit:]]+') and  tblClass.Period='3' and tblClass.CurrentClass='Yes'";


//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php echo "Class:". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
<?php
}
//echo $extraclassQuery;
//mysqli_close($conn);
?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignExtra1" value="Re-Assign Extra Class 1"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td>

<!-- Extra Class 2 Reassign-->
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Extra Class 2</td></tr>
<?php

//query string
$extraquery2 = "SELECT A.StudentMemberID,
                 A.ClassID,
                 B.TeacherMemberID,
                 C.FirstName,
                 C.LastName,
                 C.ChineseName,
                 B.GradeOrSubject,
                 B.ClassNumber,
				 A.Year
           FROM  tblClassRegistration A join tblClass B on A.classID=B.ClassID join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE  B.Period='4'  and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";
                      //WHERE not (B.GradeOrSubject REGEXP '[[:digit:]]+') and B.Period='4'  and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";
//do query
$extrars2 = mysqli_query($conn,$extraquery2);
//display result
$extraassignclassrow2=mysqli_fetch_array($extrars2);
$currentextraID2=0;
if($extraassignclassrow2[ClassID]>0){
	$currentextraID2 = $extraassignclassrow2[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2" value="<?php echo $extraassignclassrow2[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "Class:". $extraassignclassrow2[GradeOrSubject]."-".$extraassignclassrow2[ClassNumber]."  Teacher:".$extraassignclassrow2[FirstName]." ".$extraassignclassrow2[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra2">
						<option value="0">None</option>
<?php
$extraclassQuery2 = "SELECT ClassID,
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
           WHERE  tblClass.Period='4' and  tblClass.CurrentClass='Yes'";
                      //WHERE not (tblClass.GradeOrSubject REGEXP '[[:digit:]]+') and tblClass.Period='4' and  tblClass.CurrentClass='Yes'";

//do query

$extraclassRs2 = mysqli_query($conn,$extraclassQuery2);

while($extraclassRow2=mysqli_fetch_array($extraclassRs2)){
	$extraselected2="";
	if($currentextraID2==$extraclassRow2[ClassID]){
		$extraselected2="selected";
	}
?>
						<option <?php echo $extraselected2;?> value=<?php echo $extraclassRow2[ClassID];?>> <?php echo "Class:". $extraclassRow2[GradeOrSubject]."-".$extraclassRow2[ClassNumber]."  Teacher:".$extraclassRow2[FirstName]." ".$extraclassRow2[LastName];?></option>
<?php
}
//echo $extraclassQuery2;
mysqli_close($conn);
?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignExtra2" value="Re-Assign Extra Class 2"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
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
