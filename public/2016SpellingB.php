<?php include 'header.html'; ?>
<style> 
    .height100 {height: 100%; padding: 0; margin: 0;}
   .marginTopN100 { margin-top: -100px;} 
</style>
<div class="container-fluid">
    <div class="container">
        <div class="col-sm-12" id="main">
            <div class="row">
                <div class="row">
                    <embed src="assets/pdf/2016SpellingBeeWinnersList.pdf" width="800" height="600">
                </div>
                <div class="row height100">
                     <div class = "row">
                    <h3 class="text-center">2016 SCCS Spelling Bee</h3>
                    <?php include "2016SpellingBee.php"; ?>
                </div>  
            </div><!--end #main-->
        </div> <!-- end #body-->
    </div>
</div>
<hr>
<footer id="footer">
    <?php include 'footer.html'; ?>
</footer>