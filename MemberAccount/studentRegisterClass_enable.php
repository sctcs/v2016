<?php
//ini_set('error_reporting', E_ALL);
//ini_set('display_errors', 'On');
//ini_set('display_startup_errors', 'On');

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
if(isset($_SESSION['family_id']))
{
   //echo "OK";
}
else
{
 header( 'Location: Logoff.php' ) ;
 exit();
}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);
$whose="student";

//echo $whose;

//exit();
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Register Classes</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
  <meta http-equiv="Expires" CONTENT="0">
  <meta http-equiv="Cache-Control" CONTENT="no-cache">
  <meta http-equiv="Pragma" CONTENT="no-cache">
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
<body>
<table  background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php //include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td >
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="0%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php // include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php
					$SQLstring = "select *   from tblMember left join tblEthnicity  on tblMember.Ethnicity=tblEthnicity.Ethnicity where tblMember.MemberID=".$_GET['stuid'];

                          // primary contact parent
						  $SQLparent = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND MB.PrimaryContact='Yes' AND MB.FamilyID=".$_SESSION['family_id'] ." LIMIT 1";
						  $RSp=mysqli_query($conn,$SQLparent);
						  $RSAp=mysqli_fetch_array($RSp);


						//echo "see111: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						$RSA1=mysqli_fetch_array($RS1);
					?>
					<td align="center" valign="top">
						<table width="100%">
 							<tr>
								<td align="left"><a href="FamilyChildList.php">[Student List]
								                 <a href="FeePaymentVoucher.php">[Print Payment Voucher]</a>
								                 <a href="studentClassesRegistered.php?stuid=<?php echo $RSA1[MemberID]; ?>">[Registered Classes]</a>
								                 <a href="studentProfile.php?stuid=<?php echo $RSA1[MemberID];?>">[Update Profile]</a>
								</td>
							</tr>





       
							<tr><td>&nbsp;</td></tr>
							<tr><td align="center"><font color="red">Class Registration for <?php echo " $SchoolYear"; ?></font><hr></td></tr>
							</td>
							</tr>


	
		
                    
							<tr>
								<td >
									<table >

										<form name="NewMember" action="studentRegisterClassUpdate.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="updtmemberid" value="<?php echo $RSA1[MemberID];?>">
                                        <input type="hidden" name="whose" value="<?php echo $whose;?>">
<!--
										<tr>
											<td width="50%" align="Right">MemberID: </td>
											<td width="50%" align="Left">&nbsp;<?php echo $RSA1[MemberID];?></td>
										</tr>
										<tr>
											<td width="50%" align="Right">FamilyID: </td>
											<td width="50%" align="left">&nbsp;<?php echo $RSA1[FamilyID];?></td>
										</tr>

-->
										<tr>
											<td width="50%" align="left">Student Name:&nbsp;<?php echo $RSA1[FirstName];?> 
&nbsp;<?php echo $RSA1[LastName];?></td>

										</tr>
<!--
                                        <tr>
											<td width="50%" align="Right">Chinese Name:</td><td>&nbsp;<?php echo $RSA1[ChineseName];?></td>
										</tr>
                                        <tr>
											<td width="50%" align="Right">Date of Birth:</td><td>&nbsp;<?php echo $RSA1[DateOfBirth];?></td>
										</tr>
-->
									<?php

