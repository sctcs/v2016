<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/index.css" rel="stylesheet">
        <title>SCCS 2016 Announcements</title>
    </head>
    <body>
        <header>
            <?php include "header.html"; ?>
        </header>
        <div class="container body-col" id="body">
                <div class="col-sm-12">
                     <?php include("htmlFiles/announcements/Announcements2016.html");?>
                </div>
        </div>
        <footer>
            <?php include "footer.html" ?>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
      
<!--       <script>    
           $(function(){
               $("article h3").each(function() {
                   len = $(this).text().length;
                   if(len > 10) {
                      // $(this).text($(this).text().substr(0,10) + '...');
                      $myvar = $(this).text().substr(0,10);
                   }
               });
           });
        </script>-->
    </body>
</html>
