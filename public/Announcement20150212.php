<?php include "header.html"; ?>
<div class="container body-col" id="body">
    <div class="row-fluid">
        <div class="col-sm-4 body-col">
            <?php include "NewsMenu.html"; ?>
        </div>
        <div class="col-sm-8 body-col" id="rightCol">
            
        </div>
    </div>
</div>
<footer>
    <?php include "footer.html" ?>
</footer>
<script>
$("#rightCol").load("htmlFiles/Announcements2015.html #20150212");
</script>

