<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
 session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>School Activity List</title>
<meta name="keywords" content="Southern Connecticut Chinese School, Chinese School, SCCS">
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
						$SQLstring = "select * from tblActivity where active ='Y'";

						$RS1=mysqli_query($conn,$SQLstring);
					?>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td align="center"><font><b>School Activity List</b></font></td>
							</tr>


							<tr>
								<td align="center">&nbsp;</td>
							</tr>
							<tr>
								<td bgcolor="#000000">
									<table CLASS="page" bgcolor="#FFFFFF" border="1" width="100%">

										<tr bgcolor="#990000">
											<td><font color="#FFFFFF">Activity Name</font></td>
											<td><font color="#FFFFFF">Activity Description</font></td>
											<td><font color="#FFFFFF">Date and Time</font></td>
											<td><font color="#FFFFFF">Location</font></td>
											<td><font color="#FFFFFF">Main Contact</font></td>
											<td><font color="#FFFFFF">Other Contacts</font></td>
											<td><font color="#FFFFFF">Action</font></td>

										</tr>
										<form action="ActivityRegView.php" method="post">
										<?php
											$i=0;
											while($RSA1=mysqli_fetch_array($RS1))

										{ ?>
										<tr>
											<td><?php echo $RSA1[ActivityName];?></td>
											<td><?php echo $RSA1[Activity];?></td>
											<td><?php echo $RSA1[DateAndTime];?></td>
											<td><?php echo $RSA1[Location];?></td>
											<td><?php echo $RSA1[MainContact];?></td>
											<td><?php echo $RSA1[OtherContacts];?></td>

											<td>

												<input type="hidden" value="<?php echo $RSA1[ActivityID ];?>"  name="SID<?php echo $i;?>">

												<input type="submit" value="View Participants " onClick="sendme(<?php echo $i;?>);">

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
							<?php if ( isset ($_SESSION['memberid']) && $_SESSION['memberid'] != "") { ?>
							<td aling="center"> <a href="ActivityListForMember.php">sign up</a> for activities</td>
							<?php } else { ?>
							<td aling="center">Please <a href="../MemberAccount/MemberLoginForm.php">log in</a> to sign up for activities</td>
							<?php } ?>

							<tr>

								<td align="center">&nbsp;</td>
							</tr>
<td aling="center"><a href="http://picasaweb.google.com/lh/photo/Qj0WK8pBOG9oa-c2LO8-zg?authkey=Gv1sRgCJ6_nt_kyYvD_wE&feat=directlink" target="_blank">View</a> winners and Finalists from SCCS First Card Game Championship</td>

							<tr>

								<td align="center">&nbsp;</td>
							</tr>

<td aling="center"><a href="http://picasaweb.google.com/mlei8972/Cardgame2009?authkey=Gv1sRgCLXhnazEyI3ipgE&feat=directlink#" target="_blank">View</a> photos from SCCS First Card Game Championship</td>


							<tr>

								<td align="center">&nbsp;</td>
							</tr>
<td aling="center"><a href="http://picasaweb.google.com/mcyuan/SCCSPTAPicnic92609?feat=email#" target="_blank">View</a> photos from 2009 PTA Picnic</td>

							<tr>

								<td align="center">&nbsp;</td>
							</tr>

<td aling="center"><a href="http://picasaweb.google.com/shal0333/091003210447?authkey=Gv1sRgCP2Vm_KIj5uwPg&feat=email#" target="_blank">More</a> photos from 2009 PTA Picnic</td>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
<td aling="center"><a href="http://www.flickr.com/photos/fchengphoto/sets/72157629399949353/" target="_blank">View</a> photos from 2012 Chinese School New Year Show</td>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
<td aling="center"><a href="https://plus.google.com/photos/115106817296204702336/albums/5846863447783233153?authkey=CKj98M38nebZ5gE#photos/115106817296204702336/albums/5846863447783233153?authkey=CKj98M38nebZ5gE" target="_blank">View</a> photos from 2013 Chinese School New Year Show</td>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
<td aling="center"><a href="http://www.flickr.com/photos/97035500@N08/sets/72157634315340204/" target="_blank">View</a> photos from 2013 PTA Picnic</td>
							<tr>
								<td align="center">&nbsp;</td>
							</tr>
<td aling="center"><a href="https://www.dropbox.com/sh/w0kmc0u6ta3k7vm/G8IFz5Woer" target="_blank">View</a> photos from 2014 Chinese School New Year Show</td>


						</table>

					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>

	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>

</table>



</body>
</html>

