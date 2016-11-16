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

//$target_file = $target_path . $ClassID . "_".$hwversion. "_". $origname; // basename( $_FILES['hwfile']['name']);
$target_file = $target_path . '/'. $ClassID . "_". $origname; // basename( $_FILES['hwfile']['name']);
echo "it will be save as: " .$target_file. "<br>";

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
             " values (". $ClassID .",'". $target_path."','".$fname."','".$ftype."','".$hwduedate."','".$hwdescription."',".$_SESSION[memberid].", now() )";
//echo "see: ".$SQLstring;

$SQLSemails = "select m.Email as Email
        FROM  tblClassRegistration r, tblClass c, tblMember m, tblTeacher t
        WHERE r.ClassID = '".$ClassID."' AND c.Year='".$CurrentYear."' AND c.Term='".$CurrentTerm."' AND c.CurrentClass='Yes'  AND r.StudentMemberID = m.MemberID AND r.Status= 'OK' AND t.MemberID = $_Session[memberid]";
        
$SQLTemail = "SELECT Email FROM tblMember WHERE MemberID = '".$_SESSION[memberid]."' ";

$RS1=mysqli_query($conn,$SQLstring);


if ( ! $RS1 ) {
  echo mysqli_error($conn);
  exit;
}

$RSE = mysqli_query($conn, $SQLSemails);  //Query Student Email Address
$RST = mysqli_query($conn, $SQLTemail);   //Query Teacher Email Address

if (!RSE || !RST ) {
    echo mysqli_error( "Error: " + $conn ) ;
    exit;
}

mysqli_close($conn);


// save the file to disk

if(move_uploaded_file($_FILES['hwfile']['tmp_name'], $target_file)) {
    echo " file ".  basename( $_FILES['hwfile']['name']).  " has been uploaded successfully<br>";
    $success = true; 
    
} else{
    echo "There was an error uploading the file, please try again!";
    $success = false;
    $_SESSION[hwdesc]=$hwdescription;
    $_SESSION[hwduedate]=$hwduedate;
	   echo "<a href=\"HomeworkUploadForm_test.php?vererror=1\">Back</a>";
   exit;
}
//Compose emaillist and send out alert when file uploaded successfully

if ($success) {
    echo "Batch emailing students of new homework assignments...";
    //Compose email messages 
    $RST1 = mysqli_fetch_assoc($RST) ; //get teacher email 
    $recipients = $array();
    
    while ($row = mysqli_fetch_array($RSE)) {   //retrieving student emails one row at a time and store in recipients array
     $recipients[] =$row['Email'];
    }
    
    $to = "$RST1";
    $subject = "New Homework is uploaded";
    $message = "A new homework is uploaded to the school website.";
    $headers = "From: $RST1". "\r\n";
    $headers .="Reply-To: $RST1" . "\r\n";
    $headers .= 'BCC: ' .implode(',', $recipients) ."\r\n";
    $sent = mail($to, $subject, $message, $headers);
    }
  
 
//// 4. redirect to ////

 echo "<BR><a href=\"HomeworkList.php\">Continue</a>";


?>