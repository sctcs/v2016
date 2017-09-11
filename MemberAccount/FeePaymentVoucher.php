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
<title>Fee Payment Voucher</title>
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
		<td align="right">
		<a href="JavaScript:window.print();">Print</a>
<!--
		<a href="JavaScript:window.history.back();">Back</a>
		<a href="MemberAccountMain.php">My Account</a>
		<a href="FamilyChildList.php">Student List</a>
-->
		</td>
	</tr>

	<tr>
		<td>
		<?php //include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" bgcolor="">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="1%" align="center" valign="top">
						<table width="100%">

							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php


						$SQLstring = "select DISTINCT MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  "
						            ."where   MB.FamilyID=".$_SESSION['family_id'];
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);

						$SQLpc = "select *   from tblMember  where tblMember.FamilyID=".$_SESSION['family_id']." and PrimaryContact='Yes'";
						$RS2=mysqli_query($conn,$SQLpc);
						$RSA2=mysqli_fetch_array($RS2);

					?>
					<td align="center" valign="top">
						<table width="100%">
                            <tr>
									<td align="left"><?php echo date("m/d/Y"); ?></td>
							</tr>
							<tr>
								<td align="center">Payment Voucher</td>
							</tr>


							<tr>
								<td align="left">
								<?php echo $RSA2[FirstName]." ".$RSA2[LastName]."<br>";
								      echo $RSA2[HomeAddress]."<br>";
								      echo $RSA2[HomeCity].", ".$RSA2[HomeState]." ".$RSA2[HomeZip]."<br>";
								      echo "<b>Family ID: ". $_SESSION[family_id]. "</b>";
								?>
								<br><br>Dear Parent, <br><br>You have registered the following class(es):</td>
							</tr>
							<tr>
								<td>
									<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">

										<tr align=center>
											<td>ID</td>
											<td>Name</td>
											<td>Classes Registered<br>for <?php echo $SchoolYear; ?></td>
                                            <td>Book fee</td>
											<td>Subtotal</td>


										</tr>
										<form action="EditStudentInfo.php" method="post">
										<?php
										    $totalfee=0;
											$childcount=0;
											$hasoldstudent=0;
										while($RSA1=mysqli_fetch_array($RS1))
										{
										   //$oldstudent=0;

										?>
										<tr align=center>
											<td><?php echo $RSA1[MemberID];?></td>
											<td align="left"><?php echo $RSA1[LastName].", ".$RSA1[FirstName];?></td>
											<td align=left nowrap>
											<?php // class registration
$sql5 = "SELECT tblClass.ClassID, tblClass.ClassCode, tblClass.GradeOrSubject, tblClass.ClassNumber, tblClass.ClassFee,tblClass.Term, tblClass.Classroom,tblClass.Period,tblClass.IsLanguage 
											              FROM tblClassRegistration,tblClass
											             WHERE tblClassRegistration.StudentMemberID = '". $RSA1[MemberID] ."' AND tblClass.CurrentClass='Yes' AND tblClassRegistration.Status != 'Dropped'"
											                  . " AND tblClass.ClassID=tblClassRegistration.ClassID ORDER BY tblClass.Term,tblClass.GradeOrSubject, tblClass.ClassNumber";
											          //echo $sql5;

                                               // old student?
											   $sql6 = "SELECT count(*) as  count
											              FROM tblClassRegistration,tblClass
											             WHERE tblClassRegistration.StudentMemberID = '". $RSA1[MemberID] ."' AND tblClass.Year='" .$LastYear. "' AND tblClass.Term ='". $LastTerm."'"
											                  . " AND tblClass.ClassID=tblClassRegistration.ClassID ORDER BY tblClass.GradeOrSubject, tblClass.ClassNumber";
											          //echo $sql6;
											          $rs6=mysqli_query($conn,$sql6);
													  $rw6=mysqli_fetch_array($rs6) ;
													  //$oldstudent=$rw6[count];

											          $fee = 0;
											          $feetxtbk = 0;

													  $rs5=mysqli_query($conn,$sql5);
													  while ( $rw5=mysqli_fetch_array($rs5) ) {
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
echo $period;
													     echo ", ".$rw5[Term].", $".$rw5[ClassFee].", ".$rw5[Classroom].")<br>";

													     $fee += $rw5[ClassFee];

													     $lvl = 0 + substr($rw5['GradeOrSubject'],0,2);
													   //if ( $rw5[GradeOrSubject] =='1' || $rw5[GradeOrSubject] =='2') {
													     if ($lvl > 0 && $lvl < 4) {
													       $feetxtbk = $BOOKFEE1;

													     }
													     if ($lvl > 3 && $lvl < 13) {
													       $feetxtbk = $BOOKFEE2;

													     }

													     if ( $rw6[count] > 0 && $CurrentTerm == 'Spring' ) {
														 	  $feetxtbk = 0;
														 	  $hasoldstudent=1;
													     }
                                                      }

                                                      if ( $fee <= 0 ) {
                                                        echo "<font color=red></font>";
                                                      } else {
                                                        $childcount++;
                                                        $fees[$childcount] = $fee + $feetxtbk;
                                                        $totalfee += $fee + $feetxtbk;
                                                      }




                                             ?>
										    <!--	<td><?php echo $RSA1[GradeOrSubject].".".$RSA1[ClassNumber ];?></td> -->
											<!--<td><?php echo $RSA1[english_name ];?></td> -->
                                            &nbsp;</td>
                                           <td>&nbsp; <?php if ( $feetxtbk > 0 ) { echo '$'.$feetxtbk;} else { echo ""; } ?> </td>
                                            <td>&nbsp; <?php if ( $fee > 0 ) { echo '$'.($fee + $feetxtbk ); } else { echo ""; }  ?> </td>


												<input type="hidden" value="<?php echo $RSA1[MemberID ];?>"  name="SID<?php echo $i;?>">

											<!--	<input type="submit" value="Edit " onClick="sendme(<?php echo $i;?>);">

												 <td><input type="button"   onClick="window.location.href='MyProfile.php?whose=student&stuid=<?php echo $RSA1[MemberID];?>'" value="View/Edit/Register Class"></td>

											</td>-->

										</tr>

										<?php

										} //while

                                          $fmemberfee = 0;
										  if ( $hasoldstudent < 1) {
										      $fmemberfee = $MEMBERSHIP_FEE; // new family
										  } else {
										      $fmemberfee = 0; // old family
										  }

                                        // balance from last year
                                        $sql9 = "select charge.FamilyID,Receivable,Payment, Receivable-Payment Balance  from
