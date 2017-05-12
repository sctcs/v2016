<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
        {
            echo "access denied";
            exit();
        }
if ( isset($_GET[begdate]) && strlen($_GET[begdate]) == 10 ){
   echo "From ";
   print $_GET[begdate];
   echo " to ";
   print $_GET[enddate];
   echo "<br><br>";
   //header("Location: index.php?view=PaymentViewListAll&cid=".$_GET[cid]."&beg_date=".$_GET[begdate]."&end_date=".$_GET[enddate]);
   echo "<a href=\"index.php?view=PaymentViewListAll&cid=".$_GET[cid]."&beg_date=".$_GET[begdate]."&end_date=".$_GET[enddate]."&mainmenu=off\">Continue</a>";
   exit();
}
?>
<html>
<body>

<form action="paymentviewsetup.php">
<input type=hidden name=cid value="<?php echo $_GET[cid]; ?>" >
Between <input type=text name="begdate" value="2016-07-01">
and <input type=text name="enddate" value="2017-07-01">
<input type="submit" value="Go">
</form>

