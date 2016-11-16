<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
	session_start();
	//only for principal
	if(! isset($_SESSION['membertype'])  ) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}
	if( $_SESSION['membertype'] != 10 && $_SESSION['membertype'] != 15 && $_SESSION['membertype'] != 20) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>SCCS Class Management</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>
<body>
	<table>
 	 	<tr><td>&nbsp;</td></tr>
 	 	<tr><?php include("classesmenu.php");?>
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


$langbtassign = $_POST["reassignLang"];


$extrabtassign = $_POST['reassignExtra1'];


$extrabtassign2 = $_POST['reassignExtra2'];


$query1f = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.IsLanguage='Yes' and a.StudentMemberID=".$StudentMemberID ." and b.CurrentClass='Yes' and b.Term='Fall' and a.Status='OK' limit 1";
$rs1 = mysqli_query($conn,$query1f);
$studentrow1=mysqli_fetch_array($rs1);
$nameLF = "[".$studentrow1[ClassID]."] ".$studentrow1[GradeOrSubject]."-".$studentrow1[ClassNumber];

$query1s = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.IsLanguage='Yes' and a.StudentMemberID=".$StudentMemberID ." and b.CurrentClass='Yes' and b.Term='Spring' and a.Status='OK' limit 1";
$rs1s = mysqli_query($conn,$query1s);
$studentrow1s=mysqli_fetch_array($rs1s);
$nameLS = "[".$studentrow1s[ClassID]."] ".$studentrow1s[GradeOrSubject]."-".$studentrow1s[ClassNumber];


$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='0' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Fall' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
//$name2F = $studentrow2[gradeorsubject];
$name0F = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='1' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Fall' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
//$name2F = $studentrow2[gradeorsubject];
$name1F = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='2' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Fall' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
//$name2F = $studentrow2[gradeorsubject];
$name2F = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query3 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='3' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Fall' and a.Status='OK' limit 1";
$rs3 = mysqli_query($conn,$query3);
$studentrow3=mysqli_fetch_array($rs3);
//$name3F = $studentrow3[gradeorsubject];
$name3F = "[".$studentrow3[ClassID]."] ".$studentrow3[GradeOrSubject]."-".$studentrow3[ClassNumber];

$query3 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='4' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Fall' and a.Status='OK' limit 1";
$rs3 = mysqli_query($conn,$query3);
$studentrow3=mysqli_fetch_array($rs3);
//$name3F = $studentrow3[gradeorsubject];
$name4F = "[".$studentrow3[ClassID]."] ".$studentrow3[GradeOrSubject]."-".$studentrow3[ClassNumber];


$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='0' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Spring' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
$name0S = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='1' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Spring' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
$name1S = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='2' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Spring' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
$name2S = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query2 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='3' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Spring' and a.Status='OK' limit 1";
$rs2 = mysqli_query($conn,$query2);
$studentrow2=mysqli_fetch_array($rs2);
$name3S = "[".$studentrow2[ClassID]."] ".$studentrow2[GradeOrSubject]."-".$studentrow2[ClassNumber];

$query3 = "SELECT b.ClassID, b.GradeOrSubject,b.ClassNumber,b.Year, b.Term
           FROM tblClassRegistration a join tblClass b on a.ClassID=b.ClassID
           WHERE b.Period='4' and b.IsLanguage='No' and a.StudentMemberID=".$StudentMemberID." and b.CurrentClass='Yes' and b.Term='Spring' and a.Status='OK' limit 1";
