<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
//echo "not logon yet";
if (!isset($_SESSION['logon'])) {
    header('Location: MemberLoginForm.php?error=3');
    exit();
}
//echo "role not set";
if (!isset($_SESSION['membertype'])) {
    header('Location: MemberLoginForm.php?error=4');
    exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//echo "see family_id: ".$_SESSION['family_id'];
//echo "see logon: ".$_SESSION['logon'];
//echo "see useremail: ".$_SESSION['useremail'];
//echo "see MemberTypes: ".$_SESSION['MemberTypes'];
//echo $_SESSION['memberid'];
//echo "::";
//echo $_SESSION[memberid];
?>

<header>
    <?php include("../common/site-header1.php"); ?>
</header>

<div class="container">
    <div id="memberFunctionWrapper">
        <?php
        if (isset($_SESSION['logon'])) {
            $seclvl = $_SESSION['membertype'];
            $secdesc = $_SESSION['MemberTypes'][$seclvl];
            echo "<p class='alert alert-success text-center'>You are now logged in as <span style='color: red;'>" . $secdesc . "</span></span>. ";
            if (count($_SESSION['MemberTypes']) > 1) {
                echo " If you want to change to another role, click <a href=\"chooseRole.php\">here</a></p>";
            }        
                
         }
        ?>
        <p class="text-center lead" style="color: white; font-weight: 500;">Allowed Functions</p>

        <!--<br /><a href="http://sites.google.com/site/ynhchineseschool/">Students Reward Token Redeem (??Ʒ?һ?)</a> -->

        <?php if ($seclvl == 10 || $seclvl == 15 || $seclvl == 20 || $seclvl == 40 || $seclvl == 55) { ?>
            <div class="col-md-12"> 
                <br><p class="text-center lead"><b><a href="../MemberAccount/MemberLookupForm.php">Member Lookup</a></b></p>
            </div>               
        <?php } ?>
        <!-- MemberType and SecurityLevel --
        Principal               10 
        Board Chairman          11 
        PTA President           12  
        Provost                 15 
        Database Administrator  20
        Student Point Manager   21 
        Teacher                 25 
        Student                 30
        Board Member            35 
        School Administrator    40 
        Treasurer               45 
        Collector               55
        Parent                  50 
        Volunteer               60
        Former Student          65 
        Former Member           70 
        New Member              75
        ------------------------------------>

        <?php if ($seclvl == 45 || $seclvl == 55) { ?>
            <div class="col-md-12 accessFrame"><!--Payment Management-->
                <h2 class="text-center">Accounting</h2>
                <p class="text-center"><a href="../accounting/index.php">Payment Management</a>
                    <br /><a href="FeePaymentVoucher_byadmin.php?fid=2" target=_blank>Print Payment Voucher of a Family</a>
                    <br /><a href="../Registration/Registration_and_Refund_Policies.php" target="_blank">Registration and Refund Policies</a>
                    <br /><a href="../classes/listallstudents.php?type=reg">Registered Students</a>
                    <!--<br /><a href="../Finance/FinanceFileListDetail.php">Finance Files</a>-->
                </p>
            </div>
        <?php } ?>

        <?php if ($seclvl == 50) { ?>
            <div class="col-md-12 accessFrame"> <!--parent-->
                <h2 class="text-center">Parents Access</h2>
                <p class="text-center"><a href="MyProfile.php?whose=spouse">Spouse Profile</a>
                    <br><a href="FamilyChildList.php">Student List or Add a Student</a>
                    <br /><a href="EmergencyContactParentEdit.php">Emergency Contact Information</a>
                    <br /><a href="../public/SCCS_safety_rules.pdf">Parent Agreement</a>
                </p>
                <?php
                $sql01 = "SELECT count(*) rcount FROM tblClassRegistration, tblMember,tblClass WHERE 		tblClassRegistration.StudentMemberID=tblMember.MemberID and tblMember.FamilyID=" . $_SESSION['family_id'] . " and tblClassRegistration.ClassID=tblClass.ClassID and tblClass.Year='" . $CurrentYear . "' and 		tblClass.Term='" . $CurrentTerm . "'";
                $rs01 = mysqli_query($conn, $sql01);
                $rw01 = mysqli_fetch_array($rs01);
                ?>

                <p class="text-center"><a href="../Registration/Registration_and_Refund_Policies.php" target="_blank">Registration and Refund Policies</a>
                    <br /><a href="../Directory/Classes.php">Course Catalog or Class List</a>
                    <br /><a href="../Directory/detail_desc_on_courses.php" target=_blank>Course Description and Teacher's Background</a>
                    <br /><a href="OpenSeats.php" target=_blank>Class Opening/Available Seats</a>
                    <!--<br /><a href="../Curriculum/CourseDescription.htm" >Course Description</a>-->
                    <br /><a href="FamilyChildList.php">Register/Update/Drop Classes</a>
                </p>       
                <?php
                if ($CurrentTerm == 'Fall') {
                    if ($rw01[rcount] > 0) {
                        // echo " (<font color=red>Registered</font>)";
                    } else {
                        // echo " (<font color=red>Not Registered</font>)";
                    }
                }
                ?>

                <p class="text-center"><a href="FeePaymentVoucher.php" target=_blank>Print Payment Voucher</a>
                    <br /><a href="../accounting/familyAccountSummary.php#balance">Billing and Payment History</a>
                    <!--
                    <br /><a href="../classes/TeachingMaterialsListDetail.php">Teaching Material List</a>
                    -->
                    <br /><a href="../classes/HomeworkList.php">Homework</a>
                    <!-- <br /><a href="ViewSafetyPatrol.php">My Safety Patrol Schedule</a>-->
                </p>
            <?php } ?>  <!--Parent-->

            <?php if ($seclvl == 60) { ?>  <!--Volunteer-->
                <p class="text-center"><a href="../volunteering/index.php">Volunteer Management</a>

                <?php } ?><!--closing volunteer-->

                <?php if ($seclvl == 30) { ?>  <!--student-->
                <p class="text-center"><a href="../classes/HomeworkList.php">Homework</a></p>
            </div>  <!--End parent/volunteer-->
        <?php } ?>
            
        <?php if ($seclvl == 10 || $seclvl == 15 || $seclvl == 20) { ?>
            <div class="col-md-12 accessFrame"><!-- principal, provost, dba-->
                <h3 class="text-center">Management</h3>
                <p class="text-center"><a href="../classes/index.php">Class Management</a>
                    <br /><a href="../classes/TeacherList.php">Teacher Table Management</a>
                    <br /><a href="../classes/ClassList.php">Class Table Management</a></p>
            </div>

        <?php } if ($seclvl == 20) { ?> <!--DBA-->
            <div class="col-md-12 accessFrame"><h3 class="text-center">Database Administrator</h3>
                <p class="text-center"><a href="assignMemberRoles.php">Assign Member Roles</a>
                    <br /><a href="../accounting/index.php">Payment Management</a>
                    <br /><a href="ManageSafetyPatrol.php" target="_blank">Manage Safety Patrol Schedule</a></p>
            </div>
        <?php } ?>

        <?php if ($seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 55) { ?> 
            <div class="col-md-12 accessFrame"><!--Management-->
                <h3 class="text-center">Classes and Files</h3>
                <?php if ($seclvl <= 25 || $seclvl == 40 || $seclvl == 55) { ?>
                    <p class="text-center"><a href="../Files/Documents/Payment_Request.pdf" target="_blank">Payment Request Form</a>
                    <?php } ?>
                    <?php if ($seclvl < 25 || $seclvl == 55 || $seclvl == 40 || $seclvl == 12) { ?>

                    <p class="text-center"><a href="MemberEmailListForm.php">Get Member Emails</a>
                        <br><a href="../classes/listallstudents_by_term.php?type=reg&term=fall">Fall Student-Class List</a>
                        <br /><a href="../classes/listallstudents_by_term.php?type=reg&term=spring">Spring Student-Class List</a>
                        <br /><a href="../Directory/Classes.php">Course Catalog</a>
                        <br /><a href="OpenSeats.php" >View Class Opening/Available Seats</a>

                        <br /><a href="SchoolLeadershipDocument.php">School Policies and Documents for Leaders</a>
                        <br /><a href="../MemberAccount/TeacherDocument.php">Teacher Manual</a>
                        <br /><a href="../Activity/ActivityList.php">Manage School Activity</a>
                        <br /><a href="../classes/HomeworkList.php">Homework</a></p>

                <?php } ?>

                <?php if ($seclvl <= 20 || $seclvl == 35 || $seclvl == 40) { ?>
                    <p class="text-center"><a href="../Files/filesList4Dir.php?directory=Logo">Logo Files</a></p>
                <?php } ?>

                <?php if ($seclvl == 10 || $seclvl == 11 || $seclvl == 20) { ?>
                    <p class="text-center"><a href="../public/announceForm.php">Make an Announcement</a></p>
                <?php } ?>
            </div>
        <?php } ?>

        <!--Teacher Access-->
        <?php if ($seclvl == 25) { ?> <!--Teacher-->
            <div class="col-md-12  accessFrame">
                <h3 class="text-center">Teacher Access</h3>
                <p class="text-center"><a href="../classes/HomeworkList.php">Homework</a>
                    <br /><a href="MyClasses_frame.php">My Class(es)</a>
                    <br /><a href="../Directory/Classes.php">Course Catalog</a>
                    <br /><a href="OpenSeats.php" >View Class Opening/Available Seats</a>
                    <br /><a href="../MemberAccount/TeacherDocument.php">Teacher Manual</a>
                </p>
            </div><!--Teacher-->
        <?php } ?>

        <?php if ($seclvl > 0) { ?> 
            <div class="col-md-12 accessFrame">
                <h3 class="text-center">General Access</h3>
                <?php if ($seclvl == 30) { ?>
                    <p class="text-center"><a href="studentProfile.php?stuid=<?php echo $_SESSION['memberid']; ?>">My Profile</a></p>

                <?php } else { ?>
                    <p class="text-center"><a href="MyProfile.php">My Profile</a></p>

                <?php } if ($seclvl > 0) { ?>
                    <p class="text-center"><a href="../Curriculum/Curriculum.php">Curriculum</a></p>
                <?php } if ($_SESSION['logon'] != '') { ?>
                    <!-- <br /><a href="../accounting/payment_notice.php">Payment Reminder</a> -->

                    <p class="text-center"><a href="../Activity/ActivityListForMember.php">Register Activity</a>
                        <br><a href="SchoolPolicyDocument.php">School Policies and Programs</a>
                        <br><a href="EventCalendar.php">School Event Calendar</a>
                        <br><a href="../Activity/Election/2016/SCCSElectionMay2016.php">SCCS Election May 2016</a>
                        <br><a href="../Activity/Election/2016/SCCSElectionSep2016.php">Election of Board Director September 2016</a>
                    </p>
                    <br>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
</div>
<div class="clearfix">&nbsp;</div>
<?php include("../common/site-footer1.php"); ?>

<?php mysqli_close($conn); ?>
