<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
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

  if ($RSA1[EmergencyFilled] != "Yes") {

    //header( 'Location: FamilyChildList.php' );
  //} else {
    header( 'Location: EmergencyContact.php' );
  }

  if ($RSA1[Waiver] != "Yes") {
    //header( 'Location: FamilyChildList.php' );
  //} else {
    header( 'Location: ParentsWaiver.php' );
  }
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Student List and Registered Classes</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
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
						//$SQLstring = "select * from viewClassStudents  where FamilyID=".$_SESSION['family_id'];

						$SQLstring = "select DISTINCT MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  "
						            ."where MB.FamilyID=".$_SESSION['family_id'];
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);

					?>
					<td align="center" valign="top">
						<table width="100%">
<!--							<tr>
								<td align="left"><a href="OpenSeats.php" >View Class Opening/Available Seats</a>
								                 <a href="FeePaymentVoucher.php">Print Payment Voucher</a>
								                 <a href="../accounting/familyAccountSummary.php">Billing Statement</a>
								</td>
							</tr> -->
							<tr>
								<td align="center"><font><b>Student List and Registered Classes</b></font></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td>
									<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">

										<tr align=center>
											<td>First<br>Name</td>
											<td>Last<br>Name</td>
											<td>Classes Registered<br>for <?php echo $SchoolYear; ?></td>
											<!--<td>Textbook<br> fee</td>-->
											<!--<td>Fee<br>Subtotal</td>-->

											<td>Action</td>
										</tr>
										<form action="EditStudentInfo.php" method="post">
										<?php
											$i=0;
											while($RSA1=mysqli_fetch_array($RS1))

										{ ?>
										<tr align=center>
											<td><a href="studentProfile.php?stuid=<?php echo $RSA1[MemberID];?>"><?php echo $RSA1[FirstName ];?></a></td>
											<td><?php echo $RSA1[LastName ];?></td>
											<td align=left nowrap>
											<?php // class registration
   $sql5 = "SELECT tblClass.ClassID, tblClass.ClassCode, tblClass.GradeOrSubject, tblClass.ClassNumber, tblClass.ClassFee,tblClass.Term,tblClass.Classroom,tblClass.Period,tblClass.IsLanguage 
											              FROM tblClassRegistration,tblClass
											             WHERE tblClassRegistration.StudentMemberID = '". $RSA1[MemberID] ."' AND tblClass.CurrentClass='Yes' AND tblClassRegistration.Status != 'Dropped'"
											                  . " AND tblClass.ClassID=tblClassRegistration.ClassID ORDER BY tblClass.GradeOrSubject, tblClass.ClassNumber";
											          //echo $sql5;

                                               // old (Fall) student?
											   $sql6 = "SELECT count(*) as  count
											              FROM tblClassRegistration,tblClass
											             WHERE tblClassRegistration.StudentMemberID = '". $RSA1[MemberID] ."' AND tblClass.Year='" .$LastYear. "' AND tblClass.Term ='". $LastTerm ."'"
											                  . " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped'";
											          //echo $sql6;
											          $rs6=mysqli_query($conn,$sql6);
													  $rw6=mysqli_fetch_array($rs6) ;
													  //$oldstudent=$rw6[count];

											          $fee = 0;
											          $feetxtbk=0;

													  $rs5=mysqli_query($conn,$sql5);
													while ( $rw5=mysqli_fetch_array($rs5) ) {
//													     echo "[".$rw5[ClassCode]."]".$rw5[GradeOrSubject].".".$rw5[ClassNumber ].' ('.$rw5[Term].", $".$rw5[ClassFee].", Room ".$rw5[Classroom] . ")<br>";
  echo "[".$rw5[ClassID]."]"."[".$rw5[ClassCode]."]".$rw5[GradeOrSubject].".".$rw5[ClassNumber ]." (";

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
echo $period;                                                                                                             echo ", ".$rw5[Term].", $".$rw5[ClassFee].", ".$rw5[Classroom].")<br>";

													     $fee += $rw5[ClassFee];


                                                      if ( $rw5[GradeOrSubject] == '1' ) {
													  	   $feetxtbk = 25;
													  }

													  $lvl = 0 + substr($rw5['GradeOrSubject'],0,2);
													  //echo "lvl: ".$lvl."<br>";
													  if ($lvl > 1 && $lvl < 13) {
													  	   $feetxtbk = 20;
													  }
													}
													if ( $rw6[count] > 0 && $CurrentTerm =="Spring") {
													   $feetxtbk = 0;
													}

                                                      if ( $fee <= 0 ) {
                                                        echo "<font color=red>NOT REGISTERED</font>";
                                                      }

                                             ?>
                                             <a href="studentClassesRegistered.php?stuid=<?php echo $RSA1[MemberID];?>">detail</a>

                                            &nbsp;</td>
                                            <!--<td>&nbsp; <?php
                                                   if ( $feetxtbk > 0 ) {
                                                     echo '$'. $feetxtbk;

                                                   } ?>
                                            </td>-->
                                            <!--<td>&nbsp; <?php
                                                   if ( $fee > 0 ) {

                                                     //echo '$'.($fee + $feetxtbk);
                                                     echo '$'.($fee + 0.0 );
                                                   } ?>
                                            </td>-->

												<input type="hidden" value="<?php echo $RSA1[MemberID ];?>"  name="SID<?php echo $i;?>">



										    <td><a href="studentProfile.php?stuid=<?php echo $RSA1[MemberID];?>">Update Profile</a><br><br>
										        <a href="studentRegisterClass.php?stuid=<?php echo $RSA1[MemberID];?>">Add/Switch/Drop Classes</a><br><br>
										        <a href="../classes/studentRegisterCamp.php?stuid=<?php echo $RSA1[MemberID];?>">Register Summer Camp</a>
										    </td>





										</tr>

										<?php
											$i++;
										} ?>

										<input type="hidden" name="Container">
										</form>
									</table>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align="center"><input type="button" value="Add A New Student " onClick="window.location.href='NewProfile.php?newmembertype=student'">
<!--								<input type="button" value="Done" onClick="window.location.href='MemberAccountMain.php'"> -->
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td align="left">Note: Don't forget to include the Annual Family Membership Fee and registration fee in your payment. Please print the Payment Voucher for more detail.</td>
							</tr>
							<tr>
								<td align="center"></td>
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
