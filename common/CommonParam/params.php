<?php
$DEBUG = 0;

$SchoolYear="2016-2017";

$CurrentYear="2016";
$CurrentTerm="Fall";
$LastYear="2015";
$LastTerm="Spring";
$NextYear="2017";
$NextTerm="Spring";

$LANG_CLASS_SEAT_LIMIT = 18;  // default if not defined in tblClass.Seats
$ENRICH_CLASS_SEAT_LIMIT = 20;  // default if not defined in tblClass.Seats

$StudentType[1] = "New";
$StudentType[2] = "Return";

$StudentStatus[1]= "Active";
$StudentStatus[2]= "InActive";
$AGE_TO_START = 5;
$DOB_TO_START = "2011-09-01";

$SCHOOLNAME = "Southern Connecticut Chinese School";
$SCHOOLNAME_ABR="SCCS";
//$SCHOOLNAME = "Yale-New Haven Community Chinese School";
//$SCHOOLNAME_ABR="YNHCCS";

$EARLY_REG_DEADLINE = "2016-08-31";
$EARLY_REG_FEE = "$0";
$REG_REG_DEADLINE   = "2016-09-18";
$REG_REG_FEE = "$20";
$REG_REG_FEE_DOLLAR = "20";
$LATE_REG_DEADLINE  = "2016-09-25";
$LATE_REG_FEE = "$40";
$LATE_REG_FEE_DOLLAR = "40";

$BLOCK_FALL_REGISTRATION = 0;

$FIRST_CLASS_DATE = "2016-09-11";
$SECOND_CLASS_DATE = "2016-09-18";
$THIRD_CLASS_DATE = "2016-09-25";
$FOURTH_CLASS_DATE = "2016-10-02";
$FIFTH_CLASS_DATE = "2016-10-09";

$FIRST_PAYMENT_DUEDATE = "2016-09-11";
$SECOND_PAYMENT_DUEDATE = "2017-01-22";

$MEMBERSHIP_FEE = 20;
$PARENT_DUTY_FEE = 0;

$PERIOD0 = "12:35-1:20pm";
$PERIOD1 = "1:30-2:15pm";
$PERIOD2 = "2:25-3:10pm";
$PERIOD3 = "3:30-4:15pm";
$PERIOD4 = "4:25-5:10pm";

$SPPERIOD1 = "1:30-3:10pm";
$SPPERIOD3 = "3:30-5:10pm";

$PAST_BALANCE_DATE="2016-06-31"; // used in various places to limit receivables or payments before or after this day

$AUTO_RECEIVABLE="No";  // used in registration module to call accounting/Tools.php UpdateIncomeInfo(familyid) with FamilyID
$AUTO_RECEIVABLE4DROP="No"; // used in accounting/Tools.php UpdateIncomeInfo() to add credit for dropped class

$SCHOOL_PAY_ADDRESS_WEB="
	$SCHOOLNAME<br>
	P.O. Box 8296<br>
        New Haven, CT 06530
    ";
$SCHOOL_PAY_ADDRESS="
Southern Connecticut Chinese School
P.O. Box 8296
New Haven, CT 06530 
 ";

$BOOKFEE1 = 0;
$BOOKFEE2 = 0;

$CLASSNUM_ONE_CHINESE_SPEAKING_PARENTS='4';
$CLASSNUM_TWO_CHINESE_SPEAKING_PARENTS='5';

$REGISTRATION_POLICIES="
SCCS Registration Policies (2016-2017)
<UL>

<LI> Enrichment programs are registered annually for both the Fall and Spring terms: 
 <ul>
 <li>If you pick the Fall programs but not the Spring programs, the same programs in Spring as in Fall will be automatically added. <li>You can pick different programs in Fall and Spring. 
 <li>If you decide to drop classes, you should request cancellation and refund by contacting support@ynhchineseschool.org or by visiting school office.
 </ul>
<LI> The first day of school will be September 11. On that day, we just have Chinese Language classes. The enrichment programs will start one week later.
<LI> Fees
<pre>
    * Annual family membership (due in Fall): $20
    * Early Registration fee before August 31 (by postmark):  0 
    * Regular Registration fee on and before September 18:  $20 
    * Late Registration fee after September 18:  $40 
    * Chinese language classes: $150 per term, $300 per year
    * General enrichment classes: $90 per term, $180 per year
    * Stage performing art (dance, singing) classes: $100 per term, $200 per year 
    * $30 charge for bounced check
    
</pre>
<LI> Refund Policy
<pre>
    * Full refund if class is cancelled by school
    * Full refund of class fee <b>before the SECOND</b> lesson
    * <b>No refund on or after the SECOND</b> lesson
    * Other fees, the registration fee, late fee, are not refundable
</UL>
";

$REGISTRATION_TIPS="
Registration Tips
<UL>
<li> The intensive class uses the same textbook as the regular class, but it has more homework and requires greater participation from parents and thus is more effective in improving students Chinese. 
<li> Some enrichment classes take two consecutive periods, do not pick any other class in conflict with 2-periods class.
<li> Do not use the Back button or Forward button of your browser to navigate to other pages, follow the links instead.
<li> To drop an enrichment class, select \"No (will not take any)\" and Update.
</UL>
";

$SHOWTEACHER='Yes';

?>
