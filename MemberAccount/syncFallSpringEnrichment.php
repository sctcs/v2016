<?php


function syncTerms($memberid, $id, $period, $term, $conn, $year )
{
//include_once("../common/DB/DataStore.php");
  if ( !isset($id )  || $id == "" ) {
    return;
  }
 $DEBUG=0;

  // taking other class at this period?
  $sql3="select c.ClassID from tblClass c, tblClassRegistration r where r.StudentMemberID='".$memberid."' and c.ClassID=r.ClassID and c.IsLanguage !='Yes' and c.CurrentClass='Yes' and c.Period='". $period ."' and c.ClassID !='" . $id . "' and Term !='" . $term . "' and r.Status='OK'";
  if ($DEBUG) {echo $sql3;}
  echo "<br>";
  $rs3=mysqli_query($conn,$sql3);
  while($rw3=mysqli_fetch_array($rs3)){
    if ($DEBUG) {echo "found other class at this period of other term, ClassID: " . $rw3[ClassID];}
    echo "<br>";
    if ( isset($rw3[ClassID] )  && $rw3[ClassID] != "" ) {
       return;
    }
  } 

  if ($DEBUG) {echo $id. $term. $period. $year;}

  $sqlst = "select ClassID from tblClass where CurrentClass='Yes' and Period='". $period ."' and Term !='" . $term . "' and GradeORSubject in 
           (select GradeOrSubject from tblClass where ClassID='" . $id . "') limit 1";
  if ($DEBUG) {echo "<br>$sqlst<br>";}
  echo "<br>";

  $rsst=mysqli_query($conn,$sqlst);

  $rwst=mysqli_fetch_array($rsst);
  if ($DEBUG) {echo "ClassID: " . $rwst[ClassID];}
         
  if ( isset($rwst[ClassID] )  && $rwst[ClassID] != "" ) {
     $sql02 = "select ClassRegistrationID,Status from tblClassRegistration where ClassID = ". $rwst[ClassID]." and StudentMemberID = '" . $memberid ."'";
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ( !isset($rw02[Status] )  || $rw02[Status] == "" ) {
           $sql4 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$memberid.", ". $rwst[ClassID]. ", '".$year."',  now(), 'OK')";
           if ($DEBUG) {echo $sql4;}
  echo "<br>";
           if (!mysqli_query($conn,$sql4)) { die('Error: ' . mysqli_error($conn)); }
       } elseif ($rw02[Status] == "Dropped") {
           $sql4 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where ClassRegistrationID=" . $rw02[ClassRegistrationID];
           if ($DEBUG) {echo $sql4;}
  echo "<br>";
           if (!mysqli_query($conn,$sql4)) { die('Error: ' . mysqli_error($conn)); }
       } 
  }
  echo "<BR>";

}

function syncSpring2Fall($memberid, $fallid, $period, $conn, $year )
{
//include_once("../common/DB/DataStore.php");

  echo $fallid. $spring. $period. $classtitle;

  $sqlst = "select ClassID from tblClass where CurrentClass='Yes' and Term !='Fall' and GradeORSubject in 
           (select GradeOrSubject from tblClass where ClassID='" . $fallid . "') limit 1";
  if ($DEBUG) { echo "<br>$sqlst<br>";}

  $rsst=mysqli_query($conn,$sqlst);

  $rwst=mysqli_fetch_array($rsst);
  echo "Spring ClassID: " . $rwst[ClassID];
         
  $sql02 = "select ClassRegistrationID,Status from tblClassRegistration where ClassID = ". $rwst[ClassID]." and StudentMemberID = '" . $memberid ."'";
           $rs02=mysqli_query($conn,$sql02);
           $rw02=mysqli_fetch_array($rs02);
       if ( !isset($rw02[Status] )  || $rw02[Status] == "" ) {
           $sql4 = "insert into tblClassRegistration (StudentMemberID, ClassID, Year,  DateTimeRegistered, Status)
               values (".$memberid.", ". $rwst[ClassID]. ", '".$year."',  now(), 'OK')";
           echo $sql4;
           if (!mysqli_query($conn,$sql4)) { die('Error: ' . mysqli_error($conn)); }
       } elseif ($rw02[Status] == "Dropped") {
           $sql4 = "update tblClassRegistration set Status = 'OK',DateTimeRegistered=now() where ClassRegistrationID=" . $rw02[ClassRegistrationID];
           echo $sql4;
           if (!mysqli_query($conn,$sql4)) { die('Error: ' . mysqli_error($conn)); }
       } 

  echo "<BR>";

}

?>
