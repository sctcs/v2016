 $(document).ready(function() {
                 $("aside").append("<h2>Table of Contents</h2>");
                 
                 $("article h3").wrapInner("<a></a>"); //wrap h3 text in article in <a> tags
                 
                 $num =$('h1').text().match(/\d+/g);  //get the number of the announcement title
                
                
                 $("article h3 a").each(function(index) {   //add ids to the a tags
                   var id = $num + "heading" + (index+1);
                   $(this).attr("id", id);
                 });
                 
                 //Clone the <a> tags in the article and insert them into the aside
                 
               //  alert ($("article h3 a").;
                 $("article h3 a").clone().add("<br>").insertAfter($("aside h2"));
              
                 //Remove the id attributes from the <a> tags in the aside
                 $("aside a").attr("href", function(index) {
                     $("aside a").removeAttr("id");
                 });
                 
                 //Add the href attribute to the <a> tags in the aside
                 $("aside a").attr("href", function(index) {
                     var href = "#" + $num +"heading" + (index+1);
                    return href;
                 });
                 
                 $("aside a").each(function() {
                     $(this).append("<br>");
                 });
                 
                 //wrap an <a> tag around the h1 text
                 $("h1").wrapInner("<a id='top'></a>");
                 
                 //insert "back to top"<a> tags after each announcement
                 $("article").after("<p class='text-center'><a href='#top'>***Back to Top***</a></p>");
    
             });
