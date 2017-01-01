<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();

$seclvl = $_SESSION['membertype'];
$mid = $_GET['mid'];
$who = $_GET['whose'];
$family_id = $_SESSION['family_id'];
$membid = $_SESSION['memberid'];
//echo 'seclvl=' . $seclvl . " mid=" . $mid . ",who=" . $who . ",family_id=" . $family_id;

if ($seclvl != 50 && $seclvl != 20 && $seclvl != 40) {
    echo "Access denied";
    header('Location Logof.php');
    exit();
}
if ($seclvl == 50) {
    if ($_GET[whose] == "student") {
        header('Location: studentProfile.php?stuid=' . $_GET[stuid]);
    }

    if (isset($_SESSION['family_id'])) {
        
    } else {
        header('Location: Logoff.php');
        exit();
    }
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

if ($seclvl == 50 || $seclv == 5) {
    if ($_GET[whose] == "spouse") {
        $SQLstring = "SELECT count(*) as cnt FROM `tblMember`,tblLogin WHERE tblMember.MemberID=tblLogin.MemberID and FamilyID=" . $_SESSION['family_id'] . " and MemberTypeID=15 and tblLogin.MemberID != " . $_SESSION['memberid'];
        $RS1 = mysqli_query($conn, $SQLstring);
        $RSA1 = mysqli_fetch_array($RS1);
        if ($RSA1[cnt] <= 0) {
            header('Location: NewProfile.php?newmembertype=spouse');
        }
    }
}
?>

<!--<html xmlns="http://www.w3.org/1999/xhtml">-->
<!DOCTYPE html>
<head>
    <title>Member Profile</title>
    <meta http-equiv="Content-type" content="text/html; charset=GBK">
    <meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Southern Connecticut Chinese School, Chinese School">
    <link href="../common/ynhc_addoncss.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="../common/JS/MainValidate.js"></script>
    <script>
        function SSAutoTab(input, Gnext, len, e)
        {
            if (input.value.length >= len)
            {
                if (eval("document.all." + Gnext))
                {
                    eval("document.all." + Gnext).focus();
                }
            }
        }


        function displayme(which)
        {
            if (which == 'NewStudentLine')
            {
                document.all('NewStudentLine').style.display = "";
                document.all('ReturnStudentLine').style.display = "none";
                //document.all('returingcusotmer').style.display = "none";
                //alert("OK1");
            }
            else if (which == 'ReturnStudentLine')
            {
                document.all('ReturnStudentLine').style.display = "";
                document.all.NewStudentLine.style.display = "none";

            }
            else if (which == 'ArtClassSelect')
            {
                if (document.all.ArtChoose[0].checked == true)
                {
                    document.all('ArtClassSelect').style.display = "";
                }
                else if (document.all.ArtChoose[1].checked == true)
                {
                    document.all('ArtClassSelect').style.display = "none";
                }

            }
            else if (which == 'VolunteerLine')
            {
                if (document.all.volunteer.value == 4)
                {
                    document.all('VolunteerLine').style.display = "";
                }
                else
                {
                    document.all.VolunteerLine.style.display = "none";
                }
            }
        }

    </script>
</head>
<body>
    <header><?php include("../common/site-header1.php"); ?></header>


    <?php
    if ($seclvl == 20 || $seclvl == 40) {
        $SQLstring = "select MB.*  from tblMember MB where MB.MemberID =" . $mid . " AND MB.PrimaryContact='Yes'";
    } else if ($seclvl == 50 || $seclvl == 5) {
//$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND  MB.FamilyID=".$_SESSION['family_id'];
        if ($_GET[whose] == "spouse") {
            //$SQLstring = "select MB.*   from tblMember MB where MB.MemberID !=".$_SESSION['memberid']. " and FamilyID=".$_SESSION['family_id'];;
            $SQLstring = "SELECT * FROM `tblMember`,tblLogin WHERE tblMember.MemberID=tblLogin.MemberID and FamilyID=" . $_SESSION['family_id'] . " and MemberTypeID=15 and tblLogin.MemberID != " . $_SESSION['memberid'];
        } else if ($_GET[whose] == "student") {
            $SQLstring = "select *   from tblMember left join tblEthnicity  on tblMember.Ethnicity=tblEthnicity.Ethnicity where tblMember.MemberID=" . $_GET['stuid'];

            // primary contact parent
            $SQLparent = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND MB.PrimaryContact='Yes' AND MB.FamilyID=" . $_SESSION['family_id'] . " LIMIT 1";
            $RSp = mysqli_query($conn, $SQLparent);
            $RSAp = mysqli_fetch_array($RSp);
        } else {
            $SQLstring = "select MB.*   from tblMember MB where MB.MemberID=" . $_SESSION['memberid'];
        }
    }

//$SQLstring = "select *  from tblMember where PrimaryContact='Yes' and FamilyID=".$_SESSION['family_id'];
//echo "see111: ".$SQLstring;
    $RS1 = mysqli_query($conn, $SQLstring);
    $RSA1 = mysqli_fetch_array($RS1);
//$family_id=$RSA1[family_id];
//$MemberType=$RSA1[MemberType];
//echo "<br>see: ".$RSA1[HomePhone];

    $PhoneArrary = explode("-", $RSA1[HomePhone]);
//$x=$PhoneArrary[0];
//echo "<br>see22: ".$PhoneArrary[0];
    $CPhoneArrary = explode("-", $RSA1[CellPhone]);
    $OPhoneArrary = explode("-", $RSA1[OfficePhone]);

    if (strlen($RSA1[DateOfBirth]) > 0) {
        list($y, $m, $d) = explode("-", $RSA1[DateOfBirth]);
        $dob = $m . "/" . $d . "/" . $y;
        if ($dob == "00/00/0000") {
            $dob = "01/01/2002";
        }
    }
    //}
    ?>

    <div class='container'>
        <?php if ($_GET[whose] == "spouse") { ?>
            <h3 class='text-center'>Spouse Profile</h3>

        <?php } else if ($_GET[whose] == "student") { ?>
            <h3 class='center'>Student Profile</h3>
            <p><a href="FamilyChildList.php">[Back to Childlist]</a>
                <a href="FeePaymentVoucher.php">[Print Payment Voucher]</a>
            </p>

        <?php } else { ?>
            <h3 class='text-center'>Emergency Contact Form</h3>

        <?php } ?>
        <div class="page formwrapper">
            <form name="NewMember" id="emergencyContact" action="UpdateEmergencyContact.php?mid=<?php echo $RSA1[MemberID]; ?>" method="post" onsubmit="return Validate(this);">
                <fieldset>
                  <legend>Emergency Contact</legend>
                    <div class="form-group">
                        <input name="updtmemberid" type="hidden" value="<?php echo $RSA1[MemberID]; ?>">
                        <input  name="whose" type="hidden" value="<?php echo $_GET[whose]; ?>">

                        <label for="MemberID" class="control-label">Member ID: </label>
                        <input type="text" name="MemberID" disabled="disabled" value="<?php echo $RSA1[MemberID]; ?>"><br>
                        <label for="FamilyID">Family ID: </label>
                        <input type="text" name="FamilyID" disabled="disabled" value="<?php echo $RSA1[FamilyID]; ?>"> <br> 

                        <label for="FirstName">Your First Name:  </label>
                        <input type="text" name="FirstName" disabled="disabled" value="<?php echo $RSA1[FirstName]; ?>"><br>

                        <label for="LastName">Your Last Name: </label>
                        <input type="text" name="Last Name" disabled="disabled" value="<?php echo $RSA1[LastName]; ?>">
                    </div>
                    <p style="background:#336600; color: white;" class="center lead">Emergency Contact Information</p>

                    <div class="form-group">
                        <label for="FirstContactName">First Contact Name<span class="red-color">*</span></label>
                        <input type="text" size="28" name="FirstContactName" value="<?php echo $RSA1[FirstContactName]; ?>"><br>

                        <label for="FirstContactRelation">First Contact Relationship<span class="red-color">*</span></label>
                        <input type="text" size="28" name="FirstContactRelation" value="<?php echo $RSA1[FirstContactRelation]; ?>">
                        <br>
                        
                        <label for="FirstContactPhone">First Contact Phone<span class="red-color">*</span></label>
                        <input type="text" size="15" name="FirstContactPhone" value="<?php echo $RSA1[FirstContactPhone]; ?>">
                        <br>

                        <label for="SecondContactName">Second Contact Name<span class="red-color">*</span></label>
                        <input type="text" size="28" name="SecondContactName" value="<?php echo $RSA1[SecondContactName]; ?>">
                        <br>

                        <label for="SecondContactRelation">Second Contact Relationship<span class="red-color">*</span></label>
                        <input type="text" size="28" name="SecondContactRelation" value="<?php echo $RSA1[SecondContactRelation]; ?>"><br/>

                        <label for="SecondContactPhone">Second Contact Phone<span class="red-color">*</span></label>	
                        <input type="text" size="15" name="SecondContactPhone" value="<?php echo $RSA1[SecondContactPhone]; ?>">
                    </div>

                    <div class="form-group">
                        <label for="DoctorName">Doctor Name<span class="red-color">*</span></label>
                        <input type="text" size="28" name="DoctorName" value="<?php echo $RSA1[DoctorName]; ?>">
                        <br>

                        <label for="DoctorCity">Doctor City<span class="red-color">*</span></label>
                        <input type="text" size="28" name="DoctorCity" value="<?php echo $RSA1[DoctorCity]; ?>">
                        <br>

                        <label for="DoctorPhone">Doctor Phone<span class="red-color">*</span></label>
                        <input type="text" size="15" name="DoctorPhone" value="<?php echo $RSA1[DoctorPhone]; ?>">
                        </div>
                    <div class="form-group">

                        <label for="DentistName">Dentist Name<span class="red-color">*</span></label>
                        <input type="text" size="28" name="DentistName" value="<?php echo $RSA1[DentistName]; ?>">
                        <br>

                        <label for="DentistCity">Dentist City<span class="red-color">*</span></label>
                        <input type="text" size="28" name="DentistCity" value="<?php echo $RSA1[DentistCity]; ?>">
                        <br>

                        <label for="DentistPhone">Dentist Phone<span class="red-color">*</span></label>
                        <input type="text" size="15" name="DentistPhone" value="<?php echo $RSA1[DentistPhone]; ?>">
                        </div>
                    <div class="form-group">
                        <label for="HospitalPreference">Hospital Preference<span class="red-color">*</span></label>
                        <input type="text" size="28" name="HospitalPreference" value="<?php echo $RSA1[HospitalPreference]; ?>"><br>

                        <label for="SepecialMedicalConditions">Allergies or Special Medical Conditions: </label>
                        <input type="text" size="50" name="SpecialMedicalConditions" value="<?php echo $RSA1[SpecialMedicalConditions]; ?>"><br>
                    </div>
                    <div class="form-group">
                        <label for="InsuranceName">Insurance Company Name: </label>			       
                        <input type="text" size="50" name="InsuranceName" value="<?php echo $RSA1[InsuranceName]; ?>">
                        <br>
                        <label for="InsurancePolicyNumber">Insurance Policy Number: </label>			       
                        <input type="text" size="28" name="InsurancePolicyNumber" value="<?php echo $RSA1[InsurancePolicyNumber]; ?>">
                    </div>

                    <h5>Waiver and Release</h5>
                    <p class="alert alert-info">I, the undersigned parent or legal guardian of the above child(ren), do give my permission and approval for his/her participation in Southern Connecticut Chinese School program(s) and therefore, assume all risks and hazards incidental to such participation. On behalf of my child(ren) and family, I freely and voluntarily agree to release, indemnify and hold harmless, the Southern Connecticut Chinese School, its directors, officers, administrators, teachers, and volunteers from any liabilities arising from any injury, mental or physical, arising from my child(ren)'s involvement and participation in the school's program(s). In the event that my child becomes ill or injured during any Southern Connecticut Chinese School activity, its officers, teachers, or volunteers have my permission to arrange for adequate medical attentions and treatment, including the transportation of my child to an appropriate emergency medical facility. I have read and accepted the above Release, and I understand and agree fully with its provisions.</p>
                    <p class="text-center">
                        <input type="submit" value="Save and Sign Form">
                        <input type="button" onClick="window.location.href = 'FamilyChildList.php'" value="Cancel">
                    </p>
                </fieldset>
            </form>
        </div>
    </div>

    <?php include("../common/site-footer1.php"); ?>

</body>
</html>
