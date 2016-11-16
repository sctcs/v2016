<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if (!isset($_SESSION['logon'])) {
    echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' );
    exit();
}
//if(! isset($_SESSION[membertype]) ||  $_SESSION[membertype] >= 25)
//{
//echo ( 'you need to log in as a school admin' ) ;
// exit();
//}

include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);
$SQLteacher = "select * from tblTeacher where MemberID = $_POST[MID]";
$result = mysqli_query($conn, $SQLteacher);

if (!result) {
    $SQLstring = "insert into tblTeacher (MemberID,CurrentTeacher) values(" . $_POST[MID] . ", 'Yes')";

//echo $SQLstring;
    $RS1 = mysqli_query($conn, $SQLstring);
//$RSA1=mysqli_fetch_array($RS1);
    echo "<p class='alert alert-success'>New teacher was succcessfully added.</p>";
} else {
    echo "<p class='alert alert-danger'>This teacher already exists.</p>";
}
mysqli_close($conn);
?>
<p class="lead"><a href="TeacherList.php">Go to Teacher List</a> | <a href="TeacherAddNew.php">Add New Teacher</a></p>




