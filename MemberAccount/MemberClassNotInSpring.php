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
        <meta charset="GBK"/>
        <meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School"/>

        <title>Classes Registered for Fall Not In Spring</title>
        <link href="../../common/ynhc_addon.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header>
            <?php include("../common/site-header1.php"); ?>
        </header>

        <?php
        $SQLAllRegMembers = "SELECT r.StudentMemberID as MemberID,r.Status as Status, c.GradeOrSubject as GradeOrSubject, c.ClassID as ClassID,"
                . "c.IsLanguage as IsLanguage,r.Year as Year, "
                . "m.LastName as LastName, m.FirstName as FirstName, m.Email as Email, m.FamilyID as FamilyID, r.Status as Status, c.CurrentClass as CurrentClass "
                . "from tblClass c, tblClassRegistration r, tblMember m "
                . "where r.ClassID=c.ClassID and r.StudentMemberID = m.MemberID ";


        $SQLCanceledClass2017 = "SELECT ClassID, GradeOrSubject from tblClass WHERE Year='2017' and Term='Spring' and CurrentClass='No'";

        // members registered for fall 2016
        $SQLFall = $SQLAllRegMembers . " AND c.Year='2016' and c.Term= 'Fall' and r.Status<>'Dropped'";
        //   echo " see fall " . $SQLFall;

        $RSFall = mysqli_query($conn, $SQLFall);

        $fallStudents = array();
        while ($rowFall = mysqli_fetch_array($RSFall)) {
            $fallStudents[] = $rowFall;
        }

        //members regitered for Spring 2017
        $SQLSpring = $SQLAllRegMembers . " AND c.Year='2017' and c.Term='Spring'";
        //   echo "see ".$SQLSpring;

        $RSSpring = mysqli_query($conn, $SQLSpring);
        $ctSpring = 0;
        $springStudents = [];
        while ($rowSpring = mysqli_fetch_array($RSSpring)) {
            $springStudents[] = $rowSpring;
        }

        $RSCanceledClass2017 = mysqli_query($conn, $SQLCanceledClass2017);
        $springCaneledClass = [];
        while ($rowSpring = mysqli_fetch_array($RSCanceledClass2017)) {
            $springCaneledClass[] = $rowSpring;
        }

        //  echo "<pre>";
