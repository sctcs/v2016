/*Javscript for studentTeacherCorner files*/

  $("#term").on('change', function () {
                var term = this.value;
                var grade = $("#grade").val();
                if (grade === "Choose") {
                    alert("Please select a grade");
                }
                else { 
                  $("#sessions").load("htmlFiles/studentWork/" + term + ".html" + " #" + grade);
               }
            });

            $("#grade").on('change', function () {
                var grade = this.value;
                if(grade === "Choose") {
                    alert ("Please select a grade");
                }
                else {
                 var term = $("#term").val();
                 alert (term);
                 $("#sessions").load("htmlFiles/StudentWork/" + term + ".html" + " #" + grade);   
             }
            });

            $("#studentTeacherCornerArea").on('click', '#sessions li a', function (e) {
                e.preventDefault();
                $('#details').html("");
                var url = this.href;
                $('#details').append('<object>');
                $('object').attr('data', url);
                $('object').attr('type', "application/pdf");
                $('object').append('<embed>');
                $('embed').attr('src', url);
                $('embed').attr('type', "application/pdf");
                $('embed').attr('width', "100%");
                $('embed').attr('height', "100%");
                $('#sessions a.current').removeClass('current');
                $(this).addClass('current');
            });
