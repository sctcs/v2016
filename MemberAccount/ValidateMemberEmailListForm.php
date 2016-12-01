<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if( ! isset($_SESSION['logon'])) {
    echo "You need to login to send an announcement, <a href=\"../MemberAccount/MemberLoginForm.php\">Login</a>";
    exit;
} else {
	$seclvl = $_SESSION['membertype'];
	$secdesc= $_SESSION['MemberTypes'][$seclvl];
	if ($seclvl != 10 && $seclvl != 11 && $seclvl != 20 ) {
	   echo "You need to login as Principal, Chariman or DB/Web Admin to send an announcement, <a href=\"../MemberAccount/chooseRole.php\">Change Role</a>";
	   exit;
	}
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
    </head>
    <body>
    <form method="POST" action="ValidateMemberEmailList.php">

  Enter curent list emails: <br />
  <textarea name="emails" rows="65" cols="70" wrap="hard"><?php echo $msg; ?></textarea><br />
  <p>
  <input type="submit" value="Validate" />


    </form>
    </body>
</html>
