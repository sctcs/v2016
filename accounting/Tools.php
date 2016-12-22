<?php
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

function getdbconnection()
{
	$dbName="";
	$conn="";
	include("../common/DB/DataStore.php");
//	mysql_select_db($dbName, $conn);
	return $conn;
}


function OpenTable()
{
echo "<table>";
}

function FamilyAccessCheck()
{

	if(  CheckAccess() or $_GET['familyid']==$_SESSION['family_id'] )
	{
		return 1;
        }else
        {
         	return 0;
        }
}

function CheckAccess()
{
         session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
// session_save_path("/var/www/phpsessions");

         session_start();
        $seclvl = $_SESSION['membertype'];
	$secdesc= $_SESSION['MemberTypes'][$seclvl];

	if( $seclvl == 45 or $seclvl ==55 or $seclvl == 20)
        //$_SESSION['MemberTypes']['55'] == "Collector")
        {
                  return 1;
        }else
        {
         return 0;
        }
}




function CloseTable()
{
?>
</table>
<?php
}


function UpdateIncomeInfo($familyid)
{
 include("../common/CommonParam/params.php");

 //$familyid="all";
 if ( isset($_GET[FamilyID]) && $_GET[FamilyID] != "") {
   $familyid=$_GET[FamilyID];
 }

if ( $familyid != "all" && $familyid != "") {
  $sqlmod1 = " and m.FamilyID =".$familyid . " ";
  $sqlmod2 = " and i.FamilyID =".$familyid . " ";
} else {
  $sqlmod1 = "";
}
// class tuitions
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
              select c.IncomeCategoryID,cr.StudentMemberID,m.FamilyID,'ClassFee', c.ClassID,cr.ClassRegistrationID,c.classfee ,concat(c.Year,' ',c.Term,' Period: ',Period,' Class: ',c.GradeOrSubject,'.',c.ClassNumber) Descr,now()," . $_SESSION[memberid] .
           " from tblClass c,tblClassRegistration cr,tblMember m
             where c.CurrentClass='Yes' and c.ClassID=cr.ClassID and DateTimeRegistered >'". $PAST_BALANCE_DATE ."' and cr.StudentMemberID=m.MemberID AND cr.Status != 'Dropped' ". $sqlmod1
          ." and not exists (select i.ClassRegistrationID from tblReceivable i where i.DateTime > '". $PAST_BALANCE_DATE ."' and i.ClassRegistrationID=cr.ClassRegistrationID". $sqlmod1 ." and i.ClassRegistrationID !=0 and i.ClassRegistrationID is not null )";
echo "$updatecmd<br><BR>";
$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for New class registration<br>Debug info: $updatecmd <br>\n");


// Auto adjust for dropped classes. and make sure only adjust once
if ( $familyid != "all"  && $familyid != "") {
  $sqlmod2 = " and r.FamilyID =".$familyid . " ";
} else {
  $sqlmod2 = "";
}

// auto credit for dropped classes
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select IncomeCategory,MemberID,FamilyID, 'ClassFeeDropped',  `ClassID`,ClassRegistrationID,0-Amount, 'Class Dropped' ,now(), createdByMemberID
from tblReceivable r
where ReceivableType='ClassFee' and DateTime>'". $PAST_BALANCE_DATE ."' " .$sqlmod2 ."
and r.ClassRegistrationID is not null
and not exists (select cr.ClassRegistrationID from tblClassRegistration cr where r.ClassRegistrationID=cr.ClassRegistrationID and cr.Status !='Dropped')
and not exists (select er.ClassRegistrationID from tblReceivable er where r.ClassRegistrationID=er.ClassRegistrationID and er.ReceivableType='ClassFeeDropped') ";

// only allowed before the first school date
if ( $AUTO_RECEIVABLE4DROP == "Yes" && date('Y-m-d') < "$REG_REG_DEADLINE" ) {
    echo "$updatecmd<br><BR>";
//	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for dropped class registration<br>Debug info: $updatecmd <br>\n");
}

// book fee calculation

// turn off by neil on 2010-10-15, run SQL ourside once per year without "not exists " check
  //$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
  //    select 12 IncomeCategory,MemberID,FamilyID, 'BookFee',  c.`ClassID`, cr.ClassRegistrationID,
  //    case c.GradeOrSubject
  //when  '1' then $BOOKFEE1
  //when  '2' then $BOOKFEE1
  //when  '3' then $BOOKFEE1
  //else $BOOKFEE2
  //end
  //as Amount,
  //    'Book fee for ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
  //      from tblClass c,tblClassRegistration cr,tblMember m
  //            where c.CurrentClass='Yes' and c.Term='Fall' and c.ClassID=cr.ClassID  ". $sqlmod1 ." and
  //            cr.StudentMemberID=m.MemberID  and c.GradeOrSubject in
  //    ('1','2','3','4','5','6','7','8','9','10','11','12') and cr.Status != 'Dropped'
  //and not exists (select i.ClassRegistrationID from tblReceivable i where i.ClassRegistrationID=cr.ClassRegistrationID and IncomeCategory=12)";
  //if ($DEBUG) { echo "$updatecmd<br><br>"; }
  //	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for book fee on Language class registration<br>Debug info: $updatecmd <br>\n");


// membership fee.
if ( $familyid != "all"  && $familyid != "") {
  $sqlmod3 = " and i.FamilyID =".$familyid . " ";
} else {
  $sqlmod3 = "";
}
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
    select 1 IncomeCategory,MemberID,FamilyID, 'Membership',  0, 0,
$MEMBERSHIP_FEE Amount,    'Membership fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember
where PrimaryContact='Yes' and FamilyID in
(select m.FamilyID from tblClass c,tblClassRegistration cr,tblMember m
where c.CurrentClass='Yes' and c.Term='Fall' ".$sqlmod1." and c.ClassID=cr.ClassID and cr.StudentMemberID=m.MemberID and cr.Status !='Dropped')
and not exists (select MemberID from tblReceivable i
where i.MemberID=tblMember.MemberID ".$sqlmod3." and i.Description='Membership fee ".$SchoolYear."' and IncomeCategory=1)";
if ( $familyid != "all"  && $familyid != "") {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 1 IncomeCategory, m.MemberID, m.FamilyID, 'Membership', 0, 0, ".
$MEMBERSHIP_FEE ." Amount, 'Membership fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m , viewClassStudents v where m.PrimaryContact='Yes' and m.FamilyID=v.FamilyID and v.Status='OK' and v.CurrentClass='Yes'  and m.FamilyID ='". $familyid ."'  and not exists (select MemberID from tblReceivable i where i.MemberID=m.MemberID and i.FamilyID ='". $familyid ."' and i.Description='Membership fee ".$SchoolYear."' ) limit 1";
} else {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 1 IncomeCategory, m.MemberID, m.FamilyID, 'Membership', 0, 0, ".
$MEMBERSHIP_FEE ." Amount, 'Membership fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m  where m.PrimaryContact='Yes' and m.FamilyID in (select v.FamilyID from viewClassStudents v
where v.Status='OK' and v.CurrentClass='Yes'  )
and not exists (select MemberID from tblReceivable i where i.
MemberID=m.MemberID  and i.Description='Membership fee ".$SchoolYear."' )";
}
echo "$updatecmd<br><br>";
//	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for family membership fee <br>Debug info: $updatecmd <br>\n");

