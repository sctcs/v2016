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


if ( isset($_POST[familyid]) && trim($_POST[familyid]) != "") {
  $familyid=$_POST[familyid];
}

if ($familyid=="")
{
 header( 'Location: payment_notice.php?error=1' ) ;
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
} else {
   $fids[0] = $familyid;
}


?>
<html>
<head></head>
<body>
Payment notice summary:
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
  mail_notice($fid,$useremail,$fname,$lname) ;

  echo "sent";
 } else {
  echo "not";
 }
?>
</td></tr>
<?php
}

mysqli_close($conn);

?>