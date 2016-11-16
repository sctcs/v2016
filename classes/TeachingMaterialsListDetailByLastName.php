<?php

if ( $_SERVER["SERVER_NAME"] != "localhost" ) 
  {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
  }

session_start();

if( !isset($_SESSION['logon']) || !isset($_SESSION[membertype]) ||  $_SESSION[membertype] > 100)
{
 echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a> as a member to view the list.' ) ;
 exit();
}


include("../common/DB/DataStore.php");

//mysqli_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <title>Teaching Material List</title>
  <meta http-equiv="Content-type" content="text/html; charset=gb2312" />
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
					<td width="0%" align="center" valign="top">
						<table width="100%">
							<tr><td> &nbsp; </td></tr>
													</table>
					</td>

					<?php
			
 					$SQLstring = $SQLstring = "select tblTeachingMaterials.*, LastName, FirstName from tblTeachingMaterials INNER JOIN tblMember ON MemberID=CreatedByMemberID where DisplayOnline='Y' ORDER BY LastName ASC, CreatedDate ASC";
					$RS1=mysqli_query($conn,$SQLstring);
					
					?>

					<td align="center" valign="top">
						<br>Teaching Material List</font><br>

						<table width="100%" border="1">

						<tr><th>file Description</th><th nowrap><a href="TeachingMaterialsListDetail.php">类别</a></th><th nowrap><a href="TeachingMaterialsListDetailByGrade.php">实用年级</a></th><th><a href="TeachingMaterialsListDetailByDate.php">上传时间</a></th><th><a href="TeachingMaterialsListDetailByLastName.php">上传人</a></th> 
						    <th nowrap>Open/Download</th>
						<?php if ( isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25 ) { ?>
						    <th nowrap>Delete</th>
						<?php } ?>
						</tr>

                    			<?php
                      			  $upload=0;
					  while ( $row=mysqli_fetch_array($RS1) ){
						echo "	<tr>";
						echo "	<td align=center>". $row[FileDescription] ."</td><td align=center>". $row[MaterialType] . "</td><td nowrap align=center>". $row[MaterialGrade] ."</td>" ;
						echo "	<td align=center>" . $row[CreatedDate] ."</td><td align=left>". $row[LastName].','.$row[FirstName] . "</td>" ;
						echo "  <td align=center><a href=\"".$row[Filepath].'/'.$row[FileName].'.'.$row[FileType]."\">open/download</a></td>";
					   if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25) {
						$upload=1;
					   } else {
					     echo "&nbsp;";
					   }

					   if( isset($_SESSION[memberid]) &&  $_SESSION[memberid] == $row[CreatedByMemberID]) {
						echo " <td align=center><a href=\"TeachingMaterialsDeleteConfirm.php?tmid=".$row[TeachingMaterialID]."\">delete</a></td>";
					   } else {
					      echo "&nbsp;";
					   }
						echo "	</tr>";
						
					  } // end while
					?>

						</table>
 
                    <?php
                       echo '<br><br>';

                      if(   isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25) {

				         echo '<a href="TeachingMaterialsUploadForm.php">Upload a New Teaching Material</a>';
				         }
			  ?>
<div align="left">				
				<br><br>                   Note on how to Download: <br>
				<ul>
				    <li> To open a teaching material file in your browser, move curser to Open/Download and click the left-button of your mouse;<br>
                    <li> To save a teaching material file to your computer, click the right-button and choose "Save Link As ...(Firefox)" or "Save Target As ...(IE)"
			  <li> To sort the materials, click the column title with a hyperlink.
                </ul>
</div>
					</td>


					</tr>
				<tr><td></td><td>


                     </td></tr>
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
<?php mysqli_close($conn); ?>