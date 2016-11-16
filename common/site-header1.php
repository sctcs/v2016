<table width="780" border="0">

  <tr align="center">
    <td><img width="600" height="135" src="../Image/School_Logo.jpg" ALIGN="CENTER"></td>
  </tr>

  <tr>
    <td>
		<table width="100%">
			<tr  align="center" >
				<td ><a href="../public/index.php"><font class="textlargeBoldBrown">
<img src="../Image/sy.png" align="absmiddel" border="0"/></font></a></td>
				<td>&nbsp;|</td>
				<td>
				<a href="../public/StudentRule.php">
				<!-- <a href="../../Registration/MemberRegistration.php" > -->
				<font class="textlargeBoldBrown">
<img src="../Image/jxgl.png" align="absmiddel" border="0"/></font></a></td>
				<td>&nbsp;|</td>
				<td><a href="../public/AnnouncementEN.php"><font class="textlargeBoldBrown">
<img src="../Image/xwxx.png" align="absmiddel" border="0"/></font></a></td>
				<td>&nbsp;|</td>
				<td><a href="../public/AboutSouthernCT.php"><font class="textlargeBoldBrown">
<img src="../Image/xysq.png" align="absmiddel" border="0"/></font></a></td>

				<td>&nbsp;|</td>

				<?php if(isset($_SESSION['logon'])) { ?>

				<td> <a href="../MemberAccount/Logoff.php" ><font class="textlargeBoldBrown">Logout</font></a>|<a href="../MemberAccount/MemberAccountMain.php" >My Account</a></td>
				<?php }
					else {
				?>

				<!--<td> <a href="/db/register.php?action=12" onclick="return com.jschart.get(this, 'mainContent');"><font class="textlargeBoldBrown">
<img src="../Image/xydl.png" align="absmiddel" border="0"/></font></a></td>-->

				 <td> <a href="../MemberAccount/MemberLoginForm.php" ><font class="textlargeBoldBrown">
<img src="../Image/xydl.png" align="absmiddel" border="0"/></font></a>
                                      <a href="../MemberAccount/MemberLoginForm.php" >Login
</a>
                                 </td>

				<?php } ?>
			</tr>
		</table>
	</td>
  </tr>
</table>

