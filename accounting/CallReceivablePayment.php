<?php

// require_once("../common/DB/DataStore.php");

require_once("AccountMain.php");
require_once("AccountReceivable.php");
require_once("AccountPayment.php");
require_once("Tools.php");
getdbconnection();
if (CheckAccess()==1)
{
  searchReceivable();
}
  else
{
?>
<center>
<h2>Access Denied</h2>
<hr>
You do not have access to the function at this page. Please Go back.
<br>
If you need access. Please contact a proper person to get your permission.

</center>
<?php
}
?>
