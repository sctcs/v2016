<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();
if($_GET[whose] == "student" )
{
  header( 'Location: studentProfile.php?stuid='.$_GET[stuid] ) ;
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

if ( $_GET[whose] == "spouse") {
	$SQLstring = "SELECT count(*) as cnt FROM `tblMember`,tblLogin WHERE tblMember.MemberID=tblLogin.MemberID and FamilyID=".$_SESSION['family_id']." and MemberTypeID=15 and tblLogin.MemberID != ".$_SESSION['memberid'];
    $RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
	if ( $RSA1[cnt] <= 0 ) {
	   header('Location: NewProfile.php?newmembertype=spouse');
	}
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Member Profile</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
</head>
<script language="JavaScript">
function SSAutoTab(input, Gnext, len, e)
	{
		if(input.value.length >= len )
		{
			if (eval("document.all."+Gnext))
			{
				eval("document.all."+Gnext).focus();
			}

		}
	}


function displayme(which)
	{
		if (which =='NewStudentLine')
		{
			document.all('NewStudentLine').style.display = "";
			document.all('ReturnStudentLine').style.display = "none";
			//document.all('returingcusotmer').style.display = "none";
			//alert("OK1");
		}
		else if (which=='ReturnStudentLine')
		{
			document.all('ReturnStudentLine').style.display = "";
			document.all.NewStudentLine.style.display = "none";

		}
		else if (which=='ArtClassSelect')
		{
			if (document.all.ArtChoose[0].checked ==true)
			{ 	document.all('ArtClassSelect').style.display = ""; }
			else if (document.all.ArtChoose[1].checked ==true)
			{document.all('ArtClassSelect').style.display = "none";}

		}
		else if (which=='VolunteerLine'  )
		{
			if ( document.all.volunteer.value== 4 )
			{ document.all('VolunteerLine').style.display = ""; }
			else
			{document.all.VolunteerLine.style.display = "none"; }

		}


	}

</script>
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
					<td width="0%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php // include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php
						//$SQLstring = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND  MB.FamilyID=".$_SESSION['family_id'];
						if ( $_GET[whose] == "spouse") {
						  //$SQLstring = "select MB.*   from tblMember MB where MB.MemberID !=".$_SESSION['memberid']. " and FamilyID=".$_SESSION['family_id'];;
						  $SQLstring = "SELECT * FROM `tblMember`,tblLogin WHERE tblMember.MemberID=tblLogin.MemberID and FamilyID=".$_SESSION['family_id']." and MemberTypeID=15 and tblLogin.MemberID != ".$_SESSION['memberid'];
						} else if ( $_GET[whose] == "student") {
						  $SQLstring = "select *   from tblMember left join tblEthnicity  on tblMember.Ethnicity=tblEthnicity.Ethnicity where tblMember.MemberID=".$_GET['stuid'];

                          // primary contact parent
						  $SQLparent = "select MB.*   from tblMember MB INNER JOIN tblLogin Login ON MB.MemberID = Login.MemberID  where Login.MemberTypeID =15 AND MB.PrimaryContact='Yes' AND MB.FamilyID=".$_SESSION['family_id'] ." LIMIT 1";
						  $RSp=mysqli_query($conn,$SQLparent);
						  $RSAp=mysqli_fetch_array($RSp);

						} else {
						  $SQLstring = "select MB.*   from tblMember MB where MB.MemberID=".$_SESSION['memberid'];
						}

						//$SQLstring = "select *  from tblMember where PrimaryContact='Yes' and FamilyID=".$_SESSION['family_id'];

						//echo "see111: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						$RSA1=mysqli_fetch_array($RS1);
						//$family_id=$RSA1[family_id];
						//$MemberType=$RSA1[MemberType];
						//echo "<br>see: ".$RSA1[HomePhone];

						$PhoneArrary=explode("-",$RSA1[HomePhone]);
						//$x=$PhoneArrary[0];
						//echo "<br>see22: ".$PhoneArrary[0];
						$CPhoneArrary=explode("-",$RSA1[CellPhone ]);
                        $OPhoneArrary=explode("-",$RSA1[OfficePhone]);

                        if (strlen($RSA1[DateOfBirth])>0) {
							list($y,$m,$d)=explode("-",$RSA1[DateOfBirth]);
							$dob=$m."/".$d."/".$y;
							if ( $dob == "00/00/0000" ) {
							   $dob="01/01/2002";
							}
						}
					?>
					<td align="center" valign="top">
						<table width="100%">
                        <?php if ( $_GET[whose] == "spouse") { ?>
							<tr>
								<td align="center"><font><b>Spouse Profile</b></font></td>
							</tr>
                        <?php } else if ( $_GET[whose] == "student") { ?>
							<tr>
								<td align="center"><font><b>Student Profile</b></font></td>
							</tr>
 							<tr>
								<td align="left"><a href="FamilyChildList.php">[Back to Childlist]
								                 <a href="FeePaymentVoucher.php">[Print Payment Voucher]</a>
								</td>
							</tr>
                        <?php } else { ?>
							<tr>
								<td align="center"><font><b>My Profile</b></font></td>
							</tr>
                        <?php } ?>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form name="NewMember" action="UpdateMyProfile.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="updtmemberid" value="<?php echo $RSA1[MemberID];?>">
                                        <input type="hidden" name="whose" value="<?php echo $_GET[whose];?>">

										<tr>
											<td width="50%" align="Right">MemberID: </td>
											<td width="50%" align="Left"><?php echo $RSA1[MemberID];?></td>
										</tr>
										<tr>
											<td width="50%" align="Right">FamilyID: </td>
											<td width="50%" align="left"><?php echo $RSA1[FamilyID];?></td>
										</tr>


										<tr>
											<td width="50%" align="Right">First Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCFristName" disabled="disabled" value="<?php echo $RSA1[FirstName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Last Name<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="PCLastName" disabled="disabled" value="<?php echo $RSA1[LastName];?>"></td>
										</tr>
                                        <tr>
											<td width="50%" align="Right">Chinese Name<font color="#FF0000"></font></td>
											<td><input type="text" size="28" name="PCChineseName" value="<?php echo $RSA1[ChineseName];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Gender<font color="#FF0000"></font></td>
										    <?php	if ( $RSA1[Gender] == "M" ) {
											    $male="checked";
											    $female="";
											} else if ( $RSA1[Gender] == "F" ){
											    $male="";
											    $female="checked";
											} else {
											    $male="";
											    $female="";
											} ?>
											<td><input type="radio" name="gender" value="M" <?php echo $male;?> >Male
											    <input type="radio" name="gender" value="F" <?php echo $female;?> >Female</td>
										</tr>
										<?php if ( $_GET[whose] =="student" || $_SESSION[membertype] == 30 ) { ?>
                                        <tr>
											<td width="50%" align="Right">Date of Birth<font color="#FF0000"></font></td>
											<td align="left" ><input type="text" size="10" name="dob" value="<?php echo $dob; ?>"> (mm/dd/yyyy)</td>
										</tr>
                                        <tr>
											<td width="50%" align="Right">Ethnicity<font color="#FF0000"></font></td>
											<td align="left" >
										<?php
										     $sqleth="select Ethnicity,Explanation from tblEthnicity";
										     $rseth=mysqli_query($conn, $sqleth);
										     echo "<select name=\"ethnicity\">";
						                     while ($rweth=mysqli_fetch_array($rseth) ) {
						                       if ( $rweth[Ethnicity] == $RSA1[Ethnicity] ) {
						                          echo "<option SELECTED value=\"". $rweth[Ethnicity] ."\">". $rweth[Explanation]. "</option>\n";
						                       } else {
						                          echo "<option          value=\"". $rweth[Ethnicity] ."\">". $rweth[Explanation]. "</option>\n";
						                       }
						                     }
						                     ?>
											</td>
										</tr>

										<?php } ?>

                                      <?php if ( $_GET[whose] !="student" && $_SESSION[membertype] != 30 ) { ?>
										<tr>
											<td width="50%" align="Right">Primary Contact<font color="#FF0000"></font></td>
											<?php if ( $RSA1[PrimaryContact] == "Yes" ) {
											    $PCParentYes="checked";
											    $PCParentNo="";
											} else {
											    $PCParentYes="";
											    $PCParentNo="checked";

											} ?>
											<td><input type="radio" name="PrimaryContact" value="Yes" disabled="disabled" <?php echo $PCParentYes;?> >Yes
											    <input type="radio" name="PrimaryContact" value="No" disabled="disabled" <?php echo $PCParentNo;?> >No</td>
										</tr>
									  <?php } ?>

										<?php if ( $_GET[whose] =="student" || $_SESSION[membertype] == 30 ) {
										 if ( $_GET[whose] =="student")  {
										  $sql="select FirstRegistrationDate,StartingLevel,PrimaryHomeLanguage,NumChSpeakParents,StudentType,StudentStatus,PreferredClassLevel,PreferredExtraClass1,PreferredExtraClass2 from tblStudent where MemberID=".$_GET['stuid'];
										  $sql1="select tblClass.GradeOrSubject,tblClass.ClassNumber from tblClassRegistration,tblClass
										  		  where tblClassRegistration.ClassID=tblClass.ClassID AND tblClassRegistration.StudentMemberID=".$_GET['stuid'] ." and tblClass.Term='".$LastTerm ."' AND tblClass.GradeOrSubject in ('1','2','3','4','5','6','7','8','9','10','11')";
										 } else {
										  $sql="select FirstRegistrationDate,StartingLevel,PrimaryHomeLanguage,NumChSpeakParents,StudentType,StudentStatus,PreferredClassLevel,PreferredExtraClass1,PreferredExtraClass2 from tblStudent where MemberID=".$_SESSION['memberid'];
										  $sql1="select tblClass.GradeOrSubject,tblClass.ClassNumber from tblClassRegistration,tblClass where tblClassRegistration.ClassID=tblClass.ClassID AND tblClassRegistration.StudentMemberID=".$_SESSION['memberid'] ."  and tblClass.Term='".$LastTerm."'";
										 }
										  $rs=mysqli_query($conn, $sql);
						                  $rw=mysqli_fetch_array($rs);


											     $sql_pec1 = "SELECT distinct GradeOrSubject from tblClass WHERE Period ='1' and CurrentClass='Yes'";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql6 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='1' "
                                                       . " AND tblClass.CurrentClass='Yes'"
                                                       . " AND tblClassRegistration.StudentMemberID=".$_GET[stuid];
		                                         $rs6=mysqli_query($conn,$sql6);
		                                         $rw6=mysqli_fetch_array($rs6);


                                               // old student?
											   $sql7 = "SELECT count(*) as  count
											              FROM tblClassRegistration,tblClass
											             WHERE tblClassRegistration.StudentMemberID = '". $_GET[stuid] ."' AND tblClass.Year='" .$CurrentYear. "' AND tblClass.Term !='". $CurrentTerm."'"
											                  . " AND tblClass.ClassID=tblClassRegistration.ClassID ";
											          //echo $sql7;
											          $rs7=mysqli_query($conn,$sql7);
													  $rw7=mysqli_fetch_array($rs7) ;
													  //$oldstudent=$rw7[count];

											    // seats taken for all classes

                                                 $sql71 = "SELECT count(*) count, tblClass.ClassID
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID  "
                                                       . " AND tblClass.CurrentClass='Yes'"
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

                                                if ($rw6[ClassNumber] != "" ) {
                                                   $newclass = $rw6[ClassNumber];
                                                }
                                             }
                                          } // end while

                                          if ( $rw7[count] > 0 ) {
                                          		$oldstudent='yes';
                                          }

                                          $pref_level = $rw6[GradeOrSubject];
                                          if ( $pref_level == 0 || $pref_level =='' ) {
                                           $pref_level = $prev_level + 1;
                                          }
										?>

										<tr><td align="Right"><hr></td><td><hr></td></tr>

										<tr><td align="Right"><font color="red">IMPORTANT: </font></td><td> <font color="red">Class Registration Closed for <?php echo "$CurrentTerm $CurrentYear"; ?></font><br>
										</td></tr>


										<tr>
											<td width="50%" align="Right">Primary Home Language</td>
											<td>

											<select name="PrimaryHomeLanguage">
											<?php if ( isset($rw['PrimaryHomeLanguage']) && $rw['PrimaryHomeLanguage'] == "Chinese" ) { ?>
											  <option value="Chinese" SELECTED>Chinese</option>
											<?php } else { ?>
											  <option value="Chinese">Chinese</option>
											<?php } ?>
											<?php if ( isset($rw['PrimaryHomeLanguage']) && $rw['PrimaryHomeLanguage'] == "English" ) { ?>
											  <option value="English" SELECTED>English</option>
											<?php } else { ?>
											  <option value="English">English</option>
											<?php } ?>
											<?php if ( isset($rw['PrimaryHomeLanguage']) && $rw['PrimaryHomeLanguage'] == "Other" ) { ?>
											  <option value="Other" SELECTED>Other</option>
											<?php } else { ?>
											  <option value="Other">Other</option>
											<?php } ?>

											</select>
											</td>
										</tr>

                                        <tr>
											<td width="50%" align="Right">Chinese Speaking Parents<font color="#FF0000"></font></td>
										    <?php	if ( $rw[NumChSpeakParents] == 0 ) {
											    $none="checked";
											    $one="";
											    $both="";
											} else if ( $rw[NumChSpeakParents] == 1 ){
											    $none="";
											    $one="checked";
											    $both="";
											} else if ( $rw[NumChSpeakParents] == 2 ){
											    $none="";
											    $one="";
											    $both="checked";
											} else {
											    $none="";
											    $one="";
											    $both="checked";
											} ?>
											<td><input type="radio" name="NumChSpeakParents" value="0" <?php echo $none;?> >None
											    <input type="radio" name="NumChSpeakParents" value="1" <?php echo $one;?> >One
											    <input type="radio" name="NumChSpeakParents" value="2" <?php echo $both;?> >Both</td>
											    <input type="hidden" name="NumChSpeakParentsOld" value="<?php echo $rw['NumChSpeakParents'];?>">
										</tr>

										<tr>
											<td width="50%" align="Right">Your Class level last Semester</td>
											<td>

											<select name="StartingLevel">

										     <?php for ($i=0;$i<=12;$i++) {


											       if ( isset($rw['StartingLevel']) && $rw['StartingLevel'] == $i ) {
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
										<tr>
									<?php if ($oldstudent == 'yes') { // old student ?>

											<td width="50%" align="Right">Language Class Level this New Semester<br>(1:20-3:00)</td>
											<td>

											<input type="text" name="PreferredClassLevel" value="<?php echo $newlevel; ?>" readonly>
											<input type="hidden" name="oldstudent" value="yes">
											<input type="hidden" name="newclass" value="<?php echo $newclass;?>">

                                               <?php
										  } else { // end old, start new student ?>

											<td width="50%" align="Right">Preferred Language Class Level this New Semester<br>(1:20-3:00)</td>
											<td>

											<select name="PreferredClassLevel" >

										<?php
										  //for ($i=1;$i<=12;$i++){

											//       if ( isset($rw['PreferredClassLevel']) && $rw['PreferredClassLevel'] == $i ) {
											//         echo "<option SELECTED value=\"".$i."\">".$i."</option>\n";
											//       } else if (   $pref_level == $i ) {
											//         echo "<option SELECTED value=\"".$i."\">".$i."</option>\n";
											//       } else {
											//         echo "<option value=\"".$i."\">".$i."</option>\n";
											//       }
											//   }
											?>



									    <?php while ( $rw_pec1=mysqli_fetch_array($rs_pec1) ) {
									        //$classid = $rw_pec1[ClassID];
									        $grade   = $rw_pec1[GradeOrSubject];
									        //$class   = $rw_pec1[ClassNumber];
									     ?>
											<?php if ( isset($rw6['GradeOrSubject']) && $rw6['GradeOrSubject'] == $grade ) { ?>
											  <option value="<?php echo $grade; ?>" SELECTED><?php echo $grade; ?></option>
											<?php
											 } else if (   $pref_level == $grade ) {
											        echo "<option SELECTED value=\"".$grade."\">".$grade."</option>\n";
											 } else { ?>
											  <option value="<?php echo $grade; ?>"><?php echo $grade; ?></option>
											<?php } ?>
									    <?php } ?>
											</select>(1:20-3:00pm)
									<?php } // end new student ?>

											<input type="hidden" name="PreferredClassLevelOld" value="<?php echo $rw6['GradeOrSubject'];?>">
											<input type="hidden" name="PreferredClassIDOld" value="<?php echo $rw6['ClassID'];?>">
											 <?php
											   //echo $sql6;
											   if ( $rw6[GradeOrSubject] != "" ) {
											    echo "<br>(currently registered for <b>". $rw6[GradeOrSubject].".".$rw6[ClassNumber] ."</b>)";
                                               } else {
                                                if ($oldstudent == 'yes') {
                                                   echo "<br>(You are assigned to class ".$newclass. " of level ".$newlevel ." or ".$newlevel.".".$newclass.")";
                                                } else {
                                                  echo "<br>(Note: You will be automatically assigned to a class of the level you choose.)";
                                                }
                                               }
                                              ?>
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Preferred Extra Class 1 (3:10-3:55)</td>
											<td nowrap>

											<select name="PreferredExtraClass1">

											<?php
											     $sql_pec1 = "SELECT * from tblClass WHERE Period = '3' and CurrentClass='Yes'";
											     $rs_pec1=mysqli_query($conn,$sql_pec1);

                                                 $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='3' "
                                                       . " AND tblClass.CurrentClass='Yes'"
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
									        if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw7['ClassID']) && $rw7['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo $grade ." (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo $grade ." (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											}
									     } ?>

											 </select>
											 <input type="hidden" name="PreferredExtraClass1Old" value="<?php echo $rw7['ClassID'];?>">
											 <?php if ( $rw7[GradeOrSubject] != "" ) { ?>
											   <br>(currently registered for <b><?php echo $rw7[GradeOrSubject].".".$rw7[ClassNumber] ; //echo $sql7; ?></b>)
                                             <?php } ?>
											</td>
										</tr>

										<tr>
											<td width="50%" align="Right">Preferred Extra Class 2 (4:05-4:50)</td>
											<td>

											<select name="PreferredExtraClass2">

											  <?php
											  	$sql_pec2 = "SELECT * from tblClass WHERE Period = '4' and CurrentClass='Yes'";
											  	$rs_pec2=mysqli_query($conn,$sql_pec2);

                                                 $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.ClassNumber,tblClass.Seats
                                                            FROM tblClassRegistration,tblClass
                                                           WHERE tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.Period='4' "
                                                       . " AND tblClass.CurrentClass='Yes'"
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
									        if ( $openseats > 0 ) {
									     ?>
											<?php if ( isset($rw8['ClassID']) && $rw8['ClassID'] == $classid ) { ?>
											  <option value="<?php echo $classid; ?>" SELECTED><?php echo $grade ." (seats available ". ($openseats) . ")"; ?></option>
											<?php } else { ?>
											  <option value="<?php echo $classid; ?>"><?php echo $grade ." (seats available ". ($openseats) . ")"; ?></option>
											<?php }
											}
									     } ?>


											 </select>
											 <input type="hidden" name="PreferredExtraClass2Old" value="<?php echo $rw8['ClassID'];?>">
											 <?php
											   //echo $sql8;
											   if ( $rw8[GradeOrSubject] != "" ) { ?>
											   <br>(currently registered for <b><?php echo $rw8[GradeOrSubject].".".$rw8[ClassNumber] ;  ?></b>)
                                             <?php } ?>

											</td>
										</tr>

											<tr><td align="right"><!--
												<input type="submit" value="Update"> -->
											</td>
											<td align="left">
												<input type="button" width="18"  onClick="window.location.href='MemberAccountMain.php'" value="Cancel">
											</td></tr>
															<tr>
																<td align="right"><a href="OpenSeats.php" >View Class Opening/Available Seats</a>
																<td  align="center"><a href="http://classes.yale.edu/chns130/chineseschool/">Course Description</a></td>

																</td>
															</tr>

										<tr><td align="Right"><hr></td><td><hr></td></tr>
									<?php } ?>


									<?php if ( $_GET[whose] == "student" ) {
									  if ( !isset($PhoneArrary[0]) || $PhoneArrary[0] == "" ) {
									     $PhoneArrary=explode("-",$RSAp[HomePhone]);
									  }
									  if ( !isset($CPhoneArrary[0]) || $CPhoneArrary[0] == "" ) {
									  	 $CPhoneArrary=explode("-",$RSAp[CellPhone]);
									  }
									  if ( !isset($RSA1[HomeAddress]) || $RSA1[HomeAddress] == "" ) {
									     $RSA1[HomeAddress]=$RSAp[HomeAddress];
									  }
									  if ( !isset($RSA1[HomeCity]) || $RSA1[HomeCity] == "" ) {
									  	 $RSA1[HomeCity]=$RSAp[HomeCity];
									  }
									  if ( !isset($RSA1[HomeState]) || $RSA1[HomeState] == "" ) {
									  	 $RSA1[HomeState]=$RSAp[HomeState];
									  }
									  if ( !isset($RSA1[HomeZip]) || $RSA1[HomeZip] == "" ) {
									  	 $RSA1[HomeZip]=$RSAp[HomeZip];
									  }
									  if ( !isset($RSA1[Email]) || $RSA1[Email] == "" ) {
									  	 $RSA1[Email]=$RSAp[Email];
									  }
									 } ?>
										<tr>
											<td width="50%" align="Right">Email<font color="#FF0000">*</font></td>
											<td><input  type="text" size="28" name="PCEmail" value="<?php echo $RSA1[Email];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Home Phone<font color="#FF0000">*</font></td>
											<td align="left">
												<input size="3" maxlength="3" name="area" onKeyUp="return SSAutoTab(this,'prefix', 3, event);" value="<?php echo $PhoneArrary[0];?>">
												<font size="3">-</font>
												<input size="3" maxlength="3" name="prefix"  onKeyUp="return SSAutoTab(this,'suffix', 3, event);"  value="<?php echo $PhoneArrary[1];?>">
												<font size="3">-</font>
												<input size="4" maxlength="4" name="suffix"   value="<?php echo $PhoneArrary[2];?>">
											</td>
										</tr>
										<tr>
											<td width="50%" align="Right">Cell Phone</td>
											<td align="left">
												<input size="3" maxlength="3" name="Carea" onKeyUp="return SSAutoTab(this,'Cprefix', 3, event);" value="<?php echo $CPhoneArrary[0];?>">
												<font size="3">-</font>
												<input size="3" maxlength="3" name="Cprefix"  onKeyUp="return SSAutoTab(this,'Csuffix', 3, event);"  value="<?php echo $CPhoneArrary[1];?>">
												<font size="3">-</font>
												<input size="4" maxlength="4" name="Csuffix"   value="<?php echo $CPhoneArrary[2];?>">
											</td>
										</tr>
                                        <tr>
											<td width="50%" align="Right">Office Phone</td>
											<td align="left">
												<input size="3" maxlength="3" name="Oarea" onKeyUp="return SSAutoTab(this,'Oprefix', 3, event);" value="<?php echo $OPhoneArrary[0];?>">
												<font size="3">-</font>
												<input size="3" maxlength="3" name="Oprefix"  onKeyUp="return SSAutoTab(this,'Osuffix', 3, event);"  value="<?php echo $OPhoneArrary[1];?>">
												<font size="3">-</font>
												<input size="4" maxlength="4" name="Osuffix"   value="<?php echo $OPhoneArrary[2];?>">
											</td>
										</tr>



										<tr>
											<td width="50%" align="Right">Address<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="Address" value="<?php echo $RSA1[HomeAddress ];?>"></td>
										</tr>

										<tr>
											<td width="50%" align="Right">City<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="city" value="<?php echo $RSA1[HomeCity ];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">State<font color="#FF0000">*</font></td>
											<td><input type="text" size="28" name="state" value="<?php echo $RSA1[HomeState ];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Zip Code<font color="#FF0000">*</font></td>
											<td><input type="text" size="5" maxlength="5"  name="zip" value="<?php echo $RSA1[HomeZip  ];?>" ></td>
										</tr>
                                      <?php if ( $_GET[whose] !="student" && $_SESSION[membertype] != 30 ) { ?>
										<tr>
											<td width="50%" align="Right" valign="top">Profession: </td>
											<td><input type="text" size="28" name="PCProfession" value="<?php echo $RSA1[Profession];?>"></td>
										</tr>
										<tr>
											<td width="50%" align="Right">Organization: </td>
											<td><input type="text" size="28" maxlength="100"  name="org" value="<?php echo $RSA1[Organization];?>" ></td>
										</tr>

										<tr>
											<td width="50%" align="Right">Hobbies: </td>
											<td><input type="text" size="28" maxlength="150"  name="hobbies" value="<?php echo $RSA1[Hobbies];?>" ></td>
										</tr>
                                       <?php } ?>

										<tr>
											<td width="50%" align="Right" valign="top">Directory: </td>
											<?php if ( $RSA1[Directory] == "No" ) {
											    $dir = "checked";
											   } else {
											    $dir = "";
											   }
											 ?>
											<td><input type="checkbox"  name="dir" value="no dir" <?php echo $dir;?> >I do NOT want my name to be listed in school directories.</td>

										</tr>
										<tr>
											<td width="50%" align="Right" valign="top">Picture: </td>
											<?php if ( $RSA1[Picture] == "No" ) {
											    $pic = "checked";
											   } else {
											    $pic = "";
											   }
											 ?>

											<td><input type="checkbox"  name="pic" value="no pic" <?php echo $pic;?> >I do NOT want picture or video to be taken on me.</td>
										</tr>

										<tr>
											<td width="50%" align="Right">Login: </td>
											<td width="50%" align="Left"><?php echo $RSA1[UserName];?></td>
										</tr>
										<tr>
											<td width="50%" align="Right">New Password</td>
											<td nowrap><input type="password" size="20" maxlength="20"  name="password1"  > <br>(Leave blank if no change)</td>
										</tr>
										<tr>
											<td width="50%" align="Right">New PW Confirm</td>
											<td><input type="password" size="20" maxlength="20"  name="password2"  > </td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="center">
												<input type="submit" value="Update">
											</td>
											<td align="center">
												<input type="button" width="18"  onClick="window.location.href='MemberAccountMain.php'" value="Cancel">
											</td>
										</tr>

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