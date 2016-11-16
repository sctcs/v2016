<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
//only for principal
if(! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 10 ) {
   echo "You don't sufficient authroization to access this page";
   exit();
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
 	 	<tr><?php //include("classesmenu.php");?>
 	 		<td valign='top'>
 	 		<div class=Section1 style="layout-grid:15.6pt 0pt" align="left">
<!--start content  -->
			<form method="post" action=reassignClassDo.php>

			<table>
			<tr><td>
<?php

$StudentMemberID = $_GET['StudentMemberID'];
//common parameters
include("../common/CommonParam/params.php");
//database connection
include("../common/DB/DataStore.php");
?>
<a href="studentLookup.php">[Back]</a>
<a href="../">[Home]</a>
<a href="../MemberAccount/MemberAccountMain.php">[My Account]</a>
<a href="../MemberAccount/OpenSeats.php" >[View Class Opening/Available Seats]</a>
<br><br><br>

<?php

if ( $StudentMemberID == 0 ) {
  echo "No student was selected, exiting...<a href=\"studentLookup.php\">lookup</a>";
  mysqli_close($conn);
  exit;
}

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
                 PreferredExtraClass2,
                 Registered
           FROM tblStudent join tblMember on tblMember.MemberID=tblStudent.MemberID
           WHERE tblStudent.MemberID=".$StudentMemberID;
//echo $query;
//do query
$rs = mysqli_query($conn,$query);
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
					<td bgcolor='silver' class='textsmallheadBrown'>Preferred Class Level</td><td class='textsmallblack'><?php echo $studentrow[PreferredClassLevel];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Preferred Extra Class1 (ClassID)</td><td class='textsmallblack'><?php echo $studentrow[PreferredExtraClass1];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Preferred Extra Class2 (ClassID)</td><td class='textsmallblack'><?php echo $studentrow[PreferredExtraClass2];?>&nbsp;</td>
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
if($studentrow[Registered] !="yes" ){
	$enabled ="disabled";
	$noteStr= "<br><font color='red'>Cannot assign class without registration</font>";
}
?>

<!-- Language Class Reassign-->
			<table border="1" cellspacing="0">
			<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Chinese Language Class</td></tr>

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
           FROM  tblClassRegistration A left join tblClass B on A.ClassID=B.ClassID left join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE B.GradeOrSubject REGEXP '[[:digit:]]+' and A.StudentMemberID=".$StudentMemberID. " and A.Year='".$CurrentYear."'";
//do query
$langrs = mysqli_query($conn,$langquery);
if ( ! $langrs ) {
   die('Error: ' . mysqli_error($conn));
}
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
           WHERE tblClass.GradeOrSubject REGEXP '[[:digit:]]+' and tblClass.Year='".$CurrentYear."'";

//do query

$langclassRs = mysqli_query($conn,$langclassQuery);
if ( ! $langclassRs ) {
   die('Error: ' . mysqli_error($conn));
}
while($langclassRow=mysqli_fetch_array($langclassRs)){
	$langselected="";
	if($currentlangID==$langclassRow[ClassID]){
		$langselected="selected";
	}
?>

						<option <?php echo $langselected?> value="<?php echo $langclassRow[ClassID];?>" > <?php echo "". $langclassRow[GradeOrSubject]."-".$langclassRow[ClassNumber].";  Teacher:".$langclassRow[FirstName]." ".$langclassRow[LastName];?></option>
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
if ( $studentrow[PreferredExtraClass1] != 0 ) {
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
           FROM  tblClassRegistration A left join tblClass B on A.ClassID=B.ClassID left join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE not (B.GradeOrSubject REGEXP '[[:digit:]]+') and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";

        $extraquery .=   " AND A.ClassID = ". $studentrow[PreferredExtraClass1];

  //do query
  //echo $extraquery;
  $extrars = mysqli_query($conn,$extraquery);
  if ( ! $extrars ) {
     die('Error: ' . mysqli_error($conn));
  }
  //display result
  $extraassignclassrow=mysqli_fetch_array($extrars);
  $currentextraID=0;

  if($extraassignclassrow[ClassID]>0) {
	$currentextraID = $extraassignclassrow[ClassID];
     ?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber].";  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
   <?php
  } else {
    ?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
   <?php
  } // end if extraassignclassrow
} else {
    ?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
   <?php

} // end if studentrow
    ?>

				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra1">
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
           WHERE not (tblClass.GradeOrSubject REGEXP '[[:digit:]]+') and tblClass.CurrentClass='Yes' AND tblClass.Period='3'";

//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);
  if ( ! $extraclassRs ) {
     die('Error: ' . mysqli_error($conn));
  }
while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php echo "". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber].";  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
<?php
}
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
if ( $studentrow[PreferredExtraClass2] != 0 ) {
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
           FROM  tblClassRegistration A left join tblClass B on A.ClassID=B.ClassID left join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE not (B.GradeOrSubject REGEXP '[[:digit:]]+') and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes'";

         $extraquery2 .=  " AND A.ClassID = ". $studentrow[PreferredExtraClass2];

  //do query
  //echo $extraquery2;
  $extrars2 = mysqli_query($conn,$extraquery2);
  if ( ! $extrars2 ) {
       die('Error: ' . mysqli_error($conn));
  }
  //display result
  $extraassignclassrow2 =mysqli_fetch_array($extrars2);
  $currentextraID2=0;

  if($extraassignclassrow2[ClassID]>0) {
	$currentextraID2 = $extraassignclassrow2[ClassID];
    ?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2" value="<?php echo $extraassignclassrow2[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "". $extraassignclassrow2[GradeOrSubject]."-".$extraassignclassrow2[ClassNumber].";  Teacher:".$extraassignclassrow2[FirstName]." ".$extraassignclassrow2[LastName];?></td>
				</tr>
   <?php
  } else {
    ?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
   <?php
  } // end if extraassignclassrow2
} else {
    ?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
   <?php


} // end if studentrow
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
           WHERE not (tblClass.GradeOrSubject REGEXP '[[:digit:]]+') and tblClass.CurrentClass='Yes' AND tblClass.Period='4'";

//do query

$extraclassRs2 = mysqli_query($conn,$extraclassQuery2);
  if ( ! $extraclassRs2 ) {
       die('Error: ' . mysqli_error($conn));
  }

while($extraclassRow2=mysqli_fetch_array($extraclassRs2)){
	$extraselected="";
	if($currentextraID2 == $extraclassRow2[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow2[ClassID];?>> <?php echo "". $extraclassRow2[GradeOrSubject]."-".$extraclassRow2[ClassNumber].";  Teacher:".$extraclassRow2[FirstName]." ".$extraclassRow2[LastName];?></option>
<?php
}
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

			</div>
			</td>
		</tr>
	</table>
</body>
</html>
