<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

?>
<html>
<head>
<title>Enter Payment Batch</title>
<script>
function goBack() {
    window.history.back()
}
</script>
</head>

<body>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br>

<?php
$seclvl = $_SESSION['membertype'];
if(  $seclvl !=10 && $seclvl !=20 && $seclvl !=45 && $seclvl !=55  )  // treasurer access
        {
            echo "access denied";
            exit();
        }
?>

<p>
Family IDs entered: 
<?php
  $familyids = $_POST[familyids];
  echo $familyids;
echo "</p>";

include("../common/DB/DataStore.php");

$SQLstring = "SELECT distinct FamilyID,FirstName,LastName,HomeAddress,HomeCity,HomeState,HomeZip
                FROM tblMember where FamilyID in (" . $familyids . ") and PrimaryContact='Yes'";
//echo $SQLstring;
    echo "<br>";
$RS1=mysqli_query($conn,$SQLstring);
  $rc=0;

echo "<br>";
echo "Valid FamilyIDs:";
echo "<table border=1>";
echo "<tr><th>FamilyID</th><th>Name and Address</th></tr>";
 while ($row=mysqli_fetch_array($RS1)) 
 {
  $fid=$row[FamilyID];
//echo $fid;
  echo "<br>";
//echo strpos($familyids,$fid) ;
//if (strpos($familyids,$fid) !==false ) 
//{
    $rc = $rc + 1;
//  echo $fid . " is valid";
    echo "<tr><td>".$fid."</td><td>".$row[FirstName]." "
                                    .$row[LastName].", "
                                    .$row[HomeAddress].", "
                                    .$row[HomeCity].", "
                                    .$row[HomeState]." "
                                    .$row[HomeZip]."</td></tr> ";
//  echo "<br>";
       if ($rc ==1) 
       { 
         $valid_fids =  $fid ;
       } else {
         $valid_fids .= "," . $fid ;
       }

    $valid[$fid]=1;
//} else {
//  echo $fid . " is invalid";
//}
 }
echo "</table>";
echo "<p>Note: Please verify name and address against the check received.</p>";

echo "<br><br>";
  $fids = explode(",", $familyids);
  $count = 0; 
    
    foreach ($fids as $key => $value) 
    { 
     if (isset($value))
     {
            $count++; 
        if ( !isset($valid[$value]))
        {
          echo "<font color=red>".$value . "</font> is invalid";
        }
//      echo $value ."<br>";
     }
    } 
  
  echo "<br>";
  echo "<br>";
  echo "Entered Total: ". $count;
  echo "<br>";
  echo "Valid   Total: ". $rc;
?>
<br>
<br>
<button onclick="goBack()">Go Back & Edit</button>
<br>
<br>
<?php
 if ($rc > 0 )
 { ?>
<form action="enterPaymentBatchInput.php" method="POST">
    <input  type="hidden" name="valid_fids" value="<?php echo $valid_fids; ?>" >
    <input type="submit" value="Continue to enter payments">
</form>
 <?php } ?>

</body>
</html>

<?php 
mysqli_close($conn);

?>
