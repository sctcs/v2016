<?php

//DEV
$dbUser = "changeme";
$dbPass = "changeme";
$dbName = "changeme";

$conn = mysqli_connect("localhost", $dbUser, $dbPass);
//$conn = mysqli_connect("ynhchine.startlogicmysql.com", $dbUser, $dbPass);
if (mysqli_connect_errno($conn))
{
  die ('Could not connect: ' . mysqli_connect_error());
  echo "<br>fail to connect ";
}

$db_selected = mysqli_select_db( $conn, $dbName);

if (! $db_selected) {
    die ('Cannot use '.$dbName.' : ' . mysqli_error($conn));
}

date_default_timezone_set('America/New_York');

?>
