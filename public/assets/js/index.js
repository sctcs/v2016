/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 
var $=jQuery.noConflict();

$('.dropdown-toggle').dropdown();

$().dropdown('toggle');
$('.collapse').collapse();

$('.carousel').carousel({
    interval:2000  //in millionseconds
});

//navbar menu 
//$(document).ready(function() {
//    function toggleNavbarMethod() {
//        if ($(window).width() > 768) {
//            $('.navbar .dropdown').on('mouseover', function(){
//                $('.dropdown-toggle', this).trigger('click'); 
//            }).on('mouseout', function(){
//                $('.dropdown-toggle', this).trigger('click').blur();
//            });
//        }
//        else {
//            $('.navbar .dropdown').off('mouseover').off('mouseout');
//        }
//    }
//
//     // toggle navbar hover
//        toggleNavbarMethod();
//        // bind resize event
//        $(window).resize(toggleNavbarMethod);
//});

//$('#monitor').html($(window).width());
//
//$(window).resize(function() {
//    var viewportWidth = $(window).width();
//    $('#monitor').html(viewportWidth);
//});