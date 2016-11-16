<?php include 'header.html'; ?>
<style> 
    #adGroup { height: 130px; overflow: hidden;}
    .height100 {height: 100%; padding: 0; margin: 0;}
    .marginTopN100 { margin-top: -100px;}
</style>

<div class="container-fluid">
    <div id="carousel" class="clearfix">
        <?php include "carousel2016.html"; ?>
    </div>
    <div class="container" id="body">
        <!--Reserved for weather alert-->
            <!--<div class="col-sm-12"><p class="lead alert alert-danger"><span class="h2">WEATHER ALERT</h2></span>- Chinese School Cancellation Sunday, January 24 / 中文学校1月24日的课程因天气原因取消。</p>
      </div> 
        -->
        <div class="col-sm-12" id="sccs20year">
            <p class="text-center lead" style="color: red; margin-top: 10px; background: gold; line-height: 25px;">&#10084;&#10084;&#10084; <a style="padding: 10px 0;"  href="timeline.php">SCCS 20 Anniversary Timeline </a> &#10084;&#10084;&#10084;</p>
            <?php //include 'htmlFiles/sccs20Anniversary.html'; ?>
            <hr>
            <p class="lead text-center"><a href="assets/pdf/firstday2016_17.pdf" target="_blank">&rarr; Must-Have Package for SCCS 2016 Fall First Day of School (2016秋季开学第一天指南必备) &larr; </a></p>
        </div>
        <div class="col-sm-4" id="menu">
            <?php include 'index_menu_noAmazon.html'; ?>
        </div>
        <div class="col-sm-5" id="main">
            <div class="row">  
                <?php include 'htmlFiles/2016FallOnlineRegistration.html'; ?>

                <?php include "htmlFiles/announcements/Announcements2016.html"; ?>

                <!-- <h3 class="text-center">SCCS Summer Program 2016 Registration</h3>-->
                <?php // include "htmlFiles/2016SummerCamp.html"; ?> 
                <?php // include "htmlFiles/2015SummerCamp.html"; ?>
            </div>
            <div class="row">
                <?php // include "htmlFiles/2015SummerCamp_test.html"  ;?>
                <?php // include "2015StudentPostSession.html"; ?>
            </div>  
        </div><!--end main-->

        <div class="col-sm-2 col-sm-offset-1">
             <h3 style="margin-left: 0; margin-right:0; text-align: center; overflow: hidden;" class="text-center">Support Us</h3>  
           
                <div>
                    <?php include "ad1.html"; ?>
                </div>
            </div>
        </div>
    </div> <!-- end #body-->

<hr>
<footer id="footer">
    <?php include 'footer.html'; ?>
</footer>