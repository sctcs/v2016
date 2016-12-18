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
       
    <?php if ($_GET["error"] == 1) { ?>
<!--        <p class="red-color">Can not have both fields empty.</p>-->
    <?php } ?>

    <?php if ($_GET["error"] == 2) { ?>
        <p class="red-color">Either the Family ID or Member ID that you supplied was incorrect.</p>

    <?php } ?>
        <form action="MemberLookupByID.php" method="post">
            <p class='alert alert-info'>Please enter either Family ID or Member ID to search for member</p>
            <label for="familyID">Family ID: </label>
            <input type="number" name="familyID" min="1" max="4000"><br />
            <label for="memberID">Member ID: </label>
            <input type="number" name="memberID" min="1" max="4000"><br />
            <input type="submit" value="Lookup" />
        </form>
    </div>
</div>

<?php include("../common/site-footer1.php"); ?>


