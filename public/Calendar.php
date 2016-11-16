<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title>SCCS School Calendar</title>
    </head>
    <body>
        <div id="header">
            <?php include 'header.html'; ?>
        </div>
        <div class="container body-col">
            <div class="row">
                <div class="col-sm-4 body-col">
                    <?php include 'index_menu.html'; ?>
                </div>
                <div class="col-sm-8 body-col">
                    <?php include 'htmlFiles/Calendar.html' ?>
                </div>
            </div>
        </div>
        <footer>
            <?php include 'footer.html'; ?>
        </footer>
    </body>
</html>
