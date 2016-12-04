<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();


include("../common/DB/DataStore.php");

$emails = $_POST[emails];
//echo $emails;

//unset($emflag);
$addresses = explode(",", $emails);
foreach(array_keys($addresses) as $key){
    $em = trim( str_replace('@','-',$addresses[$key]) );
    $emflag[$em]=1;
// echo $em ."=" . $emflag[$em] . "<br>";
}

$SQLstring = "SELECT distinct a.Email 
                FROM tblMember a, tblClass c
                  where a.MemberID=c.TeacherMemberID 
                    and  c.CurrentClass='Yes'  ";

//echo $SQLstring;

$RS1=mysqli_query($conn,$SQLstring);

    echo "Active but not found in list:" .              "<br>";
while ($row=mysqli_fetch_array($RS1) ) {
   $em = strtolower( trim( $row[Email] ) );
    $em = str_replace('@','-',$em);
// echo $em . "<br>";
// echo $em ."=" . $emflag[$em] . "<br>";
 if ( $emflag[$em] > 0 ) {
//  echo "found in list:" . $row[Email] ."<br>";
    $emflag[$em] = 0;
 } else {
    echo "Not found in list:".  $row[Email] ."<br>";
 }
}

echo "<br>";
    echo "In list but not active:" .                   "<br>";
foreach(array_keys($addresses) as $key){
    $em = trim( str_replace('@','-',$addresses[$key]));
// echo $em ."=" . $emflag[$em] . "<br>";
    if ( $emflag[$em] > 0) {
    echo                 $addresses[$key] ."<br>";
    }
}

mysqli_close($conn);

?>