//                                     $age = (strtotime($FIRST_CLASS_DATE) - strtotime($RSA1[DateOfBirth]) ) / (60 * 60 * 24 * 365);
$age=6;
                                       if ( $age < $AGE_TO_START ) {
                                         echo "<tr><td><br><br>";
                                         echo "<font color=red>  ". $RSA1[FirstName] ." is still younger than 6 years old by ". $FIRST_CLASS_DATE. ", too young to start school at SCCS. Please try again next year.</font>";
                                         echo "</td></tr></table>";
					mysqli_close($conn);
					exit;

                                       }
                                     



										  $sql="select FirstRegistrationDate,StartingLevel,PrimaryHomeLanguage,NumChSpeakParents,StudentType,StudentStatus,PreferredClassLevel,PreferredExtraClass1,PreferredExtraClass2 from tblStudent where MemberID=".$_GET['stuid'];
										  $sql1="select tblClass.GradeOrSubject,tblClass.ClassNumber from tblClassRegistration,tblClass"
										  		."  where tblClassRegistration.ClassID=tblClass.ClassID AND tblClassRegistration.Status != 'Dropped' "
										  		."  AND tblClassRegistration.StudentMemberID=".$_GET['stuid'] ." and tblClass.Term='".$LastTerm ."' and tblClass.Year='".$LastYear
										  		."' AND tblClass.IsLanguage='Yes' ";

										 
								$rs=mysqli_query($conn,$sql);
						                  $rw=mysqli_fetch_array($rs);


$sql_pec1 = "SELECT distinct ClassID, GradeOrSubject, ClassNumber, Period, Seats from tblClass WHERE IsLanguage ='Yes' and CurrentClass='Yes' and Term='".$CurrentTerm."' and Year='".$CurrentYear."' order by GradeOrSubject";
								$rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql6 = "SELECT tblClass.ClassID, tblClass.Period, tblClass.GradeOrSubject,tblClass.ClassNumber
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.IsLanguage='Yes' "
                                                       . " AND tblClass.CurrentClass='Yes'"
                                                       . " AND tblClass.Term='".$CurrentTerm."' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid]." limit 1";
                                                 if ($DEBUG) { echo "<tr><td>$sql6</td><td></td><tr>"; }
		                                         $rs6=mysqli_query($conn,$sql6);
		                                         $rw6=mysqli_fetch_array($rs6);
                                                 $sql62 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.IsLanguage='Yes' "
                                                       . " AND tblClass.CurrentClass='Yes'"
                                                       . " AND tblClass.Term='".$NextTerm."' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid]." limit 1";
		                                         $rs62=mysqli_query($conn,$sql62);
		                                         $rw62=mysqli_fetch_array($rs62);


                                               // old student?
						$sql7 = "SELECT count(*) as  count
							FROM tblClassRegistration,tblClass
							WHERE tblClassRegistration.StudentMemberID = '". $_GET[stuid] ."' AND tblClass.Year='" .$LastYear. "' AND tblClass.Term !='". $LastTerm."'"
							. " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped'";
							//echo $sql7;
							$rs7=mysqli_query($conn,$sql7);
							$rw7=mysqli_fetch_array($rs7) ;
							//$oldstudent=$rw7[count];

							// seats taken for all classes

                                                 $sql71 = "SELECT count(*) count, tblClass.ClassID
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID  "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " GROUP by tblClass.ClassID";
                                                 //echo $sql71."<br>";

		                                         $rs71=mysqli_query($conn,$sql71);
		                                         while ($rw71=mysqli_fetch_array($rs71) ){
		                                            $seats_taken[$rw71[ClassID]]=$rw71[count];
		                                         }


										  $rs1=mysqli_query($conn,$sql1);
										  $prev_level = 0;
										  $oldstudent='no';
										  $newlevel='';
										  $newclass='';
						                  while ( $rw1=mysqli_fetch_array($rs1) ) {
                                             $prev_levels =$rw1['GradeOrSubject'];
                                             if ( $prev_levels > 0 && $prev_levels < 13 ) {
                                                $prev_level = $prev_levels;
                                                $oldstudent='yes';
                                                $newlevel = $rw6[GradeOrSubject];
                                                if ( $newlevel == 0 || $newlevel =='' ) {
                                                    $newlevel = $prev_level + 1;
                                                }
                                                $newclass = $rw1[ClassNumber]; // same as last year
                                              //  if ( $prev_level == '1' && $newclass == '4' ) { // 1.4 -> 2.3
                                              //    $newclass = '3';
                                              //  } else if ( $prev_level == '6' && $newclass == '2' ) { // 6.2 -> 7.1
                                              //    $newclass = '1';
                                              //  }

                                             }
                                          } // end while

                                          if ( $rw7[count] > 0 ) {
                                          		$oldstudent='yes';
                                          }
                                                if ($rw6[ClassNumber] != "" ) {
                                                   $newclass = $rw6[ClassNumber];
                                                }

                                          $pref_level = $rw6[GradeOrSubject];
                                          if ( $pref_level == 0 || $pref_level =='' ) {
                                           $pref_level = $prev_level + 1;
                                          }
				?>

                                  <!--      <tr><td><?php echo $sql1; ?></td><td></td><tr> -->

										<tr>
