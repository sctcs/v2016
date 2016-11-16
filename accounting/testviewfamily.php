<?php
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Account Receivable Payment</title>
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">
</head>

<body>
<?php
require_once("AccountReceivable.php");
require_once("AccountPayment.php");
require_once("Tools.php");
// require_once("../common/DB/DataStore.php");

ViewFamilyAccount($_GET['family_id'])
?>
</body>
</html>
