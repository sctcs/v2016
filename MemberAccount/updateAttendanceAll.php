<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include_once("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

// if DEBUG
$debug=0;
if ($debug) {
// loop through every form field
while ( list( $field, $value ) = each( $_POST )) {
   // display values
   if ( is_array( $value )) {
      // if checkbox (or other multiple value fields)
      while ( list( $arrayField, $arrayValue ) = each( $value )) {
       if ( is_array( $arrayValue )) {
       while ( list( $arrayField1, $arrayValue1 ) = each( $arrayValue )) {
     echo "<p>" . $arrayField1 . "</p>\n";
     echo "<p>" . $arrayValue1 . "</p>\n";
       }
       } else {
     echo "<p>" . $arrayField . "</p>\n";
     echo "<p>" . $arrayValue . "</p>\n";
       }
      }
   } else {
  echo "<p>" . $field . "</p>\n";
  echo "<p>" . $value . "</p>\n";
   }
}
}
?>

<?php
//echo $_POST[classid];
//echo $_POST[studentid];
if (isset($_POST[studentid] )) {
while ( list( $sidArrayField, $sidArrayValue ) = each( $_POST[studentid] )) {
//     echo "<p>" . $sidArrayField . "</p>\n";
//     echo "<p>" . $sidArrayValue . "</p>\n";

#
# delete all existing first
#
$sql="delete from tblAttendance where ClassID=".$_POST[classid]." and StudentID=".$sidArrayValue ;
//echo $sql."<br>";
 if (!mysqli_query($conn,$sql))      {
	  	            die('Error: ' . mysqli_error($conn));
 }
//exit;

# insert all
$sid_att="chk_attendance_".$sidArrayValue;
//echo $sid_att;
if (isset($_POST[$sid_att] )) {
$n=0;
$sql="";
while ( list( $arrayField, $arrayValue ) = each( $_POST[$sid_att] )) {
//       echo "<p>" . $arrayField . "</p>\n";
       if ($n == 0 ) {
         $sql .= "(".$_POST[classid].",".$sidArrayValue          ."," . $arrayValue . ")";
       } else {
         $sql .= ", (".$_POST[classid].",".$sidArrayValue        ."," . $arrayValue . ") ";
       }
       $n++;
}

if ( strlen($sql) > 0 ) {
$sql="insert into tblAttendance values ".$sql;
//echo $sql."<br>";
 if (!mysqli_query($conn,$sql))      {
	  	            die('Error: ' . mysqli_error($conn));
      }
}
//echo "<hr>";
}

} //studentid
}

if ( isset($_POST[notes]) && $_POST[notes] !="" ) {
 $notes = $_POST[notes];
 $notes = str_replace("'","&apos;", $notes);
   $sql="insert into tblAttendanceNote(ClassID,Notes) values(" . $_POST[classid]. ", '" . $notes . "')" ;
 //echo $sql;
 if (!mysqli_query($conn,$sql))      {
 $sql="update tblAttendanceNote set Notes='" . $notes . "' where ClassID=".$_POST[classid] ;
      //echo $sql;
   if (!mysqli_query($conn,$sql))      {
      die('Error: ' . mysqli_error($conn));
   }
 }
}
?>
<p>

Attendance data have been saved successfully!

</p>
<?php
echo "Back to <a href=\"" .
"studentAttendanceAll.php?MID=".$_POST[MID] ."&classid=".$_POST[classid].
"&year=".$_POST[year]."&term=".$_POST[term]."&lastname=".$_POST[lastname]."&firstname=".$_POST[firstname]."\">Attendance</a><br>";
if ( isset($_SESSION[membertype]) && 
     $_SESSION[membertype] == 25 ) {
echo "Back to <a href=\"MyClasses_frame.php\">My Classes</a>";
} else {
echo "Back to <a href=\"../Directory/Classes.php\">All Classes</a>";
}
echo " <a href=\"MemberAccountMain.php\">My Account</a>";

mysqli_close($conn);

?>
