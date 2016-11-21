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


if (isset($_POST[memberID]) || isset($_POST[familyID])) {
    $memberID = trim($_POST[memberID]);
    $familyID = trim($_POST[familyID]);
} else if (isset($_GET[fid])) {
    $familyID = $_GET[fid];
} else if(isset($_GET[memid])) {
    $memid = $_GET[memid];
}

if (($memberID == "") && ($familyID == "")) {
    header('Location: MemberLookupByIDForm.php?error=1');
    exit();
}

if ($memberID != "") {
    $memid = $memberID;
}


if (isset($_SESSION['logon'])) {
    $seclvl = $_SESSION['membertype'];
    $secdesc = $_SESSION['MemberTypes'][$seclvl];
}

if ($memberID != "") {
    $SQLstring = 'SELECT `FamilyID`, `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`,`UserName`,`Password` FROM `tblMember`  WHERE `MemberID` = \'' . $memberID . '\'';
} else if ($familyID != "") {
    $SQLstring = 'SELECT `FamilyID`, `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`,`UserName`,`Password` FROM `tblMember`  WHERE `FamilyID` = \'' . $familyID . '\'';
}
// 3. get class info
$SQLclass = "SELECT GradeOrSubject,ClassNumber,Classroom,c.Year,Term,CurrentClass,ClassFee,
                     r.ClassRegistrationID, r.ClassID
             FROM `tblClass` c, tblClassRegistration r
             where c.ClassID=r.ClassID and r.StudentMemberID=" . $memid . " and r.Status !='Dropped'";
$RSc = mysqli_query($conn, $SQLclass);
//echo $SQLclass;
//}
//echo "see 1: ".$SQLstring;

$RS1 = mysqli_query($conn, $SQLstring);

$rc = 0;
while ($row1 = mysqli_fetch_array($RS1)) {
    $mid = $row[MemberID];
    $lname = $row[LastName];
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
if ($rc == 1) {
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

        <?php
        if (isset($SESSION['logon']) && $seclvl == 20) {
            ?>

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
<!--                <table class="table">-->
<!--                    <tr><td>&nbsp;</td></tr>
                    <tr><td rowspan="4">&nbsp;</td></tr>
                    <tr>
                        <td>-->
                            <table border="0" class="table table-striped">
                                <?php
                                //// 2. get login info  ////
                                if ($memid != "") {
                                    $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID` FROM `tblMember` WHERE `MemberID`=\'' . $memberID . '\'';
                                    //$SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "'  ORDER BY FirstName";
                                }
//                                else {
//                                    $SQLstring = 'SELECT `MemberID`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`, `FamilyID` FROM `tblMember` WHERE `MemberID`=\'' . $MemberID .'\'';
//                                    //$SQLstring = "SELECT * FROM tblMember WHERE LastName='" . $lname . "' and FirstName='". $fname . "'";
//                                }
                                //   echo "see 2: ".$SQLstring;
                                $RS1 = mysqli_query($conn, $SQLstring);
                                $rc = 0;

                                while ($row = mysqli_fetch_array($RS1)) {
                                    $rc = $rc + 1;
                                    ?>
                                    <tr><td><?php echo $rc; ?>.&nbsp;
                                            <a href="MemberLookup.php?memid=<?php echo $row[MemberID] . "&lname=" . $row[LastName] . "\">" . $row[LastName] . ", " . $row[FirstName] . "  " . $row[ChineseName] . ", memberID=" . $row[MemberID]; ?></a></td>
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
                                                   <h3>Detailed Record of <?php echo $row[FirstName] . '  ' . $row[LastName]; ?></h3>
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
                                               echo "<p class='red-color text-center'>no record found for " . $memid . ", <a href=\"MemberLookupByIDForm.php\">continue ...</a>";
                                               exit;
                                           }
                                       }
                                       mysqli_close($conn);
                                       ?>
                        </table>
                        <p class="lead"><a href="MemberLookupByID.php?fid=<?php echo $familyID; ?>">View list of <?php echo $familyID; ?></a>&nbsp;||&nbsp;<a href="MemberLookupByIDForm.php">Lookup By ID</a>&nbsp;||&nbsp;<a href='MemberLookupForm.php'>Look up By Name</a></p>
                        </div>
                        </div>
                        <?php include("../common/site-footer1.php"); ?>