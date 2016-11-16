<?php include 'header.html'; ?>
<style> 
    #adGroup { height: 130px; overflow: hidden;}
    .height100 {height: 100%; padding: 0; margin: 0;}
    .marginTopN100 { margin-top: -100px;}
</style>

<div class="container-fluid" id="2015NewYear">
    <div id="carousel" class="clearfix">
        <?php include "carousel2016.html"; ?>
    </div>
    <div class="container" id="body">
        <!--Reserved for weather alert-->
            <!--<div class="col-sm-12"><p class="lead alert alert-danger"><span class="h2">WEATHER ALERT</h2></span>- Chinese School Cancellation Sunday, January 24 / 中文学校1月24日的课程因天气原因取消。</p>
      </div> 
        -->
        <div class="col-sm-12" id="sccs20year">
            <?php include 'htmlFiles/sccs20Anniversary.html'; ?>
            <hr>
        </div>

        <div class="col-sm-4 body-col" id="menu><?php include 'index_menu.html'; ?></div>
             <div class="col-sm-8" id="main">
             <div class="row">    
                <h3 class="text-center">SCCS Summer Program 2016 Registration Starts</h3>
                <?php include "htmlFiles/2016SummerCamp.html"; ?> 
                <?php include "htmlFiles/2015SummerCamp.html"; ?>
            </div>
            <div class="row">
                <embed src="assets/pdf/2016SpellingBeeWinnersList.pdf" width="800" height="600">
            </div>
            <div class="row height100">
                <h3 class="text-center">2016 SCCS Spelling Bee</h3>
                <?php include "2016SpellingBee.php"; ?>
            </div>  
           <div class="row">
                 <?php include "2015StudentPostSession.html"; ?>
            </div>        
        </div><!--end #main-->
        <div class="col-sm-12" id="adGroup"><?php include "adGroupSlide.html"; ?></div>
    </div> <!-- end #body-->
</div>
<hr>
<footer id="footer">
    <?php include 'footer.html'; ?>
</footer>