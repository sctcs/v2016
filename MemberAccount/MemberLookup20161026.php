<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

//if( ! isset($_SESSION['logon']) ) {
//  echo "You need to <a href=\"MemberLoginForm.php\">login</a>";
//  exit;
//}

include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);

////////////////////////////////////////////
// 1. get all variables
// 2. query DB and get login id
// 3. create necessary session
// 4. redirect page to new location
///////////////////////////////////////////

////  1. load all variables ////


if (isset($_POST[lname])) {
$lname=$_POST[lname];
} else if (isset($_GET[lname])) {
$lname=$_GET[lname];
}

$lname=str_replace("'", "''",$lname);
$lname=str_replace("\n", " ",$lname);
$lname=trim($lname);

$fname=$_POST[fname];
$fname=str_replace("'", "''",$fname);
$fname=str_replace("\n", " ",$fname);
$fname=trim($fname);

if ($lname=="") // || $fname=="")
{
 header( 'Location: MemberLookupForm.php?error=1' ) ;
 exit();
 }

$memid=$_GET[memid];
//if ($memid =="" && $fname !="") {
//   echo "<center>";
//   echo "memid= ". $memid."<br>";
//   echo "fname= ". $fname."<br>";
//   echo "no match found, <a href=\"MemberLookupForm.php\">continue ...</a>";
//   echo "</center>";
//   exit;

//}

if ( isset($_SESSION['logon']) ) {

	$seclvl = $_SESSION['membertype'];
	$secdesc= $_SESSION['MemberTypes'][$seclvl];
}


//// 2. get login info  ////
if ($fname=="") {
     $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID`,UserName,Password FROM `tblMember` WHERE `LastName`=\''.$lname.'\'' ;
 //  $SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "'";
} else {
  // $SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "' and FirstName='". $fname . "'";
   $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID`,UserName,Password FROM `tblMember` WHERE `LastName`=\''.$lname.'\' and FirstName=\''.$fname.'\'' ;
}
if ($memid !="") {
  $SQLstring .= " and MemberID = ".$memid."";

  // 3. get class info
  $SQLclass = "SELECT GradeOrSubject,ClassNumber,Classroom,c.Year,Term,CurrentClass,ClassFee,
  r.ClassRegistrationID, r.ClassID
  FROM `tblClass` c, tblClassRegistration r
               where c.ClassID=r.ClassID and r.StudentMemberID=".$memid."";
  $RSc=mysqli_query($conn,$SQLclass);
  //echo $SQLclass;
}

//echo "see 1: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
$rc=0;

while ($row1=mysqli_fetch_array($RS1)) {
   $mid=$row1[MemberID];
   $lname=$row1[LastName];
   $rc = $rc + 1;
   $rows[$rc] = $row1;
}

   if ($rc == 1) {
   $row = $rows[1];
   ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Yale New Haven Community Chinse School Member Lookup</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../../common/ynhc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
<script language="javascript" src="../common/JS/MainValidate.js"></script>

</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr>
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="28%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>
					</td>
					<td align="center" valign="top" >
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td bgcolor="#993333">
									<table height="60%" border="0" width=100% bgcolor="white">
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
<?php     if(  isset($_SESSION['logon']) && ( $seclvl <=25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) ) {
?>
										<tr><td align="right">Member ID:</td>
											<td align="left"><?php echo $row[MemberID]; ?></td>
										</tr>
										<tr><td align="right">Family ID:</td>
											<td align="left"><?php echo $row[FamilyID]; ?></td>
										</tr>
	<?php        if(  isset($_SESSION['logon']) && $seclvl == 20) { ?>
										<tr><td align="right">Login:</td>
											<td align="left"><?php echo $row[UserName]; ?></td>
										</tr>
										<tr><td align="right">Password:</td>
											<td align="left"><?php echo $row[Password]; ?></td>
										</tr>

             <?php } } ?>
										<tr><td align="right">Last Name:</td>
											<td align="left"><?php echo $row[LastName]; ?></td>
										</tr>
										<tr><td align="right">First Name:</td>
											<td align="left"><?php echo $row[FirstName]; ?></td>
										</tr>
										<tr><td align="right">Chinese Name:</td>
											<td align="left"><?php echo $row[ChineseName]; ?></td>
										</tr>
   <?php if(  isset($_SESSION['logon']) ) { ?>
										<tr><td align="right">Home Phone:</td>
											<td align="left"><?php echo $row[HomePhone]; ?></td>
										</tr>
						<?php if ( $seclvl <=25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) {			?>
										<tr><td align="right">Email:</td>
											<td align="left"><?php echo $row[Email]; ?></td>
										</tr>
										<tr><td align="right">Office Phone:</td>
											<td align="left"><?php echo $row[OfficePhone]; ?></td>
										</tr>
										<tr><td align="right">Cell Phone:</td>
											<td align="left"><?php echo $row[CellPhone]; ?></td>
										</tr>
										<tr><td align="right">Street:</td>
											<td align="left"><?php echo $row[HomeAddress]; ?></td>
										</tr>
										<tr><td align="right">City:</td>
											<td align="left"><?php echo $row[HomeCity]; ?></td>
										</tr>
										<tr><td align="right">State:</td>
											<td align="left"><?php echo $row[HomeState]; ?></td>
										</tr>
										<tr><td align="right">Zip:</td>
											<td align="left"><?php echo $row[HomeZip]; ?></td>
										</tr>
										<tr><td align="right">Profession:</td>
											<td align="left"><?php echo $row[Profession]; ?></td>
										</tr>



    <?php } } }

