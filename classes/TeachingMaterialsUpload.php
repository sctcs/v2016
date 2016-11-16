<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

include("../common/DB/DataStore.php");
ini_set('memory_limit', '8M');

////  1. load all variables ////


$FileName=$_POST[FileName];
$FileName=str_replace("'", "''",$FileName);
$FileName=str_replace("\n", " ",$FileName);
$FileName=trim($FileName);

$FileDescription=$_POST[FileDescription];
$FileDescription=str_replace("'", "''",$FileDescription);
$FileDescription=str_replace("\n", " ",$FileDescription);
$FileDescription=trim($FileDescription);

$MaterialType=$_POST[MaterialType];
$MaterialType=str_replace("'", "''",$MaterialType);
$MaterialType=str_replace("\n", " ",$MaterialType);
$MaterialType=trim($MaterialType);

$MaterialGrade=$_POST[MaterialGrade];
$MaterialGrade=str_replace("'", "''",$MaterialGrade);
$MaterialGrade=str_replace("\n", " ",$MaterialGrade);
$MaterialGrade=trim($MaterialGrade);

$tmfile=$_POST[tmfile];
$tmfile=str_replace("'", "''",$tmfile);
$tmfile=str_replace("\n", " ",$tmfile);
$tmfile=trim($hwfile);

//echo "Member ID: ". $_SESSION[memberid]. "<br>";
//echo "File Name: " .$FileName . "<br>";
//echo "File Description: " .$FileDescription . "<br>";
//echo "Material Type: " .$MaterialType . "<br>";
//echo "Material Grade: " .$MaterialGrade . "<br>";

//echo "basename: " . basename( $_FILES['tmfile']['name']) . "<br>";

$origname = basename( $_FILES['tmfile']['name'] );

list($fname,$ftype) = explode('\.',$origname);
//echo "origname: ".$origname . "<br>";
//echo "fname: ".$fname . "<br>";
//echo "ftype: ".$ftype . "<br>";

// set target path and file name

$target_path = "TeachingMaterials";

$target_file = $target_path . '/'. $origname;
//echo "File will be save as: " .$target_file. "<br>";

if ($target_file==$target_path.'/') {
    echo "<b>You forget to attach your file!!!</b><br>";
    echo '<a href="TeachingMaterialsUploadForm.php">Back</a>';
    exit;
   }

// Exclude uploading potential dangerous file types
if ($ftype=='exe' || $ftype=='com' || $ftype=='php' || $ftype=='jsp' || $ftype=='asp') {
    echo "You cannot upload this type of file.";
    exit;
   }
if (file_exists($target_file)) {
    echo "The file $target_file exists<br>";
    echo "<b>Please use a different file name</b><br>";
    echo '<a href="TeachingMaterialsUploadForm.php">Back</a>';
   exit;
} else {
   echo "";
}

// insert a record into table

$SQLstring = "insert into tblTeachingMaterials (MaterialGrade, FilePath, FileName,FileDescription,FileType,MaterialType,CreatedByMemberID, CreatedDate) ".
             " values ('".$MaterialGrade."','".$target_path."','".$fname."','".$FileDescription."','".$ftype."','".$MaterialType."',".$_SESSION[memberid].", now() )";
//echo "see: ".$SQLstring;
$RS1=mysqli_query($conn,$SQLstring);
if ( ! $RS1 ) {
  echo mysqli_error($conn);
  exit;
}


mysqli_close($conn);


// save the file to disk and send e-mail if successfully uploaded

if(move_uploaded_file($_FILES['tmfile']['tmp_name'], $target_file)) {
    echo " <br>File ".  basename( $_FILES['tmfile']['name']).  " has been uploaded successfully<br>";
    $to = "liang97@yahoo.com"; 
    $subject = "New Material Uploaded"; 
    $message = "A New Material is Uploaded to the School Web site."; 
    $headers = "From: support@ynhchineseschool.org"; 
    $sent = mail($to, $subject, $message, $headers); 
    } else{
    echo "There was an error uploading the file, please try again!";
    echo '<a href="TeachingMaterialsUploadForm.php">Back</a>';
   exit;
}

//// 4. redirect to ////

 echo '<BR><a href="TeachingMaterialsListDetail.php">Back to the Material List Page</a>';


?>