<!--							<td width="50%" align="Right">Primary Home Language:</td> -->
											<?php if ( isset($rw['PrimaryHomeLanguage']) && $rw['PrimaryHomeLanguage'] == "Chinese" ) {
											         $PrimLang = "Chinese";
											      } else if ( isset($rw['PrimaryHomeLanguage']) && $rw['PrimaryHomeLanguage'] == "English" ) {
											         $PrimLang = "English";
											      } else if ( isset($rw['PrimaryHomeLanguage']) && $rw['PrimaryHomeLanguage'] == "Other" ) {
											         $PrimLang = "Other";
											      }
											?>
<!--							<td>&nbsp;<?php echo  "$PrimLang";?></td> -->
										</tr>
<!--
                                        <tr>
											<td width="50%" align="Right">Chinese Speaking Parents<font color="#FF0000"></font>:</td>
-->
										    <?php	if ( $rw[NumChSpeakParents] == 0 ) {
											    $none="checked";
											    $one="";
											    $both="";
											    $num="None";
											} else if ( $rw[NumChSpeakParents] == 1 ){
											    $none="";
											    $one="checked";
											    $both="";
											    $num="One";
											} else if ( $rw[NumChSpeakParents] == 2 ){
											    $none="";
											    $one="";
											    $both="checked";
											    $num="Both";
											} else {
											    $none="";
											    $one="";
											    $both="checked";
											    $num="Both";
											} ?>
											<input type="hidden" name="NumChSpeakParents" value="<?php echo $rw[NumChSpeakParents];?>">
<!--
										    <td>&nbsp;<?php echo $num;?></td>
										</tr>
										<tr><td align="Right"><hr></td><td><hr></td></tr>
##################### CHINESE CLASS:
-->
							<tr><td>&nbsp;</td></tr>

<tr><td colspan=2> [1]      Chinese Language Class: </td></tr>
<!--
										<tr>
											<td width="30%" align="Right">Previous Grade Level</td>
											<td>

											<select name="StartingLevel">

										     <?php for ($i=0;$i<=12;$i++) {


											       if ( isset($prev_level) && $prev_level == $i ) {
											         echo "<option SELECTED value=\"".$i."\">".$i."</option>\n";
                                                   } else if (  $prev_level == $i ) {
											         echo "<option SELECTED value=\"".$i."\">".$i."</option>\n";
											       } else {
											         echo "<option value=\"".$i."\">".$i."</option>\n";
											       }
                                              } ?>
											</select><?php //echo $oldstudent.$sql1; ?>
											</td>
										</tr>
