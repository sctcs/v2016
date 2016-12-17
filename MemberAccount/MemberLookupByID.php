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
}

if (isset($_GET['memid'])) {
    $memid = $_GET['memid'];
} else {
    $memid = "";
}

if (($memberID == "") && ($familyID == "") && ($memid == "")) {
    header('Location: MemberLookupByIDForm.php?error=1');
    exit();
}

if (isset($_SESSION['logon'])) {
    $seclvl = $_SESSION['membertype'];
    $secdesc = $_SESSION['MemberTypes'][$seclvl];
}

$SQLstring = 'SELECT `FamilyID`, `MemberID`,`UserName`, `Password`, `FirstName`, `LastName`, `ChineseName`, `HomePhone`, `OfficePhone`, `CellPhone`, `Email`, `SecondEmail`, `HomeAddress`, `HomeCity`, `HomeState`, `HomeZip`, `Profession`,`UserName`,`Password`,`PrimaryContact` FROM `tblMember`';


if ($memberID != "") {
    //  $SQLstring .= ' WHERE `MemberID` = \'' . $memberID . '\'';
    $SQLstring .= " WHERE `FamilyID` in (select `FamilyID` from tblMember where `MemberID` =" . $memberID . ")";
} else if ($familyID != "") {
    $SQLstring .= ' WHERE `FamilyID` = \'' . $familyID . '\'';
} else if ($memid != "") {
    $SQLstring .= ' WHERE `MemberID` = \'' . $memid . '\'';
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
    $mid = $row1[MemberID];
    //  $lname = $row1[LastName];
    $rc = $rc + 1;
    $rows[$rc] = $row1;
}
?>

<header>
    <?php include("../common/site-header1.php"); ?>
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
                <?php if(isset($_SESSION['logon']) && ( $seclvl <= 25 || $seclvl === 35 || $seclvl === 40 || $seclvl === 55)) {
                    ?>
                    <p class="text-center"><a href="MemberLookupByID.php?fid=<?php echo $row[FamilyID] . "\">" . "More Members in FamilyID#='" . $row[FamilyID] . "' && LastName='" . $row[LastName] . "'</a>"; ?><?php $row[LastName] . " " . $row[FamilyID]; ?></p>
                            <tr><td>Member ID:</td>
                            <td><?php echo $row[MemberID]; ?></td>
                            </tr>
                            <tr><td>Family ID:</td>
                            <td><?php echo $row[FamilyID]; ?></td>
                            </tr>
                       <?php   
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
                            
                           <?php if($seclvl == 20) { ?>
                          <tr><td>Login:</td>
                                <td><?php echo $row[UserName]; ?></td>
                                </tr>
                                <tr><td>Password:</td>
                                <td><?php echo $row[Password]; ?></td>
                                </tr>
                         
                        <?php }
                            
                            if ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) { ?>
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
                                  ?>
                          </table>  
                     <?php }  //end $rc=1

             if ($rc > 1) {   ?>
                   <h3>Member Records</h3>
                   <table border="1" class="table table-striped">
                        <tr><th>Member List</th><th>English Name</th><th>Chinese Name</th><th>Member ID</th><th>Primary Contact</th></tr>
                        <?php
                        // var_dump($rows);

                        for ($i = 1; $i <= $rc; $i++) {
                            ?>
                            <tr><td><?php echo $i; ?>.&nbsp</td><td>
                                    <a href="MemberLookupByID.php?memid=<?php echo $rows[$i][MemberID] . "\">" . $rows[$i][LastName] . ", " . $rows[$i][FirstName] . "</a></td><td>"; ?><?php echo $rows[$i][ChineseName] . "</td><td> " . $rows[$i][MemberID] . "</td><td>" . $rows[$i][PrimaryContact] . "</td>"; ?></td>
                                    <?php
                                    if ($rows[$i][PrimaryContact] == "Yes") {
                                        echo "<h4>Family ID#: " . $rows[$i][FamilyID] . "</h4>";
                         }
                 }   ?>
                    </table>
                 <?php
                 } //end $rc>1
                
                else if ($rc == 1) {
                //header( 'Location: MemberLookupByID.php?memid=' .$mid);
                //$seclvl = $_SESSION['membertype'];
                if (isset($_SESSION['logon']) && ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55)) {

                    if ($memid != "") { ?>
                        </div>
                        <div class='col-sm-12'>
                        <h3>Detailed Record of <?php echo $row[FirstName] . '  ' . $row[LastName]; ?></h3>
                        <table border=1 class='table table-striped'>
                        <tr><th>ClassID</th><th>ClassRegID</th><th>Grade</th><th>Class</th><th>Classroom</th><th>Year</th><th>Term</th><th>Current<br>Class</th><th>Tuition</th></tr>
                    <?php
           
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
                    }?>
                       </table>
                  </div>
                       <?php }
                    }    //End $rc=1
                    else {  //No record found
                        if ($memid == "") {
                            echo "<h3 class='text-center'>Member not exist</h3><p class='red-color text-center'>Member ID does not exist, <a href=\"MemberLookupByIDForm.php\">search again ...</a>";
                            exit;
                        }
                    }
                    mysqli_close($conn);
                    ?>
                    </table>
        
      <div class='container'> 
            <a href="MemberLookupByID.php?
            <?php if ($familyID != '') { ?>
                  fid=<?php echo $familyID; ?>">Current Family ID=<?php echo $familyID; ?> 
            <?php } else if ($memberID != '') { ?> 
                  memid=<?php echo $memberID; ?>">Details of Member ID='<?php echo $memberID; ?>' 
            <?php } ?></a> || &nbsp;&nbsp;<a href="MemberLookupByIDForm.php">Lookup By ID</a>&nbsp;
                         ||&nbsp;<a href='MemberLookupForm.php'>Look up By Name</a>
      </div>
          <br/>
         </div>
    </div>
<?php include("../common/site-footer1.php"); ?>
