<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
 //echo "not logon yet";
if( ! isset($_SESSION['logon']))
{
    header( 'Location: MemberLoginForm.php?error=3' ) ;
	exit();
}
 //echo "role not set";
if( ! isset($_SESSION['membertype']))
{
    header( 'Location: MemberLoginForm.php?error=4' ) ;
	exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//echo "see family_id:  ".$_SESSION['family_id'];
//echo "see logon:  ".$_SESSION['logon'];
//echo "see useremail:  ".$_SESSION['useremail'];
//echo "see MemberTypes:  ".$_SESSION['MemberTypes'];
//echo $_SESSION['memberid'];
//echo "::";
//echo $_SESSION[memberid];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Account Main</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

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
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							<tr><td>
							<?php

							if(  isset($_SESSION['logon'])) {

							 $seclvl = $_SESSION['membertype'];
							 $secdesc= $_SESSION['MemberTypes'][$seclvl];
							 echo "You are now logged in as <font color='red'>".$secdesc."</font>.<br> ";
							 if (count($_SESSION['MemberTypes']) > 1)
							    echo "If you want to change to another role, click <a href=\"chooseRole.php\">here</a>.<br><br>";
							}
                            ?>
                            </td></tr>
							<tr>
								<td align="center"><font><b>Allowed Functions<br></b></font></td>
							</tr>
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>



							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">
										<tr>
											<td align="center" >
												<table>
													<tr>
														<td width="50%"><table>
														  <?php if ( $seclvl == 30 ) { // student ?>
															<tr>
																<td><a href="studentProfile.php?stuid=<?php echo $_SESSION['memberid']; ?>">My Profile</a></td>
															</tr>
														  <?php } else { ?>
															<tr>
																<td><a href="MyProfile.php">My Profile</a></td>
															</tr>
														  <?php } ?>

 							<!--<tr>
 								<td align="left" nowrap><a href="http://sites.google.com/site/ynhchineseschool/">Students Reward Token Redeem (??Ʒ?һ?)</a> </td>
 							</tr>-->

  <?php	if ($seclvl == 10 || $seclvl == 15 || $seclvl == 20 || $seclvl == 40 || $seclvl == 55 ) { ?>
            <tr><td><a href="../MemberAccount/MemberLookupForm.php">Member Lookup</a></td></tr>	
   <?php } ?> 
<!--
MemberType  SecurityLevel  
Principal 10 
Board Chairman 11 
PTA President 12 
Provost 15 
Database Administrator 20 
Student Point Manager 21 
Teacher 25 
Student 30 
Board Member 35 
School Administrator 40 
Treasurer 45 
Parent 50 
Collector 55 
Volunteer 60 
Former Student 65 
Former Member 70 
New Member 75 

 -->
                                                      <?php
														  if ($seclvl == 45 || $seclvl == 55) { ?>

														    <tr>
																<td><a href="../accounting/index.php">Payment Management</a></td>
															</tr>
															<tr>
																<td><a href="FeePaymentVoucher_byadmin.php?fid=2" target=_blank>Print Payment Voucher of a Family</a></td>
															</tr>
	                                                        <tr>
																<td nowrap><a href="../Registration/Registration_and_Refund_Policies.php" target="_blank">Registration and Refund Policies</a></td>
															</tr>

														    <tr>
																<td><a href="../classes/listallstudents.php?type=reg">Registered Students</a></td>
															</tr>

													<!--	    <tr>
																<td><a href="../Finance/FinanceFileListDetail.php">Finance Files</a></td>
															</tr> -->

														  <?php } if ($seclvl == 50) { ?>

															<tr>
																<td><a href="MyProfile.php?whose=spouse">Spouse Profile</a></td>
															</tr>

															<tr>
																<td nowrap><a href="FamilyChildList.php">Student List or Add a Student</a></td>
															</tr>

					                                        <tr>
																<td nowrap><a href="EmergencyContactParentEdit.php">Emergency Contact Information</a></td>
															</tr>
															<tr>
																<td><a href="../public/SCCS_safety_rules.pdf">Parent Agreement</a></td>
															</tr>

															<?php
															  $sql01="SELECT count(*) rcount FROM tblClassRegistration, tblMember,tblClass WHERE tblClassRegistration.StudentMemberID=tblMember.MemberID and tblMember.FamilyID=" . $_SESSION['family_id'] ." and tblClassRegistration.ClassID=tblClass.ClassID and tblClass.Year='". $CurrentYear. "' and tblClass.Term='". $CurrentTerm ."'";
															  $rs01=mysqli_query($conn,$sql01);
	                                                          $rw01=mysqli_fetch_array($rs01) ;
	                                                         ?>
	                                                        <tr>
																<td nowrap><a href="../Registration/Registration_and_Refund_Policies.php" target="_blank">Registration and Refund Policies</a></td>
															</tr>
																<tr>
																	<td><BR><a href="../Directory/Classes.php">Course Catalog or Class List</a></td>
															</tr>
 							<tr>
 								<td align="left" nowrap><a href="../Directory/detail_desc_on_courses.php" target=_blank>Course Description and Teacher's Background</a> </td>
 							</tr>


 							<tr>
 								<td align="left" nowrap><a href="OpenSeats.php" target=_blank>Class Opening/Available Seats</a> </td>
 							</tr>
<!--	                                                        <tr>
																<td nowrap><a href="../Curriculum/CourseDescription.htm" >Course Description</a></td>
															</tr>-->

															<tr>
																<td nowrap><a href="FamilyChildList.php">Register/Update/Drop Classes</a>
																<?php if ( $CurrentTerm == 'Fall' ) {
																      if ( $rw01[rcount] > 0 ) {
//																        echo " (<font color=red>Registered</font>)";
																      } else {
//																        echo " (<font color=red>Not Registered</font>)";
																      }
																 } ?>
																</td>
															</tr>

															<tr>
																<td><BR><a href="FeePaymentVoucher.php" target=_blank>Print Payment Voucher</a></td>
															</tr>
															<tr>
																<td><a href="../accounting/familyAccountSummary.php#balance">Billing and Payment History</a></td>
															</tr>
<!--
																<tr>
																	<td><a href="../classes/TeachingMaterialsListDetail.php">Teaching Material List</a></td>
															</tr>-->
																<tr> <td><BR><a href="../classes/HomeworkList.php">Homeworks</a></td> </tr>
<!--															<tr> <td><a href="ViewSafetyPatrol.php">My Safety Patrol Schedule</a></td> </tr>
-->
            <?php } if ($seclvl > 0) { ?>
																<tr>
																	<td><a href="../Curriculum/Curriculum.php">Curriculum</a></td>
															</tr> 

																<?php } if ($seclvl == 30) { ?>
																<tr>
																	<td><a href="../classes/HomeworkList.php">Homeworks</a></td>
															</tr>

														   <?php } if ($seclvl ==10 || $seclvl ==15 || $seclvl ==20) // pricipal, provost, dba
														   { ?>

															<tr>
																<td><a href="../classes/index.php">Class Management</a></td>
															</tr>
															<tr>
																<td><a href="../classes/TeacherList.php">Teacher Table Management</a></td>
															</tr>
															<tr>
																<td><a href="../classes/ClassList.php">Class Table Management</a></td>
															</tr>
                                                        <?php } if ($seclvl == 20) { ?>
															<tr>
																<td><a href="assignMemberRoles.php">Assign Member Roles</a></td>
															</tr>

			<tr>
																<td><a href="../accounting/index.php">Payment Management</a></td>
															</tr>

																<tr> <td><a href="ManageSafetyPatrol.php" target="_blank">Manage Safety Patrol Schedule</a></td> </tr>

			<?php } if ($seclvl == 25) { ?>

																<tr>
																	<td><a href="../classes/HomeworkList.php">Homeworks</a></td>
															</tr>
																<tr>
																	<td><a href="MyClasses_frame.php">My Class(es)</a></td>
															</tr>
																<tr>
																	<td><a href="../Directory/Classes.php">Course Catalog</a></td>
															</tr>
 							<tr>
 								<td align="left" nowrap><a href="OpenSeats.php" >View Class Opening/Available Seats</a> </td>
 							</tr>
																<tr>
																	<td><a href="../MemberAccount/TeacherDocument.php">Teacher Manual</a></td>
															</tr>

																<tr>
			
			<?php } if ($seclvl < 25 || $seclvl==55 || $seclvl==40 || $seclvl == 12) { ?>
																<tr>
																	<td><a href="../classes/HomeworkList.php">Homeworks</a></td>
															</tr>

																<tr>
																	<td><a href="../MemberAccount/TeacherDocument.php">Teacher Manual</a></td>
															</tr>

																<tr>
																	<td><a href="../Directory/Classes.php">Course Catalog</a></td>
															</tr>
																<tr>
																	<td><a href="../classes/listallstudents_by_term.php?type=reg&term=fall">Fall Student-Class List</a></td>
															</tr>
																<tr>
																	<td><a href="../classes/listallstudents_by_term.php?type=reg&term=spring">Spring Student-Class List</a></td>
															</tr>
																<tr>
																	<td><a href="MemberEmailListForm.php">Get Member Emails</a></td>
															</tr>
																<tr>
																	<td><a href="SchoolLeadershipDocument.php">School Policies and Documents for Leaders</a></td>
															</tr>

			</tr>
						<td><a href="../Activity/ActivityList.php">Manage School Activity</a></td>
															</tr>
 							<tr>
 								<td align="left" nowrap><a href="OpenSeats.php" >View Class Opening/Available Seats</a> </td>
 							</tr>

			<?php } if ($seclvl == 60) { ?>

																<tr>
																	<td><a href="../volunteering/index.php">Volunteer Management</a></td>
															</tr>

			<?php } if ($seclvl <=20 || $seclvl==35 || $seclvl==40) { ?>

																<tr>
																	<td><a href="../Files/filesList4Dir.php?directory=Logo">Logo Files</a></td>
															</tr>


			<?php } if ($seclvl==10 || $seclvl==11 || $seclvl==20) { ?>

																<tr>
																	<td><a href="../public/announceForm.php">Make an Announcement</a></td>
															</tr>
			<?php } if ($seclvl<=25 || $seclvl==40 || $seclvl==55) { ?>

																<tr>
																	<td><a href="../Files/Documents/Payment_Request.pdf" target="_blank">Payment Request Form</a></td>
															</tr>												
															
                        <?php } if ($_SESSION['logon'] != '') { ?>
                         <!--   <tr><td><a href="../accounting/payment_notice.php">Payment Reminder</a></td></tr> -->
	                                            <tr>
												<td><BR><a href="../Activity/ActivityListForMember.php">Register Activity</a>
												   <br><a href="SchoolPolicyDocument.php"">School Policies and Programs</a>
		                                    
		                                           
												<br><a href="EventCalendar.php">School Event Calendar</a>
<br><a href="../Activity/Election/2016/SCCSElectionMay2016.php">SCCS Election May 2016</a>
<br><a href="../Activity/Election/2016/SCCSElectionSep2016.php">Election of Board Director September 2016</a>
												</td>
												</tr>

			<?php } ?>																								</table>
														</td>
														<td width="50%">
															&nbsp;
														</td>
		 										</table>
											</td>
										</tr>

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
