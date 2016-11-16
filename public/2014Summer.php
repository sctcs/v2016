<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
        <div class="container body-col" id="body">
            <div class="row-fluid">
                <div class="col-sm-4 body-col">
                    <?php include "NewsMenu.html"; ?>
                </div>
                <div class="col-sm-8 body-col">
                    <h3 class="text-center">News &amp; Review</h3>
                    <?php include "news/SummerCamp2014.html"; ?>
                    <?php include "news/ImproveTeachingQuality.html"; ?>
                    <?php include "news/NewsFromBoardOfDirectors.html"; ?>
                    <?php include "news/TeacherGathering.html" ;?>
                </div>
            </div>
        </div>
        <footer>
            <?php include "footer.html" ?>
        </footer>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
    </body>
</html>
