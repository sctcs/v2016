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


if (isset($_POST[lname])) {
    $lname = $_POST[lname];
} else if (isset($_GET[lname])) {
    $lname = $_GET[lname];
}

$lname = str_replace("'", "''", $lname);
$lname = str_replace("\n", " ", $lname);
$lname = trim($lname);

$fname = $_POST[fname];
$fname = str_replace("'", "''", $fname);
$fname = str_replace("\n", " ", $fname);
$fname = trim($fname);

if ($lname == "") { // || $fname=="")
    header('Location: MemberLookupForm.php?error=1');
    exit();
}

$memid = $_GET[memid];
//if ($memid =="" && $fname !="") {
//   echo "<center>";
//   echo "memid= ". $memid."<br>";
//   echo "fname= ". $fname."<br>";
//   echo "no match found, <a href=\"MemberLookupForm.php\">continue ...</a>";
//   echo "</center>";
//   exit;
//}

if (isset($_SESSION['logon'])) {

    $seclvl = $_SESSION['membertype'];
    $secdesc = $_SESSION['MemberTypes'][$seclvl];
}


//// 2. get login info  ////
if ($fname == "") {
    $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID`,UserName,Password FROM `tblMember` WHERE `LastName`=\'' . $lname . '\'';
    //  $SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "'";
} else {
    // $SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "' and FirstName='". $fname . "'";
    $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID`,UserName,Password FROM `tblMember` WHERE `LastName`=\'' . $lname . '\' and FirstName=\'' . $fname . '\'';
}
if ($memid != "") {
    $SQLstring .= " and MemberID = " . $memid . "";

    // 3. get class info
    $SQLclass = "SELECT GradeOrSubject,ClassNumber,Classroom,c.Year,Term,CurrentClass,ClassFee,
  r.ClassRegistrationID, r.ClassID
  FROM `tblClass` c, tblClassRegistration r
               where c.ClassID=r.ClassID and r.StudentMemberID=" . $memid . " and r.Status !='Dropped'";
    $RSc = mysqli_query($conn, $SQLclass);
    //echo $SQLclass;
}

//echo "see 1: ".$SQLstring;
$RS1 = mysqli_query($conn, $SQLstring);
$rc = 0;

while ($row1 = mysqli_fetch_array($RS1)) {
    $mid = $row1[MemberID];
    $lname = $row1[LastName];
    $rc = $rc + 1;
    $rows[$rc] = $row1;
}
?>

<header>
    <?php include("../common/site-header1.php"); ?>
<!--    <script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>-->
    <script language="javascript" src="../common/JS/MainValidate.js"></script>
