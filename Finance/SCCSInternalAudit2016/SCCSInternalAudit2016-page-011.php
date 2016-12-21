<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
//echo "not logon yet";
if (!isset($_SESSION['logon'])) {
    header('Location: ../../MemberAccount/MemberLoginForm.php?error=3');
    exit();
}

?>

<script type="text/javascript">
//<![CDATA[
/* ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
Disable context menu on images by GreenLava (BloggerSentral.com)
Version 1.0
You are free to copy and share this code but please do not remove this credit notice.
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^ */
    function nocontext(e) {
        var clickedTag = (e==null) ? event.srcElement.tagName : e.target.tagName;
        if (clickedTag == "IMG") {
            alert(alertMsg);
            return false;
        }
    }
    var alertMsg = "Don't attempt to save this image";
    document.oncontextmenu = nocontext;
//]]>
</script>

<a href="../AnnualInternalAudit.php">Internal Audits</a>
<a href="SCCSInternalAudit2016-page-010.php">Prev Page</a>
<a href="SCCSInternalAudit2016-page-012.php">Next Page</a>

<img src="P011.JPG">

<a href="SCCSInternalAudit2016-page-010.php">Prev Page</a>
<a href="SCCSInternalAudit2016-page-012.php">Next Page</a>
<a href="..eAnnualInternalAudit.php">Internal Audits</a>