-->
										<tr>
									<?php if ($oldstudent == 'YES') { // old student ?>

											<td width="30%" align="Right"><?php echo "$SchoolYear"; ?> Grade Level</td>
					       			<?php		if ( $rw6[GradeOrSubject] != "" ) { ?>
											<td>
											<?php if (isset($newlevel) && $newlevel !="") { ?>
											   <input type="text" name="PreferredClassLevel" value="<?php echo $newlevel; ?>" size=3 >
											<?php } else { ?>
											   <input type="text" name="PreferredClassLevel" value="<?php echo $rw6['GradeOrSubject']; ?>" size=3 >
											<?php } 
										} else { ?>
											<td>
											<?php if (isset($newlevel) && $newlevel !="") { ?>
											   <input type="text" name="PreferredClassLevel" value="<?php echo $newlevel; ?>" size=3 >
											<?php } else { ?>
											   <input type="text" name="PreferredClassLevel" value="<?php echo $rw6['GradeOrSubject']; ?>" size=3 >
											<?php } 
 										} ?>

											<input type="hidden" name="oldstudent" value="yes">
											<input type="hidden" name="newclass" value="<?php echo $newclass;?>">

                                               <?php				
									  } else 
                                      { // end old, start new student ?>
											<input type="hidden" name="oldstudent" value="no">
											<input type="hidden" name="newclass" value="<?php echo $newclass;?>">

											<td width="50%" align="Right"><?php echo ""; ?> &nbsp; </td>
											
											<td>
  
											<select name="PreferredClassLevel" >


                                                                            <option value="0">0 (will not take any)</option>
									    <?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
											$classnumber   = $rw_pec1[ClassNumber];
									        $period  = $rw_pec1[Period];
											$openseats = $rw_pec1[Seats] - $seats_taken[$classid];
                                                                                if ($period == "1") { $period_time = $PERIOD1." and ".$PERIOD2; }
                                                                                if ($period == "2") { $period_time = $PERIOD2." and ".$PERIOD3; }
                                                                                if ($period == "3") { $period_time = $PERIOD3." and ".$PERIOD4; }
                                                                                if ($period == "4") { $period_time = $PERIOD4; }
									     
										 if ( isset($rw6['ClassNumber']) && $rw6['ClassNumber'] == $classnumber &&
										      isset($rw6['GradeOrSubject']) && $rw6['GradeOrSubject'] == $grade ) { ?>
											  <option value="<?php echo $grade.".".$classnumber; ?>" SELECTED><?php echo $grade.".".$classnumber . " (". $period_time.")"."(seats available ". ($openseats) . ")"; ?></option>
											<?php
						//				 } else if (   $pref_level == $grade ) {
						//					        echo "<option SELECTED value=\"".$grade."\">".$grade." (".$period_time.")</option>\n";
										 } else { 
										   if ( $openseats > 0 ) { ?>
											  <option value="<?php echo $grade.".".$classnumber; ?>"><?php echo $grade.".".$classnumber." (".$period_time.")"."(seats available ". ($openseats) . ")"; ?></option>
										<?php } }
									    } ?>
											</select>
									<?php } // end new student ?>

											<input type="hidden" name="PreferredClassLevelOld" value="<?php echo $rw6['GradeOrSubject'].".".$rw6[ClassNumber];?>">
											<input type="hidden" name="PreferredClassIDOld1" value="<?php echo $rw6['ClassID'];?>">
											<input type="hidden" name="PreferredClassIDOld2" value="<?php echo $rw62['ClassID'];?>">
											<input type="hidden" name="PreferredClassPeriod" value="<?php echo $rw6['Period'];?>">
											 <?php
											   //echo $sql6;
					       if ( $rw6[GradeOrSubject] != "" ) {
											    echo "&nbsp;Class <b>". $rw6[GradeOrSubject].".".$rw6[ClassNumber] ."</b>,&nbsp; ";
   							if ( $rw6[Period] == "1" ) {
								echo $PERIOD1 . " and ". $PERIOD2;
                                                        } else if ( $rw6[Period] == "2" ) {
								echo $PERIOD2 . " and ". $PERIOD3;
                                                        } else if ( $rw6[Period] == "3" ) {
								echo $PERIOD3 . " and ". $PERIOD4;
 							}
                                               } 

//################################################################################################################################# END LANGUAGE.

                                              ?>
											</td>
										</tr>
										<tr><td>&nbsp;</td></tr>
