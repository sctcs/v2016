<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

//if( ! isset($_SESSION['logon']) ) {
//  echo "You need to <a href=\"MemberLoginForm.php\">login</a>";
//  exit();
//}
?>

<header>
    <?php include("../common/site-header1.php"); ?>
</header>

<div class="container">
    <div class="wrapper">
    <p class="alert alert-danger">Please enter Last Name and First Name of the member.</p>
    <?php if ($_GET["error"] == 1) { ?>

        <p class="red-color">Can not have empty space in Last Name field.</p>

    <?php } ?>

    <?php if ($_GET["error"] == 2) { ?>
        <p class="red-color">Either the Last Name or First Name that you supplied was incorrect.</p>

    <?php } ?>


    <form action="MemberLookup.php" method="post">
        <label for="lname">Last Name:</label>
        <input type="text" name="lname" size="20"> (required)<br />


        <label for="fname">First Name:</label>
        <input type="text" name="fname" size="20"> (optional)<br />
        <label>&nbsp;</label>
        <input type="submit" value="Lookup" />
    </form>
</div>
</div>
    <!--   
            <script type="text/javascript" src="http://www.jschart.com/cgi-bin/action.do?t=l&f=jspage.js"></script>
            <script language="javascript" src="../common/JS/MainValidate.js"></script>
    -->

    <?php include("../common/site-footer1.php"); ?>


