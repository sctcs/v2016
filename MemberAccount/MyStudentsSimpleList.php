<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
// echo ( '<center>you need to login, <a href="MemberLoginForm.php">login now<a/></center>' ) ;
 //header( 'Location: MemberLoginForm.php');
// exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
//{
// echo ( 'you need to log in as a teacher or school admins' ) ;
 //header( 'Location: MemberLoginForm.php' );
// exit();
//}
if(! isset($_GET[teacherid]) )
{
 echo ( 'you need to enter  a valid teacher memberID' ) ;
 exit();
}
if(! isset($_GET[classid]) )
{
 echo ( 'you need to enter  a valid class ID' ) ;
 exit();
} else {
 $classid = $_GET[classid];
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
//mysql_select_db($dbName, $conn);
$seclvl = $_SESSION[membertype];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SCCS Students in a Class</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />

</head>

<body>


<a href="javascript:window.history.back();">Back</a>
<center>
					<?php

						$SQLstring = "select *   from viewClassStudents v, tblMember m where v.MemberID=m.MemberID and v.TeacherMemberID=".$_GET[teacherid]
						            ." and v.ClassID='".$classid."'"
//						            ." AND v.CurrentClass='Yes'  order by v.LastName";//.$_SESSION[memberid];
						            ."                           order by v.LastName";//.$_SESSION[memberid];
						if ($DEBUG) { echo "see111: ".$SQLstring; }
						$RS1=mysqli_query($conn,$SQLstring);
                        $allemails="";
                        $ei=0;

					$row=mysqli_fetch_array($RS1);
					echo "<h3>Students in Class:<font color=\"red\"> ". $row[GradeOrSubject].".".$row[ClassNumber]."</font></h3>";


                    $SQLstring1 = "select * from tblMember where MemberID=".$_GET[teacherid];
                    $RS1=mysqli_query($conn,$SQLstring1);
                    $row=mysqli_fetch_array($RS1);
                    ?>

				    <?php if (isset($_SESSION[membertype]) ) { ?>
				    <table width="70%"  CELLSPACING="0" CELLPADDING="0" border="0">
				    <?php } else {?>
				    <table width="60%"  CELLSPACING="0" CELLPADDING="0" border="0">
				    <?php } ?>
					<tr>
					    <td nowrap>Teacher Name: <?php echo $row[FirstName]." ".$row[LastName]."  ".$row[ChineseName]; ?></td>
					    <td nowrap>Year: <?php echo $_GET[year]; ?></td>
					    <td nowrap>Term: <?php echo $_GET[term]; ?></td>
					    <td nowrap>Class ID: <?php echo $_GET[classid]; ?></td>
					    <td nowrap>Class Room: <?php echo $_GET[classroom]; ?></td>
					</tr>
					</table>
					<?php if (isset($_SESSION[membertype]) ) { ?>
						<table width="70%" CLASS="page" CELLSPACING="0" CELLPADDING="0" border="1">
					<?php } else {?>
					    <table width="35%" CLASS="page" CELLSPACING="0" CELLPADDING="0" border="1">
					<?php } ?>
						<tr><th>No</th>
						<th>English Name</th><th >Chinese Name</th>
					<?php if (isset($_SESSION[membertype]) ) {
					   if ( $seclvl <=25 || $seclvl == 35 || $seclvl == 40 ||$seclvl==55||$seclvl==12 ) {
						  echo "<th>Parent Names</th>";
						echo "<th>Family ID</th>";
					   } else {
					      echo "<th >Parent Names</th>";
					   }
                      }
                      if ( isset($_SESSION[membertype]) && $_SESSION[membertype] <= 25 ) {
                         //echo "<th>Fee Paid</th>";
                      }
                      echo "</tr>";
                      $RS1=mysqli_query($conn,$SQLstring);
                      $no=0;
					  while ( $row=mysqli_fetch_array($RS1) ){
                        $no++;
						$PhoneArrary=explode("-",$row[HomePhone]);
						$CPhoneArrary=explode("-",$row[CellPhone ]);
						$SQLstring1 = "select * from tblMember where FamilyID=".$row[FamilyID]." and  MemberID not in (select MemberID from tblStudent) ";
						$RS2=mysqli_query($conn,$SQLstring1);
						$pphones="";
						$pemails="";
						$pnames="";

						while ( $row1=mysqli_fetch_array($RS2) ){

						   if ( $row1[HomePhone] != "" ) {
						    $pphones .= $row1[HomePhone]."(h)"; }
						   if ( $row1[OfficePhone] != "" ) {
						    $pphones .= "<br>".$row1[OfficePhone]."(o)";}
						   if ( $row1[CellPhone] != "" ) {
						    $pphones .= "<br>".$row1[CellPhone]."(c)";}
						  //  $pphones .= $row1[HomePhone]."(h), ".$row1[OfficePhone]."(o), ".$row1[CellPhone]."(c), ";
						  //  $pphones .= $row1[HomePhone]."(h), ".$row1[OfficePhone]."(o), ".$row1[CellPhone]."(c), ";
						   if ($row1[Email] != ""){
						     $allemails .= $row1[Email].", "; $ei++;
						     if ($pemails != ""){
						      $pemails .= "<br>".$row1[Email];
						     } else {
						      $pemails .= "".$row1[Email];
						     }
						   } //.",". $row1[SecondEmail].",";
						   if ($row1[SeconEmail] != ""){
						    $allemails .= $row1[SecondEmail].", "; $ei++;
						    $pemails .= "<br>".$row1[SecondEmail];}
						    $pnames  .= $row1[LastName].", ".$row1[FirstName]."; ";
						}
						echo "	<tr><td class=\"page\" align=center>".$no."</td>";
						
					
						echo "<td nowrap class=\"page\" >". $row[LastName] .", ". $row[FirstName] ."</td>";
						echo "      <td class=\"page\">". $row[ChineseName] ;
                        if( isset($_SESSION[membertype]) ){
                          if ( $seclvl <=25 || $seclvl == 35 || $seclvl == 40 ||$seclvl==55||$seclvl==12 ) {
						     echo     "</td><td class=\"page\">".$pnames."</td>";
						  } else {
						     echo     "</td><td class=\"page\">".$pnames."</td>";
						  }
						}
						if (isset($_SESSION[membertype]) && ($_SESSION[membertype] <= 25 ||$seclvl==40||$seclvl==55||$seclvl==12)) {
$sqlb="select FReceivable.FamilyID,PayableAmount,PaymentAmount,PayableAmount-PaymentAmount Balance 
from (select FamilyID , sum(Amount) PayableAmount from tblReceivable where FamilyID=".$row[FamilyID]." group by FamilyID ) FReceivable 
left join (select FamilyID, sum(Amount) PaymentAMount from tblPayment where FamilyID=".$row[FamilyID]." group by FamilyID ) FamilyPayment on FReceivable.FamilyID=FamilyPayment.FamilyID limit 1";
                    $RSB=mysqli_query($conn,$sqlb);
                    $rowb=mysqli_fetch_array($RSB);

$sqlbf="SELECT FamilyID, MemberID, sum( Amount ) BookFeeDeposit FROM tblReceivable ".
       " WHERE MemberID=". $row[MemberID] . " and DateTime > '". $CurrentYear ."-08-01' AND IncomeCategory =12 GROUP BY FamilyID, MemberID";
                    $RSBF=mysqli_query($conn,$sqlbf);
                    $rowbf=mysqli_fetch_array($RSBF);
						echo "      <td class=\"page\" align=center>". $row[FamilyID] . "</td>";

                        }
						echo "	</tr>";


					  }
						?>
						</table>

</table>
<?php
if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25) {  ?>
<?php } ?>
</center>
</body>
</html>
<?php mysqli_close($conn); ?>
