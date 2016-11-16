 	 		<td valign='top'>
 	 		<a href="../../prod_v14">[Home]</a><a href="../MemberAccount/MemberAccountMain.php">[My Account]</a><br><br><br>
 	 		<div class=Section1 style="layout-grid:15.6pt 0pt" align="left">
 	 		<table border="0" cellspacing="0">
 	 			<tr class='textlargeBoldBrown'><td>Class Management</td></tr>
 	 			<tr class='textmedium'><td>&nbsp;List Classes</td></tr>
 	 			<tr class='textmedium'><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="listallclasses.php?type=all">All</a></td></tr>
 	 			<tr class='textmedium'><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="listallclasses.php?type=cur">Current</a></td></tr>
				<tr class='textmedium'><td>&nbsp;List Students</td></tr>
				<tr class='textmedium'><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="listallstudents.php?type=all">All</a></td></tr>
				<tr class='textmedium'><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="listallstudents.php?type=reg">Registered</a></td></tr>
             <?php if ($_SESSION['membertype'] == 10 || $_SESSION['membertype'] == 20 || $_SESSION['membertype'] == 15) { ?>
 	 			<tr class='textmedium'><td>&nbsp;Assign Classes</td></tr>
 	 			<!-- <tr class='textmedium'><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="listcurrentclasses.php">By prefered</a></td></tr> -->
 	 			<tr class='textmedium'><td>&nbsp;&nbsp;&nbsp;&nbsp;<a href="searchstudents.php">By special</a></td></tr>
             <?php } ?>
 	 		</table>
 	 		</div>
 	 	   </td>

