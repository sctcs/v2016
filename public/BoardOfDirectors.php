<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
       <meta name="description" content="Board of Directors, Directors, Board">
        <title>Board of Directors</title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
        <div class="container body-col" id="body">
            <div class="row">
                <div class="col-sm-4 body-col">
                    <?php include "index_menu.html" ?>
                    </div>
                <div class="col-sm-8 body-col" id="contentPane">
                    <?php include "htmlFiles/boardOfDirectors/BoardOfDirectors2016_2017.html"; ?>
                </div>
            </div>
        </div>
        <footer>
            <?php include "footer.html" ?>
        </footer>
    </body>
</html>