<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
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


if (isset($_POST["lname"])) {
	$lname = $_POST["lname"];
} else if (isset($_GET["lname"])) {
	$lname = $_GET["lname"];
}

$lname = str_replace("'", "''", $lname);
$lname = str_replace("\n", " ", $lname);
$lname = trim($lname);

if (isset($_POST["fname"])) {
	$fname = $_POST["fname"];
} else if (isset($_GET["fname"])) {
	$fname = $_GET["fname"];
}

$fname = str_replace("'", "''", $fname);
$fname = str_replace("\n", " ", $fname);
$fname = trim($fname);

if ($lname == "") { // || $fname=="")
	header('Location: MemberLookupForm.php?error=1');
	exit();
}

if (isset($_GET["memid"])) {
	$memid = $_GET["memid"];
}
else {
	$memid = "";
}

if (isset($_SESSION['logon'])) {

    $seclvl = $_SESSION['membertype'];
    $secdesc = $_SESSION['MemberTypes'][$seclvl];
}

$SQLSelect = <<<SQLSELECT
SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`,
	`HomePhone`, `OfficePhone`, `CellPhone`,
	`Email`, `SecondEmail`,
	`HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`,
	`Profession`, `FamilyID`, `UserName`, `Password`
	FROM `tblMember`
SQLSELECT;

//// 2. get login info  ////
if ( $memid != "" )
{
	$SQLstring = $SQLSelect . " WHERE MemberID = " . $memid;

	$SQLclass = <<<SQLCLASS
SELECT GradeOrSubject,ClassNumber,Classroom,c.Year,Term,CurrentClass,ClassFee,
	r.ClassRegistrationID, r.ClassID
	FROM `tblClass` c, tblClassRegistration r
	WHERE c.ClassID=r.ClassID and r.StudentMemberID=" . $memid . " and r.Status !='Dropped'
SQLCLASS;
	$RSclass = mysqli_query($conn, $SQLclass);
	
}
else if ($fname == "") {
    $SQLstring = $SQLSelect . " WHERE FamilyID in ( SELECT FamilyID FROM tblMember WHERE LastName='" . $lname . "' ) order by FamilyID";
} else {
    $SQLstring = $SQLSelect . " WHERE FamilyID in ( SELECT FamilyID FROM tblMember WHERE LastName='" . $lname . "' and FirstName='" . $fname . "' )  order by FamilyID";
}

$RSmember = mysqli_query($conn, $SQLstring);
$memberCount = 0;
while ($currentRow = mysqli_fetch_array($RSmember)) {
    $mid = $currentRow["MemberID"];
    $lname = $currentRow["LastName"];
    $memberCount = $memberCount + 1;
    $members[$memberCount] = $currentRow;
}
?>

<header>
    <?php include("../common/site-header1.php"); ?>
    <script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
    <script language="javascript" src="../common/JS/MainValidate.js"></script>
</header>
<div class="container">	
    <div class="col-sm-4 col-sm-offset-1">
        <?php include("../common/site-header4Profilefolder.php"); ?><!--Side menu-->
    </div>
    <div class="col-sm-7">
        <?php
        if ($memberCount == 1) {         //one record found
            $row = $members[1];
			?>
            <h3>Member Record</h3>
            <table border="1" class="table table-striped">
            <?php
            if (isset($_SESSION['logon']) && ( $seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55)) {
				?>
				<tr><td>Member ID:</td><td><?php echo $row["MemberID"]; ?></td></tr>
				<tr><td>Family ID:</td><td><?php echo $row["FamilyID"]; ?></td></tr>
				<?php
				if (isset($_SESSION['logon']) && $seclvl == 20) {
					?>
					<tr><td>Login:</td><td><?php echo $row["UserName"]; ?></td></tr>
					<tr><td>Password:</td><td><?php echo $row["Password"]; ?></td></tr>
					<?php
				}
			}
			?>
				<tr><td>Last Name:</td><td><?php echo $row["LastName"]; ?></td></tr>
                <tr><td>First Name:</td><td><?php echo $row["FirstName"]; ?></td></tr>
                <tr><td>Chinese Name:</td><td><?php echo $row["ChineseName"]; ?></td></tr>
			<?php
			if (isset($_SESSION['logon'])) { 
				?>
				<tr><td>Home Phone:</td><td><?php echo $row["HomePhone"]; ?></td></tr>
				<?php
				if ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) {
					?>
					<tr><td>Email:</td><td><?php echo $row["Email"]; ?></td></tr>
					<tr><td>Office Phone:</td><td><?php echo $row["OfficePhone"]; ?></td></tr>
					<tr><td>Cell Phone:</td><td><?php echo $row["CellPhone"]; ?></td></tr>
					<tr><td>Street:</td><td><?php echo $row["HomeAddress"]; ?></td></tr>
					<tr><td>City:</td><td><?php echo $row["HomeCity"]; ?></td></tr>
					<tr><td>State:</td><td><?php echo $row["HomeState"]; ?></td></tr>
					<tr><td>Zip:</td><td><?php echo $row["HomeZip"]; ?></td></tr>
					<tr><td>Profession:</td><td><?php echo $row["Profession"]; ?></td></tr>
					<?php
				}
			}
			?>
			</table>
			<?php
		}
		
		if ($memberCount > 1) { 
			?>
			<h3>Member Records</h3>
			<table class="table" border="1sp">
			<?php
			$existingFamilyID = -1;
			for ( $i = 1; $i <= $memberCount; $i++ )
			{
				$currentRow = $members[$i];
				
				if ( $existingFamilyID != $currentRow["FamilyID"] )
				{
					if ( $existingFamilyID != -1 )
					{
						?></td></tr>
						<?php
					}
					?><tr><td valign="top">Family # <?php echo $currentRow["FamilyID"];?></td>
						<td valign="top" style="fo"><?php
				}
				?>
				<ol><a href="MemberLookup.php?memid=<?php echo $currentRow["MemberID"] . "&lname='" . $currentRow["LastName"] . "'"?>">
				<?php echo $currentRow["LastName"] . ", " . $currentRow["FirstName"] . "  " . $currentRow["ChineseName"]; ?>
				</a></ol>
				<?php
				
				$existingFamilyID = $currentRow["FamilyID"];
			}
			?>
			</td></tr></table>
			<?php 
		}
		else if ($memberCount == 1) {
			if (isset($_SESSION['logon']) && ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55)) {
				if ($memid != "") {
					?>
					</div>
					<div class='col-sm-12'>
					<h3>Detailed Record of <?php echo $fname.'  '.$lname;?></h3>
					<table border=1 class='table table-striped'>
					<tr><th>ClassID</th>
						<th>ClassRegID</th>
						<th>Grade</th>
						<th>Class</th>
						<th>Classroom</th>
						<th>Year</th>
						<th>Term</th>
						<th>Current<br>Class</th>
						<th>Tuition</th></tr>
					<?php
					while ($rowc = mysqli_fetch_array($RSclass)) {?>
						<tr><td><?php echo $rowc["ClassID"]; ?></td>
						<td><?php echo $rowc["ClassRegistrationID"]; ?></td>
						<td><?php echo $rowc["GradeOrSubject"]; ?></td>
						<td><?php echo $rowc["ClassNumber"]; ?></td>
						<td><?php echo $rowc["Classroom"]; ?></td>
						<td><?php echo $rowc["Year"]; ?></td>
						<td><?php echo $rowc["Term"]; ?></td>
						<td><?php echo $rowc["CurrentClass"]; ?></td>
						<td><?php echo $rowc["ClassFee"]; ?></td></tr>
						<?php
					}?>
					</table>
					<?php 
				}
			}
		}
		else {  //no record found
			if ($memid == "") {
				echo "<p class='red-color text-center'>no record found for " . $fname . " " . $lname . ", <a href=\"MemberLookupForm.php\">continue ...</a>";
				exit;
			}
		}
		mysqli_close($conn);
		?>
		<table><tr><td><a href="MemberLookup.php?lname=<?php echo $lname; ?>">View list of <?php echo $lname; ?></a></td></tr>
			<tr><td><a href="MemberLookupForm.php">New Lookup</a></td></tr></table>
		</div>
		<?php include("../common/site-footer1.php"); ?>
