<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
 session_start();
  $login=$_SESSION[logon];
  if ( ! isset($_SESSION[logon]) || $login == "" ) {
     echo "You are not authorized to run this function.";
     exit;
  }

include("../common/DB/DataStore.php");
require_once("payment_notice_mail.php");
//mysqli_select_db($dbName, $conn);


if ( isset($_GET[familyid]) && trim($_GET[familyid]) != "") {
  $familyid=$_GET[familyid];
}

if ( isset($_POST[familyid]) && trim($_POST[familyid]) != "") {
  $familyid=$_POST[familyid];
}

// if DEBUG
$debug=0;
if ($debug) {
// loop through every form field
while ( list( $field, $value ) = each( $_POST )) {
   // display values
   if ( is_array( $value )) {
      // if checkbox (or other multiple value fields)
      while ( list( $arrayField, $arrayValue ) = each( $value )) {
       if ( is_array( $arrayValue )) {
       while ( list( $arrayField1, $arrayValue1 ) = each( $arrayValue )) {
     echo "<p>" . $arrayField1 . "</p>\n";
     echo "<p>" . $arrayValue1 . "</p>\n";
       }
       } else {
     echo "<p>" . $arrayField . "</p>\n";
     echo "<p>" . $arrayValue . "</p>\n";
       }
      }
   } else {
  echo "<p>" . $field . "</p>\n";
  echo "<p>" . $value . "</p>\n";
   }
}
}

//mysqli_close($conn);
//exit;

if ($familyid=="" && !isset($_POST[fids] ) )
{
 header( 'Location: balanceListingToPay.php?error=1' ) ;
 exit();
}


//// 1, get Family IDs ////

//// if familyid is in format of "all:100:110" where 100 is the beg ID and 110 is the end ID
if ( strpos($familyid, ":") != false ) {
  $tmp = split(':',$familyid);
  $begid = $tmp[1];
  $endid = $tmp[2];
  $SQLstring = 'select distinct tblMember.FamilyID '
          . ' from tblMember , tblClassRegistration '
          . ' where tblClassRegistration.StudentMemberID=tblMember.MemberID '
          . ' and tblMember.FamilyID >= '.$begid.' and tblMember.FamilyID <= '.$endid.''
          . ' order by FamilyID ';
          //echo $SQLstring;
    $RS1=mysqli_query($conn,$SQLstring);
    $rc=0;

   while ($row=mysqli_fetch_array($RS1)) {
    if ( $row[0] >= $begid && $row[0] <= $endid ) {
      $fids[$rc]=$row[0];
      $rc = $rc + 1;
    }
   }


} else if ( $familyid == 'all' ) {

  $SQLstring = 'select distinct tblMember.FamilyID '
          . ' from tblMember , tblClassRegistration '
          . ' where tblClassRegistration.StudentMemberID=tblMember.MemberID '
          . ' order by FamilyID ';
    $RS1=mysqli_query($conn,$SQLstring);
    $rc=0;

   while ($row=mysqli_fetch_array($RS1)) {
    $fids[$rc]=$row[0];
    $rc = $rc + 1;
   }

   //if ($rc == 0)
   //{
  	//header( 'Location: payment_notice.php?error=2' ) ;
  	//exit();
   //}
} else if ( strpos($familyid, ",") != false ) {
   $fids = split(',', $familyid);
} else if (isset($_POST[fids] )) {
  $i=0;
  while ( list( $sidArrayField, $sidArrayValue ) = each( $_POST[fids] )) {
  // echo "<p>" . $sidArrayField . "</p>\n";
  // echo "<p>" . $sidArrayValue . "</p>\n";
     $fids[$i]=$sidArrayValue;
     $i++;
  }
} else {
   $fids[0] = $familyid;
}


?>
<html>
<head></head>
<body>
<a href="../MemberAccount/MemberAccountMain.php">My Account</a><br><br>
<a href="balanceListingToPay.php">Balance to Pay</a><br><br>

Payment notice summary:
<br>
<table border="1">
<tr><td>FamilyID</td><td>Name</td><td>Home Phone</td><td>Office Phone</td><td>Cell Phone</td><td>Email</td><td>Status</td></tr>
<tr>

<?php
//// 2. get member info  ////
for ($i=0;$i<count($fids);$i++) {
  $fid = $fids[$i];

  $SQLstring = 'select FirstName,LastName,HomePhone,OfficePhone,CellPhone,Email from tblMember where FamilyID='.$fid.' and PrimaryContact=\'yes\'';

  $RS1=mysqli_query($conn,$SQLstring);
  $rc=0;

 while ($row=mysqli_fetch_array($RS1)) {
  if ($rc == 0) {
  $fname=$row[FirstName];
  $lname=$row[LastName];
  $useremail=$row[Email];
  $hp=$row[HomePhone];
  $op=$row[OfficePhone];
  $cp=$row[CellPhone];
  }
  $rc = $rc + 1;
 }

 if ($rc == 0)
 {
	header( 'Location: payment_notice.php?error=2' ) ;
	exit();
 }
?>
<td><?php echo $fid; ?></td>
<td><?php echo $fname.' '.$lname; ?></td>
<td><?php echo $hp; ?></td>
<td><?php echo $op; ?></td>
<td><?php echo $cp; ?></td>
<td><?php echo $useremail; ?></td>
<td>
<?php
 if ( trim($useremail) != "" ) {
  mail_notice_msg($fid,$useremail,$fname,$lname,$_POST[msgsubj],$_POST[msgbody]) ;

  echo "<font color=green>sent</font>";
 } else {
  echo "<font color=red>not</font>";
 }
?>
</td></tr>
<?php
}
echo "</table>";
echo "Subject: ". $_POST[msgsubj];
echo "<br>Content:<br>";
echo $_POST[msgbody];

mysqli_close($conn);

?>
