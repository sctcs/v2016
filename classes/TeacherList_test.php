<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if (!isset($_SESSION['logon'])) {
    echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' );
    exit();
}
if(! isset($_SESSION["membertype"]) ||  $_SESSION["membertype"] >= 25)
{
echo ( 'you need to log in as a school admin' ) ;
 exit();
}

include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Teacher List</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="chinese, school, education, 中文，汉语，教育，学校">
        <link href="../common/ynhc.css" rel="stylesheet" type="text/css" >
        <link href="../common/ynhc_addoncss.css" rel="stylesheet" type="text/css">
        <script>
            function sendme(who)
            {
                //alert("here ");
                document.all.Container.value = who;
            }
        </script>
    </head>
    <body>
        <!--header-->
        <div class="wrapper"><div class="header"><?php include("../common/site-header1.php"); ?></div></div>
       
        <!--Main body-->
        <div class="tablewrapper">
            <h2 class="center">Teacher List</h2>
            <?php
            $SQLstring = "select * from tblTeacher left join tblMember on tblTeacher.MemberID = tblMember.MemberID   order by tblTeacher.CurrentTeacher desc, tblMember.Lastname,tblMember.Firstname";
            $RS1 = mysqli_query($conn, $SQLstring);
            ?>
            <table CLASS="page" border="1">
                <tr class="redcolor">
                    <th>MemberID</th>
                    <th>English Name</th>
                    <th>Chinese Name</th>
                    <th>Cell</th>
                    <th>Home</th>
                    <th>Email</th>
                    <th>Current</th>
                    <th>Action</th>
                    <th>Update</th>
                </tr>
                
                <?php
                $i = 0;
                $temails = "";
                while ($RSA1 = mysqli_fetch_array($RS1)) {
                    ?>
                    <tr>
                        <td><?php echo $RSA1[MemberID]; ?></td>
                        <td><?php echo $RSA1[LastName] . ", " . $RSA1[FirstName]; ?></td>
                        <td><?php echo $RSA1[ChineseName]; ?></td>
                        <td><?php echo $RSA1[CellPhone]; ?></td>
                        <td><?php echo $RSA1[HomePhone]; ?></td>
                        <td><?php echo $RSA1[Email]; ?></td>
                        <td><?php echo $RSA1[CurrentTeacher]; ?></td>

                        <td>
                            <?php
                            if ($RSA1[CurrentTeacher] == 'Yes') {
                                $temails .= $RSA1[Email] . ", ";

                                echo "<a href=\"TeacherEdit.php?act=deactivate&MID=" . $RSA1[MemberID] . "\">Remove</a>";
                            } else {
                                echo "<a href=\"TeacherEdit.php?act=reactivate&MID=" . $RSA1[MemberID] . "\">Reactivate</a>";
                            }
                            ?>
                        </td>
                        <td> <?php echo "<a href=\"TeacherUpdate.php?MID=" . $RSA1[MemberID] . "\">Edit</a>"; ?> 
                        </td>
                    </tr>
                <?php } ?>
            </table>

            <p class="bigfont center"> <a href="TeacherAddNew.php">Add a New Teacher</a> || &nbsp;** Current teachers' emails: **</p>
            <hr>
            <p class="center"><?php echo $temails; ?></p>
        </div><!--End main body-->
        
        <!--Footer-->
        <div class="wrapper">
          <div class="footer"><?php include("../common/site-footer1.php"); ?></div>
        </div>
    </body>
</html>
