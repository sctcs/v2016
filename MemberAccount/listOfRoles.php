<?php

if(  isset($_SESSION['logon'])) {
   $mt = $_SESSION['MemberTypes'];

   $allids = array_keys($mt);

   $allvals = array_values($mt);
 ?>

 Please choose a role from the list you want to use for this login<br><br>
 <form name="chooseRoleForm" action="setRole.php" method="POST">
   <input type="hidden" name="action" value="setrole">
   <select name="membertype">
   <?php
   echo "<option value=\"0\">Choose a role</option>\n";
   for ($i=0;$i<count($allids);$i++){

     if (isset($_SESSION['membertype_chosen']) && $_SESSION['membertype_chosen'] == $allids[$i]) {
       echo "<option SELECTED value=\"".$allids[$i]."\">".$allvals[$i]."</option>\n";
     } else {
       echo "<option value=\"".$allids[$i]."\">".$allvals[$i]."</option>\n";
     }
   }
   ?>
   </select>
   <input type="submit" value="Continue">
   </form>
   <?php
}
?>