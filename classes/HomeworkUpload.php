<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include("../common/DB/DataStore.php");


////  1. load all variables ////


$ClassID=$_POST[ClassID];
$ClassID=str_replace("'", "''",$ClassID);
$ClassID=str_replace("\n", " ",$ClassID);
$ClassID=trim($ClassID);
if ( !isset($ClassID) || $ClassID == "" ) {
	echo "Sorry, you are not a teacher of any class, so you are not allowed to upload homework files<br>";
	echo '<a href="HomeworkList.php">See Homework List</a>';
	mysqli_close($conn);
	exit;
}

$hwdescription=$_POST[hwdescription];
$hwdescription=str_replace("'", "''",$hwdescription);
$hwdescription=str_replace("\n", " ",$hwdescription);
$hwdescription=trim($hwdescription);

$hwversion=$_POST[hwversion];
$hwversion=str_replace("'", "''",$hwversion);
$hwversion=str_replace("\n", " ",$hwversion);
$hwversion=trim($hwversion);

$hwduedate=$_POST[hwduedate];
$hwduedate=str_replace("'", "''",$hwduedate);
$hwduedate=str_replace("\n", " ",$hwduedate);
$hwduedate=trim($hwduedate);

$hwfile=$_POST[hwfile];
$hwfile=str_replace("'", "''",$hwfile);
$hwfile=str_replace("\n", " ",$hwfile);
$hwfile=trim($hwfile);

$success = false;
if ( !isset($hwversion) || $hwversion == "" ) {
   $hwversion="1";
}

echo "MemberID: ". $_SESSION[memberid]. "<br>";
echo "ClassID: " .$ClassID . "<br>";
echo "hwdescription: " .$hwdescription . "<br>";
echo "hwversion: " .$hwversion . "<br>";
echo "hwduedate: " .$hwduedate . "<br>";
//echo "hwfile: " .$hwfile . "<br>";
echo "basename: " . basename( $_FILES['hwfile']['name']) . "<br>";

if ( isset($_POST[origname])  && $_POST[origname] != "" ) {
  $origname = $_POST[origname];
} else {
  $origname = basename( $_FILES['hwfile']['name'] );
}

list($fname,$ftype) = explode('\.',$origname);
echo "origname: ".$origname . "<br>";
echo "fname: ".$fname . "<br>";
echo "ftype: ".$ftype . "<br>";

// set target path and file name

$target_path = "homeworks";

$recipients = array() ;
$teacherEmail = array();

//$target_file = $target_path . $ClassID . "_".$hwversion. "_". $origname; // basename( $_FILES['hwfile']['name']);
$target_file = $target_path . '/'. $ClassID . "_". $origname; // basename( $_FILES['hwfile']['name']);
echo "it will be saved as: " .$target_file. "<br>";

if (file_exists($target_file)) {
    echo "The file $target_file exists<br>";
   if ( $hwversion == "1" ) {
     echo "Please use a different file name<br>";
   } else {
     echo "Please increase the version number<br>";
   }
   $_SESSION[hwdesc]=$hwdescription;
   $_SESSION[hwduedate]=$hwduedate;
   echo "<a href=\"HomeworkUploadForm.php?vererror=1\">Back</a>";
   exit;
} else {
   echo "";
//    echo "The file $target_file does not exist<br>";
}

// insert a record into table

$SQLstring = "insert into tblClassHomework (ClassID, Filepath,Filename,Filetype,DueDate, Description, CreatedByMemberID, CreatedDate) ".
             " values (". $ClassID .",'". $target_path."','".$fname."','".$ftype."','".$hwduedate."','".$hwdescription."',".$_SESSION['memberid'].", now() )";
//echo "see: ".$SQLstring;


$RS1=mysqli_query($conn,$SQLstring);
if ( ! $RS1 ) {
  echo mysqli_error($conn);
  exit;
}


mysqli_data_seek($result, 0);
$SQLstring1 = "select distinct m.Email from tblMember m, tblClassRegistration r, tblClass c, tblTeacher t 
where r.StudentMemberID = m.MemberID and r.ClassID=c.ClassID 
and  r.Status=\"OK\" and t.MemberID= c.TeacherMemberID and t.MemberID='".$_SESSION[memberid]."' and c.ClassID='".$ClassID."'";
 echo $SQLstring1;
 
//$SQLstring = "SELECT m.Email AS email FROM tblMember m, tblClassRegistration r, tblClass c WHERE c.TeacherMemberID= '".$_SESSION['memberid']."' AND c.ClassID = '".$ClassID."' AND r.Status=\"OK\"";
$SQLstring2 = "SELECT Email FROM tblMember WHERE MemberID ='".$_SESSION[memberid]."'";           

$RSs = mysqli_query($conn, $SQLstring1); //students emaillist
$RSt = mysqli_query($conn, $SQLstring2);  //teacher email

if (!$RSs ) {
    echo mysqli_error($conn);
    exit;
}

if(!$RSt) {
    echo mysqli_error($conn);
    exit;
}

mysqli_close($conn);


// save the file to disk
if(move_uploaded_file($_FILES['hwfile']['tmp_name'], $target_file)) {
    echo " file ".  basename( $_FILES['hwfile']['name']).  " has been uploaded successfully<br>";
    $success = true;
} else{
    echo "There was an error uploading the file, please try again!";
    $_SESSION[hwdesc]=$hwdescription;
    $_SESSION[hwduedate]=$hwduedate;
    echo "<a href=\"HomeworkUploadForm.php?vererror=1\">Back</a>";
   exit;
}

if($success) {
    echo "<p>Batch email students of new homework assignments...</p>";
    
    $teacherEmail = mysqli_fetch_array($RSt, MYSQLI_NUM);
    $from = $teacherEmail[0];
       //echo "see from teacher email" . $from;
  
   
//   while ($row5 = mysqli_fetch_array($RSs)){
//     $recipients = $row5['Email']; 
//   }
    while ($row5 = mysqli_fetch_array($RSs)){
        $recipients = $row5['Email'];
    }
    echo"Start <br>";
        print_r($recipients);
    echo "  <br> End<br>";
    
    $to = $teacherEmail[0];
    $bcc = implode(',', $recipients);
    
    $subject = "New Homework Uploaded";
    $message = "New homework is uploaded to the school website";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: '".$from."'"."\r\n" ."TO: '".$to."'"."\r\n";
    $headers .= "Bcc: ".implode(',', $recipients)."\r\n";
    
    mail($to, $subject, $message, $headers);
} 

//// 4. redirect to ////

 echo "<BR><a href=\"HomeworkList.php\">Continue</a>";
 

?>