<tr><td colspan=2> [2]      <?php echo "$CurrentTerm $CurrentYear"; ?> Enrichment Classes (<font color=red>Do NOT pick enrichment programs that conflict with Chinese classes</font>):</td></tr>

										<tr>
											<td width="20%" align="center"> Enrichment 0 (<?php echo $PERIOD0; ?>):</td>
											<td nowrap>

											<select name="FallPreferredExtraClass0">

											<?php
$sql_pec0 = "SELECT * from tblClass WHERE Period = '0' and IsLanguage='No' and CurrentClass='Yes' and Term='".$CurrentTerm."' and Year='".$CurrentYear."' order by GradeOrSubject";
											     $rs_pec0=mysqli_query($conn,$sql_pec0);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='0' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Fall' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);


						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec0=mysqli_fetch_array($rs_pec0) ) {
									        $classid = $rw_pec0[ClassID];
									        $grade   = $rw_pec0[GradeOrSubject];
									        $class   = $rw_pec0[ClassNumber];
									        $openseats = $rw_pec0[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											//}
									     } ?>

											 </select>
											 <input type="hidden" name="FallPreferredExtraClass0Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>
										<tr>
											<td width="20%" align="center"> Enrichment 1 (<?php echo $PERIOD1; ?>):</td>
											<td nowrap>

											<select name="FallPreferredExtraClass1">

											<?php
$sql_pec1 = "SELECT * from tblClass WHERE Period = '1' and IsLanguage='No' and CurrentClass='Yes' and Term='".$CurrentTerm."' and Year='".$CurrentYear."' order by GradeOrSubject";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='1' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Fall' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);


						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        $class   = $rw_pec1[ClassNumber];
									        $openseats = $rw_pec1[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											//}
									     } ?>

											 </select>
											 <input type="hidden" name="FallPreferredExtraClass1Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>

										<tr>
											<td width="30%" align="center"> Enrichment 2 (<?php echo $PERIOD2; ?>):</td>
											<td>

											<select name="FallPreferredExtraClass2">

											  <?php
$sql_pec2 = "SELECT * from tblClass WHERE Period = '2' and IsLanguage='No' and CurrentClass='Yes' and Term='".$CurrentTerm."' and Year='".$CurrentYear."' order by GradeOrSubject";
											  	$rs_pec2=mysqli_query($conn,$sql_pec2);

                                                 $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats "
                                                       ."     FROM tblClassRegistration,tblClass"
                                                       ."    WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='2' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Fall' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql8."<br>";

		                                         $rs8=mysqli_query($conn,$sql8);
		                                         $rw8=mysqli_fetch_array($rs8);

						                         ?>

											<?php if ( !isset($rw8['ClassID']) || $rw8['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>

									<?php while ( $rw_pec2=mysqli_fetch_array($rs_pec2) ) {
									        $classid = $rw_pec2[ClassID];
									        $grade   = $rw_pec2[GradeOrSubject];
									        $class   = $rw_pec2[ClassNumber];
									        $openseats = $rw_pec2[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw8['ClassID']) && $rw8['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											//}
									     } ?>


											 </select>
											 <input type="hidden" name="FallPreferredExtraClass2Old" value="<?php echo $rw8['ClassID'];?>">
											 <?php
											   //echo $sql8;
											   if ( $rw8[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw8[GradeOrSubject].".".$rw8[ClassNumber] ;  ?></b>)
-->
                                             <?php } ?>

											</td>
										</tr>

										<tr>
											<td width="20%" align="center"> Enrichment 3 (<?php echo $PERIOD3; ?>):</td>
											<td nowrap>

											<select name="FallPreferredExtraClass3">

											<?php
$sql_pec1 = "SELECT * from tblClass WHERE Period = '3' and IsLanguage='No' and CurrentClass='Yes' and Term='".$CurrentTerm."' and Year='".$CurrentYear."' order by GradeOrSubject";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='3' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Fall' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);


						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        $class   = $rw_pec1[ClassNumber];
									        $openseats = $rw_pec1[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											//}
									     } ?>

											 </select>
											 <input type="hidden" name="FallPreferredExtraClass3Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>



										<tr>
											<td width="20%" align="center"> Enrichment 4 (<?php echo $PERIOD4; ?>):</td>
											<td nowrap>

											<select name="FallPreferredExtraClass4">

											<?php
$sql_pec1 = "SELECT * from tblClass WHERE Period = '4' and IsLanguage='No' and CurrentClass='Yes' and Term='".$CurrentTerm."' and Year='".$CurrentYear."' order by GradeOrSubject";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='4' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Fall' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);


						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        $class   = $rw_pec1[ClassNumber];
									        $openseats = $rw_pec1[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											//}
									     } ?>

											 </select>
											 <input type="hidden" name="FallPreferredExtraClass4Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>
<tr><td>&nbsp;</td></tr>
<!--
//################################################################################################################################# END FALL ENRICHMENT.
-->
<tr><td colspan=2> [3]      <?php echo "$NextTerm $NextYear"; ?> Enrichment Classes (<font color=red>Do NOT pick enrichment programs that conflict with Chinese classes</font>):</td></tr>
										<tr>
											<td width="30%" align="center"> Enrichment 0 (<?php echo $PERIOD0; ?>):</td>
											<td nowrap>

											<select name="SpringPreferredExtraClass0">

											<?php

$sql_pec0 = "SELECT * from tblClass WHERE Period = '0' and IsLanguage='No' and CurrentClass='Yes' and Term='".$NextTerm."' and Year='".$NextYear."' order by GradeOrSubject";
											     $rs_pec0=mysqli_query($conn,$sql_pec0);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='0' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Spring' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);



						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec0=mysqli_fetch_array($rs_pec0) ) {
									        $classid = $rw_pec0[ClassID];
									        $grade   = $rw_pec0[GradeOrSubject];
									        $class   = $rw_pec0[ClassNumber];
									        $openseats = $rw_pec0[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
										//	}
									     } ?>

											 </select>
											 <input type="hidden" name="SpringPreferredExtraClass0Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>
										<tr>
											<td width="30%" align="center"> Enrichment 1 (<?php echo $PERIOD1; ?>):</td>
											<td nowrap>

											<select name="SpringPreferredExtraClass1">

											<?php

$sql_pec1 = "SELECT * from tblClass WHERE Period = '1' and IsLanguage='No' and CurrentClass='Yes' and Term='".$NextTerm."' and Year='".$NextYear."' order by GradeOrSubject";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='1' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Spring' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);



						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        $class   = $rw_pec1[ClassNumber];
									        $openseats = $rw_pec1[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
										//	}
									     } ?>

											 </select>
											 <input type="hidden" name="SpringPreferredExtraClass1Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>

										<tr>
											<td width="30%" align="center"> Enrichment 2 (<?php echo $PERIOD2; ?>):</td>
											<td>

											<select name="SpringPreferredExtraClass2">

											  <?php
$sql_pec2 = "SELECT * from tblClass WHERE Period = '2' and IsLanguage='No' and CurrentClass='Yes' and Term='".$NextTerm."' and Year='".$NextYear."' order by GradeOrSubject";
											  	$rs_pec2=mysqli_query($conn,$sql_pec2);

                                                 $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='2' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Spring' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql8."<br>";

		                                         $rs8=mysqli_query($conn,$sql8);
		                                         $rw8=mysqli_fetch_array($rs8);

						                         ?>

											<?php if ( !isset($rw8['ClassID']) || $rw8['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>

									<?php while ( $rw_pec2=mysqli_fetch_array($rs_pec2) ) {
									        $classid = $rw_pec2[ClassID];
									        $grade   = $rw_pec2[GradeOrSubject];
									        $class   = $rw_pec2[ClassNumber];
									        $openseats = $rw_pec2[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw8['ClassID']) && $rw8['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
										//	}
									     } ?>


											 </select>
											 <input type="hidden" name="SpringPreferredExtraClass2Old" value="<?php echo $rw8['ClassID'];?>">
											 <?php
											   //echo $sql8;
											   if ( $rw8[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw8[GradeOrSubject].".".$rw8[ClassNumber] ;  ?></b>)
-->
                                             <?php } ?>

											</td>
										</tr>

										<tr>
											<td width="30%" align="center"> Enrichment 3 (<?php echo $PERIOD3; ?>):</td>
											<td nowrap>

											<select name="SpringPreferredExtraClass3">

											<?php

$sql_pec1 = "SELECT * from tblClass WHERE Period = '3' and IsLanguage='No' and CurrentClass='Yes' and Term='".$NextTerm."' and Year='".$NextYear."' order by GradeOrSubject";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='3' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Spring' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);



						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        $class   = $rw_pec1[ClassNumber];
									        $openseats = $rw_pec1[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
										//	}
									     } ?>

											 </select>
											 <input type="hidden" name="SpringPreferredExtraClass3Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>

										<tr>
											<td width="30%" align="center"> Enrichment 4 (<?php echo $PERIOD4; ?>):</td>
											<td nowrap>

											<select name="SpringPreferredExtraClass4">

											<?php

$sql_pec1 = "SELECT * from tblClass WHERE Period = '4' and IsLanguage='No'  and CurrentClass='Yes' and Term='".$NextTerm."' and Year='".$NextYear."' order by GradeOrSubject";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='4' and IsLanguage='No' "
                                                       . " AND tblClass.CurrentClass='Yes' AND tblClass.Term='Spring' AND tblClassRegistration.Status != 'Dropped'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
                                                 //echo $sql7."<br>";

		                                         $rs7=mysqli_query($conn,$sql7);
		                                         $rw7=mysqli_fetch_array($rs7);



						                     ?>

											<?php if ( !isset($rw7['ClassID']) || $rw7['ClassID'] == "" ) { ?>
											  <option value="" SELECTED>NO (will not take any)</option>
											<?php } else { ?>
											  <option value="">NO (will not take any)</option>
											<?php } ?>
									<?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        $classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        $class   = $rw_pec1[ClassNumber];
									        $openseats = $rw_pec1[Seats] - $seats_taken[$classid];
									        //if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo "[$classid] $grade (seats available ". ($openseats) . ")"; ?></option>
											<?php }
										//	}
									     } ?>

											 </select>
											 <input type="hidden" name="SpringPreferredExtraClass4Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
<!--
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
-->
                                             <?php } ?>
											</td>
										</tr>

										<tr><td align="Right">&nbsp;</td><td>&nbsp;</td></tr>
<!--
//################################################################################################################################# END SPRING ENRICHMENT.
-->

											<tr><td align="right">
												<input type="submit" value="Update">
											</td>
											<td align="left">
												<input type="button" width="18"  onClick="window.location.href='FamilyChildList.php'" value="Cancel">
											</td></tr>
<tr><td colspan=2><hr></td></tr>
															<tr>
																<td align="right"><a href="OpenSeats.php" >View Class Opening/Available Seats</a>
																<td  align="center">
																<!--<a href="http://classes.yale.edu/chns130/chineseschool/">Course Description</a>-->
																<a href="../Curriculum/CourseDescription.htm">Course Description</a>
																</td>

																</td>
															</tr>

							<!--			<tr><td align="Right"><hr></td><td><hr></td></tr>   -->
									



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
		<?php //include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>

<hr>
<?php echo $REGISTRATION_TIPS; ?>
<br>
<?php echo $REGISTRATION_POLICIES; ?>

</body>
</html>

<?php
    mysqli_close($conn);
 ?>
