<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title>8th Graders Work Display</title>
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
                <h3 class="text-center">Grade 8 Student Work Display</h3>
                 <p class="text-center"><a href="StudentTeacherCorner.php">Back to Gallery</a>&nbsp;&nbsp;|| &nbsp;&nbsp;<a href="k5.php">Previous</a>&nbsp;&nbsp;||&nbsp;&nbsp;<a href="k9.php">Next</a></p>
                <div class="container pdfFiles">
<ul>
                   <li><span>&#10020;</span><a href="assets/pdf/k8/1.pdf" target="_blank">杜若：我最喜欢的音乐课</a></li>
                    <li><span>&#10020;</span><a href="assets/pdf/k8/2.pdf" target="_blank">王小珊： 王小珊日记</a></li>
                     <li><span>&#10020;</span><a href="assets/pdf/k8/3.pdf" target="_blank">高嘉辰：一堂有趣的物理课</a></li>
</ul>
                </div>
            </div>
        </div>
        <footer class="col-lg-12">
            <?php include "footer.html" ?>
        </footer>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>