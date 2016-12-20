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
?>
<?php
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School"/>

        <title>School Leadership Document</title>
        <link href="../../common/ynhc_addon.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header>
            <?php include("../common/site-header1.php"); ?>
        </header>

        <?php
        $SQLAllRegMembers = "SELECT r.StudentMemberID as MemberID, c.GradeOrSubject as GradeOrSubject,"
                . "c.IsLanguage as IsLanguage, "
                . "m.LastName as LastName, m.FirstName as FirstName, m.Email as Email, m.FamilyID as FamilyID "
                . "from tblClass c, tblClassRegistration r, tblMember m "
                . "where r.ClassID=c.ClassID and r.StudentMemberID = m.MemberID and r.Status <> 'Dropped' "
        ;

        //echo "see reg members".$SQLAllRegMembers."<br>";
        // All members who registered for fall 2016
        $SQLFall = $SQLAllRegMembers . " AND c.Year=$CurrentYear and c.Term= 'Fall'";
        // echo " see fall " . $SQLFall;

        $RSFall = mysqli_query($conn, $SQLFall);

        $ct = 0;
        $fallStudents = array();
        while ($row = mysqli_fetch_array($RSFall)) {
            $ct = $ct + 1;
            $fallStudents[] = $row;
        }

//            
        //All members regitered for Spring 
        $SQLSpring = $SQLAllRegMembers . " AND c.Year=$NextYear and c.Term='Spring'";
        // echo "see ".$SQLSpring;

        $RSSpring = mysqli_query($conn, $SQLSpring);
        $ct1 = 0;
        $springStudents = [];
        while ($currentRow = mysqli_fetch_array($RSSpring)) {
            $springStudents[] = $currentRow;
            $ct1 = $ct1 + 1;
        }
        //        echo "<pre>";
        //     print_r($springStudents);
//        print_r($fallStudents);
//        echo "</pre>";
        ?>
        <div class="container">
            <h3>Members registered for Fall not in Spring</h3>  

            <?php
            if (isset($_SESSION['logon']) && ( $seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 45 || $seclvl == 55)) {
                $midExists = false;
                $gradeOrSubjectExits = false;
                $fallGroup = [];
                $springGroup = [];
                $classNotInSpringAll = []; //Store the difference(including null values and 0 arrays) of a member registered for fall class and spring class
                $classNotInSpring = [];  //Only store values that has content
                $midNotInSpring = [];  //Member ID did not appear in Spring registration
                $classInBoth = [];  //Members registered for same classes in both fall and spring 

                $ctSame = 0;
                $ctDif = 0;
                $ctNone = 0;

                foreach ($fallStudents as $item1) {      //Group member info by MemberID
                    $fallGroup[$item1['MemberID']][] = $item1;
                }

                foreach ($springStudents as $item2) {
                    $springGroup[$item2['MemberID']][] = $item2;
                }

                foreach ($fallGroup as $k1 => $v1) {
                    if (array_key_exists($k1, $springGroup)) {
                        $classNotInSpringAll[] = array_diff_assoc($v1, $springGroup[$k1]);
                        $classInBoth[] = array_intersect_assoc($v1, $springGroup[$k1]);
                    } else {
//                    echo "this member ID does not exist in Spring  " . $k1;
                        $midNotInSpring[] = $v1;
                    }
                }

                foreach ($classNotInSpringAll as $item) {
                    if (is_array($item) && count($item) <> 0) {
                        $classNotInSpring[] = $item;
                    }
                }

//          echo "<pre>";
//            var_dump($classNotInSpring);
//           var_dump($classNotInSpringAll);
//            echo "</pre>";
//            echo "============Member ID NOT EXIST IN Spring===============";
//            var_dump($midNotInSpring);


                foreach ($classNotInSpring as $k3 => $v3) {
                    if (is_array($v3)) {
                        foreach ($v3 as $v4) {
                            $message = "<p>" . "Attention:  MemberID: " . $v4['MemberID'] . ", " . " FamilyID: " . $v4['FamilyID'] . "</p>";
                            $message .= "<p> Dear " . $v4['FirstName'] . "  " . $v4['LastName'] . ", </p>";
                            $message.= "<p>Our system shows that you should be registering for the same class  '" . $v4['GradeOrSubject'] . "' that you have registered for the Fall semester.</p>";
                            $message.= "<p> If you are still interested in taking the class '" . $v4['GradeOrSubject'] . "' in Spring semester, please email " . "<a href='mailto:support@ynhchineseschool.org'>IT Support</a>" . "</p>";
                            $message.="<p>Thank you very much for your suppport!</p>";
                            $message.="<p>=======================</p>";
                            $message.="<p>Best Regards,</p>";;
                            $message.="<p>Southern Connecticut Chinese School Administration</p>";
                            $message.="<p><a href='mailto:support@ynhchineseschool.org'>support@ynhchineseschool.org</a></p>";

                            $to = "<a href='mailto:$v4[Email]'>" . $v4['Email'] . "</a>";
                            $subject = "Spring registration: " . $v4['GradeOrSubject'];
                            $from = "<a href='mailto:registration@ynhchineseschool.org'>registration@ynhchineseschool.org</a>";
                            $headers = "From: $from\r\n" . "Bcc: $bcc\r\n";

                            $headers = "From: $from\r\n" .
                                    'Reply-To: support@ynhchineseschool.org' . "\r\n" .
                                    'X-Mailer: PHP/' . phpversion();

                            echo "<br>From: " . $from . "<br>";
                            echo "To: " . $to . "<br>";
                            echo "Subject: " . $subject . "<br>";
                            echo "<p>" . $message . "</p>";
                            if ($_SERVER["SERVER_NAME"] != "localhost") {
                                mail($to, $subject, $message, $headers);
                            } else {
                                
                            }
                        }
                    }
                }
            }
            ?>

        </div>
        <?php include("../common/site-footer1.php"); ?>
    </body>
</html>
