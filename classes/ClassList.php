<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
 exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] >= 25)
//{
 //echo ( 'you need to log in as a school admin' ) ;
// exit();
//}

include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Class List</title>

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

					<?php
 if (isset($_GET[Year]) && $_GET[Year] != "" ) {
   $year = $_GET[Year];
 } else {
   $year = $CurrentYear;
 }
 if (isset($_GET[Term]) && $_GET[Term] != "" ) {
   $term = $_GET[Term];
 } else {
   $term = $CurrentTerm;
 }
//				$SQLstring = "select * from tblClass left join tblMember on tblClass.TeacherMemberID = tblMember.MemberID where (CurrentClass='Yes' or CurrentClass='Pri') order by ClassCode,GradeOrSubject, ClassNumber";
$SQLstring = "select * from tblClass left join tblMember on tblClass.TeacherMemberID = tblMember.MemberID where tblClass.Year='".$year."' and tblClass.Term='".$term."' order by ClassCode,GradeOrSubject, ClassNumber";
						$RS1=mysqli_query($conn,$SQLstring);

					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>Class List: <?php echo $year," ",$term,", "; 
 if ($year == $CurrentYear) {
   echo "<a href=\"ClassList.php?Year=".$NextYear."&Term=".$NextTerm."\"> ". $NextYear ." ". $NextTerm."</a>";
 }
 if ($year == $NextYear) {
   echo "<a href=\"ClassList.php?Year=".$CurrentYear."&Term=".$CurrentTerm."\"> ". $CurrentYear ." ". $CurrentTerm."</a>";
 }
 ?></b></font></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="1" width="100%">

										<tr bgcolor="#990000">
										    <td><font color="#FFFFFF">ClassID</font></td>
										    <td><font color="#FFFFFF">Class Code</font></td>
											<td><font color="#FFFFFF">Teacher Name</font></td>
											<td><font color="#FFFFFF">Grade or Subject</font></td>
											<td><font color="#FFFFFF">Class Number</font></td>
											<td><font color="#FFFFFF">Class Room</font></td>
											<td><font color="#FFFFFF">Current Class</font></td>
											<td><font color="#FFFFFF">Class Fee</font></td>
											<td><font color="#FFFFFF">Year</font></td>
											<td><font color="#FFFFFF">Term</font></td>
											<td><font color="#FFFFFF">Period</font></td>
											<td><font color="#FFFFFF">Seats</font></td>

										</tr>
										<form action="ClassEdit.php" method="post">
										<?php
											$i=0;
											while($RSA1=mysqli_fetch_array($RS1))

										{ ?>
										<tr>
										    <td><?php echo $RSA1[ClassID];?></td>
										    <td><?php echo $RSA1[ClassCode];?></td>
											<td><?php echo $RSA1[FirstName]. " ". $RSA1[LastName];?></td>
											<td><?php echo $RSA1[GradeOrSubject];?></td>
											<td><?php echo $RSA1[ClassNumber];?></td>
											<td><?php echo $RSA1[Classroom];?></td>
											<td><?php echo $RSA1[CurrentClass];?></td>
											<td><?php echo $RSA1[ClassFee];?></td>
											<td><?php echo $RSA1[Year];?></td>
											<td><?php echo $RSA1[Term];?></td>
											<td><?php echo $RSA1[Period];?></td>
											<td><?php echo $RSA1[Seats];?></td>

											<td>

												<input type="hidden" value="<?php echo $RSA1[ClassID ];?>"  name="SID<?php echo $i;?>">

												<input type="submit" value="Edit " onClick="sendme(<?php echo $i;?>);">

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
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><input type="button" value="Add New Class " onClick="window.location.href='ClassAddNew.php'"></td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
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
