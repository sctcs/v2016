<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if (!isset($_SESSION['logon'])) {
    echo "<center>";
    echo ( 'you need to <a href="MemberLoginForm.php">login</a> first' );
    exit();
}
if (!isset($_SESSION[membertype]) || $_SESSION[membertype] > 25) {
    echo "<center>";
    echo ( 'you need to <a href="MemberAccountMain.php">login as Principal, PTA President, or Chairman of Board of Directors</a>' );
    exit();
}

$seclvl = $_SESSION['membertype'];
$secdesc = $_SESSION['MemberTypes'][$seclvl];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
?>

<!doctype html>
<html>
    <head>
        <title>Send Email</title>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <script language="javascript" src="../common/JS/MainValidate.js"></script>
        <script type ="text/javascript" src = "http://js.nicedit.com/nicEdit-latest.js" ></script>
        <script>
            //<![CDATA[
            bkLib.onDomLoaded(function () {
                nicEditors.allTextAreas()
            });
            //]]>
        </script>
    </head>
    <body>
        <header>
            <?php include("../common/site-header1.php"); ?>
        </header>
        <div class="container">
            <!--                     <a href="MemberAccountMain.php">My Account</a>-->

            <h3 class="text-center">Send a School Wide Email</h3>
            <?php
            $SQLstring = "select *  from tblMemberType";
            $RS1 = mysqli_query($conn, $SQLstring);
            //$RSA1=mysqli_fetch_array($RS1);
            ?>
            <div style="width: 85%; margin: 10px auto;">
                <form name="emailform" action="SendEmailToMembersAction.php" method="POST" >
                    <table>
                        <tr>
                            <td width="10%" align="Right">From: </td>
                            <td><?php
                                echo $firstname . " " . $lastname . ", ";
                                echo $secdesc;
                                if ($seclvl == 10) {
                                    echo ", principal@ynhchineseschool.org";
                                    $from = "principal@ynhchineseschool.org";
                                } else if ($seclvl == 11) {
                                    echo ", boardchairman@ynhchineseschool.org";
                                    $from = "boardchairman@ynhchineseschool.org";
                                } else if ($seclvl == 12) {
                                    echo ", ptachair@ynhchineseschool.org";
                                    $from = "ptachair@ynhchineseschool.org";
                                } else {
                                    echo "Invalid login";
                                    exit;
                                }
                                ?>
                                <input type="hidden" name="From" value="<?php echo $from; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top">To: </td>

                            <td><input type="checkbox" name="ParentPC" value="primary" checked>Primary Contact Parents<BR>
                                <input type="checkbox" name="ParentSP" value="both">Second Parents<BR>
                                Limit to those took classes within: 
                                <SELECT name="PCYear" >
                                    <option  value="C-year" SELECTED>Current School Year </option> <!-- current schoo year -->
                                    <option  value="L-year">Last School Year </option> <!-- Last school year -->
                                    <option  value="2-year">Before Last School Year </option> <!-- two school year -->
                                    <option  value="3-year">3 School Years </option> <!-- three school years ago -->
                                </select>
                                <BR>
                                <input type="checkbox" name="NewMembers" value="newmembers">New Members after <?php echo $CurrentYear; ?>-05-01</td> 
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top"> </td>
                            <td><input type="checkbox"  name="Teachers" value="teachers">Teachers<br>
                                <input type="checkbox"  name="Admins" value="admins">School Administrators<br>
                                <input type="checkbox" name="Principal" value="principal">School Principal<br>

<!--		<input type="checkbox"  name="Alumni" value="alumni">Alumni (all former members)<BR> -->
                            </td>
                        </tr>

                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                        
                         <tr>
                            <td width="10%" align="Right" valign="Top">CC: &nbsp;</td>
                            <td>
<!--                                <input type="text" name="cc" size="60">-->
                            <input type="email" multiple value="" name="cc" size="60">
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top">BCC: </td>
                            <td> 
<!--                           <input type="email" multiple pattern="" name="bcc" size="60">-->
                            <input type="email" multiple value="" name="bcc" size="60">
                            </td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>

                        <tr>
                            <td width="10%" align="Right" valign="Top">Subject: </td>
                            <td><input type="text" name="Subject" size=60>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width="10%" align="Right" valign="Top">Message: </td>
                            <td><textarea cols=90 rows=30 name="Message"></textarea>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">
                                <input type="submit" name="Preview" value="Previev">
                                <input type="submit" name="Send" value="Send">
                            </td>
                        </tr>
                        <tr><td>&nbsp;</td></tr>
                    </table>
                </form>
            </div>
        </div>
        <div class="clearfix">&nbsp</div>
        <?php include("../common/site-footer1.php"); ?>

    </body>
</html>
