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
if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] >= 25)
{
 echo ( 'you need to log in as a <a href="MemberAccountMain.php">school admin or DBA</a>' ) ;
 exit();
}

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Class List</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
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
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>

					<?php
						$SQLstring = "select * from tblMember order by LastName, FirstName";
						$RS1=mysqli_query($conn,$SQLstring);

					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>Member List</b></font></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="1" width="100%">

										<tr bgcolor="#990000">
											<td><font color="#FFFFFF">Member ID</font></td>
											<td><font color="#FFFFFF">Family ID</font></td>
											<td><font color="#FFFFFF">First Name</font></td>
											<td><font color="#FFFFFF">Last Name</font></td>
											<td><font color="#FFFFFF">Chinese Name</font></td>
											<td><font color="#FFFFFF">User Name</font></td>
											<td><font color="#FFFFFF">Password</font></td>
											<td><font color="#FFFFFF">Email</font></td>
											<td><font color="#FFFFFF">Home Address</font></td>
											<td><font color="#FFFFFF">Home City</font></td>
											<td><font color="#FFFFFF">Primary Contact</font></td>

										</tr>
										<form>
										<?php
											$i=0;
											while($RSA1=mysqli_fetch_array($RS1))

										{ ?>
										<tr>
											<td><?php echo $RSA1[MemberID];?></td>
											<td><?php echo $RSA1[FamilyID];?></td>
											<td><?php echo $RSA1[FirstName];?></td>
											<td><?php echo $RSA1[LastName];?></td>
											<td><?php echo $RSA1[ChineseName];?></td>
											<td><?php echo $RSA1[UserName];?></td>
											<td><?php echo $RSA1[Password];?></td>
											<td><?php echo $RSA1[Email];?></td>
											<td><?php echo $RSA1[HomeAddress];?></td>
											<td><?php echo $RSA1[HomeCity];?></td>
											<td><?php echo $RSA1[PrimaryContact];?></td>

											<td>

												<input type="hidden" value="<?php echo $RSA1[MemberID ];?>"  name="SID<?php echo $i;?>">

											</td>

										</tr>
										<?php
											$i++;
										} ?>

										</form>
									</table>
								</td>
							</tr>
							<tr>
								<td align="center">&nbsp;</td>
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
