<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include_once("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

// loop through every form field
while ( list( $field, $value ) = each( $_POST )) {
   // display values
   if ( is_array( $value )) {
      // if checkbox (or other multiple value fields)
      while ( list( $arrayField, $arrayValue ) = each( $value )) {
      // echo "<p>" . $arrayField . "</p>\n";
      // echo "<p>" . $arrayValue . "</p>\n";
      }
   } else {
   // echo "<p>" . $field . "</p>\n";
   // echo "<p>" . $value . "</p>\n";
   }
}
?>

<?php
//echo $_POST[classid];
//echo $_POST[studentid];
#
# delete all existing first
#
$sql="delete from tblAttendance where ClassID=".$_POST[classid]." and StudentID=".$_POST[studentid];
//echo $sql;
 if (!mysqli_query($conn,$sql))      {
	  	            die('Error: ' . mysqli_error($conn));
      }

# insert all
$n=0;
$sql="";
if (isset($_POST[chk_attendance] )) {
while ( list( $arrayField, $arrayValue ) = each( $_POST[chk_attendance] )) {
      // echo "<p>" . $arrayField . "</p>\n";
      // echo $_POST[classid].",".$_POST[studentid]."," . $arrayValue . ",\n";
       if ($n == 0 ) {
         $sql .= "(".$_POST[classid].",".$_POST[studentid]."," . $arrayValue . ")";
       } else {
         $sql .= ", (".$_POST[classid].",".$_POST[studentid]."," . $arrayValue . ") ";
       }
       $n++;
      }
//echo $sql;
if ( strlen($sql) > 0 ) {
$sql="insert into tblAttendance values ".$sql;
 if (!mysqli_query($conn,$sql))      {
	  	            die('Error: ' . mysqli_error($conn));
      }
}
}

if ( isset($_SESSION[membertype]) && 
     $_SESSION[membertype] == 25 ) {
echo "Back to <a href=\"MyClasses_frame.php\">My Classes</a>";
} else {
echo "Back to <a href=\"../Directory/Classes.php\">All Classes</a>";
}

mysqli_close($conn);

?>
