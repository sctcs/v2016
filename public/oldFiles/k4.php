<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
<!--        <link href="assets/css/bootstrap.min.css" rel="stylesheet">-->
<!--        <link href="assets/css/index.css" rel="stylesheet">-->
        <link href="assets/css/photo-view.css" rel="stylesheet">
        <title>PHP file for Student-Teacher Corner</title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
<div class="container body-col">
        <div class="row">
        <div class="col-sm-4 body-col" id='leftCol'>
            <?php include "index_menu.html" ; ?>
        </div>
        <div class="col-sm-8  body-col" id="rightCol">
           <?php include "gallery/k4.html"; ?>
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