(select  FamilyID, sum(Amount) Receivable from tblReceivable where DateTime < '".$PAST_BALANCE_DATE."' group by FamilyID) charge
left join
(select  sum(Amount) Payment, FamilyID from tblPayment where Date < '".$PAST_BALANCE_DATE."' group by FamilyID) pay
on charge.FamilyID=pay.FamilyID where charge.FamilyID=".$_SESSION[family_id];
											          $rs9=mysqli_query($conn,$sql9);
													  $rw9=mysqli_fetch_array($rs9) ;

$sql10="select  sum(Amount) Payment, FamilyID from tblPayment where Date >= '".$PAST_BALANCE_DATE."' ".
" and FamilyID=".$_SESSION[family_id].  " group by FamilyID";
//echo $sql10;
$rs10=mysqli_query($conn,$sql10);
$rw10=mysqli_fetch_array($rs10) ;
$paid4currentyear=$rw10[Payment];

$sql11="select  sum(Amount) Discount, FamilyID from tblReceivable where DateTime >= '".$PAST_BALANCE_DATE."' ".
" and FamilyID=".$_SESSION[family_id].  " and Amount<0 and ReceivableType != 'Registration'  group by FamilyID";
$rs11=mysqli_query($conn,$sql11);
$rw11=mysqli_fetch_array($rs11) ;
$disc4currentyear=$rw11[Discount];

$sql12="select  sum(Amount) Reg, FamilyID from tblReceivable where DateTime >= '".$PAST_BALANCE_DATE."' ".
" and FamilyID=".$_SESSION[family_id].  " and IncomeCategory='14' group by FamilyID";
$rs12=mysqli_query($conn,$sql12);
$rw12=mysqli_fetch_array($rs12) ;
$reg4currentyear=$rw12[Reg];

										    echo "<tr><td colspan=4 align=\"right\">$SchoolYear Family Membership Fee </td><td align=center>$". $fmemberfee ."</td></tr>";
										    echo "<tr><td colspan=4 align=\"right\">$SchoolYear Parent-Duty Deposit (Refundable)</td><td align=center>$". $PARENT_DUTY_FEE ."</td></tr>";
									//	    if ( $rw9[Balance] >= 0  ) {
										      echo "<tr><td colspan=4 align=\"right\">Outstanding Balance of past terms <br><a href=\"../accounting/familyAccountSummary.php?date=".$PAST_BALANCE_DATE."\">see Account Detail</a></td><td align=center>$". $rw9[Balance]  ."</td></tr>";
		      $total_due = ($totalfee + $fmemberfee + $reg4currentyear + $rw9[Balance] + $PARENT_DUTY_FEE );
									//	    } else {
									//	      $total_due = ($totalfee + $fmemberfee  +                $PARENT_DUTY_FEE ); // not to apply credit automatically
									//	    }

