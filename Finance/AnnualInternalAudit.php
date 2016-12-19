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

?>

<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br><br>
<!--
<a href="SCCSInternalAudit2014.pdf" target=_blank>Internal Audit Report 2014 by SCCS Audit Team</a><br>
<a href="SCCSInternalAudit2015.pdf" target=_blank>Internal Audit Report 2015 by SCCS Audit Team</a><br>
<a href="SCCSInternalAudit2016.pdf" target=_blank>Internal Audit Report 2016 by SCCS Audit Team</a><br>
-->

Internal Audit Report 2014 by SCCS Audit Team: 
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-001.php">P1</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-002.php">P2</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-003.php">P3</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-004.php">P4</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-005.php">P5</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-006.php">P6</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-007.php">P7</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-008.php">P8</a>
<a href="SCCSInternalAudit2014/SCCSInternalAudit2014-page-009.php">P9</a>
<br><br>
Internal Audit Report 2015 by SCCS Audit Team: 
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-001.php">P1</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-002.php">P2</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-003.php">P3</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-004.php">P4</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-005.php">P5</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-006.php">P6</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-007.php">P7</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-008.php">P8</a>
<a href="SCCSInternalAudit2015/SCCSInternalAudit2015-page-009.php">P9</a>
<br><br>
Internal Audit Report 2016 by SCCS Audit Team: 
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-001.php">P1</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-002.php">P2</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-003.php">P3</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-004.php">P4</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-005.php">P5</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-006.php">P6</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-007.php">P7</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-008.php">P8</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-009.php">P9</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-010.php">P10</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-011.php">P11</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-012.php">P12</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-013.php">P13</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-014.php">P14</a>
<a href="SCCSInternalAudit2016/SCCSInternalAudit2016-page-015.php">P15</a>