// registration fee
if ( $familyid != "all"  && $familyid != "") {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 14 IncomeCategory, m.MemberID, m.FamilyID, 'Registration', 0, 0, ".
$REG_REG_FEE_DOLLAR ." Amount, 'Registration fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m , viewClassStudents v where m.PrimaryContact='Yes' and m.FamilyID=v.FamilyID and v.Status='OK' and v.CurrentClass='Yes'  and m.FamilyID ='". $familyid ."'  and not exists (select MemberID from tblReceivable i where i.MemberID=m.MemberID and i.FamilyID ='". $familyid ."' and i.Description='Registration fee ".$SchoolYear."' ) limit 1";
} else {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 14 IncomeCategory, m.MemberID, m.FamilyID, 'Registration', 0, 0, ".
$REG_REG_FEE_DOLLAR ." Amount, 'Registration fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m  where m.PrimaryContact='Yes' and m.FamilyID in (select v.FamilyID from viewClassStudents v
where v.Status='OK' and v.CurrentClass='Yes'  )
and not exists (select MemberID from tblReceivable i where i.
MemberID=m.MemberID  and i.Description='Registration fee ".$SchoolYear."' )";
}

echo "$updatecmd<br><br>";
//	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for family registration fee <br>Debug info: $updatecmd <br>\n");


// safety patrol deposit (20140919 Neil: disabled)
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
    select 15 IncomeCategory,MemberID,FamilyID, 'PatrolDeposit',  0, 0,