//								    echo "<tr><td colspan=4 align=\"left\">Registration Fee (payment received date is postmark day if by mail): <table><tr><td align=\"right\">pay before or on ".$EARLY_REG_DEADLINE.": </td><td> $EARLY_REG_FEE </td></tr><tr><td align=\"right\">after ".$EARLY_REG_DEADLINE." and before or on ".$REG_REG_DEADLINE.": </td><td> $REG_REG_FEE </td></tr><tr><td align=\"right\"> after ".$REG_REG_DEADLINE.": </td><td> $LATE_REG_FEE </td></tr></table></td><td>&nbsp;reg. fee</td></tr>";
										    echo "<tr><td colspan=4 align=\"left\">Registration Fee (payment received date is by postmark date if by mail): 
											<table>
											<tr><td align=\"right\">pay before or on <b>".$EARLY_REG_DEADLINE."</b>: </td><td> $EARLY_REG_FEE </td></tr>
											<tr><td align=\"right\">before or on <b>".$REG_REG_DEADLINE."</b>: </td><td> $REG_REG_FEE </td></tr>
											<tr><td align=\"right\"> after <b>".$REG_REG_DEADLINE."</b>: </td><td> $LATE_REG_FEE </td></tr>
											</table>
</td><td>reg fee:<br>$";
if ($reg4currentyear > 0) { echo $reg4currentyear; }
echo                            "</td></tr>";

//</td><td>reg fee:<br>".$EARLY_REG_FEE . " or " .$REG_REG_FEE . " or " . $LATE_REG_FEE ."</td></tr>";

echo "<tr><td colspan=4 align=\"right\">Total Due ";
if ($reg4currentyear == 0) { echo "<b>(This does not include the registration fee)</b>"; }

echo ": </td><td align=center>$". ($total_due                   ) ."  </td></tr>";
echo "<tr><td colspan=4 align=\"right\">Discount or Credit : </td><td align=center>$". ($disc4currentyear + 0.0) ."  </td></tr>";
echo "<tr><td colspan=4 align=\"right\">Paid since ".$PAST_BALANCE_DATE." : </td><td align=center>$". ($paid4currentyear + 0.0) ."  </td></tr>";
echo "<tr><td colspan=4 align=\"right\">Current Due: </td><td align=center>$". ($total_due + $disc4currentyear -  $paid4currentyear                  ) ." " ." </td></tr>";
echo "<tr><td colspan=4 align=\"right\">Actual amount in this payment: </td><td align=center>$" ."&nbsp;&nbsp;&nbsp;&nbsp; </td></tr>";


										  ?>





										<input type="hidden" name="Container">
										</form>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<!--
							<tr>
								<td align="center"><input type="button" value="Add A New Student " onClick="window.location.href='NewProfile.php?newmembertype=student'">
								<input type="button" value="Done" onClick="window.location.href='MemberAccountMain.php'">
								</td>
							</tr> -->

							 <!--
								<td align="left">In addition, the annual membership fee is $20 per family.<br><br>
							   -->
						    <tr><td>

 							<?php
 							  //if ( $childcount > 1) {
								//echo "You have registered ".$childcount." children, write a separate check for each child";
							  //if ( $hasoldstudent < 1) {
								//echo ", and add the $20 membership fee to the first check.";
							  //}
								//echo ". So you need to write ".$childcount." checks in the amount of ";
								//echo '$'.($fees[1] + 20) .", ";
								//for ($j=2;$j<=$childcount; $j++) {
								//  if ( $fees[$j] > 0){
								//   echo '$'.$fees[$j].", ";
								//  }
								//}
								//echo "respectively. ";
							 // } else {

							//	echo " Write one check, in total amount of ". '$'. ($fees[1] + 20 ) .". ";
							  //}

//                                echo " You can pay the total due in one payment or two payments. If in two payments, the first payment (due date $FIRST_PAYMENT_DUEDATE) should at least include all annual fees (membership and textbook), parent-duty deposit, and class tuition of Fall term. The second payment (due date $SECOND_PAYMENT_DUEDATE) should be for the class tuition of Spring term.<br><br>";
							echo "<p style='font-color: red; font-size: 130%;'>SCCS will not accept cash. We will ONLY accept checks!</b></p>"	;
                                                        echo " Make check payable to <b>". $SCHOOLNAME ."</b>.";
								echo " Mark on the check your family ID (".$_SESSION[family_id].") and student names. You can pay by one of the following methods:";

							  // if ( $childcount > 1) {
								//echo " Please mail the check(s) and this payment voucher to:<br><br>";
							   //}
							   ?>


							    <br><br>Method 1 (preferred): mail this payment voucher and a check to: <br><br>
                                <b> <?php echo $SCHOOL_PAY_ADDRESS_WEB; ?><br> </b>
								<br><br>Method 2: bring this payment voucher and check to school office on the first school day in Fall.



								<!-- <br><br>
								Your payment has to be received by <?php echo $LATE_REG_DEADLINE; ?> to avoid the late registration fee of $20 or by <?php echo $REG_REG_DEADLINE; ?> to avoid the regular registration fee of $10.
								-->
<br><br> Contact <a href="finance@ynhchineseschool.org">finance@ynhchineseschool.org</a> for any question regarding your payment.
								<br><br>
								Thank you for your support.
								<br><br>
								<?php echo $SCHOOLNAME; ?>
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
		<?php //include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

<?php
    mysqli_close($conn);
 ?>
