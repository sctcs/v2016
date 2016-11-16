<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
	session_start();
	//only for principal or collector
	if(! isset($_SESSION['membertype']) ) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}

	if( $_SESSION['membertype'] != 10 && $_SESSION['membertype'] != 55 && $_SESSION['membertype'] != 20 && $_SESSION['membertype'] != 15) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Class Management</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>
<body>
	<table>
 	 	<tr><td>&nbsp;</td></tr>
 	 	<tr>
 	 	<?php
 	 	  //if ($_SESSION['membertype'] == 10) {
 	 	    include("classesmenu.php");
 	 	  //}
 	 	 ?>

 	 	<td valign='top'>
 	 		<div class=Section1 style="layout-grid:15.6pt 0pt" align="left">
<!--start content  -->
<?php
//common parameters
include("../common/CommonParam/params.php");
//database connection
include("../common/DB/DataStore.php");

$showType = $_GET['type'];
$orderType = $_GET['order'];
$sortType= $_GET['sort'];

$querystring="";
if($showType=="reg"){
	$queryString= "&type=reg";
}

if($sortType=="DESC"){
	$queryString.= "&sort=ASC";
}else{
	$queryString.= "&sort=DESC";
}

?>
			<table border="1" cellspacing="0">
			    <tr>
					<td  bgcolor='powderblue' class='textlargeBoldBrown' colspan='12'>List of All Students</td>
				</tr>

				<tr  align='center' class='textsmallheadBrown' bgcolor='silver'>
					<td>No.</td>
					<td>Member<br>ID</td>
					<td><a href="listallstudents.php?order=ne<?php echo $queryString;?>">Student<br> Name</a></td>
					<td>Chinese<br> Name</td>
					<td>Family<br> ID</td>
					<!--<td>First<br/>Registered Date</td>-->
					<!--<td>Starting<br/>Level</td>-->
					<!--<td><a href="listallstudents.php?order=st<?php echo $queryString;?>">Student<br/>Type</a></td>-->
					<!--<td><a href="listallstudents.php?order=ps<?php echo $queryString;?>">Student<br/>Status</a></td>-->
					<td><a href="listallstudents.php?order=fpc<?php echo $queryString;?>">Fall <br/>Language<br/> Class</a></td>
					<td><a href="listallstudents.php?order=fpe0<?php echo $queryString;?>">Fall <br/>Enrichment<br/> Class 0</a></td>
					<td><a href="listallstudents.php?order=fpe1<?php echo $queryString;?>">Fall <br/>Enrichment<br/> Class 1</a></td>
					<td><a href="listallstudents.php?order=fpe2<?php echo $queryString;?>">Fall <br/>Enrichment <br/>Class 2</a></td>
					<td><a href="listallstudents.php?order=fpe3<?php echo $queryString;?>">Fall <br/>Enrichment <br/>Class 3</a></td>
					<td><a href="listallstudents.php?order=fpe4<?php echo $queryString;?>">Fall <br/>Enrichment <br/>Class 4</a></td>

					<td><a href="listallstudents.php?order=spc<?php echo $queryString;?>">Spring <br/>Language <br/>Class</a></td>
					<td><a href="listallstudents.php?order=spe0<?php echo $queryString;?>">Spring <br/>Enrichment <br/>Class 0</a></td>
					<td><a href="listallstudents.php?order=spe1<?php echo $queryString;?>">Spring <br/>Enrichment <br/>Class 1</a></td>
					<td><a href="listallstudents.php?order=spe2<?php echo $queryString;?>">Spring <br/>Enrichment <br/>Class 2</a></td>
					<td><a href="listallstudents.php?order=spe3<?php echo $queryString;?>">Spring <br/>Enrichment <br/>Class 3</a></td>
					<td><a href="listallstudents.php?order=spe4<?php echo $queryString;?>">Spring <br/>Enrichment <br/>Class 4</a></td>
					<td>Reg'd</td>
				</tr>



<?php

$queryCondition=" ";
$orderBy="";

if($showType=="reg"){
	$queryCondition=" WHERE Registered='yes' ";
}

if($orderType=="st"){
	$orderBy=" ORDER BY StudentType ".$sortType." ,LastName,FirstName";
}elseif($orderType=="pc"){
	$orderBy=" ORDER BY grade ".$sortType." ,classnum,LastName, FirstName";
}elseif($orderType=="pe1"){
	$orderBy=" ORDER BY exclass1 ".$sortType." ,LastName, FirstName";
}elseif($orderType=="pe2"){
	$orderBy=" ORDER BY exclass2 ".$sortType." ,LastName, FirstName";
}elseif($orderType=="ps"){
	$orderBy=" ORDER BY StudentStatus ".$sortType." ,LastName, FirstName";
}else{
	$orderBy=" ORDER BY LastName ".$sortType.", FirstName ";
}

