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
   date_default_timezone_set("EST") ;
   $bdate = date_format( date_create($_GET[begdate]),"Y-m-d");
   print $bdate;
   echo " to ";
   $edate = date_format( date_create($_GET[enddate]),"Y-m-d");
   print $edate;
   echo "<br><br>";
   //header("Location: index.php?view=PaymentViewListAll&cid=".$_GET[cid]."&beg_date=".$_GET[begdate]."&end_date=".$_GET[enddate]);
   echo "<a href=\"index.php?view=PaymentViewListAll&cid=".$_GET[cid]."&beg_date=".$bdate."&end_date=".$edate."&mainmenu=off\">Continue to Form 1</a>";
   echo "<br><br><a href=\"index.php?view=PaymentViewListAllExt&cid=".$_GET[cid]."&beg_date=".$bdate."&end_date=".$edate."&mainmenu=off\">Continue to Form 2 (more columns)</a>";
   exit();
}
?>
<html>
<head>
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
    <script src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<script>
$(function()
            {
                     $( ".datepicker" ).datepicker();
                     $(".icon").click(function() { $(".datepicker").datepicker( "show" );})
             });
</script>
</head>

<body>
<form action="paymentviewsetup.php">

<input type=hidden name=cid value="<?php echo $_GET[cid]; ?>" >
Between <input type=text class="datepicker" name="begdate" value="2017-08-01">
    and <input type=text class="datepicker" name="enddate" value="2017-08-02">
<input type="submit" value="Go">
</form>
</body>
</html>