//  $rc = $rc + 1;
//}

if ($rc > 1 ) { ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Yale New Haven Community Chinse School Member Lookup</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../../common/ynhc.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
<script language="javascript" src="../common/JS/MainValidate.js"></script>

</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr>
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="28%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php// include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>
					</td>
					<td align="center" valign="top" >
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td bgcolor="#993333">
									<table height="60%" border="0" width=100% bgcolor="white">
										<tr>
											<td colspan=2>&nbsp;

											</td>
										</tr>
<?php
//// 2. get login info  ////
if ($fname=="") {
  $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID` FROM `tblMember` WHERE `LastName`=\''.$lname.'\''.' order by FirstName' ;
  //$SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "'  ORDER BY FirstName";
} else {
  $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID` FROM `tblMember` WHERE `LastName`=\''.$lname.'\' and FirstName=\''.$fname.'\'' ;
  //$SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "' and FirstName='". $fname . "'";
}
//echo "see 2: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
$rc=0;

 while ($row=mysqli_fetch_array($RS1)) {
  $rc = $rc + 1;

  ?>
										<tr><td align="right"><?php echo $rc; ?>, </td>
											<td align="left"><a href="MemberLookup.php?memid=<?php echo $row[MemberID]."&lname=".$row[LastName]."\">".$row[LastName].", ".$row[FirstName] ."  ".$row[ChineseName]; ?></a></td>
										</tr>
  <?php
 }

} else if ($rc == 1 ) {
   //header( 'Location: MemberLookup.php?memid=' .$mid  ."&lname=".$lname );
//	$seclvl = $_SESSION['membertype'];
   if ( isset($_SESSION['logon']) && ($seclvl <=25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55)) {
    if ( $memid !="" ) { ?>

      </table>
      <table border=1 bgcolor="white" width=100%>
      <tr><th>ClassID</th><th>ClassRegID</th><th>Grade</th><th>Class</th><th>Classroom</th><th>Year</th><th>Term</th><th>Current<br>Class</th><th>Tuition</th></tr>
      <?php
//      echo $SQLclass;
      while ( $rowc=mysqli_fetch_array($RSc) ) { ?>
         <tr>
	   		 <td align="middle"><?php echo $rowc[ClassID]; ?></td>
	   		 <td align="middle"><?php echo $rowc[ClassRegistrationID]; ?></td>
	   		 <td align="middle"><?php echo $rowc[GradeOrSubject]; ?></td>
	   		 <td align="middle"><?php echo $rowc[ClassNumber]; ?></td>
	   		 <td align="middle"><?php echo $rowc[Classroom]; ?></td>
	   		 <td align="middle"><?php echo $rowc[Year]; ?></td>
	   		 <td align="middle"><?php echo $rowc[Term]; ?></td>
	   		 <td align="middle"><?php echo $rowc[CurrentClass]; ?></td>
	   		 <td align="right"><?php echo $rowc[ClassFee]; ?></td>
		 </tr>
      <?php } ?>
      </table><table>
    <?php }
   }


} else {
  if ($memid =="") {

   echo "<center>";
   //echo "memid= ". $memid."<br>";
   //echo "fname= ". $fname."<br>";
   echo "no record found for ".$fname." ".$lname.", <a href=\"MemberLookupForm.php\">continue ...</a>";
   echo "</center>";
   exit;

  }
}



mysqli_close($conn);

?>

</table>
								</td>
							</tr>
							<tr><td><a href="MemberLookup.php?lname=<?php echo $lname; ?>">View list of <?php echo $lname; ?></a>&nbsp;<a href="MemberLookupForm.php">New Lookup</a></td></tr>
						</table>
					</td>
					<!-- <td  width="6%">
						<?php include("Advertisment/ad1.php"); ?>
					</td> -->
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>

		</td>
	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>
