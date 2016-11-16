<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if(! isset($_SESSION['logon']) )
{
 echo "<center>";
 echo ( 'you need to <a href="MemberLoginForm.php">login</a> first' ) ;
 exit();
}
if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 25)
{
 echo "<center>";
 echo ( 'you need to <a href="MemberAccountMain.php">login as a school admin</a>' ) ;
 exit();
}

include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);

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
                  <?php
                     $SQLstring = "select *  from tblMemberType";
						$RS1=mysqli_query($conn,$SQLstring);
						//$RSA1=mysqli_fetch_array($RS1);
					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>Email List Parameters</b></font></td>

							</tr>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="0" width="100%">

										<form name="NewMember" action="CreateMemberEmailList.php" method="post" onSubmit="return Validate(this);">

                                        <input type="hidden" name="newmember" value="1">
                                        <input type="hidden" name="newmembertype" value="<?php echo $_GET[newmembertype];?>">

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
											<td width="50%" align="Right">Member Type: </td>
											<td>
											 <select name="MemberTypeID">
											   <?php while ($RSA1=mysqli_fetch_array($RS1) )
											         {
											            if ($RSA1[MemberTypeID] == 15 ) {
											             echo "<option selected value=\"". $RSA1[MemberTypeID]. "\">".$RSA1[MemberType]." </option>";
											            } else {
											             echo "<option value=\"". $RSA1[MemberTypeID]. "\">".$RSA1[MemberType]." </option>";
											            }
											         }
											   ?>
											 </select>
											</td>
										</tr>
										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
											<td width="50%" align="Right" valign="Top">If Parent: </td>

											<td><input type="radio" name="Parent" value="primary" checked>Primary Contact Only<BR>
											    <input type="radio" name="Parent" value="both">Both Parents</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td width="50%" align="Right" valign="Top">Fields: </td>
											<td><input type="checkbox"  name="FirstName" value="fn">First Name<BR>
											    <input type="checkbox"  name="LastName" value="ln">Last Name<BR>
											    <input type="checkbox"  name="HomePhone" value="hp">Home Phone<BR>
											    <input type="checkbox"  name="Email" value="em" checked>Email Address
											</td>
										</tr>

										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>

										<tr>
											<td width="50%" align="Right" valign="Top">Format: </td>

											<td><input type="radio" name="Format" value="perline" checked>One Entry Per Line<BR>
											    <input type="radio" name="Format" value="comma">Comma Separated</td>
										</tr>





										<tr>
											<td align="center" colspan="2">&nbsp;</td>
										</tr>
										<tr>
											<td align="right">
												<input type="submit" value="Create">
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
