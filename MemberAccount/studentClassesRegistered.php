<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if( !isset($_GET[stuid]) || $_GET[stuid] =="" )
{
   echo "need to pass student id";
   exit;

}

if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

//echo $_SESSION['membertype'];
//echo $_SESSION['memberid'];
//exit();

// signed the waiver as a parent
if ( $_SESSION['membertype'] == 50 ) {

	$SQLstring = "select MB.*   from tblMember MB  "
				."where   MB.MemberID=".$_SESSION['memberid'];

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);

  if ($RSA1[Waiver] != "Yes") {

    //header( 'Location: FamilyChildList.php' );
  //} else {
    header( 'Location: ParentsWaiver.php' );
  }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Registered Classes</title>
<meta name="keywords" content="Southern Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

<script language="JavaScript">

	function sendme(who)
	{
		//alert("here ");
		document.all.Container.value=who;

	}
</script>
</head>

<body>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="1%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php


						//$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  "
						//            ."where Login.MemberTypeID =5 AND  MB.FamilyID=".$_SESSION['family_id'];
						$SQLstring = "select *   from tblMember where MemberID = ". $_GET[stuid];
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						$RSA1=mysqli_fetch_array($RS1);


					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="left"><a href="OpenSeats.php" >View Class Opening/Available Seats</a>
								<a href="FeePaymentVoucher.php">Print Payment Voucher</a>
								<a href="FamilyChildList.php">Student List</a>
								<a href="studentProfile.php?stuid=<?php echo $_GET[stuid];?>">Update Profile</a>
								</td>
							</tr>
							<tr>
								<td align="center"><font><b><br>Registered Classes</b></font></td>
							</tr>
							<tr><td>Student Name: <?php echo $RSA1[FirstName ]." ".$RSA1[LastName ];?></td></tr>
							<tr><td>Student ID: <?php echo $_GET[stuid ];?></td></tr>
							<tr><td align=right><a href="studentRegisterClass.php?stuid=<?php echo $RSA1[MemberID];?>">Add/Change Class</a></td></tr>


							<tr>
								<td>
									<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">
                                    <tr><th>Reg.<br>ID</th><th>Class<br>ID</th><th>Teacher<br>ID</th><th>Grade<br>Subject</th><th>Class<br>No</th><th>Room</th><th>Period</th><th>Term</th><th>Year</th><th>Current<br>Class</th><th>Datetime</th><th>Status</th><th></th></tr>
											<?php // class registration
$sql5 = "SELECT r.ClassRegistrationID,r.ClassID, c.GradeOrSubject,c.Classroom,c.ClassNumber,c.Period,c.Term ,r.Year,r.Status,r.DateTimeRegistered ,c.CurrentClass ,c.TeacherMemberID , c.IsLanguage 
											              FROM tblClassRegistration r,tblClass c 
											             WHERE r.StudentMemberID = '". $RSA1[MemberID]."'";
											   $sql5 .= " AND c.ClassID=r.ClassID ORDER BY c.ClassID desc, r.ClassRegistrationID desc";
											   if ($DEBUG){       echo $sql5;}

                                               // old (Fall) student?
											   $sql6 = "SELECT count(*) as  count
											              FROM tblClassRegistration,tblClass
											             WHERE tblClassRegistration.StudentMemberID = '". $RSA1[MemberID] ."' AND tblClass.Year='" .$LastYear. "' AND tblClass.Term ='Fall'"
											                  . " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped'";
											          //echo $sql6;
											         // $rs6=mysqli_query($conn,$sql6);
													 // $rw6=mysqli_fetch_array($rs6) ;
													  //$oldstudent=$rw6[count];



													  $rs5=mysqli_query($conn,$sql5);
                                              ?>
										<form action="EditStudentInfo.php" method="post">
										<?php
											$i=0;

										while ( $rw5=mysqli_fetch_array($rs5) ) {	   ?>

										<tr align=center>
										    <td align=center nowrap><?php  echo $rw5[ClassRegistrationID]; ?></td>
										    <td align=center nowrap><?php  echo $rw5['ClassID']; ?></td>
										    <td align=center nowrap><a href="teacherInfo.php?id=<?php  echo $rw5[TeacherMemberID]; ?>"><?php  echo $rw5[TeacherMemberID]; ?> </a></td>
											<td align=center ><?php  echo $rw5[GradeOrSubject]; ?></td>
											<td align=center nowrap><?php  echo $rw5[ClassNumber]; ?></td>
											<td align=center nowrap><?php  echo $rw5[Classroom]; ?></td>
											<td align=center >
<?php 
if ($rw5[IsLanguage] == 'Yes' || strpos($rw5[GradeOrSubject],"two periods") != false )
{
 if ($rw5[Period]=='1') {
											       $period= $PERIOD1." ".$PERIOD2;
											    } else if ($rw5[Period]=='0') {
											       $period= $PERIOD0." ".$PERIOD1;
											    } else if ($rw5[Period]=='2') {
											       $period= $PERIOD2." ".$PERIOD3;
											    } else if ($rw5[Period]=='3') {
											       $period= $PERIOD3." ".$PERIOD4;
											    } else if ($rw5[Period]=='4') {
											       $period= $PERIOD4;
 }
}
else {
 if ($rw5[Period]=='1') {
											       $period= $PERIOD1;
											    } else if ($rw5[Period]=='0') {
											       $period= $PERIOD0;
											    } else if ($rw5[Period]=='2') {
											       $period= $PERIOD2;
											    } else if ($rw5[Period]=='3') {
											       $period= $PERIOD3;
											    } else if ($rw5[Period]=='4') {
											       $period= $PERIOD4;
 }
}
echo $period;
?></td>
											<td align=center nowrap><?php  echo $rw5[Term]; ?></td>
											<td align=center nowrap><?php  echo $rw5[Year]; ?></td>

											<td align=center nowrap><?php  echo $rw5[CurrentClass]; ?></td>
											<td align=left ><?php  echo $rw5[DateTimeRegistered]; ?></td>
											<td><?php
											if ($rw5[Status] == "Dropped") {
											   echo "<font color=red>Dropped</font>";
											} else if ($rw5[CurrentClass]=='Yes') {
										       echo "<font color=green>OK</font>";
										    } else {
										       echo "Taken";
										    } ?>
										    </td>




										    <td>
											<?php  if ($rw5[CurrentClass]=='Yes' && $rw5[Status] != "Dropped") { ?>
										      <!--<a href="studentRegisterClassDropAsk.php?action=Drop&regid=<?php echo $rw5[ClassRegistrationID];?>&stuid=<?php echo $RSA1[MemberID];?>">Drop</a>-->

										     <?php } else {
										      //echo "&nbsp;";
										     } ?>
										    </td>

											</td>

										</tr>
										<?php } ?>



										<input type="hidden" name="Container">
										</form>
									</table>

								</td>
							</tr>

						</table>
					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>

		</td>
	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
