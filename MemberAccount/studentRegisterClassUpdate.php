<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(!isset($_SESSION['family_id']) && !isset($_POST[newmember]) )
{
 header( 'Location: ../main.php' ) ;
 exit();
}
?>
<html>
<head>
  <meta http-equiv="Expires" CONTENT="0">
  <meta http-equiv="Cache-Control" CONTENT="no-cache">
  <meta http-equiv="Pragma" CONTENT="no-cache">
</head>
<body>

<?php
include_once("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");
include("./syncFallSpringEnrichment.php");


//syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass1'], $period="1", $term="Fall", $conn, $NextYear);
//syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass2'], $period="2", $term="Fall", $conn, $NextYear);
//syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass3'], $period="3", $term="Fall", $conn, $NextYear);
//syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass4'], $period="4", $term="Fall", $conn, $NextYear);

//syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass1'], $period="1", $term="Spring", $conn, $CurrentYear);
//syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass2'], $period="2", $term="Spring", $conn, $CurrentYear);
//syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass3'], $period="3", $term="Spring", $conn, $CurrentYear);
//syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass4'], $period="4", $term="Spring", $conn, $CurrentYear);

$MemberUpdateDate=date("Y/m/d");

   // check registration changes
   //
   if ($DEBUG) {
     echo "Pref Class (old, new): ".$_POST['PreferredClassLevelOld']."=>".$_POST['PreferredClassLevel']."<br>";
     echo "Fall Extra Class 0 (old, new): ".$_POST['FallPreferredExtraClass0Old']."=>".$_POST['FallPreferredExtraClass0']."<br>";
     echo "Fall Extra Class 1 (old, new): ".$_POST['FallPreferredExtraClass1Old']."=>".$_POST['FallPreferredExtraClass1']."<br>";
     echo "Fall Extra Class 2 (old, new): ".$_POST['FallPreferredExtraClass2Old']."=>".$_POST['FallPreferredExtraClass2']."<br>";
     echo "Fall Extra Class 3 (old, new): ".$_POST['FallPreferredExtraClass3Old']."=>".$_POST['FallPreferredExtraClass3']."<br>";
     echo "Fall Extra Class 4 (old, new): ".$_POST['FallPreferredExtraClass4Old']."=>".$_POST['FallPreferredExtraClass4']."<br>";
     echo "Spri Extra Class 0 (old, new): ".$_POST['SpringPreferredExtraClass0Old']."=>".$_POST['SpringPreferredExtraClass0']."<br>";
     echo "Spri Extra Class 1 (old, new): ".$_POST['SpringPreferredExtraClass1Old']."=>".$_POST['SpringPreferredExtraClass1']."<br>";
     echo "Spri Extra Class 2 (old, new): ".$_POST['SpringPreferredExtraClass2Old']."=>".$_POST['SpringPreferredExtraClass2']."<br>";
     echo "Spri Extra Class 3 (old, new): ".$_POST['SpringPreferredExtraClass3Old']."=>".$_POST['SpringPreferredExtraClass3']."<br>";
     echo "Spri Extra Class 4 (old, new): ".$_POST['SpringPreferredExtraClass4Old']."=>".$_POST['SpringPreferredExtraClass4']."<br>";
   }
     //echo "Chinese Speak Parents (old, new): ".$_POST['NumChSpeakParentsOld']."=>".$_POST['NumChSpeakParents']."<br><br>";

   if ( $_POST['PreferredClassLevel']  != $_POST['PreferredClassLevelOld']  ||

        $_POST['FallPreferredExtraClass0'] != $_POST['FallPreferredExtraClass0Old'] ||
        $_POST['FallPreferredExtraClass1'] != $_POST['FallPreferredExtraClass1Old'] ||
        $_POST['FallPreferredExtraClass2'] != $_POST['FallPreferredExtraClass2Old'] ||
        $_POST['FallPreferredExtraClass3'] != $_POST['FallPreferredExtraClass3Old'] ||
        $_POST['FallPreferredExtraClass4'] != $_POST['FallPreferredExtraClass4Old'] ||
        $_POST['SpringPreferredExtraClass0'] != $_POST['SpringPreferredExtraClass0Old'] ||
        $_POST['SpringPreferredExtraClass1'] != $_POST['SpringPreferredExtraClass1Old'] ||
        $_POST['SpringPreferredExtraClass2'] != $_POST['SpringPreferredExtraClass2Old'] ||
        $_POST['SpringPreferredExtraClass3'] != $_POST['SpringPreferredExtraClass3Old'] ||
        $_POST['SpringPreferredExtraClass4'] != $_POST['SpringPreferredExtraClass4Old']
        )
   {

// 20081030 Neil: turn off class change
 //  echo "Registration and class change are not allowed for the $CurrentTerm $CurrentYear term anymore, please contact the Principal if you have any questions.";
 //  mysqli_close($conn);
 //  exit;

 // load class seats taken
 $sqlst = "SELECT count(*) count, tblClass.ClassID,tblClass.Seats FROM tblClassRegistration,tblClass WHERE  tblClass.ClassID=tblClassRegistration.ClassID AND tblClass.CurrentClass='Yes' and tblClassRegistration.Status !='Dropped'
           AND CurrentClass='Yes'  group by tblClass.ClassID";
     if ($DEBUG) { echo "<br>$sqlst<br>";}
     $rsst=mysqli_query($conn,$sqlst);

	 while ($rwst=mysqli_fetch_array($rsst) ) {
	   $stc[$rwst[ClassID]] = $rwst[count]; // seats taken count
	   $stl[$rwst[ClassID]]  = $rwst[Seats]; // seats taken limit
	 }


   if ( isset($_POST['PreferredClassLevel']) && $_POST['PreferredClassLevel'] != "" && $_POST[PreferredClassLevel] != $_POST['PreferredClassLevelOld']  )
   {
   //$openclassid = '';
   
   $gradeANDclass = explode(".",$_POST['PreferredClassLevel']);

   // old/returning students
   if ($DEBUG) { echo "oldstudent: ".$_POST[oldstudent]."<br>";}
   if ($DEBUG) { echo "newclass: ".$_POST[newclass]."<br>";}
   if ($DEBUG) { echo "newgrade: ".$gradeANDclass[0]."<br>";}
   if ($DEBUG) { echo "newclassno: ".$gradeANDclass[1]."<br>";}
 /*  
   $foundid = 0;
   if ( $_POST[oldstudent] == "yes" ) {
     // find the class id for the level and newclass
     $sql00 = "SELECT ClassID,Seats from tblClass where GradeOrSubject='". $_POST['PreferredClassLevel'] ."' AND ClassNumber='". $_POST['newclass']. "' AND CurrentClass='Yes' order by ClassID limit 2";
     if ($DEBUG) { echo $sql00;}
     $rs00=mysqli_query($conn,$sql00);
     $i=1;
	 while ($rw00=mysqli_fetch_array($rs00) ) {
	  if ( $stc[$rw00[ClassID]] < $rw00[Seats] ) { // not filled class
	   $openclassids[$i] = $rw00[ClassID];
	   if ($DEBUG) { echo "<br>openclassids[$i]=".$openclassids[$i];}

	   $i++;
	   $foundid = 1;
	  } else {
	     echo "<br> class ". $rw00[ClassID] ." is full";
	  }
	 }

	 if ( $foundid != 1 ) {
//   echo "<br>GradeOrSubject='". $_POST['PreferredClassLevel'] ."' AND ClassNumber='". $_POST['newclass'] ." is either full or not valid";
	 }
	 //echo "openclassid=".$openclassid;

   }

   
   if ( $_POST[oldstudent] != "yes" || $foundid != 1 ) {
   // find the first open class
   //
      $foundid = 0;

      // Grade 1 is special:
      //                    type   I, 3 classes or sections, for students whose BOTH parents speak Chinese
      //                    type  II, 1 class   or section,  for students whose ONE  parents speak Chinese
      //                    type III, 1 class   or section,  for students whose NONE parents speak Chinese
      //
      // get # of classes per grade
      $sql01="SELECT count(*) classlimit, GradeOrSubject from tblClass where Year='".$CurrentYear
            ."' AND Term='".$CurrentTerm."' AND IsLanguage='Yes' GROUP by GradeOrSubject";
      if ($DEBUG) { echo "<br>$sql01<BR>";}
      $rs01=mysqli_query($conn,$sql01);
	  while ( $rw01=mysqli_fetch_array($rs01) ) {
	           $classlimits[$rw01[GradeOrSubject]] = $rw01[classlimit];
      }
      if ($DEBUG) { echo "<br># of classes for grade level ".$gradeANDclass[0]." is ".$classlimits[$gradeANDclass[0]]. "<br>";}

      $classnum = '1';
      $chspnum = $_POST['NumChSpeakParents'];
      if ($DEBUG) { echo "NumChSpeakParents=$chspnum ";}
      echo "<br>";


      for ($i=1; $i<=$classlimits[$_POST['PreferredClassLevel']]; $i++ )
      {
        //skip 1.4 and 1.5 here for new students with 2 Chinese speaking parents
        if ($_POST['PreferredClassLevel'] == '1')
        {
           if ( $chspnum == 1 && $i != $CLASSNUM_ONE_CHINESE_SPEAKING_PARENTS ) {
              continue;
           }
           if ( $chspnum == 0 && $i != $CLASSNUM_TWO_CHINESE_SPEAKING_PARENTS ) {
              continue;
           }
        } //if

        // count seats taken
          $sql5 = "SELECT tblClass.ClassID, tblClass.ClassNumber, tblClass.Seats, tblClass.Period 
                     FROM tblClassRegistration,tblClass
                  WHERE tblClass.GradeOrSubject='".$_POST['PreferredClassLevel']. "' AND tblClass.ClassNumber = '". $i
                ."' AND tblClass.Year='" .$CurrentYear. "' AND tblClass.Term='". $CurrentTerm."'"
                  . " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status !='Dropped' ";
          if ($DEBUG) { echo $sql5."<br>";}
          $scount = 0;
          $total = 0;
		  $rs5=mysqli_query($conn,$sql5);
		  while ( $rw5=mysqli_fetch_array($rs5) ) {
		     $scount++;
		     $openclassid = $rw5[ClassID];
		     $total = $rw5[Seats];
          }
          if ( $total < 1 ) {
               $total = $LANG_CLASS_SEAT_LIMIT;
          }
          if ( $scount > 0 && $scount < $total)
          {
              //$openclassid = $rw5[ClassID];
              if ($DEBUG) { echo "<br>found the partially taken class ID (".$openclassid.") for ".$_POST['PreferredClassLevel'].".". $i ."<br>";}
              $classnum = $i;
              $foundid = 1;
              break;
          } else if ( $scount == 0 ) { // class empty, set class number, need to get classid
              $classnum = $i;
              if ($DEBUG) { echo "<br>class  ".$_POST['PreferredClassLevel'].".". $i ." is empty <br>";}
              break;
          } else { // == 18, class full, try next
            $classnum = 0; // unset class number
            if ($DEBUG) { echo "<br>class  ".$_POST['PreferredClassLevel'].".". $i ." is full, try next <br>";}
            continue;
          } //if 18

      } // end for

      if ( $classnum == 0 ) // found no empty class
      {

         echo "No empty class found for grade level ".$_POST['PreferredClassLevel']. "<br>";
         echo "Sign-up for this class was not successful<br><br>";
         echo "<br><br><font color=red>Please contact school principal</font>, or <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">try another grade level</a>";

         mysqli_close($conn);
         exit;
      } else {
      if ($DEBUG) { echo "<br>foundid=$foundid";}
      if ($DEBUG) { echo "<br> classnum=$classnum";}

        if ($_POST['PreferredClassLevel'] == '1') {
         if ( $chspnum == 1 ) {// single chinese speaking parent
            $classnum = $CLASSNUM_ONE_CHINESE_SPEAKING_PARENTS; 
         }
         if ( $chspnum == 0  ) { // two chinese speaking parent
            $classnum = $CLASSNUM_TWO_CHINESE_SPEAKING_PARENTS;
         }
        } // if 1

        // retrieve classid based on level and class number
          $sql6 = "SELECT ClassID,Period FROM tblClass WHERE GradeOrSubject='". $_POST['PreferredClassLevel']. "' AND ClassNumber='".$classnum
                 ."' AND CurrentClass='Yes' order by ClassID ";
          if ($DEBUG) { echo "<br>$sql6<br>";}
          $rs6=mysqli_query($conn,$sql6);
          $i=1;
		  while ($rw6=mysqli_fetch_array($rs6)) {
		    $openclassids[$i] = $rw6[ClassID];
		     $LGPERIOD = $rw6[Period];
		    if ($DEBUG) { echo "<br>found the empty class, ID ". $openclassids[$i]. ", for ".$_POST['PreferredClassLevel'].".". $classnum ."<br>";}
		    $i++;
		  }

          //echo "<br>found the empty class, ID ". $openclassid. ", for ".$_POST['PreferredClassLevel'].".". $classnum ."<br>";
       } // if 0

    } // end new student
*/
        // retrieve classid based on level and class number
          $sql6 = "SELECT ClassID,Period FROM tblClass WHERE GradeOrSubject='". $gradeANDclass[0]. "' AND ClassNumber='".$gradeANDclass[1]
                 ."' AND CurrentClass='Yes' order by ClassID ";
          if ($DEBUG) { echo "<br>$sql6<br>";}
          $rs6=mysqli_query($conn,$sql6);
          $i=1;
		  while ($rw6=mysqli_fetch_array($rs6)) {
		    $openclassids[$i] = $rw6[ClassID];
		     $LGPERIOD = $rw6[Period];
		    if ($DEBUG) { echo "<br>".$i." found the empty class, ID ". $openclassids[$i]. ", for ".$_POST['PreferredClassLevel'].".". $classnum ."<br>";}
		    $i++;
		  }

          //echo "<br>found the empty class, ID ". $openclassid. ", for ".$_POST['PreferredClassLevel'].".". $classnum ."<br>";



   // insert new language selection into tblClassRegistration
   //
   $registered=0;
   //if ( isset($openclassids[1]) && $openclassids[1] != "" && $CurrentTerm == "Fall" ) // no change for Spring
   //{
     if ( isset($_POST[PreferredClassIDOld1]) && $_POST[PreferredClassIDOld1] != "" ) {
        if ( $_POST[PreferredClassIDOld1] != $openclassids[1] ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[PreferredClassIDOld1];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }


           $sql2 = "update tblClassRegistration set status='" .$status."', DateTimeRegistered=now() ".
                   " WHERE StudentMemberID = " . $_POST['updtmemberid'] ;
		if ( isset($_POST[PreferredClassIDOld2]) && $_POST[PreferredClassIDOld2] != "" ) {
            $sql2 .=       " AND ClassID in (".$_POST[PreferredClassIDOld1].", ".$_POST[PreferredClassIDOld2].")";
        } else {
		    $sql2 .=       " AND ClassID ='".$_POST[PreferredClassIDOld1]."'";
        }
           if ($DEBUG) { echo "<br>update Lang: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }

        }
     }
    if ( isset($openclassids[1]) && $openclassids[1] != '') {
     // new lang registration
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $openclassids[1] ." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql2 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$openclassids[1];
       } else {

         $sql2 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $openclassids[1]. ", '".$CurrentYear."',  now(), 'OK')";
       }
       if ($DEBUG) { echo "<br>insert/update Lang: ".$sql2."<br>"; }
       if (!mysqli_query($conn,$sql2))    {
	  		         die('Error: ' . mysqli_error($conn));
       }
      }
    if ( isset($openclassids[2]) && $openclassids[2] != '') {
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $openclassids[2]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql2 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$openclassids[2];
       } else {

         $sql2 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered,Status)
               values (".$_POST['updtmemberid'].", ". $openclassids[2]. ", '".$NextYear."',  now(), 'OK')";
       }
       if ($DEBUG) { echo "<br>insert/update Lang: ".$sql2."<br>";}
       if (!mysqli_query($conn,$sql2))    {
	  		         die('Error: ' . mysqli_error($conn));
       }
      }

     $registered=1;
    //}
   }

