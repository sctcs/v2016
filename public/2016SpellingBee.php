<!DOCTYPE html>

<html>
    <head>
        <title>SCCS 2016 New Year Gala</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
       
        <link href='assets/css/carousel.css' rel='stylesheet' />
         <link href="assets/css/index.css" rel="stylesheet" />
      <style> 
#2016SpellingBee .carousel { height: 530px; }
 </style>
    </head>
    <body>
      
        <div class="container-fluid hero">
            <div id="2016SpellingBee" class="carousel slide" data-ride="carousel" data-interval="false">
                <div class="carousel-inner">
                    <div class="item active"><img src="assets/images/events/2016SpellingBee/1.jpg" alt="1"></div>
                   <?php
                   $path='assets/images/events/2016SpellingBee/';
                   $count = 30; 
                   for($i=2; $i< ($count+1); $i++) {
                       echo '<div class="item">'.'<img src='.$path .$i . '.jpg' .'>'.'</div>';
                   }
                   ?>
                   
               </div><!--End carousel-inner-->
              <!-------------------carousel control-------------->
                    <a class="left carousel-control" href="#2016SpellingBee" role="button" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#2016SpellingBee" role="button" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
                </div><!--end container-->
           <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
      