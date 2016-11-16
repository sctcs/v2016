<?php
//session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
session_start();
/*
if(! isset($_SESSION['logon']) )
{
 echo ( 'you need to log in' ) ;
 header( 'Location: MemberLoginForm.php');
 exit();
}
if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
{
 echo ( 'you need to log in as a teacher or school admins' ) ;
 header( 'Location: MemberLoginForm.php' );
 exit();
}
if(! isset($_GET[teacherid]) )
{
 echo ( 'you need to enter  a valid teacher memberID' ) ;
 exit();
}*/
include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>YNHCS Students in a Class</title>
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

<center>

					<?php

					//  $SQLstring = "select *   from viewClassStudents where TeacherMemberID=".$_GET[teacherid]." order by LastName";//.$_SESSION[memberid];
						$SQLstring = "select *   from viewClassStudents order by LastName";//.$_SESSION[memberid];
						//echo "see111: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
                        $allemails="";
                        $ei=0;

					$row=mysqli_fetch_array($RS1);
					echo "<h3>Students in Class:<font color=\"red\"> ". $row[GradeOrSubject].".".$row[ClassNumber]."</font></h3>";


                    $SQLstring1 = "select * from tblMember where MemberID=".$_GET[teacherid];
                    $RS1=mysqli_query($conn,$SQLstring1);
                    $row=mysqli_fetch_array($RS1);
                    ?>

				    <?php if (isset($_SESSION[membertype]) ) { ?>
				    <table width="70%"  CELLSPACING="0" CELLPADDING="0" border="0">
				    <?php } else {?>
				    <table width="60%"  CELLSPACING="0" CELLPADDING="0" border="0">
				    <?php } ?>
					<tr>
					    <td nowrap>Teacher Name: <?php echo $row[FirstName]." ".$row[LastName]."  ".$row[ChineseName]; ?></td>
					    <td nowrap>Class Name: <?php echo $_GET[classname]; ?></td>
					    <td nowrap>Class Room: <?php echo $_GET[classroom]; ?></td>
					</tr>
					</table>
					<?php if (isset($_SESSION[membertype]) ) { ?>
						<table width="70%" CLASS="page" CELLSPACING="0" CELLPADDING="0" border="1">
					<?php } else {?>
					    <table width="35%" CLASS="page" CELLSPACING="0" CELLPADDING="0" border="1">
					<?php } ?>
						<tr><th>No</th>
					<?php if (isset($_SESSION[membertype]) && $_SESSION[membertype] <= 25 ) { ?>
						<th>MemberID</th><th>FamilyID</th>
					<?php } ?>
						<th>English Name</th><th >Chinese Name</th>
					<?php if (isset($_SESSION[membertype]) ) { ?>
						<th >Parent Names</th><th >Parent Phones</th><th >Parent E-mails</th>
                    <?php }
                      if ( isset($_SESSION[membertype]) && $_SESSION[membertype] <= 25 ) {
                         echo "<th>Fee Paid</th>";
                      }
                      echo "</tr>";
                      $RS1=mysqli_query($conn,$SQLstring);
                      $no=0;
					  while ( $row=mysqli_fetch_array($RS1) ){
                        $no++;
						$PhoneArrary=explode("-",$row[HomePhone]);
						$CPhoneArrary=explode("-",$row[CellPhone ]);
						$SQLstring1 = "select * from tblMember where FamilyID=".$row[FamilyID]." and  MemberID not in (select MemberID from tblStudent) ";
						$RS2=mysqli_query($conn,$SQLstring1);
						$pphones="";
						$pemails="";
						$pnames="";

						while ( $row1=mysqli_fetch_array($RS2) ){

						   if ( $row1[HomePhone] != "" ) {
						    $pphones .= $row1[HomePhone]."(h)"; }
						   if ( $row1[OfficePhone] != "" ) {
						    $pphones .= "<br>".$row1[OfficePhone]."(o)";}
						   if ( $row1[CellPhone] != "" ) {
						    $pphones .= "<br>".$row1[CellPhone]."(c)";}
						  //  $pphones .= $row1[HomePhone]."(h), ".$row1[OfficePhone]."(o), ".$row1[CellPhone]."(c), ";
						  //  $pphones .= $row1[HomePhone]."(h), ".$row1[OfficePhone]."(o), ".$row1[CellPhone]."(c), ";
						   if ($row1[Email] != ""){
						     $allemails .= $row1[Email].", "; $ei++;
						     if ($pemails != ""){
						      $pemails .= "<br>".$row1[Email];
						     } else {
						      $pemails .= "".$row1[Email];
						     }
						   } //.",". $row1[SecondEmail].",";
						   if ($row1[SeconEmail] != ""){
						    $allemails .= $row1[SecondEmail].", "; $ei++;
						    $pemails .= "<br>".$row1[SecondEmail];}
						    $pnames  .= $row1[LastName].", ".$row1[FirstName]."; ";
						}

						//query tblIncome for tuiition payment
						if (strlen($_GET[classname]) <= 4) {
						   // language class
						   //$sqlstr3 = "SELECT sum(Amount) as amt FROM `tblIncome` where  `PayeeMemberID`=".$row[MemberID]." and IncomeCategory=2";
						   $sqlstr3 = "SELECT sum(Amount) as amt FROM tblReceivablePayRecord,ViewReceivable where  tblReceivablePayRecord.ReceivableID=ViewReceivable.ReceivableID and ViewReceivable.MemberID=".$row[MemberID]." and Description='Language Class'";
						} else {
						   // art class
						   //$sqlstr3 = "SELECT sum(Amount) as amt FROM `tblIncome` where  `PayeeMemberID`=".$row[MemberID]." and IncomeCategory in (3,4,5)";
						   $sqlstr3 = "SELECT sum(Amount) as amt FROM tblReceivablePayRecord,ViewReceivable where  tblReceivablePayRecord.ReceivableID=ViewReceivable.ReceivableID and ViewReceivable.MemberID=".$row[MemberID]." and Description !='Language Class'";
						}
						if ( isset($_SESSION[membertype]) && $_SESSION[membertype] <= 25 ) {
						//echo $sqlstr3;
						$RS3=mysqli_query($conn,$sqlstr3);
						$row3=mysqli_fetch_array($RS3);
						$amount = $row3[amt];
						//if ((strlen($_GET[classname]) <= 4 && $amount >= 120.00 ) || (strlen($_GET[classname]) > 4 && $amount >= 70.00 )) {
						//  $paid = "Yes";
						//} else {
						//  $paid = "No";
						//}
						}
						echo "	<tr><td class=\"page\" align=center>".$no."</td>";
						if (isset($_SESSION[membertype]) && $_SESSION[membertype] <= 25 ) {
						echo "		<td class=\"page\" align=center>" . $row[MemberID] ."</td>";
						echo "      <td class=\"page\" align=center>". $row[FamilyID] . "</td>";
						}
						echo "<td nowrap class=\"page\" >". $row[LastName] .", ". $row[FirstName] ."</td>";
						echo "      <td class=\"page\">". $row[ChineseName] ;
                        if( isset($_SESSION[membertype]) ){
						echo     "</td><td class=\"page\">".$pnames."</td><td class=\"page\">".$pphones."</td><td class=\"page\">".$pemails."</td>";
						}
						if (isset($_SESSION[membertype]) && $_SESSION[membertype] <= 25 ) {
						                         echo "<td class=\"page\" align=center>".$amount."</td>";
                        }
						echo "	</tr>";


					  }
						?>
						</table>

</table>
<?php
if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25) {  ?>
<table width="70%" CLASS="page" CELLSPACING="0" CELLPADDING="4" border=1>
<tr><td>All E-mail addresses:</td><td> <?php //echo $allemails; ?></td></tr>
</table>
<?php } ?>
</center>
</body>
</html>
<?php mysqli_close($conn); ?>