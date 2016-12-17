<?php

function mail_notice($fid,$useremail,$fname,$lname) {

//echo "Payment notice has been sent to ".$useremail."<br><br>";
$message = "Dear ".$fname." ".$lname.",

Our school system shows that you still have unpaid balance. Please make a payment at your earliest convenience. You can login to your account for detail information or come to school office at A107 and I will help you to figure out how much you should pay. 

Best Regards,
Min Li
SCCS Financial Manager
";

$to      = $useremail;
$subject = 'Please pay your SCCS balance';

$headers = 'From: finance@ynhchineseschool.org' . "\r\n" .
'Reply-To: finance@ynhchineseschool.org' . "\r\n" .
'X-Mailer: PHP/' . phpversion() . "\r\n";
$headers .= 'Bcc: finance@ynhchineseschool.org' . "\r\n";

mail($to, $subject, $message, $headers);

}

function mail_notice_msg($fid,$useremail,$fname,$lname,$subject, $message) {

if (!isset($subject) || $subject == "") {
$subject = 'Please pay your SCCS balance';
}

if (!isset($message) || $message == "") {
//echo "Payment notice has been sent to ".$useremail."<br><br>";
$message = "Dear ".$fname." ".$lname.",

Our school system shows that you still have unpaid balance. Please make a payment at your earliest convenience. You can login to your account for detail information or come to school office at A107 and I will help you to figure out how much you should pay. 

Best Regards,
Min Li
SCCS Financial Manager
";
}

$to      = $useremail;

$headers = 'From: finance@ynhchineseschool.org' . "\r\n" .
'Reply-To: finance@ynhchineseschool.org' . "\r\n" .
'X-Mailer: PHP/' . phpversion() . "\r\n";
$headers .= 'Bcc: finance@ynhchineseschool.org' . "\r\n";

mail($to, $subject, $message, $headers);

}
?>
