<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
//if(! isset($_SESSION['logon']) )
//{
// echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' ) ;
// exit();
//}

include("../common/DB/DataStore.php");

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Class Information</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
<script language="javascript" src="../common/JS/MainValidate.js"></script>
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
								<td align="center"><font><b>Class Information<br><br></b></font></td>
							</tr>

							<?php
								$SQLstring = " SELECT * FROM tblClass WHERE ClassID=".$_GET[id]; //echo $SQLstring;
								$RS1=mysqli_query($conn,$SQLstring);
								$RSA1=mysqli_fetch_array($RS1);
							?>




										<tr>
											<td width="20%" align="Right">ClassID: </td>
											<td><?php echo $RSA1[ClassID];?></td>
										</tr>
										<tr>
											<td width="20%" align="Right">Class Code: </td>
											<td><?php echo $RSA1[ClassCode];?></td>
										</tr>
<?php if ($SHOWTEACHER =='Yes' ) { ?>
										<tr>
											<td width="20%" align="Right">Teacher Name: </td>
											<td width="80%">

										<?php
										$sqleth="select tblMember.MemberID, Concat(LastName, ', ', FirstName) as Name from tblMember inner join tblTeacher on tblTeacher.MemberID = tblMember.MemberID where CurrentTeacher = 'Yes' order by Name";
										$rseth=mysqli_query($conn,$sqleth);
                                                                                $rweth=mysqli_fetch_array($rseth);
                                                                                                 echo $rweth[Name];
						                     	        ?>

											</td>

										</tr>
<?php   } ?>


										<tr>
											<td width="20%" align="Right">Grade or Subject: </td>
											<td><?php echo $RSA1[GradeOrSubject];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Class Number: </td>
											<td><?php echo $RSA1[ClassNumber];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Classroom: </td>
											<td><?php echo $RSA1[Classroom];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Current Class: </td>
											<td><?php echo $RSA1[CurrentClass];?></td>
										</tr>


										<tr>
											<td width="20%" align="Right">Class Fee: </td>
											<td><?php echo $RSA1[ClassFee];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Year: </td>
											<td><?php echo $RSA1[Year];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Term: </td>
											<td><?php echo $RSA1[Term];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Period: </td>
											<td><?php echo $RSA1[Period];?></td>
										</tr>

										<tr>
											<td width="20%" align="Right">Seats: </td>
											<td><?php echo $RSA1[Seats];?></td>
										</tr>
		
										<tr>
											<td width="20%" align="Right">Language? </td>
											<td><?php echo $RSA1[IsLanguage];?></td>
										</tr>
										<tr>
											<td width="20%" align="Right" valign=top>Description:</td>
											<td><?php echo $RSA1[Description];?>  </td>
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
