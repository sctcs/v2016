<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if( !isset($_GET[id]) || $_GET[id] =="" )
{
   echo "need to pass teacher id";
   exit;

}

if(isset($_SESSION['family_id']))
{  }
else
{header( 'Location: Logoff.php' ) ;
 exit();
}
include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

//mysql_select_db($dbName, $conn);

//echo $_SESSION['membertype'];
//echo $_SESSION['memberid'];
//exit();



?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Teacher Info</title>
<meta name="keywords" content="Southern Connecticut Chinese School, Chinese School">
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
					<td width="1%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php



						$SQLstring = "select *   from tblMember where MemberID = ". $_GET[id];
						//echo "see: ".$SQLstring;
						$RS1=mysqli_query($conn,$SQLstring);
						$RSA1=mysqli_fetch_array($RS1);


					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="left"><A HREF="javascript:javascript:history.go(-1)">Back</A>
								<a href="FamilyChildList.php">Child List</a>
								</td>
							</tr>
							<tr>
								<td align="center"><font><b><br>Teacher Info</b></font></td>
							</tr>

										<tr>
											<td width="50%" align="Right">MemberID: </td>
											<td width="50%" align="Left">&nbsp;<?php echo $RSA1[MemberID];?></td>
										</tr>
										<tr>
											<td width="50%" align="Right">FamilyID: </td>
											<td width="50%" align="left">&nbsp;<?php echo $RSA1[FamilyID];?></td>
										</tr>


										<tr>
											<td width="50%" align="Right">First Name:</td><td>&nbsp;<?php echo $RSA1[FirstName];?></td>
									<!--		<td><input type="text" size="28" name="PCFristName" value="<?php echo $RSA1[FirstName];?>"></td> -->
										</tr>
										<tr>
											<td width="50%" align="Right">Last Name:</td><td>&nbsp;<?php echo $RSA1[LastName];?></td>
									<!--		<td><input type="text" size="28" name="PCLastName" value="<?php echo $RSA1[LastName];?>"></td> -->
										</tr>
                                        <tr>
											<td width="50%" align="Right">Chinese Name:</td><td>&nbsp;<?php echo $RSA1[ChineseName];?></td>
										<!--
											<td><input type="text" size="28" name="PCChineseName" value="<?php echo $RSA1[ChineseName];?>"></td>
										-->
										</tr>
										<tr><td width="50%" align="Right">Home Phone:</td><td>&nbsp;<?php echo $RSA1[HomePhone];?></td></tr>
										<tr><td width="50%" align="Right">Cell Phone:</td><td>&nbsp;<?php echo $RSA1[CellPhone];?></td></tr>
										<tr><td width="50%" align="Right">Email:</td><td>&nbsp;<?php echo $RSA1[Email];?></td></tr>





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

<?php
    mysqli_close($conn);
 ?>