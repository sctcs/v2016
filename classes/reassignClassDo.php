<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
//only for principal
if(! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 20 ) {
   echo "You don't have sufficient authorization to access this page";
   exit();
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>SCCS Class Management</title>

<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>
<body>
<a href="../">[Home]</a>
<a href="../MemberAccount/MemberAccountMain.php">[My Account]</a>
<br><br><br>

<?php

print "MemberID : $_SESSION[memberid] <br>";

foreach($_POST as $name => $value) {
print "$name : $value<br>";
}


$StudentMemberID = $_POST['hdstudentmemberid'];

//common parameters
include("../common/CommonParam/params.php");
//database connection
include("../common/DB/DataStore.php");

function class_registered($classid, $studentid, $conn)
{
    $sql = "select Status from tblClassRegistration where StudentMemberID = ". $studentid ." and ClassID = ". $classid ." limit 1";
    //echo $sql;
    $rs=mysqli_query($conn,$sql);
	$rw=mysqli_fetch_array($rs);
	if ( isset($rw[Status]) && $rw[Status] != "" ) {
	   return $rw[Status];
	} else {
	   return "";
	}
}

$langbtassign = $_POST["reassignLangFall"];
if( $langbtassign == "Re-Assign Chinese Class Fall"  && $_POST['lastClassLangFall'] != $_POST['currentClassLangFall'])
{
	$langhdclassid=$_POST['currentClassLangFall'];
	$langckstudentid=$_POST['hdstudentmemberid'];
	$langlastclassid=$_POST['lastClassLangFall'];
     if ( $langlastclassid == 0 && $langhdclassid != 0)
     {
        $class_regd = class_registered($langhdclassid, $langckstudentid, $conn);
        if ( $class_regd != "" ) {
          $langinsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langhdclassid." and StudentMemberID=".$langckstudentid." ";
        } else {
 		  $langinsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$langckstudentid.",".$langhdclassid.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$langSQL = "update tblStudent set PreferredClassLevel = (select GradeOrSubject from tblClass where ClassID=".$langhdclassid.") where MemberID=".$langckstudentid;
        echo $langSQL;
     } else if ( $langlastclassid != 0 && $langhdclassid == 0 ){
		$langinsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langlastclassid." and StudentMemberID=".$langckstudentid." and Year='".$CurrentYear."'";
		//$langSQL = "update tblStudent set PreferredClassLevel = '' where MemberID=".$langckstudentid;
		echo $langSQL;
     } else if ( $langlastclassid != 0 && $langhdclassid != 0 ) {
	    $langinsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langlastclassid." and StudentMemberID=".$langckstudentid." ";
        echo "Query:$langinsertQuery";
        if ( !mysqli_query($conn,$langinsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($langhdclassid, $langckstudentid, $conn);
        if ( $class_regd != "" ) {
          $langinsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langhdclassid." and StudentMemberID=".$langckstudentid." ";
        } else {
	      $langinsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$langckstudentid.",".$langhdclassid.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$langSQL = "update tblStudent set PreferredClassLevel = (select GradeOrSubject from tblClass where ClassID=".$langhdclassid.") where MemberID=".$langckstudentid;
		echo $langSQL;
      } else {
	   echo " not possible";
	   $langinsertQuery = "";
      }
	echo "<br>";
	echo "Query: $langinsertQuery";
	if ( !mysqli_query($conn,$langinsertQuery) ) { die('Error: ' . mysqli_error($conn)) ;}
	//mysql_query($langSQL);
	$StudentMemberID = $langckstudentid;

	echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign1 = $_POST['reassignExtra0Fall'];
if( $extrabtassign1 == "Re-Assign Enrichment Class 0 Fall" && $_POST['currentClassExtra0Fall'] != $_POST['lastClassExtra0Fall'] ){
	$extrahdclassid1=$_POST['currentClassExtra0Fall'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid1=$_POST['lastClassExtra0Fall'];
	if($extralastclassid1 == 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid1.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
		$class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
		if ( $class_regd != "" ) {
		  $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
		}
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid1." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid1;
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra1SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra1SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign1 = $_POST['reassignExtra1Fall'];
if( $extrabtassign1 == "Re-Assign Enrichment Class 1 Fall" && $_POST['currentClassExtra1Fall'] != $_POST['lastClassExtra1Fall'] ){
	$extrahdclassid1=$_POST['currentClassExtra1Fall'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid1=$_POST['lastClassExtra1Fall'];
	if($extralastclassid1 == 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid1.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
		$class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
		if ( $class_regd != "" ) {
		  $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
		}
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid1." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid1;
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra1SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra1SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign2 = $_POST['reassignExtra2Fall'];
echo "extrabtassign2=$extrabtassign2";
if ( $extrabtassign2 == "Re-Assign Enrichment Class 2 Fall" && $_POST['currentClassExtra2Fall'] != $_POST['lastClassExtra2Fall'] ) {
   echo "inside extra 2 fall";
	$extrahdclassid2=$_POST['currentClassExtra2Fall'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra2Fall'];
	if($extralastclassid2 == 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid2.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid2." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid."  AND ClassID=".$extralastclassid2;
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra2SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra2SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign2 = $_POST['reassignExtra3Fall'];
echo "extrabtassign2=$extrabtassign2";
if ( $extrabtassign2 == "Re-Assign Enrichment Class 3 Fall" && $_POST['currentClassExtra3Fall'] != $_POST['lastClassExtra3Fall'] ) {
   echo "inside extra 3 fall";
	$extrahdclassid2=$_POST['currentClassExtra3Fall'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra3Fall'];
	if($extralastclassid2 == 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid2.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid2." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid."  AND ClassID=".$extralastclassid2;
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra2SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra2SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign2 = $_POST['reassignExtra4Fall'];
echo "extrabtassign2=$extrabtassign2";
if ( $extrabtassign2 == "Re-Assign Enrichment Class 4 Fall" && $_POST['currentClassExtra4Fall'] != $_POST['lastClassExtra4Fall'] ) {
   echo "inside extra 4 fall";
	$extrahdclassid2=$_POST['currentClassExtra4Fall'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra4Fall'];
	if($extralastclassid2 == 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid2.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid2." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid."  AND ClassID=".$extralastclassid2;
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$CurrentYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra2SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra2SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}


$langbtassign = $_POST["reassignLangSpring"];
if( $langbtassign == "Re-Assign Chinese Class Spring"  && $_POST['lastClassLangSpring'] != $_POST['currentClassLangSpring']){
	$langhdclassid=$_POST['currentClassLangSpring'];
	$langckstudentid=$_POST['hdstudentmemberid'];
	$langlastclassid=$_POST['lastClassLangSpring'];
	if ( $langlastclassid == 0 && $langhdclassid != 0){
        $class_regd = class_registered($langhdclassid, $langckstudentid, $conn);
        if ( $class_regd != "" ) {
          $langinsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langhdclassid." and StudentMemberID=".$langckstudentid." ";
        } else {
 		  $langinsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$langckstudentid.",".$langhdclassid.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$langSQL = "update tblStudent set PreferredClassLevel = (select GradeOrSubject from tblClass where ClassID=".$langhdclassid.") where MemberID=".$langckstudentid;
        echo $langSQL;
	} else if ( $langlastclassid != 0 && $langhdclassid == 0 ){
		$langinsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langlastclassid." and StudentMemberID=".$langckstudentid." ";
		//$langSQL = "update tblStudent set PreferredClassLevel = '' where MemberID=".$langckstudentid;
		echo $langSQL;
	}else if ( $langlastclassid != 0 && $langhdclassid != 0 ) {
	    $langinsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langlastclassid." and StudentMemberID=".$langckstudentid." ";
        echo "Query:$langinsertQuery";
        if ( !mysqli_query($conn,$langinsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($langhdclassid, $langckstudentid, $conn);
        if ( $class_regd != "" ) {
          $langinsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$langhdclassid." and StudentMemberID=".$langckstudentid." ";
        } else {
	      $langinsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$langckstudentid.",".$langhdclassid.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$langSQL = "update tblStudent set PreferredClassLevel = (select GradeOrSubject from tblClass where ClassID=".$langhdclassid.") where MemberID=".$langckstudentid;
		echo $langSQL;
	} else {
	   echo " not possible";
	   $langinsertQuery = "";
	}
	echo "<br>";
	echo "Query: $langinsertQuery";
	if ( !mysqli_query($conn,$langinsertQuery) ) { die('Error: ' . mysqli_error($conn)) ;}
	//mysql_query($langSQL);
	$StudentMemberID = $langckstudentid;

	echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign1 = $_POST['reassignExtra0Spring'];
if( $extrabtassign1 == "Re-Assign Enrichment Class 0 Spring" && $_POST['currentClassExtra0Spring'] != $_POST['lastClassExtra0Spring'] ){
	$extrahdclassid1=$_POST['currentClassExtra0Spring'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid1=$_POST['lastClassExtra0Spring'];
	if($extralastclassid1 == 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid1.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid1." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid1;
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra1SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra1SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign1 = $_POST['reassignExtra1Spring'];
if( $extrabtassign1 == "Re-Assign Enrichment Class 1 Spring" && $_POST['currentClassExtra1Spring'] != $_POST['lastClassExtra1Spring'] ){
	$extrahdclassid1=$_POST['currentClassExtra1Spring'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid1=$_POST['lastClassExtra1Spring'];
	if($extralastclassid1 == 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid1.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '' where MemberID=".$extrackstudentid;
        echo $extra1SQL;
	} else if($extralastclassid1 != 0 && $extrahdclassid1 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid1." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid1;
		//$extra1SQL = "update tblStudent set PreferredExtraClass1 = '".$extrahdclassid1."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid1." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid1, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid1." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid1.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra1SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra1SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign2 = $_POST['reassignExtra2Spring'];
echo "extrabtassign2=$extrabtassign2";
if ( $extrabtassign2 == "Re-Assign Enrichment Class 2 Spring" && $_POST['currentClassExtra2Spring'] != $_POST['lastClassExtra2Spring'] ) {
   echo "inside extra 2 Spring";
	$extrahdclassid2=$_POST['currentClassExtra2Spring'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra2Spring'];
	if($extralastclassid2 == 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid2.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
  		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid2." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid2;
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra2SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra2SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign2 = $_POST['reassignExtra3Spring'];
echo "extrabtassign2=$extrabtassign2";
if ( $extrabtassign2 == "Re-Assign Enrichment Class 3 Spring" && $_POST['currentClassExtra3Spring'] != $_POST['lastClassExtra3Spring'] ) {
   echo "inside extra 3 Spring";
	$extrahdclassid2=$_POST['currentClassExtra3Spring'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra3Spring'];
	if($extralastclassid2 == 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid2.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
  		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid2." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid2;
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra2SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra2SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}

$extrabtassign2 = $_POST['reassignExtra4Spring'];
echo "extrabtassign2=$extrabtassign2";
if ( $extrabtassign2 == "Re-Assign Enrichment Class 4 Spring" && $_POST['currentClassExtra4Spring'] != $_POST['lastClassExtra4Spring'] ) {
   echo "inside extra 4 Spring";
	$extrahdclassid2=$_POST['currentClassExtra4Spring'];
	$extrackstudentid=$_POST['hdstudentmemberid'];
	$extralastclassid2=$_POST['lastClassExtra4Spring'];
	if($extralastclassid2 == 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo,DateTimeRegistered) values(".$extrackstudentid.",".$extrahdclassid2.",".$CurrentYear.",'created by ".$_SESSION[memberid]."',now())";
        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
  		  $extrainsertQuery = "insert into tblClassRegistration (StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 == 0){
		//$extrainsertQuery = "delete from tblClassRegistration where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'";
		$extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '' where MemberID=".$extrackstudentid;
        echo $extra2SQL;
	} else if($extralastclassid2 != 0 && $extrahdclassid2 != 0){
		//$extrainsertQuery = "update tblClassRegistration set ClassID=".$extrahdclassid2." , Memo='updated by ".$_SESSION[memberid]."',DateTimeRegistered=now() Where StudentMemberID=".$extrackstudentid." and Year='".$CurrentYear."'AND ClassID=".$extralastclassid2;
		//$extra2SQL = "update tblStudent set PreferredExtraClass2 = '".$extrahdclassid2."' where MemberID=".$extrackstudentid;
	    $extrainsertQuery = "update tblClassRegistration set Status='Dropped', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extralastclassid2." and StudentMemberID=".$extrackstudentid." ";
        echo "Query:$extrainsertQuery";
        if ( !mysqli_query($conn,$extrainsertQuery) ) { die('Error: ' . mysqli_error($conn)) ; }

        $class_regd = class_registered($extrahdclassid2, $extrackstudentid, $conn);
        if ( $class_regd != "" ) {
          $extrainsertQuery = "update tblClassRegistration set Status='OK', DateTimeRegistered=now() , Memo='changed by ". $_SESSION[memberid] ."' where ClassID=".$extrahdclassid2." and StudentMemberID=".$extrackstudentid." ";
        } else {
	      $extrainsertQuery = "insert into tblClassRegistration(StudentMemberID, ClassID, Year, Memo, DateTimeRegistered, Status) values(".$extrackstudentid.",".$extrahdclassid2.",'".$NextYear."','created by ".$_SESSION[memberid]."', now(),'OK')";
        }

        echo $extra2SQL;
	} else {
	   echo " not possible";
	   $extrainsertQuery = "";
	}
	echo "<br>";
	echo $extrainsertQuery;
	mysqli_query($conn,$extrainsertQuery);
	//mysql_query($extra2SQL);
	$StudentMemberID = $extrackstudentid;
	//header("location:reassignstudent.php?StudentMemberID=".$StudentMemberID );
    echo "<br><a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID ."\">continue</a>";
	mysqli_close($conn);
	exit();
}


echo "<br><br>No change was made, ";
echo "<a href=\"reassignClasses.php?StudentMemberID=".$StudentMemberID."\">continue</a>";

?>
</body>
</html>
