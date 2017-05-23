<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

?>
<html>
<head>
<title>Enter Payment Batch</title>
</head>

<body>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br>
<a href="index.php">Payment Management</a><br>

<?php
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
        {
            echo "access denied";
            exit();
        }
?>

<p>Enter multiple family IDs, separated by comma, for example, 1234,1567,2890</p>


<form action="enterPaymentBatchParse.php" method="POST">
    <textarea  name="familyids" value="" cols=60 rows=5></textarea>
    <br>
    <input type="submit" value="Continue">
</form>

</body>
</html>
