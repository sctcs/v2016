<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();


include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

$DEBUG = 0;


$membertypeid = $_POST[MemberTypeID];
$PCYear = $_POST[PCYear]; // value=primary
$ParentPC = $_POST[ParentPC]; // value=primary
$ParentSP = $_POST[ParentSP]; // value=both
//$Students=$_POST[Students]; // value=student
$Teachers = $_POST[Teachers]; // value=teachers


$Principal = $_POST[Principal];


$Admins = $_POST[Admins];     // value=admins
$NewMembers = $_POST[NewMembers];     // value=newmembers
$Subject = $_POST[Subject];
$Message = $_POST[Message];
$Preview = $_POST[Preview];
$Send = $_POST[Send];
$From = $_POST[From];
$CC = $_POST[cc];
$BCC = $_POST[bcc];
$batchno = $_POST[batchno];
?>
<!DOCTYPE html>
<html>

    <head>
        <title>Send Email</title>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <link href="../common/ynhc.css" rel="stylesheet" type="text/css">
        <script language="javascript" src="../common/JS/MainValidate.js"></script>

        <script>
            function goBack() {
                window.history.back()
            }
        </script>
    </head>
    <?php
    echo "<a href=\"MemberAccountMain.php\">My Account</a>";
    if (isset($Preview) || $DEBUG) {
        echo $membertypeid . "<br>";
        echo $From . "<br>";

        echo $ParentPC . "<br>";
        echo $ParentSP . "<br>";
//echo $Students."<br>";
        echo $Teachers . "<br>";

        echo $Principal."<br>";

        echo $NewMembers . "<br>";
        echo $Alumni . "<br>";
        echo $Subject . "<br>";
        echo $Message . "<br>";
        echo $Preview;
        echo "<br/>";
        echo $Send . "<br>";
        echo "<br>";
    }

    $SQLstring = "";
    if ($ParentPC == "primary" || $ParentSP == "both") {
        $SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
WHERE Email is not null and ReceiveSchoolEmail='Y' ";
        $SQLstring .= " and tblMember.FamilyID  in (select a.FamilyID from tblMember a, tblClassRegistration b ,tblClass c
                  where a.MemberID=b.StudentMemberID and b.ClassID=c.ClassID ";
        if ($PCYear == "C-year") {
            $SQLstring .= "and c.CurrentClass='Yes' and b.Status='OK' )";
        } else if ($PCYear == "L-year") {
            $SQLstring .= "and c.CurrentClass!='Yes' and b.Status in ('Taken','OK') and ((c.Year='" . $LastYear . "' and c.Term='Fall') or (c.Year='" . $CurrentYear . "' and c.Term='Spring') )  )";
        } else if ($PCYear == "2-year") {
            $SQLstring .= "and c.CurrentClass!='Yes' and b.Status in ('Taken','OK') and ((c.Year='" . $LastYear2 . "' and c.Term='Fall') or (c.Year='" . $LastYear . "' and c.Term='Spring') )  )";
        } else if ($PCYear == "3-year") {
            $SQLstring .= "and c.CurrentClass!='Yes' and b.Status in ('Taken','OK') and ((c.Year='" . $LastYear3 . "' and c.Term='Fall') or (c.Year='" . $LastYear2 . "' and c.Term='Spring') )  )";
        }

        if ($ParentPC == "primary" && $ParentSP != "both") {
            $SQLstring .=" and tblMember.PrimaryContact='Yes' ";
        }
    }

    if ($SQLstring != "") {
        if (isset($Preview)) {
            echo "Parents: <br>";
        }
        if ($DEBUG) {
            echo $SQLstring;
        }
        echo "<br>";
        $RS1 = mysqli_query($conn, $SQLstring);
        while ($row = mysqli_fetch_array($RS1)) {
            $emails[$row[Email]] = 1;
            if (isset($Preview)) {
                echo $row[Email];
                echo "<br>";
            }
        }
    }

    echo "<br>";
    if (isset($NewMembers)) {
        $SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
 WHERE Email is not null and ReceiveSchoolEmail='Y' and MostRecentUpdateDate >= '" . $CurrentYear . "-05-01'";
        if (isset($Preview)) {
            echo "New Members: <br>";
        }
        if ($DEBUG) {
            echo $SQLstring;
        }
        echo "<br>";
        $RS1 = mysqli_query($conn, $SQLstring);
        while ($row = mysqli_fetch_array($RS1)) {
            $emails[$row[Email]] = 1;
            if (isset($Preview)) {
                echo $row[Email];
                echo "<br>";
            }
        }
    }


    echo "<br>";

    if ($Teachers == "teachers") {
        $SQLstring = "SELECT FirstName,LastName,HomePhone,Email 
 FROM tblMember
 WHERE Email is not null and ReceiveSchoolEmail='Y' ";
        $SQLstring .= " and tblMember.MemberID in (select distinct MemberID from tblTeacher where CurrentTeacher='Yes')";

        if (isset($Preview)) {
            echo "<br><br>Teachers:<br>";
        }
        if ($DEBUG) {
            echo $SQLstring;
        }
        echo "<br>";
        $RS1 = mysqli_query($conn, $SQLstring);
        while ($row = mysqli_fetch_array($RS1)) {
            $emails[$row[Email]] = 1;
            if (isset($Preview)) {
                echo $row[Email];
                echo "<br>";
            }
        }
    }

    if ($Principal == "principal") {
    $emails["principal@ynhchineseschool.org"]=1;
    }