$PARENT_DUTY_FEE Amount,    'Safety Patrol Deposit ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember
where PrimaryContact='Yes' and FamilyID in
(select m.FamilyID from tblClass c,tblClassRegistration cr,tblMember m
where c.CurrentClass='Yes' and c.Term='Fall' ".$sqlmod1." and c.ClassID=cr.ClassID and cr.StudentMemberID=m.MemberID and cr.Status !='Dropped')
and not exists (select MemberID from tblReceivable i
where i.MemberID=tblMember.MemberID ".$sqlmod3." and i.Description='Safety Patrol Deposit ".$SchoolYear."' and IncomeCategory=15)";
if ( $familyid != "all"  && $familyid != "") {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 15 IncomeCategory, m.MemberID, m.FamilyID, 'PatrolDeposit', 0, 0, ".
$PARENT_DUTY_FEE ." Amount, 'Safety Patrol Deposit ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m , viewClassStudents v where m.PrimaryContact='Yes' and m.FamilyID=v.FamilyID and v.Status='OK' and v.CurrentClass='Yes'  and m.FamilyID ='". $familyid ."'  and not exists (select MemberID from tblReceivable i where i.MemberID=m.MemberID and i.FamilyID ='". $familyid ."' and i.Description='Safety Patrol Deposit ".$SchoolYear."' ) limit 1";
} else {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 15 IncomeCategory, m.MemberID, m.FamilyID, 'PatrolDeposit', 0, 0, ".
$PARENT_DUTY_FEE ." Amount, 'Safety Patrol Deposit ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m  where m.PrimaryContact='Yes' and m.FamilyID in (select v.FamilyID from viewClassStudents v
where v.Status='OK' and v.CurrentClass='Yes'  )
and not exists (select MemberID from tblReceivable i where i.
MemberID=m.MemberID  and i.Description='Safety Patrol Deposit ".$SchoolYear."' )";
}
//echo "$updatecmd<br><br>";
//	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for family patrol deposit <br>Debug info: $updatecmd <br>\n");

}




function TestDB()
{
	 $result = mysqli_query($conn, 
		"SELECT FieldID, TableName, FieldName,DisplayName FROM tblAccountingFieldValue ");
?>
<h2><?php echo __FILE__ ?></h2>
<h2><?php echo $_SERVER['PHP_SELF'] ?></h2>
<h3><?php echo dirname(__FILE__)  ?></h3>


	<tr>
                        <th>FieldID			</th>
						<th>TableName	</th>
						<th>FieldName	</th>
						<th>DisplayName	</th>
	</tr>
<?php
        while($row = mysqli_fetch_array($result))
        {
?>
                <tr>
                        <td><?php echo $row[FieldID]			?></td>
						<td><?php echo $row[TableName]	?></td>
						<td><?php echo $row[FieldName]	?></td>
						<td><?php echo $row[DisplayName]?></td>
				</tr>
<?php
		}

}

