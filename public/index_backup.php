<?php include 'header.html'; ?>
<style> 
     #adGroup { height: 130px; overflow: hidden;}
  .padding10 { padding-bottom: 10px; }
</style>
<script>
  function mouseover(myImage) { myImage.src = "assets/images/culture/Audrey20160221.jpg";}
  function mouseout(myImage) {myImage.src="assets/images/culture/2016SpringGala.jpg";}
</script>
<div class="container-fluid" id="2015NewYear">
     <div id="carousel" class="clearfix">
           <?php include "carousel.html"; ?>
      </div>
        <div class="container" id="body">


<!--Reserved for weather alert-->
    <!--p class="lead alert alert-danger"><span class="h2">WEATHER ALERT</h2></span>- Chinese School Cancellation Sunday, January 24 / 中文学校1月24日的课程因天气原因取消。</p> -->


            <div class="row">
                   <div class="col-sm-4 body-col" id="menu">
                           <?php include 'index_menu.html'; ?>
                   </div>
                  <div class="col-sm-8 body-col" id="main">
                  <div class="row">
<h3 class="text-center">2016 SCCS Spring Gala</h3>
<img src="assets/images/culture/2016SpringGala.jpg" alt="2016 SCCS Gala" class="img-responsive" 
onmouseover="mouseover(this)" onmouseout = "mouseout(this)"/>
         
                       <?php include "2016NewYearGala.html" ;?>
                    <p class="padding10"></p>
                             <?php include "autumn2015.html" ;?> <!---autumn leaves first session-->
                             <?php include "autumn2015_1.html" ; ?> <!---autumn leaves post -->
                        <?php include "htmlFiles/2015SummerCamp_test.html"  ;?>
                        <?php include "2015StudentPostSession.html"; ?>
                     </div> <!--end row-->
                  </div><!--end main-->

                 <div class="col-sm-12"> <hr></div>
                 <div class="col-sm-12" id="adGroup"><?php include "adGroupSlide.html"; ?></div>
        </div><!--end row-->
   </div> <!-- end body-->
</div>
<hr>
<footer id="footer">
            <?php include 'footer.html'; ?>
 </footer>

 
   