</header>
<div class="container">	
    <div class="col-sm-4 col-sm-offset-1">
        <?php include("../common/site-header4Profilefolder.php"); ?><!--Side menu-->
    </div>
    <div class="col-sm-7">

        <?php
        if ($rc == 1) {         //one record
            $row = $rows[1];
            ?>
            <h3>Member Record</h3>

            <table border="1" class="table table-striped">
                <?php if (isset($_SESSION['logon']) && ( $seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55)) {
                    ?>
                    <tr><td>Member ID:</td>
                        <td><?php echo $row[MemberID]; ?></td>
                    </tr>
                    <tr><td>Family ID:</td>
                        <td><?php echo $row[FamilyID]; ?></td>
                    </tr>
                    <?php if (isset($_SESSION['logon']) && $seclvl == 20) { ?>
                        <tr><td>Login:</td>
                            <td><?php echo $row[UserName]; ?></td>
                        </tr>
                        <tr><td>Password:</td>
                            <td><?php echo $row[Password]; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr><td>Last Name:</td>
                    <td><?php echo $row[LastName]; ?></td>
                </tr>
                <tr><td>First Name:</td>
                    <td><?php echo $row[FirstName]; ?></td>
                </tr>
                <tr><td>Chinese Name:</td>
                    <td><?php echo $row[ChineseName]; ?></td>
                </tr>
                <?php if (isset($_SESSION['logon'])) { ?>
                    <tr><td>Home Phone:</td>
                        <td><?php echo $row[HomePhone]; ?></td>
                    </tr>
                    <?php if ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) { ?>
                        <tr><td>Email:</td>
                            <td><?php echo $row[Email]; ?></td>
                        </tr>
                        <tr><td>Office Phone:</td>
                            <td><?php echo $row[OfficePhone]; ?></td>
                        </tr>
                        <tr><td>Cell Phone:</td>
                            <td><?php echo $row[CellPhone]; ?></td>
                        </tr>
                        <tr><td>Street:</td>
                            <td><?php echo $row[HomeAddress]; ?></td>
                        </tr>
                        <tr><td>City:</td>
                            <td><?php echo $row[HomeCity]; ?></td>
                        </tr>
                        <tr><td>State:</td>
                            <td><?php echo $row[HomeState]; ?></td>
                        </tr>
                        <tr><td>Zip:</td>
                            <td><?php echo $row[HomeZip]; ?></td>
                        </tr>
                        <tr><td>Profession:</td>
                            <td><?php echo $row[Profession]; ?></td>
                        </tr>

                        <?php
                    }
                }
            }
            //  $rc = $rc + 1;
            //}


            if ($rc > 1) {
                ?>
                <h3>Member Records</h3>
                <table border="0" class="table table-striped">
                    <?php
                    //// 2. get login info  ////
                    if ($fname == "") {
                        $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID` FROM `tblMember` WHERE `LastName`=\'' . $lname . '\'' . ' order by FirstName';
                        //$SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "'  ORDER BY FirstName";
                    } else {
                        $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID` FROM `tblMember` WHERE `LastName`=\'' . $lname . '\' and FirstName=\'' . $fname . '\'';
                        //$SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "' and FirstName='". $fname . "'";
                    }
                    //echo "see 2: ".$SQLstring;
                    $RS1 = mysqli_query($conn, $SQLstring);
                    $rc = 0;

                    while ($row = mysqli_fetch_array($RS1)) {
                        $rc = $rc + 1;
                        ?>
                        <tr><td><?php echo $rc; ?>, </td>
                            <td><a href="MemberLookup.php?memid=<?php echo $row[MemberID] . "&lname=" . $row[LastName] . "\">" . $row[LastName] . ", " . $row[FirstName] . "  " . $row[ChineseName]; ?></a></td>
                                   </tr>
                                   <?php
                               }
                           } //$rc > 1 
                           else if ($rc == 1) {

                               //header( 'Location: MemberLookup.php?memid=' .$mid  ."&lname=".$lname );
                               //$seclvl = $_SESSION['membertype'];
                               if (isset($_SESSION['logon']) && ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55)) {
                                   if ($memid != "") {
                                       ?>
                                       </table> </div>
                                       <div class='col-sm-12'>
                                       <h3>Detailed Record of <?php echo $fname . '  ' . $lname; ?></h3>
                                       <table border=1 class='table table-striped'>
                                       <tr><th>ClassID</th><th>ClassRegID</th><th>Grade</th><th>Class</th><th>Classroom</th><th>Year</th><th>Term</th><th>Current<br>Class</th><th>Tuition</th></tr>
                                       <?php
                                       //      echo $SQLclass;
                                       while ($rowc = mysqli_fetch_array($RSc)) {
                                           ?>
                                           <tr>
                                           <td><?php echo $rowc[ClassID]; ?></td>
                                           <td><?php echo $rowc[ClassRegistrationID]; ?></td>
                                           <td><?php echo $rowc[GradeOrSubject]; ?></td>
                                           <td><?php echo $rowc[ClassNumber]; ?></td>
                                           <td><?php echo $rowc[Classroom]; ?></td>
                                           <td><?php echo $rowc[Year]; ?></td>
                                           <td><?php echo $rowc[Term]; ?></td>
                                           <td><?php echo $rowc[CurrentClass]; ?></td>
                                           <td><?php echo $rowc[ClassFee]; ?></td>
                                           </tr>
                                           <?php
                                       }
                                   }
                               }
                           } else {  //no record found
                               if ($memid == "") {
                                   //echo "memid= ". $memid."<br>";
                                   //echo "fname= ". $fname."<br>";
                                   echo "<p class='red-color text-center'>no record found for " . $fname . " " . $lname . ", <a href=\"MemberLookupForm.php\">continue ...</a>";
                                   exit;
                               }
                           }
                           mysqli_close($conn);
                           ?>

                           </table>
                           <p class='lead'><a href="MemberLookup.php?lname=<?php echo $lname; ?>">View list of <?php echo $lname; ?></a>&nbsp;|| &nbsp;<a href="MemberLookupForm.php">Lookup By Name</a></td>&nbsp;||&nbsp;<a href='MemberLookupByIDForm.php'>Lookup By ID</p>

                    </div>
                    </div>
                    <?php include("../common/site-footer1.php"); ?>