//    if ($CC == 1) {
//        $emails[$CC] = 1;
//    }
//
//    if ($BCC == 1) {
//        $emails[$BCC] = 1;
//    }

    if ($Admins == "admins") {
        $emails["adminteam@ynhchineseschool.org"] = 1;

        if (isset($Preview)) {
            echo "<br><br>Admins:<br>";
            echo "adminteam@ynhchineseschool.org";
            echo "<br>";
        }
    }

    if (isset($emails)) {
        ksort($emails);
            if (!isset($batchno) || ($batchno != 'y' &&  $batchno == 0) ) { $batchno=1;}
            if ($batchno == 'y') {
                $range_start = 0;
                $range_end   = 100000;
            } else {
                $range_start = (($batchno - 1)*200 + 1);
                $range_end   = (($batchno - 1)*200 + 200);
            }
        echo "<br><b>Final List:</b><br> ";
        if (isset($Preview)) {
            $count=0; $ecount=0; 
            foreach (array_keys($emails) as $email) 
            {
                $count++;
               if ($batchno != 'y' && $count >= $range_start && $count <= $range_end && strpos($email, 'yahoo') == false)
               {
                $ecount++;
                echo $count .", $ecount, " . $email;
                echo "<br>";
               } else if ($batchno == 'y' && strpos($email, 'yahoo') != false ) {
                $ecount++;
                echo $count .", " . $ecount . ", " . $email;
                echo "<br>";
               }
            }
        }
    } else {
        echo "No email address found";
        echo "<br>";
        echo "<br>";
    }


    if (isset($Send) && isset($emails)) {
        echo "Sending ......<br>";
       
            $count=0; $ecount=0;
        foreach (array_keys($emails) as $email) 
        {
          $count++;
          if (($batchno != 'y' && $count >= $range_start && $count <= $range_end &&strpos($email, 'yahoo') == false) || 
              ($batchno == 'y' && strpos($email, 'yahoo') != false ) )
          {
            $ecount++;
            echo  "<br>$count, $ecount, $email";
            $to = $email;
            $headers = 'From: ' . $_SESSION['firstname'] . ' ' . $_SESSION['lastname'] . '<' . strip_tags($From) . ">\r\n" .
                    'Reply-To: ' . strip_tags($From) . "\r\n";
                    'Return-Path: ' . strip_tags($From) . "\r\n";
            if (isset($CC) && $CC != "") {$headers .="Cc: $CC\r\n" ; }
            if(isset($BCC) && $BCC != "") {$headers .="Bcc: $BCC\r\n" ;}
//            $headers .= "CC: ".strip_tags($CC)."\r\n BCC: ".strip_tags($BCC)."\r\n";
            $headers .= "MIME-Version:1.0\r\n";
            $headers .= "Content-Type:text/html; charset=UTF-8". "\r\n";
            $headers .= 'X-Mailer: PHP/' . phpversion();

            $success = mail($to, $Subject, $Message, $headers);
            if ($success) {
               echo ", sent!";
            } else {
               echo ", failed.";
            }

            if ($batchno == 'y') { sleep(1); }
          }
        }
        echo "<br>Done.<br>";
    } else {
        if (isset($Preview)) {
            ?>
            <button onclick="goBack()">Go Back & Edit</button>
            <?php
        }
    }

    mysqli_close($conn);
    ?>
</body>
</html>
