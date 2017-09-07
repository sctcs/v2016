<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

$seclvl = $_SESSION['membertype'];
if ( $seclvl != 10 && $seclvl !=20 && $seclvl != 35 && $seclvl != 40  && $seclvl != 55) { //principal, DBA, Board Member, School Admin, Collector
    echo "not authorized";
    exit();

}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

$today = getdate();
$year = $today[year];
$mon = $today[mon];

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Safety Patrol Form</title>
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
		<td width="98%" >

			<?php
$year=$_POST[year];
$term=$_POST[term];
$period=$_POST[period];
$nf=$_POST[nf];
$sdate=$_POST[sdate];

     $SQLstring = "
select distinct v.FamilyID, c.Year,c.Term, concat_ws('-', v.GradeOrSubject,v.ClassNumber) as ChildClass, c.Period,'".$sdate . "' as ScheduledDate
from viewClassStudents v, tblClass c
where v.ClassID=c.ClassID

and c.CurrentClass='Yes'
and c.Period in ('" . $period . "','". ($period + 1)."')  
and c.Term='" . $term . "'
and c.Year='" . $year . "'
and v.FamilyID not in
( select p.FamilyID from tblSafetyPatrol p where
    p.Term='". $term . "'
and p.Year='". $year . "'
)
and v.FamilyID not in
(SELECT distinct m.FamilyID FROM `tblClass` c,tblMember m where c.TeacherMemberID=m.MemberID and c.CurrentClass='Yes'
)
and v.FamilyID not in (785,1600,1891,2401,2067,37,54,210)

limit " . $nf ;
//echo $SQLstring;
     $RS1=mysqli_query($conn,$SQLstring);
   //  $RSA1=mysqli_fetch_array($RS1);
?>
<table width="100%">
<tr>
<td align="center"><BR>Assign Safety Patrol for a Day</td>
</tr>

<tr>
<td align="center">&nbsp;</td>
</tr>
<tr>
<td>
<table  CLASS="page" cellpadding=1 cellspacing=1  border="1" width="100%">
<th>No</th><th>Scheduled Date</th><th>Period</th><th>FamilyID</th><th>ChildClass</th>
<?php
$i=0;
while($RSA1=mysqli_fetch_array($RS1)) {

//if ($RSA1[Period] =="1") {$period=$PERIOD1;}else{$period=$PERIOD3;}
$fid=$RSA1[FamilyID];
if ( $track[$fid] == "" ) {
$i++;
$track[$fid]=1;
$rs[$i][sd]= $RSA1[ScheduledDate];
$rs[$i][fid]=$RSA1[FamilyID];
$rs[$i][cc]= $RSA1[ChildClass];
$rs[$i][pd] = $RSA1[Period];
}

echo "<tr>";
echo "    <td align=center>". $i ."</td>";
echo "    <td align=center>". $RSA1[ScheduledDate] ."</td>";

echo "    <td align=center>". $period ."</td>";
////echo "    <td align=center>". $RSA1[Name] ."</td>";
echo "    <td align=center>". $RSA1[FamilyID] ."</td>";
echo "    <td align=center>". $RSA1[ChildClass] ."</td>";
echo "</tr>";

}

for ($i=1; $i <= count($rs); ++$i) {

echo "<tr>";
echo "    <td align=center>". $i ."</td>";
echo "    <td align=center>". $rs[$i][sd] ."</td>";

echo "    <td align=center>". $rs[$i][pd] ."</td>";
////echo "    <td align=center>". $RSA1[Name] ."</td>";
echo "    <td align=center>". $rs[$i][fid] ."</td>";
echo "    <td align=center>". $rs[$i][cc] ."</td>";
echo "</tr>";

}

if (isset($_POST[save])) {
for ($i=1; $i <= count($rs); ++$i) {
 $SQLstring = "insert into tblSafetyPatrol (FamilyID,Year,Term,ChildClass,Period,ScheduledDate) ". 
              " values('".$rs[$i][fid] ."', '". $year . "', '". $term . "', '". $rs[$i][cc] . "', '". $rs[$i][pd] . "', '". $rs[$i][sd] ."')";
//echo $SQLstring;
   mysqli_query($conn,$SQLstring);
}
}

?>
</table>
</td>
</tr>
<tr>
<td align="center">&nbsp;
<a href="AssignSafetyPatrol_form.php?sdate=<?php echo $sdate; ?>&nf=<?php echo $nf;?>&pd=<?php echo $period;?>&term=<?php echo $term;?>&year=<?php echo $year;?>">OK</a>
</td>
</tr>
</table>
</td>
</tr>
</table>
</body>
</html>

<?php
    mysqli_close($conn);
 ?>
