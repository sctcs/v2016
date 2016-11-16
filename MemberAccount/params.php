<?php
$DEBUG = 0;

$SchoolYear="2009-2010";

$CurrentYear="2009";
$CurrentTerm="Fall";
$LastYear="2009";
$LastTerm="Spring";
$NextYear="2010";
$NextTerm="Spring";

$LANG_CLASS_SEAT_LIMIT = 18;  // default if not defined in tblClass.Seats
$ENRICH_CLASS_SEAT_LIMIT = 20;  // default if not defined in tblClass.Seats

$StudentType[1] = "New";
$StudentType[2] = "Return";

$StudentStatus[1]= "Active";
$StudentStatus[2]= "InActive";
$AGE_TO_START = 6;
$DOB_TO_START = "2003-09-15";

$SCHOOLNAME = "Southern Connecticut Chinese School";
$SCHOOLNAME_ABR="SCCS";
//$SCHOOLNAME = "Yale-New Haven Community Chinese School";
//$SCHOOLNAME_ABR="YNHCCS";

$EARLY_REG_DEADLINE = "2009-08-30";
$EARLY_REG_FEE = "$0";
$REG_REG_DEADLINE   = "2009-09-13";
$REG_REG_FEE = "$20";
$LATE_REG_DEADLINE  = "2009-09-14";
$LATE_REG_FEE = "$30";

$FIRST_CLASS_DATE = "2009-09-13";
$SECOND_CLASS_DATE = "2009-09-20";
$THIRD_CLASS_DATE = "2009-09-27";
$FOURTH_CLASS_DATE = "2009-10-04";
$FIFTH_CLASS_DATE = "2009-10-11";

$FIRST_PAYMENT_DUEDATE = "2009-09-13";
$SECOND_PAYMENT_DUEDATE = "2009-12-31";

$MEMBERSHIP_FEE = 20;
$PARENT_DUTY_FEE = 20;

$PERIOD1 = "1:20-3:00pm";
$PERIOD3 = "3:10-3:55pm";
$PERIOD4 = "4:05-4:50pm";

$PAST_BALANCE_DATE="2009-06-01"; // used in various places to limit receivables or payments before or after this day

$AUTO_RECEIVABLE="No";  // used in registration module to call accounting/Tools.php UpdateIncomeInfo(familyid) with FamilyID
$AUTO_RECEIVABLE4DROP="Yes"; // used in accounting/Tools.php UpdateIncomeInfo() to add credit for dropped class

$SCHOOL_PAY_ADDRESS="
	$SCHOOLNAME
	P.O.Box 207105
	Yale Station
	New Haven, CT 06520
    ";

$BOOKFEE1 = 30;
$BOOKFEE2 = 23;
?>