$rs3 = mysqli_query($conn,$query3);
$studentrow3=mysqli_fetch_array($rs3);
//$name3F = $studentrow3[gradeorsubject];
$name4S = "[".$studentrow3[ClassID]."] ".$studentrow3[GradeOrSubject]."-".$studentrow3[ClassNumber];


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
$query = "SELECT 
                 MemberID,
			 FamilyID,
                 FirstName,
                 LastName,
                 ChineseName,
                 Registered
          FROM tblMember
           WHERE  MemberID=".$StudentMemberID;

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
					<td bgcolor='silver' class='textsmallheadBrown'>Student MemberID</td><td class='textsmallblack'><?php echo $studentrow[MemberID];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Student FamilyID</td><td class='textsmallblack'><?php echo $studentrow[FamilyID];?>&nbsp;</td>
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
					<td bgcolor='silver' class='textsmallheadBrown'>Chinese Class (Fall)</td><td class='textsmallblack'><?php echo $nameLF;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 0 (Fall)</td><td class='textsmallblack'><?php echo $name0F;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 1 (Fall)</td><td class='textsmallblack'><?php echo $name1F;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 2 (Fall)</td><td class='textsmallblack'><?php echo $name2F;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 3 (Fall)</td><td class='textsmallblack'><?php echo $name3F;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 4 (Fall)</td><td class='textsmallblack'><?php echo $name4F;?>&nbsp;</td>
				</tr>

				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Chinese Class (Spring)</td><td class='textsmallblack'><?php echo $nameLS;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 0 (Spring)</td><td class='textsmallblack'><?php echo $name0S;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 1 (Spring)</td><td class='textsmallblack'><?php echo $name1S;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 2 (Spring)</td><td class='textsmallblack'><?php echo $name2S;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 3 (Spring)</td><td class='textsmallblack'><?php echo $name3S;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Enrichment Class 4 (Spring)</td><td class='textsmallblack'><?php echo $name4S;?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Registered</td><td class='textsmallblack'><?php echo $studentrow[Registered];?>&nbsp;</td>
				</tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Check Family Balance</td><td class='textsmallblack'><?php echo "<a href=\"../MemberAccount/FeePaymentVoucher_byadmin.php?fid=$studentrow[FamilyID]\" target=\"_blank\">Paymemt Voucher</a>";?>&nbsp;</td>
				</tr>

			</table>
			</td>
			</tr>

            <tr><td>&nbsp;</td></tr>
<?php
$enabled="";
$noteStr="";
//if($studentrow[Registered]!="yes"){
//	$enabled ="disabled";
//	$noteStr= "<br><font color='red'>Cannot assign class without registration</font>";
//}
?>

<!-- Language Class Fall Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">

<?php

//query string
$langquery = "SELECT A.StudentMemberID,
                 A.ClassID,
                 B.TeacherMemberID,
                 C.FirstName,
                 C.LastName,
                 C.ChineseName,
                 B.GradeOrSubject,
                 B.ClassNumber, B.Period,
				 A.Year
           FROM  tblClassRegistration A join tblClass B on A.ClassID=B.ClassID left join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE B.IsLanguage='Yes' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Fall' and A.Status='OK' limit 1";
//do query
//echo "$langquery";
$langrs = mysqli_query($conn,$langquery);
//display result
$langassignclassrow=mysqli_fetch_array($langrs);

$currentlangID=0;
if(isset($langassignclassrow[ClassID])){
	$currentlangID = $langassignclassrow[ClassID];
?>
			<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Chinese Class Fall (
<?php
if ( $langassignclassrow[Period] == "1" ) {
                                                                echo $PERIOD1 . " ". $PERIOD2;
                                                        } else if ( $langassignclassrow[Period] == "2" ) {
                                                                echo $PERIOD2 . " ". $PERIOD3;
                                                        } else if ( $langassignclassrow[Period] == "3" ) {
                                                                echo $PERIOD3 . " ". $PERIOD4;
                                                        }
 ?>
)</td></tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassLangFall" value="<?php echo $langassignclassrow[ClassID];?>" /></td>
		 			<td class='textsmallblack'><?php echo "[". $langassignclassrow[ClassID]."] ". $langassignclassrow[GradeOrSubject]."-".$langassignclassrow[ClassNumber]."  Teacher:".$langassignclassrow[FirstName]." ".$langassignclassrow[LastName];?></td>
				</tr>
<?php
      }else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassLangFall" value="0" /></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php } ?>

				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassLangFall">
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
           WHERE tblClass.IsLanguage='Yes' and tblClass.CurrentClass='Yes' and tblClass.Term='Fall' ";

//do query

$langclassRs = mysqli_query($conn,$langclassQuery);

