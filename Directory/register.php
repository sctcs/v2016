<?php

session_start();

require("database.php");
require("data.php");
require("student.php");
require("teacher.php");
require("classroom.php");
require("page.php");
require("language.php");
require("html.php");
require("map.php");
require("family.php");

$language;
if ( isChinese() ) {
   $language =& new Chinese();
} else {
   $language =& new English();
}

$html =& new CSchoolHTML();
$html->init();

$db =& new Database();
$db->h =& $html;
$db->open();

$page =& new Page($html, $db, $language);
$page->service();

$db->close();

?>