function UpdateIncomeInfo2014($familyid)
{
 include("../common/CommonParam/params.php");

 //$familyid="all";
 if ( isset($_GET[FamilyID]) && $_GET[FamilyID] != "") {
   $familyid=$_GET[FamilyID];
 }

if ( $familyid != "all" && $familyid != "") {
  $sqlmod1 = " and m.FamilyID=".$familyid . " ";
  $sqlmod2 = " and i.FamilyID =".$familyid . " ";
} else {
  $sqlmod1 = "";
}

mysqli_query(GetDBConnection(),"set sql_big_selects=1") or die("failed to set big selects");

//loop all familyIDs
$query="SELECT distinct m.FamilyID from tblMember m, tblClassRegistration r, tblClass c 
        where m.MemberID=r.StudentMemberID and r.ClassID=c.ClassID and c.CurrentClass='Yes' and r.Status='OK'". $sqlmod1;  
	$resultfids = mysqli_query(GetDBConnection(),$query) or Die  ("<br>Failed to query  $query<br>\n");
//echo "$query<br><br>";
	while($row = mysqli_fetch_array($resultfids))
{
		$fid=$row['FamilyID'];
		//echo "$fid<br><br>";

// class tuitions
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
              select c.IncomeCategoryID,cr.StudentMemberID,m.FamilyID,'ClassFee', c.ClassID,cr.ClassRegistrationID,c.classfee ,concat(c.Year,' ',c.Term,' Period: ',c.Period,' Class: ',c.GradeOrSubject,'.',c.ClassNumber) Descr,now()," . $_SESSION[memberid] .
           " from tblClass c,tblClassRegistration cr,tblMember m
             where c.CurrentClass='Yes' and c.ClassID=cr.ClassID and cr.DateTimeRegistered >'". $PAST_BALANCE_DATE ."' and cr.StudentMemberID=m.MemberID AND cr.Status != 'Dropped' and m.FamilyID=". $fid
          ." and cr.ClassRegistrationID not in (select i.ClassRegistrationID from tblReceivable i where i.DateTime > '". $PAST_BALANCE_DATE ."' and i.FamilyID=". $fid ." and i.ClassRegistrationID !=0 and i.ClassRegistrationID is not null)";
//echo "$updatecmd<br><BR>";
$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for New class registration<br>Debug info: $updatecmd <br>\n");


// membership fee.
/*
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 1 IncomeCategory, m.MemberID, m.FamilyID, 'Membership', 0, 0, ".
$MEMBERSHIP_FEE ." Amount, 'Membership fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m , viewClassStudents v where m.PrimaryContact='Yes' and m.FamilyID=v.FamilyID and v.Status='OK' and v.CurrentClass='Yes'  and m.FamilyID ='". $fid ."'  and not exists (select MemberID from tblReceivable i where i.MemberID=m.MemberID and i.FamilyID ='". $fid ."' and i.Description='Membership fee ".$SchoolYear."' ) limit 1";
*/
//echo "$updatecmd<br><br>";
$qstr = "select count(*) as cnt from tblReceivable i where  i.FamilyID ='".$fid ."' and i.Description='Membership fee ". $SchoolYear. "' ";
$result = mysqli_query(GetDBConnection(),$qstr) or die ("failed to query exisinting membership record" . $qstr);
$row = mysqli_fetch_array($result) or die ("failed to read row");
if ( $row[cnt] < 1 ) {
$updatecmd=                          "insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 1 IncomeCategory, m.MemberID, m.FamilyID, 'Membership', 0, 0, ".
$MEMBERSHIP_FEE ." Amount, 'Membership fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m  where m.PrimaryContact='Yes' and m.FamilyID ='". $fid ."'   limit 1";
	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for family membership fee <br>Debug info: $updatecmd <br>\n");
 }
}
// registration fee

$updatecmd="                       insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 14 IncomeCategory, m.MemberID, m.FamilyID, 'Registration', 0, 0, ".
$REG_REG_FEE_DOLLAR ." Amount, 'Registration fee ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m  where m.PrimaryContact='Yes' and  m.FamilyID ='". $fid ."'   limit 1";

//echo "$updatecmd<br><br>";
$qstr = "select count(*) as cnt from tblReceivable i where  i.FamilyID ='".$fid ."' and i.Description='Registration fee ". $SchoolYear. "' ";
$result = mysqli_query(GetDBConnection(),$qstr) or die ("failed to query exisinting membership record" . $qstr);
$row = mysqli_fetch_array($result) or die ("failed to read row");
if ( $row[cnt] < 1 ) {
	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for family registration fee <br>Debug info: $updatecmd <br>\n");
}

// safety patrol deposit (20140919 Neil: disabled)
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`,  `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
    select 15 IncomeCategory,MemberID,FamilyID, 'PatrolDeposit',  0, 0,
$PARENT_DUTY_FEE Amount,    'Safety Patrol Deposit ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember
where PrimaryContact='Yes' and FamilyID in
(select m.FamilyID from tblClass c,tblClassRegistration cr,tblMember m
where c.CurrentClass='Yes' and c.Term='Fall' ".$sqlmod1." and c.ClassID=cr.ClassID and cr.StudentMemberID=m.MemberID and cr.Status !='Dropped')
and not exists (select MemberID from tblReceivable i
where i.MemberID=tblMember.MemberID ".$sqlmod3." and i.Description='Safety Patrol Deposit ".$SchoolYear."' and IncomeCategory=15)";
if ( $familyid != "all"  && $familyid != "") {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 15 IncomeCategory, m.MemberID, m.FamilyID, 'PatrolDeposit', 0, 0, ".
$PARENT_DUTY_FEE ." Amount, 'Safety Patrol Deposit ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m , viewClassStudents v where m.PrimaryContact='Yes' and m.FamilyID=v.FamilyID and v.Status='OK' and v.CurrentClass='Yes'  and m.FamilyID ='". $familyid ."'  and not exists (select MemberID from tblReceivable i where i.MemberID=m.MemberID and i.FamilyID ='". $familyid ."' and i.Description='Safety Patrol Deposit ".$SchoolYear."' ) limit 1";
} else {
$updatecmd="insert into tblReceivable (IncomeCategory,MemberID,FamilyID, `ReceivableType`, `ClassID`,ClassRegistrationID,Amount, `Description` ,`DateTime`,createdByMemberID)
select 15 IncomeCategory, m.MemberID, m.FamilyID, 'PatrolDeposit', 0, 0, ".
$PARENT_DUTY_FEE ." Amount, 'Safety Patrol Deposit ".$SchoolYear."' ,now(), ".$_SESSION[memberid] ."
from tblMember m  where m.PrimaryContact='Yes' and m.FamilyID in (select v.FamilyID from viewClassStudents v
where v.Status='OK' and v.CurrentClass='Yes'  )
and not exists (select MemberID from tblReceivable i where i.
MemberID=m.MemberID  and i.Description='Safety Patrol Deposit ".$SchoolYear."' )";
}
//echo "$updatecmd<br><br>";
//	$result = mysqli_query(GetDBConnection(),$updatecmd) or die ("died while Updating Income for family patrol deposit <br>Debug info: $updatecmd <br>\n");

}

?>