//########################## FALL ENRICHMENT:

// fall period 0:
   if ( isset($_POST['FallPreferredExtraClass0']) && $_POST['FallPreferredExtraClass0'] != "" && $_POST[FallPreferredExtraClass0Old] != $_POST['FallPreferredExtraClass0']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '0' || $LGPERIOD == '0' ) {
        echo "ERROR: your first enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 0
        //
        $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['FallPreferredExtraClass0']. "' ".
                   " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped' ";
          if ($DEBUG) { echo "<br>extra0 count: ".$sql7."<br>";}
          $scount=0;
		  $rs7=mysqli_query($conn,$sql7);
		  $total=0;
		  while ( $rw7=mysqli_fetch_array($rs7) ) {
		     $scount +=1;
		     //$openclassid = $rw7[ClassID];
		     $total=$rw7[Seats];
          }
          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra0 count: ". ($scount + 0) ." out of ".$total."<br>";

     if ( $scount < $total)
     {
     // there is open seats
        if ( isset($_POST[FallPreferredExtraClass0Old]) && $_POST[FallPreferredExtraClass0Old] != "" ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[FallPreferredExtraClass0Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

           // update current extra 0
           $sql2 = "update tblClassRegistration set Status = '" .$status. "',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass0Old];
           if ($DEBUG) { echo "update extra0: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


        }

        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[FallPreferredExtraClass0]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql3 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass0];
       } else {
           $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered,Status)
               values (".$_POST['updtmemberid'].", ". $_POST['FallPreferredExtraClass0']. ", '".$CurrentYear."',  now(), 'OK')";
       }
       if ($DEBUG) { echo " update/insert Extra0: ".$sql3."<br>";}
       if (!mysqli_query($conn,$sql3))    {
	  	  		         die('Error: ' . mysqli_error($conn));
       }


      $registered=1;
     } else { // fulll
      echo "Class " . $rw7[GradeOrSubject] . " at 0st period of Fall is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;
     }
// syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass0'], $period="0", $term="Fall", $conn, $NextYear);
   }
   // drop extra 0
   if ( !isset($_POST['FallPreferredExtraClass0']) || $_POST['FallPreferredExtraClass0'] == "" && $_POST[FallPreferredExtraClass0Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status = 'Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass0Old];
           if ($DEBUG) {echo "<br>update extra0: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

// fall period 1:
   if ( isset($_POST['FallPreferredExtraClass1']) && $_POST['FallPreferredExtraClass1'] != "" && $_POST[FallPreferredExtraClass1Old] != $_POST['FallPreferredExtraClass1']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '1' || $LGPERIOD == '1' ) {
        echo "ERROR: your first enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 1
        //
        $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['FallPreferredExtraClass1']. "' ".
                   " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped' ";
          if ($DEBUG) { echo "<br>extra1 count: ".$sql7."<br>";}
          $scount=0;
		  $rs7=mysqli_query($conn,$sql7);
		  $total=0;
		  while ( $rw7=mysqli_fetch_array($rs7) ) {
		     $scount +=1;
		     //$openclassid = $rw7[ClassID];
		     $total=$rw7[Seats];
          }
          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra1 count: ". ($scount + 0) ." out of ".$total."<br>";

     if ( $scount < $total)
     {
     // there is open seats
        if ( isset($_POST[FallPreferredExtraClass1Old]) && $_POST[FallPreferredExtraClass1Old] != "" ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[FallPreferredExtraClass1Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

           // update current extra 1
           $sql2 = "update tblClassRegistration set Status = '" .$status. "',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass1Old];
           if ($DEBUG) { echo "update extra1: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


        }

        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[FallPreferredExtraClass1]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql3 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass1];
       } else {
           $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered,Status)
               values (".$_POST['updtmemberid'].", ". $_POST['FallPreferredExtraClass1']. ", '".$CurrentYear."',  now(), 'OK')";
       }
       if ($DEBUG) { echo " update/insert Extra1: ".$sql3."<br>";}
       if (!mysqli_query($conn,$sql3))    {
	  	  		         die('Error: ' . mysqli_error($conn));
       }


      $registered=1;
     } else { // fulll
      echo "Class " . $rw7[GradeOrSubject] . " at 1st period of Fall is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;
     }
// syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass1'], $period="1", $term="Fall", $conn, $NextYear);
   }
   // drop extra 1
   if ( !isset($_POST['FallPreferredExtraClass1']) || $_POST['FallPreferredExtraClass1'] == "" && $_POST[FallPreferredExtraClass1Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status = 'Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass1Old];
           if ($DEBUG) {echo "<br>update extra1: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

   if ( isset($_POST['FallPreferredExtraClass2']) && $_POST['FallPreferredExtraClass2'] != "" && $_POST[FallPreferredExtraClass2Old] != $_POST['FallPreferredExtraClass2']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '1' || $_POST['PreferredClassPeriod'] == '2' || $LGPERIOD == '2' || $LGPERIOD == '1' ) {
        echo "ERROR: your 2nd enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 2
        //
        $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['FallPreferredExtraClass2']. "' "
                . " AND tblClass.ClassID=tblClassRegistration.ClassID  AND tblClassRegistration.Status != 'Dropped' ";
          //echo "<br>extra2 count: ".$sql8."<br>";
          $scount = 0;
		  $rs8=mysqli_query($conn,$sql8);
		  $total=0;
		  while ( $rw8=mysqli_fetch_array($rs8) ) {
		     $scount += 1;
		     //$openclassid = $rw8[ClassID];
		     $total=$rw8[Seats];
          }

          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra2 count: ". ($scount + 0) ." out of ". $total . "<br>";

     if ( $scount < $total)
     {
      if ( isset($_POST[FallPreferredExtraClass2Old]) && $_POST[FallPreferredExtraClass2Old] != "" ) {
           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[FallPreferredExtraClass2Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

        // update current extra 2
           $sql2 = "update tblClassRegistration set status = '". $status."',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass2Old];
           if ($DEBUG) {echo "<br>update extra2: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


      }
      // new extra2 registration

        // there are open seats
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[FallPreferredExtraClass2]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql4 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass2];
       } else {

        $sql4 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $_POST['FallPreferredExtraClass2']. ", '".$CurrentYear."',  now(), 'OK')";
       }
        if ($DEBUG) {echo "<br>update/insert Extra2: ".$sql4."<br>";}
        if (!mysqli_query($conn,$sql4)) {
	    	 die('Error: ' . mysqli_error($conn));
        }
       // end else

      $registered=1;
     } else { // fulll
      echo "<font color=red>Class " . $rw8[GradeOrSubject] . " at 2nd period of Fall is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;

     }

// syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass2'], $period="2", $term="Fall", $conn, $NextYear);
   }
   // drop extra 2
   if ( !isset($_POST['FallPreferredExtraClass2']) || $_POST['FallPreferredExtraClass2'] == "" && $_POST[FallPreferredExtraClass2Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status='Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass2Old];
           //echo "delete extra2: ".$sql2."<br>";
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

   if ( isset($_POST['FallPreferredExtraClass3']) && $_POST['FallPreferredExtraClass3'] != "" && $_POST[FallPreferredExtraClass3Old] != $_POST['FallPreferredExtraClass3']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '2' || $_POST['PreferredClassPeriod'] == '3'|| $LGPERIOD == '2' || $LGPERIOD == '3' ) {
        echo "ERROR: your 3rd enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // 
        // count seats taken for extra class 1
        //
        $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['FallPreferredExtraClass3']. "' ".
                   " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped' ";
          //echo "<br>extra1 count: ".$sql7."<br>";
          $scount=0;
		  $rs7=mysqli_query($conn,$sql7);
		  $total=0;
		  while ( $rw7=mysqli_fetch_array($rs7) ) {
		     $scount +=1;
		     //$openclassid = $rw7[ClassID];
		     $total=$rw7[Seats];
          }
          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra1 count: ". ($scount + 0) ." out of ".$total."<br>";

     if ( $scount < $total)
     {
      if ( isset($_POST[FallPreferredExtraClass3Old]) && $_POST[FallPreferredExtraClass3Old] != "" ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[FallPreferredExtraClass3Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

        // update current extra 1
           $sql2 = "update tblClassRegistration set Status = '" .$status. "',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass3Old];
           if ($DEBUG) {echo "<br>update extra3: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


      }

       // new extra 1 registration

       // there is open seats
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[FallPreferredExtraClass3]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql3 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass3];
       } else {

       $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $_POST['FallPreferredExtraClass3']. ", '".$CurrentYear."',  now(), 'OK')";
       }
       if ($DEBUG) {echo "<br> update/insert Extra3: ".$sql3."<br>";}
       if (!mysqli_query($conn,$sql3))    {
	  	  		         die('Error: ' . mysqli_error($conn));
       }
       // end else

      $registered=1;
     } else { // fulll
      echo "Class " . $rw7[GradeOrSubject] . " at 3rd period of Fall is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;
     }
// syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass3'], $period="3", $term="Fall", $conn, $NextYear);
   }
   // drop extra 3
   if ( !isset($_POST['FallPreferredExtraClass3']) || $_POST['FallPreferredExtraClass3'] == "" && $_POST[FallPreferredExtraClass3Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status = 'Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass3Old];
           if ($DEBUG) {echo "<br>update extra3: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

   if ( isset($_POST['FallPreferredExtraClass4']) && $_POST['FallPreferredExtraClass4'] != "" && $_POST[FallPreferredExtraClass4Old] != $_POST['FallPreferredExtraClass4']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '3' || $LGPERIOD == '3' ) {
        echo "ERROR: your 4th enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        //  
        // count seats taken for extra class 4
        //
        $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['FallPreferredExtraClass4']. "' "
                . " AND tblClass.ClassID=tblClassRegistration.ClassID  AND tblClassRegistration.Status != 'Dropped' ";
          //echo "<br>extra2 count: ".$sql8."<br>";
          $scount = 0;
		  $rs8=mysqli_query($conn,$sql8);
		  $total=0;
		  while ( $rw8=mysqli_fetch_array($rs8) ) {
		     $scount += 1;
		     //$openclassid = $rw8[ClassID];
		     $total=$rw8[Seats];
          }

          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra2 count: ". ($scount + 0) ." out of ". $total . "<br>";

     if ( $scount < $total)
     {
      if ( isset($_POST[FallPreferredExtraClass4Old]) && $_POST[FallPreferredExtraClass4Old] != "" ) {
           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[FallPreferredExtraClass4Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

        // update current extra 4
           $sql2 = "update tblClassRegistration set Status = '". $status."',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass4Old];
           if ($DEBUG) {echo "<br>update extra4: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


      }
      // new extra4 registration

        // there are open seats
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[FallPreferredExtraClass4]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql4 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass4];
       } else {

        $sql4 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $_POST['FallPreferredExtraClass4']. ", '".$CurrentYear."',  now(), 'OK')";
        }
        if ($DEBUG) {echo "<br>update/insert Extra2: ".$sql4."<br>";}
        if (!mysqli_query($conn,$sql4)) {
	    	 die('Error: ' . mysqli_error($conn));
        }
       // end else

      $registered=1;
     } else { // fulll
      echo "<font color=red>Class " . $rw8[GradeOrSubject] . " at 4th period of Fall is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;

     }

//  syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass4'], $period="4", $term="Fall", $conn, $NextYear);
   }
   // drop extra 4
   if ( !isset($_POST['FallPreferredExtraClass4']) || $_POST['FallPreferredExtraClass4'] == "" && $_POST[FallPreferredExtraClass4Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status='Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[FallPreferredExtraClass4Old];
           if ($DEBUG) {echo "<br>update extra4: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

//########################## END FALL ENRICHMENT.

//########################## SPRING ENRICHMENT:
// spring period 0:
   if ( isset($_POST['SpringPreferredExtraClass0']) && $_POST['SpringPreferredExtraClass0'] != "" && $_POST[SpringPreferredExtraClass0Old] != $_POST['SpringPreferredExtraClass0']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '0'  || $LGPERIOD == '0' ) {
        echo "ERROR: your first enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 0
        //
        $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['SpringPreferredExtraClass0']. "' ".
                   " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped' ";
          if ($DEBUG) { echo "<br>extra0 count: ".$sql7."<br>";}
          $scount=0;
		  $rs7=mysqli_query($conn,$sql7);
		  $total=0;
		  while ( $rw7=mysqli_fetch_array($rs7) ) {
		     $scount +=1;
		     //$openclassid = $rw7[ClassID];
		     $total=$rw7[Seats];
          }
          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra0 count: ". ($scount + 0) ." out of ".$total."<br>";

     if ( $scount < $total)
     {
     // there is open seats
        if ( isset($_POST[SpringPreferredExtraClass0Old]) && $_POST[SpringPreferredExtraClass0Old] != "" ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[SpringPreferredExtraClass0Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

           // update current extra 0
           $sql2 = "update tblClassRegistration set Status = '" .$status. "',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass0Old];
           if ($DEBUG) { echo "update extra0: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


        }

        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[SpringPreferredExtraClass0]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql3 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass0];
       } else {
           $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered,Status)
               values (".$_POST['updtmemberid'].", ". $_POST['SpringPreferredExtraClass0']. ", '".$NextYear."',  now(), 'OK')";
       }
       if ($DEBUG) { echo " update/insert Extra0: ".$sql3."<br>";}
       if (!mysqli_query($conn,$sql3))    {
	  	  		         die('Error: ' . mysqli_error($conn));
       }


      $registered=1;
     } else { // fulll
      echo "Class " . $rw7[GradeOrSubject] . " at 0st period of Spring is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;
     }
//  syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass0'], $period="0", $term="Spring", $conn, $CurrentYear);
   }
   // drop extra 0
   if ( !isset($_POST['SpringPreferredExtraClass0']) || $_POST['SpringPreferredExtraClass0'] == "" && $_POST[SpringPreferredExtraClass0Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status = 'Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass0Old];
           if ($DEBUG) {echo "<br>update extra0: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

// spring period 1:
   if ( isset($_POST['SpringPreferredExtraClass1']) && $_POST['SpringPreferredExtraClass1'] != "" && $_POST[SpringPreferredExtraClass1Old] != $_POST['SpringPreferredExtraClass1']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '1'  || $LGPERIOD == '1' ) {
        echo "ERROR: your first enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 1
        //
        $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['SpringPreferredExtraClass1']. "' ".
                   " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped' ";
          if ($DEBUG) { echo "<br>extra1 count: ".$sql7."<br>";}
          $scount=0;
		  $rs7=mysqli_query($conn,$sql7);
		  $total=0;
		  while ( $rw7=mysqli_fetch_array($rs7) ) {
		     $scount +=1;
		     //$openclassid = $rw7[ClassID];
		     $total=$rw7[Seats];
          }
          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra1 count: ". ($scount + 0) ." out of ".$total."<br>";

     if ( $scount < $total)
     {
     // there is open seats
        if ( isset($_POST[SpringPreferredExtraClass1Old]) && $_POST[SpringPreferredExtraClass1Old] != "" ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[SpringPreferredExtraClass1Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

           // update current extra 1
           $sql2 = "update tblClassRegistration set Status = '" .$status. "',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass1Old];
           if ($DEBUG) { echo "update extra1: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


        }

        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[SpringPreferredExtraClass1]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql3 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass1];
       } else {
           $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered,Status)
               values (".$_POST['updtmemberid'].", ". $_POST['SpringPreferredExtraClass1']. ", '".$NextYear."',  now(), 'OK')";
       }
       if ($DEBUG) { echo " update/insert Extra1: ".$sql3."<br>";}
       if (!mysqli_query($conn,$sql3))    {
	  	  		         die('Error: ' . mysqli_error($conn));
       }


      $registered=1;
     } else { // fulll
      echo "Class " . $rw7[GradeOrSubject] . " at 1st period of Spring is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;
     }
//  syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass1'], $period="1", $term="Spring", $conn, $CurrentYear);
   }
   // drop extra 1
   if ( !isset($_POST['SpringPreferredExtraClass1']) || $_POST['SpringPreferredExtraClass1'] == "" && $_POST[SpringPreferredExtraClass1Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status = 'Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass1Old];
           if ($DEBUG) {echo "<br>update extra1: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

   if ( isset($_POST['SpringPreferredExtraClass2']) && $_POST['SpringPreferredExtraClass2'] != "" && $_POST[SpringPreferredExtraClass2Old] != $_POST['SpringPreferredExtraClass2']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '1' || $_POST['PreferredClassPeriod'] == '2' || $LGPERIOD == '2' || $LGPERIOD == '1' ) {
        echo "ERROR: your 2nd enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 2
        //
        $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['SpringPreferredExtraClass2']. "' "
                . " AND tblClass.ClassID=tblClassRegistration.ClassID  AND tblClassRegistration.Status != 'Dropped' ";
          //echo "<br>extra2 count: ".$sql8."<br>";
          $scount = 0;
		  $rs8=mysqli_query($conn,$sql8);
		  $total=0;
		  while ( $rw8=mysqli_fetch_array($rs8) ) {
		     $scount += 1;
		     //$openclassid = $rw8[ClassID];
		     $total=$rw8[Seats];
          }

          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra2 count: ". ($scount + 0) ." out of ". $total . "<br>";

     if ( $scount < $total)
     {
      if ( isset($_POST[SpringPreferredExtraClass2Old]) && $_POST[SpringPreferredExtraClass2Old] != "" ) {
           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[SpringPreferredExtraClass2Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

        // update current extra 2
           $sql2 = "update tblClassRegistration set status = '". $status."',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass2Old];
           if ($DEBUG) {echo "<br>update extra2: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


      }
      // new extra2 registration

        // there are open seats
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[SpringPreferredExtraClass2]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql4 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass2];
       } else {

        $sql4 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $_POST['SpringPreferredExtraClass2']. ", '".$NextYear."',  now(), 'OK')";
       }
        if ($DEBUG) {echo "<br>update/insert Extra2: ".$sql4."<br>";}
        if (!mysqli_query($conn,$sql4)) {
	    	 die('Error: ' . mysqli_error($conn));
        }
       // end else

      $registered=1;
     } else { // fulll
      echo "<font color=red>Class " . $rw8[GradeOrSubject] . " at 2nd period of Spring is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;

     }

// syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass2'], $period="2", $term="Spring", $conn, $CurrentYear);
   }
   // drop extra 2
   if ( !isset($_POST['SpringPreferredExtraClass2']) || $_POST['SpringPreferredExtraClass2'] == "" && $_POST[SpringPreferredExtraClass2Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status='Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass2Old];
       //    echo "delete extra2: ".$sql2."<br>";
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

   if ( isset($_POST['SpringPreferredExtraClass3']) && $_POST['SpringPreferredExtraClass3'] != "" && $_POST[SpringPreferredExtraClass3Old] != $_POST['SpringPreferredExtraClass3']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '2' || $_POST['PreferredClassPeriod'] == '3'|| $LGPERIOD == '2' || $LGPERIOD == '3' ) {
        echo "ERROR: your 3rd enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 1
        //
        $sql7 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['SpringPreferredExtraClass3']. "' ".
                   " AND tblClass.ClassID=tblClassRegistration.ClassID AND tblClassRegistration.Status != 'Dropped' ";
          //echo "<br>extra1 count: ".$sql7."<br>";
          $scount=0;
		  $rs7=mysqli_query($conn,$sql7);
		  $total=0;
		  while ( $rw7=mysqli_fetch_array($rs7) ) {
		     $scount +=1;
		     //$openclassid = $rw7[ClassID];
		     $total=$rw7[Seats];
          }
          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra1 count: ". ($scount + 0) ." out of ".$total."<br>";

     if ( $scount < $total)
     {
      if ( isset($_POST[SpringPreferredExtraClass3Old]) && $_POST[SpringPreferredExtraClass3Old] != "" ) {

           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[SpringPreferredExtraClass3Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

        // update current extra 1
           $sql2 = "update tblClassRegistration set Status = '" .$status. "',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass3Old];
           if ($DEBUG) {echo "<br>update extra3: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


      }

       // new extra 1 registration

       // there is open seats
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[SpringPreferredExtraClass3]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql3 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass3];
       } else {

       $sql3 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $_POST['SpringPreferredExtraClass3']. ", '".$NextYear."',  now(), 'OK')";
       }
       if ($DEBUG) {echo "<br> update/insert Extra3: ".$sql3."<br>";}
       if (!mysqli_query($conn,$sql3))    {
	  	  		         die('Error: ' . mysqli_error($conn));
       }
       // end else

      $registered=1;
     } else { // fulll
      echo "Class " . $rw7[GradeOrSubject] . " at 3rd period of Spring is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;
     }
// syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass3'], $period="3", $term="Spring", $conn, $CurrentYear);
   }
   // drop extra 3
   if ( !isset($_POST['SpringPreferredExtraClass3']) || $_POST['SpringPreferredExtraClass3'] == "" && $_POST[SpringPreferredExtraClass3Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status = 'Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass3Old];
           if ($DEBUG) {echo "<br>update extra3: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

   if ( isset($_POST['SpringPreferredExtraClass4']) && $_POST['SpringPreferredExtraClass4'] != "" && $_POST[SpringPreferredExtraClass4Old] != $_POST['SpringPreferredExtraClass4']  )
   {
     if ( $_POST['PreferredClassPeriod'] == '3' || $LGPERIOD == '3' ) {
        echo "ERROR: your 4th enrichment class conflicts with language class. Try again: ";
        echo "                                         <a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
        mysqli_close($conn);
        exit;
     }
        // count seats taken for extra class 2
        //
        $sql8 = "SELECT tblClass.ClassID, tblClass.GradeOrSubject,tblClass.Seats FROM tblClassRegistration,tblClass
                  WHERE tblClass.ClassID='".$_POST['SpringPreferredExtraClass4']. "' "
                . " AND tblClass.ClassID=tblClassRegistration.ClassID  AND tblClassRegistration.Status != 'Dropped' ";
          //echo "<br>extra2 count: ".$sql8."<br>";
          $scount = 0;
		  $rs8=mysqli_query($conn,$sql8);
		  $total=0;
		  while ( $rw8=mysqli_fetch_array($rs8) ) {
		     $scount += 1;
		     //$openclassid = $rw8[ClassID];
		     $total=$rw8[Seats];
          }

          if ( $total < 1 ) {
             $total = $ENRICH_CLASS_SEAT_LIMIT;
          }
          //echo $scount;
          //echo "<br>extra2 count: ". ($scount + 0) ." out of ". $total . "<br>";

     if ( $scount < $total)
     {
      if ( isset($_POST[SpringPreferredExtraClass4Old]) && $_POST[SpringPreferredExtraClass4Old] != "" ) {
           $sql02 = "select CurrentClass from tblClass where ClassID = ". $_POST[SpringPreferredExtraClass4Old];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
           if ($rw02[CurrentClass] == "Yes") {
              $status = "Dropped";
           } else {
              $status = "Taken";
           }

        // update current extra 2
           $sql2 = "update tblClassRegistration set Status = '". $status."',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass4Old];
           if ($DEBUG) {echo "<br>update extra4: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }


      }
      // new extra4 registration

        // there are open seats
        // check if the class was dropped before
           $sql02 = "select Status from tblClassRegistration where ClassID = ". $_POST[SpringPreferredExtraClass4]." and StudentMemberID = " . $_POST['updtmemberid'];
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ($rw02[Status] == "Dropped") {
           $sql4 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass4];
       } else {

        $sql4 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$_POST['updtmemberid'].", ". $_POST['SpringPreferredExtraClass4']. ", '".$NextYear."',  now(), 'OK')";
        }
        if ($DEBUG) {echo "<br>update/insert Extra2: ".$sql4."<br>";}
        if (!mysqli_query($conn,$sql4)) {
	    	 die('Error: ' . mysqli_error($conn));
        }
       // end else

      $registered=1;
     } else { // fulll
      echo "<font color=red>Class " . $rw8[GradeOrSubject] . " at 4th period of Spring is full, <a href=\"studentRegisterClass.php?whose=student&stuid=".$_POST['updtmemberid']."\">please try another one</a></font><br>";
      mysqli_close($conn);
      exit;

     }

// syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass4'], $period="4", $term="Spring", $conn, $CurrentYear);
   }
   // drop extra 4
   if ( !isset($_POST['SpringPreferredExtraClass4']) || $_POST['SpringPreferredExtraClass4'] == "" && $_POST[SpringPreferredExtraClass4Old] != ""  )
   {
           $sql2 = "update tblClassRegistration set Status='Dropped',DateTimeRegistered=now() where  StudentMemberID = " . $_POST['updtmemberid'] . " AND ClassID=".$_POST[SpringPreferredExtraClass4Old];
           if ($DEBUG) {echo "<br>update extra4: ".$sql2."<br>";}
		   if (!mysqli_query($conn,$sql2))    {
		      die('Error: ' . mysqli_error($conn));
           }
   }

//########################## END SPRING ENRICHMENT.
   if ( isset($_POST['FallPreferredExtraClass0']) && $_POST['FallPreferredExtraClass0'] != "" && $_POST[FallPreferredExtraClass0Old] != $_POST['FallPreferredExtraClass0']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass0'], $period="0", $term="Fall", $conn, $NextYear);
   }
   if ( isset($_POST['FallPreferredExtraClass1']) && $_POST['FallPreferredExtraClass1'] != "" && $_POST[FallPreferredExtraClass1Old] != $_POST['FallPreferredExtraClass1']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass1'], $period="1", $term="Fall", $conn, $NextYear);
   }
   if ( isset($_POST['FallPreferredExtraClass2']) && $_POST['FallPreferredExtraClass2'] != "" && $_POST[FallPreferredExtraClass2Old] != $_POST['FallPreferredExtraClass2']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass2'], $period="2", $term="Fall", $conn, $NextYear);
   }
   if ( isset($_POST['FallPreferredExtraClass3']) && $_POST['FallPreferredExtraClass3'] != "" && $_POST[FallPreferredExtraClass3Old] != $_POST['FallPreferredExtraClass3']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass3'], $period="3", $term="Fall", $conn, $NextYear);
   }
   if ( isset($_POST['FallPreferredExtraClass4']) && $_POST['FallPreferredExtraClass4'] != "" && $_POST[FallPreferredExtraClass4Old] != $_POST['FallPreferredExtraClass4']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['FallPreferredExtraClass4'], $period="4", $term="Fall", $conn, $NextYear);
   }
/*
   if ( isset($_POST['SpringPreferredExtraClass1']) && $_POST['SpringPreferredExtraClass1'] != "" && $_POST[SpringPreferredExtraClass1Old] != $_POST['SpringPreferredExtraClass1']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass1'], $period="1", $term="Spring", $conn, $CurrentYear);
   }
   if ( isset($_POST['SpringPreferredExtraClass2']) && $_POST['SpringPreferredExtraClass2'] != "" && $_POST[SpringPreferredExtraClass2Old] != $_POST['SpringPreferredExtraClass2']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass2'], $period="2", $term="Spring", $conn, $CurrentYear);
   }
   if ( isset($_POST['SpringPreferredExtraClass3']) && $_POST['SpringPreferredExtraClass3'] != "" && $_POST[SpringPreferredExtraClass3Old] != $_POST['SpringPreferredExtraClass3']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass3'], $period="3", $term="Spring", $conn, $CurrentYear);
   }
   if ( isset($_POST['SpringPreferredExtraClass4']) && $_POST['SpringPreferredExtraClass4'] != "" && $_POST[SpringPreferredExtraClass4Old] != $_POST['SpringPreferredExtraClass4']  )
   {
      syncTerms($_POST[updtmemberid], $_POST['SpringPreferredExtraClass4'], $period="4", $term="Spring", $conn, $CurrentYear);
   }
*/
//########################## END SYNC.


   if ( $registered &&  $_SERVER["SERVER_NAME"] != "localhost" )
   {
      $SQLpc = "select FirstName, LastName, Email   from tblMember  where tblMember.FamilyID=".$_SESSION['family_id']." and PrimaryContact='Yes'";
	  						$RS2=mysqli_query($conn,$SQLpc);
						$RSA2=mysqli_fetch_array($RS2);

      $to      = $RSA2[Email];
   	  $subject = $SCHOOLNAME_ABR . ' Class Registration Confirmation';

   	  $headers = 'From: support@ynhchineseschool.org' . "\r\n" .
   			     'Reply-To: support@ynhchineseschool.org' . "\r\n" .
   			     'X-Mailer: PHP/' . phpversion() . "\r\n";
   		//	 $headers .= 'Bcc: neil.guo@comcast.net' . "\r\n";

   	  $message = "Dear ".$RSA2[FirstName]." ".$RSA2[LastName].",\n\nCongratulations!\n\nYou have successfully registered class(es). ".
   	             "Please print the Payment Voucher from your account, mail a check and the voucher to: $SCHOOL_PAY_ADDRESS".
   	             "\n\n" .
   	             "Thank you.".
   	             "\n\n" .
   	             $SCHOOLNAME;
      //echo "The following message will be sent:<br><br>";
      //echo $to ."<br><br>". $subject ."<br><br>". $message ."<br><br>". $headers;
	  mail($to, $subject, $message, $headers);
   } // if localhost


   // update tblMember.Registered to "yes"
   // to do: back to "no" if all classes are dropped before term starts
   if ( $registered ) {
      $sql="update tblMember set Registered='yes' where MemberID=".$_POST['updtmemberid'];
      //echo $sql;
      if (!mysqli_query($conn,$sql))      {
	  	            die('Error: ' . mysqli_error($conn));
      }
   }

   // update tblReceivable?
   if ( $AUTO_RECEIVABLE == "Yes" ) {
      require_once("../accounting/Tools.php");
      UpdateIncomeInfo($_SESSION['family_id']);
   }

 } // done with registration updates
 else {
   // no change, to do nothing
   echo "no class registration change to be made";
 }


echo "<center><br><br>";
echo "Class Registration updated successfully  ";
//echo "<br><a href=\"studentRegisterClass.php?stuid=".$_POST['updtmemberid']."\">Register Classes</a>";
//echo "                                         <br><a href=\"studentClassesRegistered.php?stuid=".$_POST['updtmemberid']."\">View Classes Registered</a>";
//echo "<br>or  <br><a href=\"FeePaymentVoucher.php\">Print Payment Voucher</a>";
echo "<br>  <br><a href=\"MemberAccountMain.php\">My Account</a>";
echo "</center>";

mysqli_close($conn);

?>
</body>
</html>
