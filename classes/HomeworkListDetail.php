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

//mysql_select_db($dbName, $conn);

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Homework List</title>

<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
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
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>

					<?php
					 //  if ( $_SESSION[membertype] == 50 || $_SESSION[membertype] == 30 ) { // parents
					 //    $SQLstring = "select *   from tblClassHomework,viewClassStudents where tblClassHomework.ClassID=viewClassStudents.ClassID and tblClassHomework.Status='OK' and viewClassStudents.FamilyID=".$_SESSION[family_id]; //where CurrentClass='Yes'";
					 //  } else {
 						 $SQLstring = "select *   from tblClassHomework,tblClass where tblClassHomework.ClassID=tblClass.ClassID and tblClassHomework.Status='OK' and tblClass.CurrentClass='Yes'";
 						 if ( isset($_GET[myhws]) &&  $_GET[myhws] == 1)
                         {
                            $SQLstring .= " and tblClass.TeacherMemberID=".$_SESSION[memberid];
                         }
					 //  }
					   if ( isset($_GET[grade]) && $_GET[grade] != "" ) {
					      $SQLstring .= " and GradeOrSubject='".$_GET[grade]."'";
					   }
					   if ( isset($_GET[number]) && $_GET[number] != "" ) {
					   	  $SQLstring .= " and ClassNumber=".$_GET[number];
					   }
					   $SQLstring .= " order by GradeOrSubject, ClassNumber, ClassHomeworkID DESC";

						$RS1=mysqli_query($conn,$SQLstring);
						if (! $RS1 ) {
						   //echo $_SESSION[family_id];
												  echo mysqli_error($conn);
												  exit;
						}
						$SQLstring2 = "select distinct GradeOrSubject,ClassNumber,TeacherMemberID   from tblClassHomework,tblClass where tblClassHomework.ClassID=tblClass.ClassID and tblClassHomework.Status='OK' and tblClass.CurrentClass='Yes' ";
						//$SQLstring2 .= " order by GradeOrSubject, ClassNumber";
					   if ( isset($_GET[grade]) && $_GET[grade] != "" ) {
					      $SQLstring2 .= " and GradeOrSubject='".$_GET[grade]."'";
					   }
					   if ( isset($_GET[number]) && $_GET[number] != "" ) {
					   	  $SQLstring2 .= " and ClassNumber=".$_GET[number];
					   }

						$RS2=mysqli_query($conn,$SQLstring2);
						if (! $RS2 ) {
						   //echo $_SESSION[family_id];
												  echo mysqli_error($conn);
												  exit;
						}

					?>

					<td align="center" valign="top">
						<br>Homework List of <font color=red><?php echo $_GET[grade].".".$_GET[number]; ?></font>

						<?php

						if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25) {
						 if (! isset($_GET[myhws]) ||  $_GET[myhws] != 1) {
						    //echo " of all classes";
						 } else {
						    //echo " of my class";
						 }
						 }


						//echo '<br><br>';

						if ( $_SESSION[membertype] != 50 && $_SESSION[membertype] != 30 ) { // not parents and students
						 while ( $row2=mysqli_fetch_array($RS2) ){
						  $anch=$row2[GradeOrSubject]. '.'. $row2[ClassNumber];
 						  if ( ! isset($anchs[$anch]) ) {
						   $anchs[$anch]=1;

						   //echo '<a href="#'.$anch.'">'.$anch.'</a> | ';
						  }
						 }
						}
						 ?>

						<table width="100%" border="1">

						<tr><th>Grade</th><th>Class</th><th>Room</th><th nowrap>HW No</th><th nowrap>Homework Desc</th><th nowrap>Due Date</th>
						    <th nowrap>Open/Download</th>
						<?php if ( isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25 ) { ?>
						    <th nowrap>Detail</th>
						<?php } ?>
                        <?php if(  isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25 ) { ?>
						    <th nowrap>Delete</th>
						<?php } ?>
						</tr>
                    <?php
                      $upload=0;
					  while ( $row=mysqli_fetch_array($RS1) ){
						echo "	<tr>";
						$anchor=$row[GradeOrSubject]. '.'. $row[ClassNumber];
						if ( ! isset($anchors[$anchor]) ) {
						   $anchors[$anchor]=1;
						   echo ' <a name="'.$anchor.'"></a>';
						}
						echo "		<td align=center>" . $row[GradeOrSubject] ."</td><td align=center>". $row[ClassNumber] . "</td><td nowrap align=center>". $row[Classroom] ."</td>" ;
						echo "		<td align=center>" . $row[ClassHomeworkID] ."</td><td align=left>". $row[Description] . "</td><td nowrap align=center>". $row[DueDate] ."</td>" ;
					if (isset($row[Filetype]) && $row[Filetype] !="") {
						echo "      <td align=center><a href=\"".$row[Filepath].'/'.$row[ClassID].'_'.$row[Filename].'.'.$row[Filetype]."\">open/download</a></td>";
					} else {
						echo "      <td align=center><a href=\"".$row[Filepath].'/'.$row[ClassID].'_'.$row[Filename]."\">open/download</a></td>";
					}
					   if( $row[TeacherMemberID] == $_SESSION[memberid] && isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25) {
						echo "      <td align=center><a href=\"HomeworkDetail.php?hwid=".$row[ClassHomeworkID]."\">detail</a></td>";
						$upload=1;
					   } else {
					     echo "&nbsp;";
					   }
					   if( $row[TeacherMemberID] == $_SESSION[memberid] && isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25) {
						echo "      <td align=center><a href=\"HomeworkDeleteConfirm.php?hwid=".$row[ClassHomeworkID]."&hwmembid=".$row[TeacherMemberID]."\">delete</a></td>";
					   } else {
					      echo "&nbsp;";
					   }
						echo "	</tr>";
					  } // end while
						?>

						</table>
                     <?php
                       echo '<br><br>';

                      // if (! isset($_GET[myhws]) ||  $_GET[myhws] != 1)
                     //  {
                     //      ; // echo '<a href="HomeworkList.php?myhws=1">Of My Class Only</a> | ';
					 //  } else {
					   	  // echo '<a href="HomeworkList.php">Homeworks of other Classes</a> ';
					 //  }


                      if(   isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25) {

				         echo '<a href="HomeworkUploadForm.php?grade='.$_GET[grade].'&number='.$_GET[number].'">Upload a New Homework</a>';
				         }
				         echo "<br><BR>";
				          echo '<a href="HomeworkList.php">Homeworks of other Classes</a> ';
                         ?>
					</td>




				</tr>
				<tr><td></td><td>
				<br><br>
				                     Note on how to Download: <br>
				<ul>
				    <li> to open the homework file in your browser, move curser to Open/Download and click the left-button of your mouse;<br>
                    <li> to save the homework file to your computer, click the right-button and choose "Save Link As ...(Firefox)" or "Save Target As ...(IE)"
                </ul>
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