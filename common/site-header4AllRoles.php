<?php
// session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
 session_start();
if(  isset($_SESSION['logon'])) {
 //  header( 'Location: MemberLoginForm.php?error=3' ) ;
 //  exit();
   $mt = $_SESSION['MemberTypes'];
   $allids = array_keys($mt);
   $all_descr = array_values($mt);

   //echo "User = ". $_SESSION['user']."<br>";
   //echo "MemberType = ". $_SESSION['MemberType']."<br>";

   //echo "MemberTypes id = ".$mt['id'][0]."<br>";
   //echo "MemberTypes id = ".$mt['descr'][0]."<br>";

 ?>
 Please choose your role from the list:<br><br>
 <form name="chooseRoleForm" action="setRole.php" method="POST">
   <input type="hidden" name="action" value="setrole">
   <select name="membertype">
   <?php
   for ($i=0;$i<count($allids);$i++){
     if (isset($_SESSION['membertype_chosen']) && $_SESSION['membertype_chosen'] == $allids[$i]) {
       echo "<option SELECTED value=\"".$allids[$i]."\">".$all_descr[$i]."</option><br>\n";
     } else {
       echo "<option value=\"".$allids[$i]."\">".$all_descr[$i]."</option><br>\n";
     }
   }
   ?>
   </select>
   <input type="submit" value="Continue">
   </form>
   <?php
}
?>