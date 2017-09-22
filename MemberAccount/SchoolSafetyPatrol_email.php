<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

$seclvl = $_SESSION['membertype'];

if (isset($_GET[date]) && $_GET[date] != "") {
$date = $_GET[date];
} else {
$date="";
}

$period = $_GET[period];
$time =  $period == "1" ? "1:15-3:20pm" : "3:15-5:20";

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>All Safety Patrol Schedule</title>
<meta http-equiv="Content-type" content="text/html; charset=UTF8" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>

<body>
<a href="ManageSafetyPatrol.php">Manage Safety Patrol</a>
<br>
<br>
<?php


$SQLstring = "SELECT distinct concat_ws( '', m.Email, ',' ) as email
FROM tblMember m, tblSafetyPatrol s
WHERE m.FamilyID = s.FamilyID
AND s.ScheduledDate = '". $date ."' "
. " AND s.Period = '". $period ."' ";
//AND m.PrimaryContact = 'Yes'


//echo $SQLstring;

						$RS1=mysqli_query($conn,$SQLstring);

	?>
<?php
$emails="";
while($RSA1=mysqli_fetch_array($RS1)) {

  echo  $RSA1[email] ;
  $emails .= $RSA1[email];
} ?>
<br><br>

                <form action="EmailPatrolParents.php" method="POST">
                    <table>
                        <tr>
                            <td width="10%" align="Right" valign="Top">From: </td>
                            <td><input type="text" name="From" size=90 value="SCCS Office Manager <safety@ynhchineseschool.org>"></td>
                        </tr>
                        <tr valign=top>
                            <td width="10%" align="Right" valign="Top">To: </td>
                            <td><textarea cols=90 rows=5 name="To"><?php echo $emails; ?></textarea></td>
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top">Cc: </td>
                            <td><input type="text" name="Cc" size=90 value="safety@ynhchineseschool.org"></td>
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top">Subject: </td>
                            <td><input type="text" name="Subject" size=90 value="Chinese School Safety Patrol on Sunday <?php echo $date . ", ". $time; ?>"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top">Message: </td>
                            <td><textarea cols=90 rows=30 name="Message">

Dear Parents,

You are assigned school safety patrol duty during <?php echo $time; ?>
 on this Sunday <?php echo $date; ?>. 
Please arrive at school 10 minutes early and report to the office (A107). 
Safety patrol lead will assist you with your duty. You are encouraged to do patrol
for four hours if you can so that you will not need to do it again on a different Sunday. 

If you don't have any child attending Chinese school this term, or you are
an adult student taking the language class, please let school know now.

Please inform the office (safety@ynhchineseschool.org) 2 days ahead if you choose to 
do 4-hour-patrol, switch time with other family or have trouble to make the assignment.
Don't send seniors for the duty please.

Please try your best not to change the assignment as we need enough
parents to cover the whole building.

For the school and our
children's safety, please review the Safety Patrol Guidelines
http://www.ynhchineseschool.org/prod_v08/MemberAccount/SafetyPatrolGuidelines.pdf carefully. 
When you are on duty, make sure to get yourself familiar with the nearest emergency exits.
In case of fire emergency or drill, direct and help teachers, students and
parents to evacuate the building quickly to a designated safe place (front
parking lot, 300 ft away from our building).

Your participation is greatly appreciated.

Southern Connecticut Chinese School (SCCS)

                              </textarea></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="submit" name="Send" value="Send">
                            </td>
                        </tr>
                    </table>
                </form>


</body>
</html>

<?php
    mysqli_close($conn);
 ?>