while($langclassRow=mysqli_fetch_array($langclassRs))
{
	$langselected="";
	if ( $currentlangID == $langclassRow[ClassID] ) {
		$langselected="SELECTED";
	}
   ?>

						<option <?php echo $langselected; ?> value="<?php echo $langclassRow[ClassID];?>" > <?php echo "[". $langclassRow[ClassID]."] ". $langclassRow[GradeOrSubject]."-".$langclassRow[ClassNumber]."  Teacher:".$langclassRow[FirstName]." ".$langclassRow[LastName];?></option>
   <?php
}
    ?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignLangFall" value="Re-Assign Chinese Class Fall"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 0 Fall Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 0 (<?php echo $PERIOD0; ?>) Fall</td></tr>
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
           WHERE  B.Period='0' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Fall' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra0Fall" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra0Fall" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra0Fall">
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
          WHERE tblClass.Period='0' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Fall'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra0Fall" value="Re-Assign Enrichment Class 0 Fall"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>


<!-- Extra Class 1 Fall Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 1 (<?php echo $PERIOD1; ?>) Fall</td></tr>
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
           WHERE  B.Period='1' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Fall' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1Fall" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1Fall" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra1Fall">
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
          WHERE tblClass.Period='1' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Fall'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra1Fall" value="Re-Assign Enrichment Class 1 Fall"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 2 Fall Reassign --------------------------------------------->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 2 (<?php echo $PERIOD2; ?>) Fall</td></tr>
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
           WHERE  B.Period='2' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Fall' and A.Status='OK' limit 1";