$queryLf= "(SELECT a.StudentMemberID as id, b.GradeOrSubject as grade, b.ClassNumber as classnum, b.ClassID as ClassID
           FROM tblClassRegistration a JOIN tblClass b on a.ClassID=b.ClassID
           WHERE b.IsLanguage ='Yes' and b.Year='" .$CurrentYear."' and b.Term='Fall' and a.Status='OK') cclassf";
$query0f = "(SELECT a0.StudentMemberID as id, b0.GradeOrSubject as exclass0, b0.ClassID as ClassID
           FROM tblClassRegistration a0 JOIN tblClass b0 on a0.ClassID=b0.ClassID
           WHERE b0.IsLanguage ='No' and b0.Period=0 and b0.Year='" .$CurrentYear."' and b0.Term='Fall' and a0.Status='OK') eclass0f";
$query1f = "(SELECT a1.StudentMemberID as id, b1.GradeOrSubject as exclass1, b1.ClassID as ClassID
           FROM tblClassRegistration a1 JOIN tblClass b1 on a1.ClassID=b1.ClassID
           WHERE b1.IsLanguage ='No' and b1.Period=1 and b1.Year='" .$CurrentYear."' and b1.Term='Fall' and a1.Status='OK') eclass1f";
$query2f = "(SELECT a2.StudentMemberID as id, b2.GradeOrSubject as exclass2, b2.ClassID as ClassID
           FROM tblClassRegistration a2 JOIN tblClass b2 on a2.ClassID=b2.ClassID
           WHERE b2.IsLanguage ='No' and b2.Period=2 and b2.Year='" .$CurrentYear."' and b2.Term='Fall' and a2.Status='OK') eclass2f";
$query3f = "(SELECT a3.StudentMemberID as id, b3.GradeOrSubject as exclass3, b3.ClassID as ClassID
           FROM tblClassRegistration a3 JOIN tblClass b3 on a3.ClassID=b3.ClassID
           WHERE b3.IsLanguage='No' and b3.Period=3 and b3.Year='" .$CurrentYear."' and b3.Term='Fall' and a3.Status='OK') eclass3f";
$query4f = "(SELECT a3.StudentMemberID as id, b3.GradeOrSubject as exclass4, b3.ClassID as ClassID
           FROM tblClassRegistration a3 JOIN tblClass b3 on a3.ClassID=b3.ClassID
           WHERE b3.IsLanguage='No' and b3.Period=4 and b3.Year='" .$CurrentYear."' and b3.Term='Fall' and a3.Status='OK') eclass4f";

$queryLs= "(SELECT a1.StudentMemberID as id, b1.GradeOrSubject as grade, b1.ClassNumber as classnum, b1.ClassID as ClassID
           FROM tblClassRegistration a1 JOIN tblClass b1 on a1.ClassID=b1.ClassID
           WHERE b1.IsLanguage ='Yes' and b1.Year='" .$NextYear."' and b1.Term='Spring' and a1.Status='OK') cclasss";
$query0s = "(SELECT a1.StudentMemberID as id, b1.GradeOrSubject as exclass0, b1.ClassNumber as classnum, b1.ClassID as ClassID
           FROM tblClassRegistration a1 JOIN tblClass b1 on a1.ClassID=b1.ClassID
           WHERE b1.IsLanguage ='No' and b1.Period=0 and b1.Year='" .$NextYear."' and b1.Term='Spring' and a1.Status='OK') eclass0s";
$query1s = "(SELECT a2.StudentMemberID as id, b2.GradeOrSubject as exclass1, b2.ClassID as ClassID
           FROM tblClassRegistration a2 JOIN tblClass b2 on a2.ClassID=b2.ClassID
           WHERE b2.IsLanguage ='No' and b2.Period=1 and b2.Year='" .$NextYear."' and b2.Term='Spring' and a2.Status='OK') eclass1s";
$query2s = "(SELECT a2.StudentMemberID as id, b2.GradeOrSubject as exclass2, b2.ClassID as ClassID
           FROM tblClassRegistration a2 JOIN tblClass b2 on a2.ClassID=b2.ClassID
           WHERE b2.IsLanguage ='No' and b2.Period=2 and b2.Year='" .$NextYear."' and b2.Term='Spring' and a2.Status='OK') eclass2s";
$query3s = "(SELECT a3.StudentMemberID as id, b3.GradeOrSubject as exclass3, b3.ClassID as ClassID
           FROM tblClassRegistration a3 JOIN tblClass b3 on a3.ClassID=b3.ClassID
           WHERE b3.IsLanguage ='No' and b3.Period=3 and b3.Year='" .$NextYear."' and b3.Term='Spring' and a3.Status='OK') eclass3s";
