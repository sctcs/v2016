<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if (!isset($_SESSION['logon'])) {
    echo ( 'you need to <a href="../MemberAccount/MemberLoginForm.php">login</a>' );
    exit();
}
if (!isset($_SESSION[membertype]) || $_SESSION[membertype] >= 25) {
    echo ( 'you need to log in as a school admin' );
    exit();
}

include("../common/DB/DataStore.php");

//mysql_select_db($dbName, $conn);
?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Teacher List</title>
        <meta http-equiv="Content-type" content="text/html; charset=gb2312" />
        <link href="../common/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="../common/index.css" rel="stylesheet" type="text/css" />
        <link href="../common/ynhc_addon.css" rel="stylesheet" type="text/css" />

        <script>
            function sendme(who)
            {
                //alert("here ");
                document.all.Container.value = who;
            }
        </script>
    </head>

    <body>

       <header> <?php include("../common/site-header1.php"); ?></header>

        <div class="container">
            <h3 class="text-center">Teacher List</h3>
             <p class="text-center lead"><a href="TeacherAddNew.php">Add a New Teacher</a></p>
            <?php
            $SQLstring = "select * from tblTeacher left join tblMember on tblTeacher.MemberID = tblMember.MemberID order by tblTeacher.CurrentTeacher desc, tblMember.Lastname,tblMember.Firstname";
            $RS1 = mysqli_query($conn, $SQLstring);
            ?>

            <table class="table table-bordered table-striped">
                <tr>
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
                            if ($RSA1[CurrentTeacher] == 'Yes' && !($RSA1[MemberID] == 2808 || $RSA1[MemberID] == 2460 || $RSA1[MemberID] == 2956 || $RSA1[MemberID] == 2957 || $RSA1[MemberID] == 2939)) {
                                $temails .= $RSA1[Email] . ", ";

                                echo "<a href=\"TeacherEdit.php?act=deactivate&MID=" . $RSA1[MemberID] . "\">Deactivate</a>";
                            } else {
                                echo "<a href=\"TeacherEdit.php?act=reactivate&MID=" . $RSA1[MemberID] . "\">Reactivate</a>";
                                echo " &nbsp; or &nbsp; ";
                                echo "<a href=\"TeacherEdit.php?act=delete&MID=" . $RSA1[MemberID] . "\">Delete</a>";
                            }
                            ?>
                        </td>
                        <td> <?php echo "<a href=\"TeacherUpdate.php?MID=" . $RSA1[MemberID] . "\">Edit</a>"; ?> 
                        </td>

                    </tr>
                <?php } ?>
            </table>

       <p class="lead text-center alert alert-info">Current teachers' emails:</p> 
       <p class="alert alert-success" style="margin: 10px 0; line-height: 30px;"><?php echo $temails; ?></p>
      
  </div>
        <?php include("../common/site-footer1.php"); ?>
 </body>
</html>
