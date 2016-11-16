<?php include 'header_2.html'; ?>
<style> 
    #adGroup { height: 130px; overflow: hidden;}
    .height100 {height: 100%; padding: 0; margin: 0;}
    .marginTopN100 { margin-top: -100px;}
</style>

<div class="container-fluid">
    <div id="carousel" class="clearfix">
        <?php include "carousel2016.html"; ?>
    </div>
    <div class="container">
        <!--Reserved for weather alert-->
            <!--<div class="col-sm-12"><p class="lead alert alert-danger"><span class="h2">WEATHER ALERT</h2></span>- Chinese School Cancellation Sunday, January 24 / 中文学校1月24日的课程因天气原因取消。</p>
      </div> 
        -->
        <div class="col-sm-12" id="sccs20year">
            <p class="text-center lead" style="color: red; margin-top: 10px; background: gold; line-height: 25px;">&#10084;&#10084;&#10084; <a style="padding: 10px 0;"  href="timeline.php">SCCS 20 Anniversary Timeline </a> &#10084;&#10084;&#10084;</p>
            <?php //include 'htmlFiles/sccs20Anniversary.html'; ?>
            <hr>
            <p class="lead text-center"><span style="color: green;">&#x2708;&#x2708</span><a href="assets/pdf/2016CampNewsletter.pdf" target="_blank"> SCCS 2016 Summer Camp Newsletter (南康中文学校2016年夏令营小结)</a><span style="color: green"> &#x2708;&#x2708;</span></p>
        </div>

        <div class="col-sm-4" id="menu">
            <?php include 'index_menu.html'; ?>
        </div>
        <div class="col-sm-5" id="main">
            <div class="row"> 
                <?php include "htmlFiles/announcements/Announcements2016New.html"; ?>
            </div><!--end main-->
        </div>
        <div class="col-sm-2 col-sm-offset-1">
            <h3 style="margin-left: 0; margin-right:0; padding-left: 0; text-align: center; overflow: hidden;" class="text-center">Support Us</h3>  
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