$query4s = "(SELECT a3.StudentMemberID as id, b3.GradeOrSubject as exclass4, b3.ClassID as ClassID
           FROM tblClassRegistration a3 JOIN tblClass b3 on a3.ClassID=b3.ClassID
           WHERE b3.IsLanguage ='No' and b3.Period=4 and b3.Year='" .$NextYear."' and b3.Term='Spring' and a3.Status='OK') eclass4s";

$queryclasses = "(SELECT a3.StudentMemberID as id, b3.GradeOrSubject as exclass, b3.ClassID as ClassID,b3.Period,b3.Year,b3.Term,b3.IsLanguage 
           FROM tblClassRegistration a3 JOIN tblClass b3 on a3.ClassID=b3.ClassID
           WHERE  a3.Status='OK') classes";

//query string
       $query = "SELECT StudentID,
                 tblStudent.MemberID,
                 FirstName,
                 LastName,
                 ChineseName,
                 FamilyID,
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
           FROM tblStudent LEFT JOIN tblClass c1 on c1.classID=PreferredExtraClass1 LEFT JOIN tblClass c2 on c2.ClassID=PreferredExtraClass2 LEFT JOIN tblMember on tblMember.MemberID=tblStudent.MemberID "
           .$queryCondition.$orderBy;

mysqli_query($conn,"set sql_big_selects=1");

//         $query = "
//                 SELECT StudentID,
//                 tblStudent.MemberID,
           $query = "select MemberID,
                 FirstName,
                 LastName,
                 ChineseName,
                 FamilyID," .
//               FirstRegistrationDate," .
//               StartingLevel,
//               StudentType,
//               StudentStatus,
           
               " cclassf.grade as gradef,
                 cclassf.classnum as classnumf,
                 eclass0f.exclass0 as exclass0f,
                 eclass1f.exclass1 as exclass1f,
		 eclass2f.exclass2 as exclass2f,
		 eclass3f.exclass3 as exclass3f,
		 eclass4f.exclass4 as exclass4f,
		 cclassf.ClassID as classidf,
		 eclass0f.ClassID as ex0classidf,
		 eclass1f.ClassID as ex1classidf,
		 eclass2f.ClassID as ex2classidf,
		 eclass3f.ClassID as ex3classidf,
		 eclass4f.ClassID as ex4classidf,
                 cclasss.grade as grades,
                 cclasss.classnum as classnums,
                 eclass0s.exclass0 as exclass0s,
                 eclass1s.exclass1 as exclass1s,
		 eclass2s.exclass2 as exclass2s,
		 eclass3s.exclass3 as exclass3s,
		 eclass4s.exclass4 as exclass4s,
		 cclasss.ClassID as classids,
		 eclass0s.ClassID as ex0classids,
		 eclass1s.ClassID as ex1classids,
		 eclass2s.ClassID as ex2classids,
		 eclass3s.ClassID as ex3classids,
		 eclass4s.ClassID as ex4classids,
                 Registered".
//         FROM tblStudent LEFT JOIN tblMember  on tblMember.MemberID=tblStudent.MemberID
         " FROM  tblMember  
                LEFT JOIN "
              .$queryLf." on tblMember.MemberID=cclassf.id LEFT JOIN "
              .$query0f." on tblMember.MemberID=eclass0f.id LEFT JOIN "
              .$query1f." on tblMember.MemberID=eclass1f.id LEFT JOIN "
              .$query2f." on tblMember.MemberID=eclass2f.id LEFT JOIN "
              .$query3f." on tblMember.MemberID=eclass3f.id LEFT JOIN "
              .$query4f." on tblMember.MemberID=eclass4f.id LEFT JOIN "
              .$queryLs." on tblMember.MemberID=cclasss.id LEFT JOIN "
              .$query0s." on tblMember.MemberID=eclass0s.id LEFT JOIN "
              .$query1s." on tblMember.MemberID=eclass1s.id LEFT JOIN "
              .$query2s." on tblMember.MemberID=eclass2s.id LEFT JOIN "
              .$query3s." on tblMember.MemberID=eclass3s.id LEFT JOIN "
              .$query4s." on tblMember.MemberID=eclass4s.id "

           
           .$queryCondition.$orderBy;

//$query="SELECT * FROM `tblMember` m, tblClassRegistration r,tblClass c WHERE m.MemberID=r.StudentMemberID and r.ClassID=c.ClassID and c.CurrentClass='Yes'  ";
//do query
//echo $query;

$rs = mysqli_query($conn,$query);

//echo mysqli_error($conn)

