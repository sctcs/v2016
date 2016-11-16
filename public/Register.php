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
        <link href="assets/css/menu.css" rel="stylesheet">
        <title></title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
        <div class="container body-col">
            <div class="row">
            <div class="col-sm-4 body-col">
                <?php include "index_menu.html"; ?>
            </div>
            <div class="col-sm-8 body-col">
                <?php include "Register.html"; ?>
            </div>
                </div>
        </div>
        <footer>
            <?php include "footer.html" ?>
        </footer>
    </body>
</html>
