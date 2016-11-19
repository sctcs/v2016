/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


var timeout1     = 100;
var closetimer1  = 0;
var menuitem     = 0;

function top_open()
{	top_canceltimer();
	top_close();
	menuitem = $(this).find('ul').eq(0).css('visibility', 'visible');}

function top_close()
{	if(menuitem) menuitem.css('visibility', 'hidden');}

function top_timer()
{	closetimer1 = window.setTimeout(top_close, timeout1);}

function top_canceltimer()
{	if(closetimer1)
	{	window.clearTimeout(closetimer1);
		closetimer1 = null;}}

$(document).ready(function()
{	$('#horizontal_nav > ul > li').bind('mouseover', top_open);
	$('#horizontal_nav > ul > li').bind('mouseout',  top_timer);});

document.onclick = top_close;