<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title>10th Grade Student Work Display</title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
        <div class="container body-col" id="body">
<div class="row">
            <div class="col-sm-4 body-col">
                <?php include "index_menu.html"; ?>
            </div>
            <div class="col-sm-8 body-col" id="rightCol">
                <h3 class="text-center">Grade 10 Student Work Display</h3>
                  <p class="text-info text-center"><a href="StudentTeacherCorner.php">Back to Gallery</a></p>
                <div class="embed-responsive embed-responsive-16by9 iframeArea">
                    <iframe src="assets/pdf/k10_1.pdf" ></iframe>
                </div>
            </div>
        </div>
</dov>
        <footer class="col-lg-12">
            <?php include "footer.html" ?>
        </footer>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>
