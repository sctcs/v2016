<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title>Reminder and New Teacher Introduction</title>
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
                    <h3 class="text-center">Reminder on Early Registration Discount and Introduction to New Teachers</h3>
                    <?php include "announcements/Reminder.html"; ?>
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
