<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title>5th Grade Student Work Display</title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
        <div class="container body-col" id="body">
            <div class="col-sm-4 body-col">
                <?php include "index_menu.html"; ?>
            </div>
            <div class="col-sm-8 body-col" id="rightCol">
                <h3 class="text-center">Grade 5 Student Work Display</h3>
                 <p class="text-center"><a href="StudentTeacherCorner.php">Back to Gallery</a>&nbsp;&nbsp;|| &nbsp;&nbsp;<a href="k4.php">Previous</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="k8.php">Next</a></p>
                <div class="container pdfFiles kFiles" id="k5Files">
                </div>
            </div>
        </div>
        <footer class="col-lg-12">
            <?php include "footer.html" ?>
        </footer>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
 <script>
        $(document).ready(function(){
            $files = $("#k5Files");
            $files.load("htmlFiles/StudentWork.html" + " #k5");
        });
        </script>
    </body>
</html>