<?php
$menuNewsList = array( "Announcement20150113.php" =>2015 Spring Semester/春季开学通知,
                     "2015NewYearGala.php"=> 2015 Spring Festival Celebration /2015羊年迎春,
                      "Announcement20150212.php"=> 2015 New Year Kicks Off/羊年迎春,
                      "Announcement20141212.php"=> End-of-Semester Announcement/学期结束通知,
                      "Announcement20141122.php"=> SCCS Talent Show/才艺表演,
                  "2014SummerFootPrint.php"=>2014 Summer Footprint /我的夏日足迹,
                   "2014Summer.php" => 2014 Summer News/2014夏学校活动,
                    "AnnouncementEN_II.php" =>Upcoming Events at SCCS,
                    "EnrichmentClass_II.php"=>More Enrichment Classes,
                    "EnrichmentClass.php" =>SCCS Offers Additional Enrichment Classes,
                   "Reminder.php"=>Early Registration Discount and more...,
                    "AnnouncementEN.php"=>Fall 2014 Registration Available...,
                    "AnnouncementCH.php"=>SCCS从8月3日起开始网上注册,
                    "NewsEvents.php" => 2014 February Special Event
         );
        foreach (menuNewsList as $k=> $v {
          echo '<a href=' . $k . '>' . $v . '</a><br />';
        }
   ?>