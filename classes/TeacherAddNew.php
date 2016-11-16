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

//mysqli_select_db($dbName, $conn);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Add More Classes</title>
        <meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
        <meta http-equiv="Content-type" content="text/html; charset=gb2312" />
             <style>
                 .form_height200 {height: 200px; width: 600px; margin: 20px auto;}
                
             </style>
         <script language="javascript" src="../common/JS/MainValidate.js"></script>
    </head>
    <body>
    <header>    
        <?php include("../common/site-header1.php"); ?>
    </header>
    <div class="container-fluid">
        <h3 class="text-center">Add One Teacher</h3>
        <div class="form_height200">
        <form class="form-inline" name="TeacherAddOne" action="TeacherAddOne.php" method="post" >
           <div class="form-group">
                <label for="MID" id="mid">Teacher MemberID<font color="#FF0000">*</font></label>
                <input type="text" size="70" name="MID" ><br />
            </div>
            <div class="form-group">
                <input type="submit" value="Submit">
                    </div>
        </form>
       </div> 
    </div>
 
    <?php include("../common/site-footer1.php"); ?>