//do query
$extrars2 = mysqli_query($conn,$extraquery2);
//display result
$extraassignclassrow2=mysqli_fetch_array($extrars2);
$currentextraID2=0;
if($extraassignclassrow2[ClassID]>0){
	$currentextraID2 = $extraassignclassrow2[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2Fall" value="<?php echo $extraassignclassrow2[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow2[ClassID]."] ". $extraassignclassrow2[GradeOrSubject]."-".$extraassignclassrow2[ClassNumber]."  Teacher:".$extraassignclassrow2[FirstName]." ".$extraassignclassrow2[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2Fall" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra2Fall">
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
           WHERE  tblClass.Period='2' and tblClass.IsLanguage='No' and  tblClass.CurrentClass='Yes' and tblClass.Term='Fall'";


//do query

$extraclassRs2 = mysqli_query($conn,$extraclassQuery2);

while($extraclassRow2=mysqli_fetch_array($extraclassRs2)){
	$extraselected2="";
	if($currentextraID2==$extraclassRow2[ClassID]){
		$extraselected2="selected";
	}
?>
						<option <?php echo $extraselected2;?> value=<?php echo $extraclassRow2[ClassID];?>> <?php echo  "[". $extraclassRow2[ClassID]."] ". $extraclassRow2[GradeOrSubject]."-".$extraclassRow2[ClassNumber]."  Teacher:".$extraclassRow2[FirstName]." ".$extraclassRow2[LastName];?></option>
<?php
}
//echo $extraclassQuery2;

?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignExtra2Fall" value="Re-Assign Enrichment Class 2 Fall"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 3 Fall Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 3 (<?php echo $PERIOD3; ?>) Fall</td></tr>
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
           WHERE  B.Period='3' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Fall' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra3Fall" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra3Fall" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra3Fall">
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
          WHERE tblClass.Period='3' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Fall'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra3Fall" value="Re-Assign Enrichment Class 3 Fall"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 4 Fall Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 4 (<?php echo $PERIOD4; ?>) Fall</td></tr>
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
           WHERE  B.Period='4' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Fall' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra4Fall" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra4Fall" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra4Fall">
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
          WHERE tblClass.Period='4' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Fall'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra4Fall" value="Re-Assign Enrichment Class 4 Fall"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>
			<tr><td>&nbsp;</td></tr>

<!-- Language Class Spring Reassign ---------------------------------------------->
			<tr>
			<td>
			<table border="1" cellspacing="0">

<?php

//query string
$langquery = "SELECT A.StudentMemberID,
                 A.ClassID,
                 B.TeacherMemberID,
                 C.FirstName,
                 C.LastName,
                 C.ChineseName,
                 B.GradeOrSubject,
                 B.ClassNumber, B.Period,
		 A.Year
           FROM  tblClassRegistration A join tblClass B on A.ClassID=B.ClassID left join tblMember C on C.MemberID=B.TeacherMemberID
           WHERE B.IsLanguage='Yes' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Spring' and A.Status='OK' limit 1";
//do query
$langrs = mysqli_query($conn,$langquery);
//display result
$langassignclassrow=mysqli_fetch_array($langrs);

$currentlangID=0;
if ($langassignclassrow[ClassID]>0) {
	$currentlangID = $langassignclassrow[ClassID];
   ?>
			<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Chinese Class Spring (
<?php
if ( $langassignclassrow[Period] == "1" ) {
                                                                echo $PERIOD1 . " ". $PERIOD2;
                                                        } else if ( $langassignclassrow[Period] == "2" ) {
                                                                echo $PERIOD2 . " ". $PERIOD3;
                                                        } else if ( $langassignclassrow[Period] == "3" ) {
                                                                echo $PERIOD3 . " ". $PERIOD4;
                                                        }
 ?>)</td></tr>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassLangSpring" value="<?php echo $langassignclassrow[ClassID];?>" /></td>
		 			<td class='textsmallblack'><?php echo "[". $langassignclassrow[ClassID]."] ". $langassignclassrow[GradeOrSubject]."-".$langassignclassrow[ClassNumber]."  Teacher:".$langassignclassrow[FirstName]." ".$langassignclassrow[LastName];?></td>
				</tr>
<?php
   }else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassLangSpring" value="0" /></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php } ?>

				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassLangSpring">
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
           WHERE tblClass.IsLanguage='Yes' and tblClass.CurrentClass='Yes' and tblClass.Term='Spring' ";

//do query

$langclassRs = mysqli_query($conn,$langclassQuery);

while($langclassRow=mysqli_fetch_array($langclassRs))
{
	$langselected="";
	if( $currentlangID == $langclassRow[ClassID] ) {
		$langselected="selected";
	}
    ?>

						<option <?php echo $langselected?> value="<?php echo $langclassRow[ClassID];?>" > <?php echo "[". $langclassRow[ClassID]."] ". $langclassRow[GradeOrSubject]."-".$langclassRow[ClassNumber]."  Teacher:".$langclassRow[FirstName]." ".$langclassRow[LastName];?></option>
    <?php
}
     ?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignLangSpring" value="Re-Assign Chinese Class Spring"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>



<!-- Extra Class 0 Spring Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 0 (<?php echo $PERIOD0; ?>) Spring</td></tr>
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
           WHERE  B.Period='0' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Spring' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra0Spring" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra0Spring" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra0Spring">
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
                      WHERE   tblClass.Period='0' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Spring'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra0Spring" value="Re-Assign Enrichment Class 0 Spring"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 1 Spring Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 1 (<?php echo $PERIOD1; ?>) Spring</td></tr>
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
           WHERE  B.Period='1' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Spring' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1Spring" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra1Spring" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra1Spring">
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
                      WHERE   tblClass.Period='1' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Spring'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra1Spring" value="Re-Assign Enrichment Class 1 Spring"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 2 Spring Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 2 (<?php echo $PERIOD2; ?>) Spring</td></tr>
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
           WHERE  B.Period='2' and B.IsLanguage='No'  and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Spring' and A.Status='OK' limit 1";

//do query
$extrars2 = mysqli_query($conn,$extraquery2);
//display result
$extraassignclassrow2=mysqli_fetch_array($extrars2);
$currentextraID2=0;
if($extraassignclassrow2[ClassID]>0){
	$currentextraID2 = $extraassignclassrow2[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2Spring" value="<?php echo $extraassignclassrow2[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow2[ClassID]."] ". $extraassignclassrow2[GradeOrSubject]."-".$extraassignclassrow2[ClassNumber]."  Teacher:".$extraassignclassrow2[FirstName]." ".$extraassignclassrow2[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra2Spring" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra2Spring">
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
           WHERE  tblClass.Period='2' and tblClass.IsLanguage='No' and  tblClass.CurrentClass='Yes' and tblClass.Term='Spring'";


//do query

$extraclassRs2 = mysqli_query($conn,$extraclassQuery2);

while($extraclassRow2=mysqli_fetch_array($extraclassRs2)){
	$extraselected2="";
	if($currentextraID2==$extraclassRow2[ClassID]){
		$extraselected2="selected";
	}
?>
						<option <?php echo $extraselected2;?> value=<?php echo $extraclassRow2[ClassID];?>> <?php echo  "[". $extraclassRow2[ClassID]."] ". $extraclassRow2[GradeOrSubject]."-".$extraclassRow2[ClassNumber]."  Teacher:".$extraclassRow2[FirstName]." ".$extraclassRow2[LastName];?></option>
<?php
}
//echo $extraclassQuery2;

?>
						</select>
					</td>
				</tr>
				<tr>
					<td  class='textsmallblack' colspan='2'>
						<input <?php echo $enabled ?> type="submit" name="reassignExtra2Spring" value="Re-Assign Enrichment Class 2 Spring"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 3 Spring Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 3 (<?php echo $PERIOD3; ?>) Spring</td></tr>
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
           WHERE  B.Period='3' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Spring' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra3Spring" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra3Spring" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra3Spring">
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
                      WHERE   tblClass.Period='3' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Spring'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra3Spring" value="Re-Assign Enrichment Class 3 Spring"/>
						<?php echo $noteStr ?>
					</td>
				</tr>
			</table>
			</td>
			</tr>

<!-- Extra Class 4 Spring Reassign-->
			<tr>
			<td>
			<table border="1" cellspacing="0">
				<tr><td bgcolor='powderblue' class='textlargeBoldBrown' colspan='2' >Enrichment Class 4 (<?php echo $PERIOD4; ?>) Spring</td></tr>
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
           WHERE  B.Period='4' and B.IsLanguage='No' and A.StudentMemberID=".$StudentMemberID. " and B.CurrentClass='Yes' and B.Term='Spring' and A.Status='OK' limit 1";

//do query
$extrars = mysqli_query($conn,$extraquery);
//display result
$extraassignclassrow=mysqli_fetch_array($extrars);
$currentextraID=0;
if($extraassignclassrow[ClassID]>0){
	$currentextraID = $extraassignclassrow[ClassID];
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra4Spring" value="<?php echo $extraassignclassrow[ClassID]; ?>"/></td>
		 			<td class='textsmallblack'><?php echo "[". $extraassignclassrow[ClassID]."] ". $extraassignclassrow[GradeOrSubject]."-".$extraassignclassrow[ClassNumber]."  Teacher:".$extraassignclassrow[FirstName]." ".$extraassignclassrow[LastName];?></td>
				</tr>
<?php
}else{
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Current Class:<input type="hidden" name="lastClassExtra4Spring" value="0"/></td>
		 			<td class='textsmallblack'>No Class Assigned</td>
				</tr>
<?php
}
?>
				<tr>
					<td bgcolor='silver' class='textsmallheadBrown'>Reassign Class:</td>
					<td class='textsmallblack'>
						<select name="currentClassExtra4Spring">
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
                      WHERE   tblClass.Period='4' and tblClass.IsLanguage='No' and tblClass.CurrentClass='Yes' and tblClass.Term='Spring'";



//do query

$extraclassRs = mysqli_query($conn,$extraclassQuery);

while($extraclassRow=mysqli_fetch_array($extraclassRs)){
	$extraselected="";
	if($currentextraID==$extraclassRow[ClassID]){
		$extraselected="selected";
	}
?>
						<option <?php echo $extraselected;?> value=<?php echo $extraclassRow[ClassID];?>> <?php  echo "[". $extraclassRow[ClassID]."] ". $extraclassRow[GradeOrSubject]."-".$extraclassRow[ClassNumber]."  Teacher:".$extraclassRow[FirstName]." ".$extraclassRow[LastName];?></option>
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
						<input <?php echo $enabled ?> type="submit" name="reassignExtra4Spring" value="Re-Assign Enrichment Class 4 Spring"/>
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

<?php

mysqli_close($conn);

?>