//        var_dump($springStudents);
        //  print_r($fallStudents);
        //     print_r($spring2017Class);
        //     echo "</pre>";
        ?>
        <div class="container">
            <h3>Members registered for Fall not in Spring</h3>  

            <?php
            if (isset($_SESSION['logon']) && ( $seclvl <= 25 || $seclvl == 35 || $seclvl == 40 || $seclvl == 45 || $seclvl == 55)) {

                $fallGroup = [];
                $springGroup = [];

                $classInBoth = [];  //Members registered for same classes in both fall and spring 
                $notReg4Spring = [];

                foreach ($fallStudents as $item1) {      //Group member and classes by MemberID
                    $fallGroup[$item1['MemberID']][] = $item1;
                }
                foreach ($springStudents as $item2) {
                    $springGroup[$item2['MemberID']][] = $item2;
                }

                //               echo "<pre>";
            //    var_dump($fallGroupStudents);
//                echo "</pre>";

                $ct = 0;
                $ctSame = 0;
                $ctNotReg = 0;
                $ctMIDNotInFall = 0;

                foreach ($fallGroup as $k1 => $v1) {
                    // echo "  k1  ".$k1."<br>";
                    $midInFnSpring = false;         //MemberID in both Fall 2016 and Spring 2017
                    foreach ($springGroup as $k2 => $v2) {
                        if ($k1 === $k2) {    //MemberID in Fall found in Spring
                            $midInFnSpring = true;
                            foreach ($v1 as $item1) {
                                $classExists = false;
                                foreach ($v2 as $item2) {
                                    if ($item1['GradeOrSubject'] === $item2['GradeOrSubject'] && $item1['MemberID'] === $item2['MemberID']) {
                                        //  $ctSame += 1;
                                        //   $classInBoth[$ctSame] = $items;
                                        $classExists = true;
                                        //     echo " -----found" . $item1['GradeOrSubject'] . 'for SID   ' . $item1['StudentMemberID'] . '   ' . $item1['FirstName'] . ',' . $item1['LastName'] . '<br>';
                                    }
                                }
                                if ($classExists === false) {
//                                    $row["LastName"] = $item1['LastName'];
//                                    $row["FirstName"] = $item1['FirstName'];
//                                    $row["MemberID"] = $item1['MemberID'];
//                                    $row["FamilyID"] = $items1["FamilyID"];
//                                    $row["GradeOrSubject"] = $item1['GradeOrSubject'];
//                                    $row["Email"] = $item1['Email'];
                                    $notReg4Spring[] = $item1;   //include canceled class 
                                    //      echo " Not found ".$ctNotReg."  " . $item1['GradeOrSubject'] . 'for SID   ' . $item1['StudentMemberID'] . '   ' . $item1['FirstName'] . ',' . $item1['LastName'] . '<br>';
                                    // $ctNotReg += 1;
                                }
                            }
                        }
                    }
                }

                foreach ($springCaneledClass as $key => $value) {
                    if (empty($value)) {
                        unset($springCaneledClass[$key]);
                    }
                }

                if (empty($springCaneledClass)) {
                    
                } else {
                    foreach ($springCaneledClass as $k1 => $v1) {
                        foreach ($notReg4Spring as $k => $v) {    //remove Members not registered due to class being canceled 
                            if ($v1['GradeOrSubject'] === $v['GradeOrSubject']) { //current class in 2017
                                unset($notReg4Spring[$k]);
                            }
                        }
                    }
                }

//
//                echo "<pre>";
//                var_dump($notReg4Spring);
//                var_dump($classInBoth);
//                echo "</pre>";
//                
//==================================Compose Email Message=======================================

                foreach ($notReg4Spring as $k4 => $v4) {
                    echo "<br><b>Date: ".date('Y/m/d')."</b><br>";
                    $message = "<p> Dear " . $v4['FirstName'] . ", " . $v4['LastName'] . "</p><p> " . "  MemberID: '" . $v4['MemberID'] . "',  FamilyID: '" . $v4['FamilyID'] . "'</p>";
                    $message.= "<p>Our system shows that your did not register for the same class  '" . $v4['GradeOrSubject'] . "' that you have registered for the Fall semester.</p>";
                    $message.= "<p> If you are still interested in taking the class '" . $v4['GradeOrSubject'] . "' for the Spring, please email us at " . "<a href='mailto:support@ynhchineseschool.org'>IT Support</a>" . "</p>";
                    $message.="<p>If you already received the message, please disgard it.</p><p>Thank you so much for your continued support to our Chinese School!</p>";
                    $message.="<p>-----------------------------------</p>";
                    $message.="<p><a href='mailto:support@ynhchineseschool.org'>IT Support</a></p>";
                    $message.="<p>Southern Connecticut Chinese School</p>";
                    
                    $to = "<a href='mailto:$v4[Email]'>" . $v4['Email'] . "</a>";
                    $subject = "Regarding memberID '" . $v4['MemberID'] . "' registered for the fall, did not register the same class in Spring: " . $v4['GradeOrSubject'];
                    $from = "<a href='mailto:registration@ynhhineseschool.org'>registration@ynhchineseschool.org</a>";
                    $headers = "From: $from\r\n" . "Bcc: $bcc\r\n";

                    echo "<br>From: " . $from . "<br>";
                    echo "To: " . $to . "<br>";
                    echo "Subject: " . $subject . "<br>";
                    echo "<p>" . $message . "</p>";
                    mail($to, $subject, $message, $headers);
                }
            }
            ?>
            <p></p>
        </div>
        <?php include("../common/site-footer1.php"); ?>
    </body>
</html>
