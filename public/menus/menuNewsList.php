<?php
$menuNewsList = array( "20150509Announcement.php"=>"SCCS End of Semester Reminder/中文学校期末重要通知",
                       "2015YearOfRamGala.php"=>"Year of Ram Celebration at SCCS (南康中文学校羊年迎春会)",
                        "NewsFlash.php" => "News Flash (新闻快讯)",
                        "NewsLetter.php" => "Newletter(校刊)",
                        "Archives.php" => "Archives (校刊资料库)",
                        "----------" => "-------------",
                        "Clarifications.php" => "Important Clarifications from the Board",
                        
                        "Announcement20141212.php"=>"2014秋季期末通知",
                         "Announcement20141122.php"=>"SCCS End-of-Semester Talent Show",
                        "2014SummerFootPrintActivity.php" => "2014 Summer Footprint Activity<br />（我的足迹有奖活动)",
                        "2014SummerFootPrintWinner.php" => "2014 Summer Footprint Winner<br />(我的夏日足迹获奖名单)",
                        "2014Summer.php"=>"2014 Summer News From SCCS",
                        "Announcement20140912.php" => "Upcoming Events at SCCS",
                        "Announcement20140825.php" => "Enrichment Class(秋季新增文化课)",
                        "Announcement20140822.php" => "Early Registration discount and more..",
                        "Announcement20140801.php" => "Fall 2014 Registration Available...",
                       
);
foreach ($menuNewsList as $k => $v) {
    echo '<li><a href=' . $k . '>' . $v . '</a></li>';
}