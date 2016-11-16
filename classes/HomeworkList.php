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
include("../common/CommonParam/params.php");
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
 						 $SQLstring = "select *   from tblClassHomework,tblClass where tblClassHomework.ClassID=tblClass.ClassID and tblClassHomework.Status='OK'  AND tblClass.CurrentClass='Yes' ";
 						 if ( isset($_GET[myhws]) &&  $_GET[myhws] == 1)
                         {
                            $SQLstring .= " and tblClass.TeacherMemberID=".$_SESSION[memberid];
                         }

					   $SQLstring .= " order by GradeOrSubject, ClassNumber, ClassHomeworkID DESC";
					   //echo $SQLstring;

						$RS1=mysqli_query($conn,$SQLstring);
						if (! $RS1 ) {
						   //echo $_SESSION[family_id];
												  echo mysqli_error($conn);
												  exit;
						}
						$SQLstring2 = "select distinct ClassID,GradeOrSubject,ClassNumber,FirstName,LastName,ChineseName   from tblClass,tblMember where tblClass.TeacherMemberID=tblMember.MemberID   AND tblClass.CurrentClass='Yes' ";
						$SQLstring2 .= " order by GradeOrSubject, ClassNumber";
						if ($DEBUG) { echo $SQLstring2; }
						$RS2=mysqli_query($conn,$SQLstring2);
						if (! $RS2 ) {
						   //echo $_SESSION[family_id];
												  echo mysqli_error($conn);
												  exit;
						}

					?>

					<td align="center" valign="top">
						<br>Homework Folders by Class

						<?php
						//if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25) {
						// if (! isset($_GET[myhws]) ||  $_GET[myhws] != 1) {
						//    echo " of all classes";
						// } else {
						//    echo " of my class";
						// } }

						echo '<br><br>';

						//if ( $_SESSION[membertype] != 50 && $_SESSION[membertype] != 30 ) { // not parents and students
						 while ( $row2=mysqli_fetch_array($RS2) ){
						  $grade=$row2[GradeOrSubject];
						  $anch=$row2[GradeOrSubject]. '.'. $row2[ClassNumber];
 						  if ( ! isset($anchs[$anch]) ) {
						   $anchs[$anch]=1;
						   $teacherfn[$anch]=$row2[LastName]. ', '. $row2[FirstName];
                           $teachercn[$anch]=$row2[ChineseName];
						   //echo '<a href="#'.$anch.'">'.$anch.'</a> | ';
						   $hwcount[$anch] = 0;
						   $classcount[$grade] += 1;
						  }
						 }
						//}
						 ?>

						<table width="100%" border="1">

                    <?php
					  while ( $row=mysqli_fetch_array($RS1) ){
						//echo "	<tr>";
						$anchor=$row[GradeOrSubject]. '.'. $row[ClassNumber];
						$hwcount[$anchor] += 1;
				/*
						if ( ! isset($anchors[$anchor]) ) {
						   $anchors[$anchor]=1;
						   echo ' <a name="'.$anchor.'"></a>';
						}
						echo "		<td align=center>" . $row[GradeOrSubject] ."</td><td align=center>". $row[ClassNumber] . "</td><td nowrap align=center>". $row[Classroom] ."</td>" ;
						echo "		<td align=center>" . $row[ClassHomeworkID] ."</td><td align=left>". $row[Description] . "</td><td nowrap align=center>". $row[DueDate] ."</td>" ;
						echo "      <td align=center><a href=\"".$row[Filepath].'/'.$row[ClassID].'_'.$row[Filename].'.'.$row[Filetype]."\">download</a></td>";
					   if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] <= 25) {
						echo "      <td align=center><a href=\"HomeworkDetail.php?hwid=".$row[ClassHomeworkID]."\">detail</a></td>";
					   }
					   if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25) {
						echo "      <td align=center><a href=\"HomeworkDeleteConfirm.php?hwid=".$row[ClassHomeworkID]."&hwmembid=".$row[TeacherMemberID]."\">delete</a></td>";
					   }
						echo "	</tr>";
				*/
					  }
                      echo '<tr>';
                      echo '<th>Grade</th><th>Class 1</th><th>Class 2</th><th>Class 3</th><th>Class 4</th><th>Class 5</th>';
                      echo '</tr>';
                      foreach ($classcount as $grade=>$val) {
					     echo '<tr>';
					     echo '<td align="center">' . $grade . '</td>';
					   for ($i=1; $i<=5; $i++){

					     $key=$grade.'.'.$i;
 					     //echo $key ."=". $val[0];
 					     //list($grade, $number)=explode('\.',$key);

 					     //if ( isset($classcount[$grade]) && $classcount[$grade] >= $i  ) {
 					     if ( isset($classcount[$grade]) && isset($teacherfn[$key])  ) {
 					       echo '<td><a href="HomeworkListDetail.php?grade='.$grade.'&number='.$i.'">'.$teachercn[$key].' '.$teacherfn[$key].' ('.$hwcount[$key].')</a></td>';
 					     } else {
 					       echo '<td>&nbsp</td>';
 					     }
 					  //   if ($grade != $grade_prev) {
 					  //      echo "<br>";
 					  //   }
 					  //   $grade_prev=$grade;
                       }
                       echo "</tr>";
                      }

						?>

						</table>
                     <?php if( isset($_SESSION[membertype]) &&  $_SESSION[membertype] == 25) {
                   /*    echo '<br><br>';
                       if (! isset($_GET[myhws]) ||  $_GET[myhws] != 1)
                       {
                           echo '<a href="HomeworkListDetail.php?myhws=1">Of My Class Only</a> | ';
					   } else {
					   	   echo '<a href="HomeworkListDetail.php">Of All Classes</a> | ';
					   } */
                       ?>


				  <!--    <a href="HomeworkUploadForm.php">Upload a New Homework</a> -->
                     <?php } ?>
					</td>




				</tr>
			<!--
				<tr><td></td><td>
				<br><br>
				                     Note on Download: <br>
				<ul>
				    <li> to open the homework file in your browser, click the left-button of your mouse;<br>
                    <li> to save the homework file to your computer, click the right-button and choose "Save Link As ...(Firefox)" or "Save Target As ...(IE)"
                </ul>
                     </td></tr>
              -->
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