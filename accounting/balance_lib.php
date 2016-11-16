<?php

include("../common/DB/DataStore.php");

function last_reg($conn,$ffid)
{
  $sql = "
  SELECT c.Year,c.Term,r.DateTimeRegistered FROM `tblClassRegistration` r, tblClass c,tblMember m 
  WHERE r.ClassID=c.ClassID and r.StudentMemberID=m.MemberID 
  and (r.Status='OK' or r.Status = 'Taken') 
  and m.FamilyID=". $ffid . "
  order by c.Year desc, c.Term desc, r.DateTimeRegistered DESC
  limit 1";

 $rs=mysqli_query($conn,$sql);
 $row=mysqli_fetch_array($rs) ;

  
  return $row[Year] . " " . $row[Term];
}


function spring_due($conn,$fmid)
{
  
  $sql = " select sum(Amount) sdue from tblReceivable r, tblClass c where r.FamilyID=".$fmid ." and r.ClassID=c.ClassID and c.CurrentClass='Yes' and c.Term='Spring' ";

 $rs=mysqli_query($conn,$sql);
 if ( $rs ) {
    $row=mysqli_fetch_array($rs) ;
 }

 if ( $row ) { 
  return $row[sdue] ;
 } else {
  return 0;
 }
}

function credit_selection($conn,$ffid)
{

	$SQLstring = " SELECT CreditChoice FROM `tblFamily` WHERE `FamilyID`=".$ffid;

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
        return         $RSA1[CreditChoice];

}

function pay_selection($conn,$ffid)
{

	$SQLstring = " SELECT PaymentChoice FROM `tblFamily` WHERE `FamilyID`=".$ffid;

	$RS1=mysqli_query($conn,$SQLstring);
	$RSA1=mysqli_fetch_array($RS1);
        return         $RSA1[PaymentChoice];

}
?>
