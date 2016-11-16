<?php
if ( $_SERVER["SERVER_NAME"] != "localhost" ) {
  session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();
if( ! isset($_SESSION['membertype']) || $_SESSION['membertype'] > 20 ) {
   echo "You have to login with sufficient authroization to see the member list";
   exit;
}

if ( isset($_POST[FirstName]) && trim($_POST[FirstName]) != "") {
  $firstName=$_POST[FirstName];

}
if ( isset($_POST[LastName]) && trim($_POST[LastName]) != "") {
  $lastName=$_POST[LastName];
  $_SESSION[lastName]=$_POST[LastName];
}
if ( isset($_POST[ChineseName]) && trim($_POST[ChineseName]) != "") {
  $chineseName=$_POST[ChineseName];
}

if ( isset($_POST[MemberID]) && trim($_POST[MemberID]) != "") {
  $memberID=$_POST[MemberID];
  $_SESSION[memberID]=$_POST[MemberID];
} else {
  $_SESSION[memberID]="";
}

if ( isset($_POST[roles]) && trim($_POST[roles][0]) != "") {
  for ($i=0;$i<count($_POST[roles]); $i++) {
    $roles .= $_POST[roles][$i] . ",";		// new roles
    $rolesnew[$_POST[roles][$i]]=1;
  }
  $rolescurr = explode(',', $_POST[membertypescurr]);		// existing roles
  for ($i=0;$i<count($rolescurr); $i++) {
    if (trim($rolescurr[$i]) != "" ) {
       $rolesold[$rolescurr[$i]]=1;
    }
  }
  for ($i=0;$i<20; $i++) {
     if (isset($rolesold[$i]) && $rolesold[$i] == 1) {
        if (! isset($rolesnew[$i]) || $rolesnew[$i] != 1 ) {
           $delete .= $i .',';
        }
     }
     if (isset($rolesnew[$i]) && $rolesnew[$i] == 1) {
	         if (! isset($rolesold[$i]) || $rolesold[$i] != 1 ) {
	            $insert .= $i .',';
	         }
     }
  }
  if (isset ($delete) && trim($delete) != "" ) {
     // delete some roles
     include("../common/DB/DataStore.php");
//mysqli_select_db($dbName, $conn);
     $delete = rtrim($delete,',');
     $SQLstring = 'delete FROM `tblLogin` where MemberID = '.$_POST[MemberID].' and MemberTypeID in ('.$delete.')';
     //echo $SQLstring;
     $RS1=mysqli_query($conn,$SQLstring);
     mysqli_close($conn);
  }
  if (isset ($insert) && trim($insert) != "" ) {
       // insert some roles
       include("../common/DB/DataStore.php");
//mysqli_select_db($dbName, $conn);
       $insert=rtrim($insert,',');
       $newroles = explode(',', $insert);
       $SQLstring="";
       for ($i=0;$i<count($newroles); $i++) {
          if ( trim($newroles[$i]) != "") {
            $SQLstring = 'insert into tblLogin(MemberID,MemberTypeID) values('.$_POST[MemberID].','.$newroles[$i].');';
            //echo $SQLstring;
            $RS1=mysqli_query($conn,$SQLstring);
          }
       }

       mysqli_close($conn);
  }

}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>YNHCS Assign Member Roles</title>
<meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School">
<!-- <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" /> -->
<meta http-equiv="Content-type" content="text/html; charset=gb2312" />
<link href="../common/ynhc.css" rel="stylesheet" type="text/css">

</head>

<body>
<script language="javascript">
function fillForm() {

     var memberid = updateMemberRolesForm.memberDropDown.value;
	      var n = updateMemberRolesForm.memberDropDown.selectedIndex;
	      var memberdesc = updateMemberRolesForm.memberDropDown[n].text;
	      var lname = memberdesc.substr(0,memberdesc.indexOf(","));
	      var fcname = memberdesc.substr(memberdesc.indexOf(",")+2);
	      if ( fcname.indexOf(";")>0 ) {
	      var fname = fcname.substr(0,fcname.indexOf(";"));
	      var cname = fcname.substr(fcname.indexOf(";")+2);
	      } else {
	      var fname = fcname;
	      var cname = "";
	      }
	      updateMemberRolesForm.LastName.value = lname;
	      updateMemberRolesForm.FirstName.value = fname;
	      updateMemberRolesForm.ChineseName.value = cname;
     updateMemberRolesForm.MemberID.value = memberid;

     updateMemberRolesForm.submit();

     return false;
 }

 function clearForm() {


 	//updateMemberRolesForm.LastName.value = "";
 	  updateMemberRolesForm.FirstName.value = "";
 	  updateMemberRolesForm.ChineseName.value = "";
      updateMemberRolesForm.MemberID.value = "";

      return false;
 }
</script>
<table width="780" background="" bgcolor="" border="0" align="center">
	<tr>
		<td>
		<?php include("../common/site-header1.php"); ?>
		</td>
	</tr>
	<tr >
		<td width="98%" bgcolor="#993333">
			<table height="360" width="100%" border="0" bgcolor="white">
				<tr>
					<td width="26%" align="center" valign="top">
						<table width="100%">
							<tr><td>&nbsp;</td></tr>
							<tr><td><?php //include("../common/site-header4Profilefolder.php"); ?></td></tr>
						</table>


					</td>
					<td align="center" valign="top">
						<table width="100%">
							<tr>
								<td align="center"><font><b>&nbsp</b></font></td>
							</tr>
							<tr><td>



							 First, enter a valid last name and click on Lookup to list members of this last name;
							 then, choose a member from the list; finally, check or de-check all roles that apply and click on Update Roles to save changes.<br><br>
							  <form name="updateMemberRolesForm" action="assignMemberRoles.php" method="POST">
							    <input type="hidden" name="action" value="setroles">
							    <table>
							    <tr><td align="right" nowrap>Last Name:</td><td>
									<input name="LastName"  type="label" size="20" value="<?php echo $lastName; ?>" >
							    </td></tr>
							    <tr><td colspan="2" align="center">
									<input type="submit" name="lookup" onClick="clearForm();" value="Lookup">

							    </td></tr>
							    <tr><td align="right" nowrap>Member List:</td><td>
							    <?php include("../common/listOfMembers.php"); ?>
							    </td></tr><tr><td align="right" nowrap>Member ID:</td><td>
							    <input name="MemberID" type="hidden" size="20" value="<?php echo $memberID; ?>" >
                                <?php echo $memberID; ?>
							    </td></tr>

							    <tr><td align="right" nowrap>First Name:</td><td>
							    <input name="FirstName" type="hidden" size="20" value="<?php echo $firstName; ?>" >
							    <?php echo $firstName; ?>
							    </td></tr>
							    <tr><td align="right" nowrap>Chinese Name:</td><td>
							    <input name="ChineseName" type="hidden" size="20" value="<?php echo $chineseName; ?>" >
							    <?php echo $chineseName; ?>
							    </td></tr>



							    <tr><td align="right" valign="top" nowrap>Avail. Roles:</td><td>
                                <?php include("./listOfRolesCheckboxes.php");
                                //echo "$roles"; echo "||"; echo $_POST[membertypescurr]; echo "|| delete:".$delete."|| insert:".$insert;
                                ?>
                                </td></tr><tr><td colspan="2" align="center">
							    <input type="submit" name="assign" value="Update Roles" onClick="return true;">

							    </td></tr></table>
                              </form>


                            </td></tr>
                            <tr><td align="right"><a href="MemberAccountMain.php">Done</a></td></tr>
						</table>
					</td>

				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
		</td>
	</tr>
	<tr>
		<td>
		<?php include("../common/site-footer1.php"); ?>
		</td>
	</tr>
</table>
</body>
</html>