//display result
$studentcount=0;
while ($row=mysqli_fetch_array($rs)) {
	$studentcount++;
//echo $studentcount;
//   $classes[$row[MemberID]][LastName] = $row[LastName];
//   $classes[$row[MemberID]][FirstName] = $row[FirstName];
//   $classes[$row[MemberID]][ChineseName] = $row[ChineseName];
//   $classes[$row[MemberID]][FamilyID] = $row[FamilyID];
// if ( $row[Year] == $CurrentYear && $row[Term] == $CurrentTerm && $row[IsLanguage] =='Yes' ) {
//   $classes[$row[MemberID]][FallLanguage] = "[".$row[ClassID] . "]". $row[GradeOrSubject] .".". $row[ClassNumber];
// }
  if ( $row[classidf] != "" ) {
?>

				<tr class='textsmallblack'>
					<td><?php echo $studentcount;?> &nbsp; </td>
					<td><?php echo $row[MemberID];?>&nbsp;</td>
					<td><?php echo $row[LastName]. ", " .$row[FirstName];?>&nbsp;</td>
					<td><?php echo $row[ChineseName];?>&nbsp;</td>
					<td><?php echo $row[FamilyID];?>&nbsp;</td>

					<!--<td><?php echo $row[FirstRegistrationDate];?>&nbsp;</td>-->
					<!--<td><?php echo $row[StartingLevel];?>&nbsp;</td>-->
					<!--<td><?php echo $StudentType[$row[StudentType]];?>&nbsp;</td>-->
					<!--<td><?php echo $StudentStatus[$row[StudentStatus]];?>&nbsp;</td>-->

					<td><?php if ( $row[gradef] !="" ) {echo "[".$row[classidf]."] ".$row[gradef]. "-" .$row[classnumf];} ?>&nbsp;</td>
					<td><?php if ( $row[ex0classidf] !="" ) {echo "[".$row[ex0classidf]."] ".$row[exclass0f];} ?>&nbsp;</td>
					<td><?php if ( $row[ex1classidf] !="" ) {echo "[".$row[ex1classidf]."] ".$row[exclass1f];} ?>&nbsp;</td>
					<td><?php if ( $row[ex2classidf] !="" ) {echo "[".$row[ex2classidf]."] ".$row[exclass2f];} ?>&nbsp;</td>
					<td><?php if ( $row[ex3classidf] !="" ) {echo "[".$row[ex3classidf]."] ".$row[exclass3f];} ?>&nbsp;</td>
					<td><?php if ( $row[ex4classidf] !="" ) {echo "[".$row[ex4classidf]."] ".$row[exclass4f];} ?>&nbsp;</td>

					<td><?php if ( $row[classids] !="" ) {echo "[".$row[classids]."] ".$row[grades]. "-" .$row[classnums];} ?>&nbsp;</td>
					<td><?php if ( $row[ex0classids] !="" ) {echo "[".$row[ex0classids]."] ".$row[exclass0s];} ?>&nbsp;</td>
					<td><?php if ( $row[ex1classids] !="" ) {echo "[".$row[ex1classids]."] ".$row[exclass1s];} ?>&nbsp;</td>
					<td><?php if ( $row[ex2classids] !="" ) {echo "[".$row[ex2classids]."] ".$row[exclass2s];} ?>&nbsp;</td>
					<td><?php if ( $row[ex3classids] !="" ) {echo "[".$row[ex3classids]."] ".$row[exclass3s];} ?>&nbsp;</td>
					<td><?php if ( $row[ex4classids] !="" ) {echo "[".$row[ex4classids]."] ".$row[exclass4s];} ?>&nbsp;</td>

					<!-- <td><?php echo $row[PreferredClassLevel];?>&nbsp;</td> -->
					<!-- <td><?php echo $row[PreferredExtraClass1];?>&nbsp;</td> -->
					<!-- <td><?php echo $row[cn1];?>&nbsp;</td> -->
					<!-- <td><?php echo $row[PreferredExtraClass2];?>&nbsp;</td> -->
					<!-- <td><?php echo $row[cn2];?>&nbsp;</td> -->

					<td><?php echo $row[Registered];?>&nbsp;</td>
				</tr>

<?php  
}
}
/* 
$j=0;
for ($i=1;$i++;$i<1000) {
  if ( isset($classes[$i][LastName] ) ) {
  $j++;
   echo "<tr><td>".$j."&nbsp;</td><td>". $i ."</td><td>".$classes[$i][LastName].", ".$classes[$i][FirstName] ."</td>";
   echo "<td>". $classes[$i][ChineseName] . "</td>";
   echo "<td>". $classes[$i][FamilyID] . "</td>";
   echo "<td>". $classes[$i][FallLanguage] . "</td>";
   echo "</tr>";
  }
}
*/

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
