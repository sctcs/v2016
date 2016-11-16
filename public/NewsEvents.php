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
            <div class="row">
                <div class="col-sm-4 body-col">
                    <?php include "NewsMenu.html"; ?>
                </div>
                <div class="col-sm-8 body-col" id="rightCol">&nbsp; </div>
            </div>
        </div>
        <footer>
            <?php include "footer.html" ?>
        </footer>
<script> 
$("#rightCol").load("htmlFiles/Announcements2015.html #20150116");
</script>
    </body>
</html>
