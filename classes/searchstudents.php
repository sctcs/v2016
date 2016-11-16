<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
	session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
	session_start();
	//only for principal, provost, and admin
	if(! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 20 ) {
		echo "You don't sufficient authroization to access this page";
	 exit();
	}


?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Southern Connecticut Chinese School Class Management</title>

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
<?php
//common parameters
include("../common/CommonParam/params.php");
//database connection
include("../common/DB/DataStore.php");

$searchterm="";
$searchstr = $_POST['studentname'];
$searchstr = trim($searchstr);
?>
 	 		<table  border="0" cellspacing="0">
			<tr>
			<td>
			<form method="post" action="searchstudents.php">
			<table>
				<tr>
					<td class='textsmallheadBrown'>Search Students:</td>
					<td class='textsmallblack'>
						<input type="text" name="studentname" size="20" value="<?php echo $searchstr;?>" />
					</td>
					<td class='textsmallblack'><input type="submit" name="lookup" value="Look Up"/></td>
				</tr>
				 <tr>
					<td class='textsmallheadBrown'></td>
					<td class='textsmallblack' colspan='2'>Search students by first name or last name</td>
				</tr>

			</table>
			</form>
			</td>
			</tr>
<?php
$querycond="";
if($searchstr!=""){
	$searchterms=explode(" ",$searchstr);
	foreach($searchterms as $searchterm){
		if($querycond!=""){
			$querycond .=" and ";
		}
	  	$querycond .= "(b.FirstName like '%". $searchterm. "%' or b.LastName like '%".$searchterm. "%')";
	}
?>
			<tr>
			<td>
			<table border="1" cellspacing="0">
			    <tr>
					<td  bgcolor='powderblue' class='textlargeBoldBrown' colspan='10'>List of the Students</td>
				</tr>

				<tr  class='textsmallheadBrown' bgcolor='silver'>
				    <td>No.</td>
					<td>Assign Class</td>
					<td>Student Name</td>
					<td>Student Chinese Name</td>
					<td>Registration</td>
					<td>Family ID</td>
					<td>Primary Contact Name</td>
				</tr>

<?php

if (!mysqli_query($conn,"SET SQL_BIG_SELECTS=1"))
  {
  die('Error: ' . mysqli_error($conn));
  }

//query string
$query = "SELECT b.MemberID,
                 b.FirstName,
                 b.LastName,
                 b.ChineseName,
                 b.Registered,
                 d.FamilyID,
                 d.FirstName as pfn,
                 d.LastName as pln
           FROM (tblStudent a join tblMember b on b.MemberID=a.MemberID), tblMember d
           WHERE ". $querycond. " and b.registered='yes' and b.FamilyID=d.FamilyID and d.PrimaryContact='yes'
        ORDER BY  b.LastName, b.FirstName";
$query = " SELECT b.MemberID,
                 b.FirstName,
                 b.LastName,
                 b.ChineseName,
                 b.Registered,
                 d.FamilyID,
                 d.FirstName as pfn,
                 d.LastName as pln
           FROM tblMember b , tblMember d
           WHERE ". $querycond. "                        and d.FamilyID=b.FamilyID and d.PrimaryContact='Yes'
        ORDER BY  b.LastName, b.FirstName";
//do query
$rs = mysqli_query($conn,$query);
if ( ! $rs )
{
	echo mysqli_error($conn);
    echo $query;
}
//display result
$studentcount=0;
while ($row=mysqli_fetch_array($rs)) {
	$studentcount++;
?>
				<tr class='textsmallblack'>
					<td><?php echo $studentcount;?></td>
				<!--<td><a href="reassignstudent.php?StudentMemberID=<?php echo $row[MemberID];?>">Assign Class</a></td>-->
					<td><a href="reassignClasses.php?StudentMemberID=<?php echo $row[MemberID];?>">Assign Class</a></td>
					<td><?php echo $row[FirstName]. " " .$row[LastName];?>&nbsp;</td>
					<td><?php echo $row[ChineseName];?>&nbsp;</td>
					<td><?php echo $row[Registered];?>&nbsp;</td>
					<td><?php echo $row[FamilyID];?>&nbsp;</td>
					<td><?php echo $row[pfn]. " " .$row[pln];?>&nbsp;</td>
				</tr>
<?php
}
if($studentcount==0){
?>
				<tr class='textsmallblack'>
					<td colspan='7'>No student found</td>
				</tr>
<?php
}
mysqli_close($conn);
}
?>
			</table>
			</td>
			</tr>
			</table>
<!--end of content  -->

			</div>
			</td>
		</tr>
	</table>
</body>
</html>
