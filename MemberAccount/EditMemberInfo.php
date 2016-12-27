<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}

session_start();


include("../common/DB/DataStore.php");
include("../common/CommonParam/params.php");

 if (!isset($_SESSION['logon']) || $seclvl > 25 && $seclvl != 40) 
 {  
    echo ("You are not authorized to modify member") ;
    exit();
 }
 
$memid =$_GET['memid'];

//echo " memid=". $memid;

if(!isset($memid) || $memid ===""){
   header('Location: MemberAccountMain.php'); 
}
else if($memid) {
$SQLstring = "SELECT * FROM `tblMember` WHERE tblMember.MemberID=".$memid;

//echo "see ". $SQLstring."<br>";
$RS1 = mysqli_query($conn, $SQLstring);
$RSA1 = mysqli_fetch_array($RS1);
}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Member Profile Edit</title>
        <meta http-equiv="Content-type" content="text/html; charset=gb2312" />
        <meta name="keywords" content="New Haven Chinese School, Yale New Haven Chinese School , Connecticut Chinese School, Chinese School" />
        <link href="../common/ynhc_addoncss.css" rel="stylesheet" type="text/css" />
        <script language="javascript" src="../common/JS/MainValidate.js"></script>
        <script>
            function SSAutoTab(input, Gnext, len, e)
            {
                if (input.value.length >= len)
                {
                    if (eval("document.all." + Gnext))
                    {
                        eval("document.all." + Gnext).focus();
                    }

                }
            }
            
        </script>
    </head>
    <body>
        <header>
            <?php include("../common/site-header1.php"); ?>
        </header>
        <div class="container">
            <?php
            $PhoneArrary = explode("-", $RSA1[HomePhone]);
            //$x=$PhoneArrary[0];
            //echo "<br>see22: ".$PhoneArrary[0];
            $CPhoneArrary = explode("-", $RSA1[CellPhone]);
            $OPhoneArrary = explode("-", $RSA1[OfficePhone]);
            ?>

            <div class="page formwrapper">
       
                <form name="MemberProfileEdit" action="UpdateMemberProfile.php" method="post" onsubmit="return Validate(this);">
                 <fieldset>
                    <legend>Update Member Profile</legend>
                    
                    <input type="hidden" name="mid" value="<?php echo $RSA1[MemberID]; ?>" />
                  
                    <div class="form-group">
                        <label for="MemberID">Member ID: </label>
                        <input type="text" name="MemberID" disabled="disabled" value=<?php echo $RSA1[MemberID]; ?> /><br>
                    
                        <label for="FamilyID">Family ID:</label>
                        <input type="text" name="FamilyID" disabled="disabled" value=<?php echo $RSA1[FamilyID]; ?>>
                    </div>
                    
                    <div class="form-group">
                         <label for="PCFristName">First Name: <span class="red-color">*</span></label>
                         <input type = "text" size = "28" name = "PCFristName" disabled = "disabled" value = "<?php echo $RSA1[FirstName]; ?>"><br>
                      
                            <label for = "PCLastName">Last Name: <span class = "red-color">*</span></label>
                            <input type = "text" size = "28" name = "PCLastName" disabled = "disabled" value = "<?php echo $RSA1[LastName]; ?>"><br>
                     </div>
                    
                     <div class="form-group">
                                <label for = "PCChineseName">Chinese Name: <span class = "red-color"></span></label>
                                <input type = "text" size = "28" name = "PCChineseName" value = "<?php echo $RSA1[ChineseName]; ?>"><br>
                    </div>
                    
                    <div class="form-group">
                          <label for = "gender">Gender: </label>
                             <?php
                                if ( $RSA1[Gender] == "M" ) {
                                    $male = "checked";
                                    $female = "";
                                } else if ($RSA1[Gender] == "F") {
                                    $male = "";
                                    $female = "checked";
                                } else {
                                    $male = "";
                                    $female = "";
                                }
                             ?>
                           Male<input type="radio" name="gender" value="M" disabled="disabled" <?php echo $male; ?> >
                           Female <input type="radio" name="gender" value="F" disabled="disabled" <?php echo $female; ?> >
                    </div>
                    
                    <div class="form-group">
                            <label for="PrimaryContact">Primary Contact<span class="red-color">*</span></label>
                            <?php
                            if ($RSA1[PrimaryContact] == "Yes") {
                                 $PCParentYes = "checked";
                                 $PCParentNo = "";
                            } else {
                                 $PCParentYes = "";
                                 $PCParentNo = "checked";
                            }
                            ?>
                            Yes<input type="radio" name="PrimaryContact" value="Yes"  <?php echo $PCParentYes; ?> >
                            No<input type="radio" name="PrimaryContact" value="No"  <?php echo $PCParentNo; ?> >
                    </div>

                    <div class="form-group">    
                        <label for="PCEmail">Email<span class="red-color">*</span></label>
                        <input  type="text" size="28" name="PCEmail" value="<?php echo $RSA1[Email]; ?>">
                        <br> <label for="SCEmail">Second Email: </label>
                        <input type="text" size="28" name="SCEmail" value="<?php echo $RSA1[SecondEmail]; ?>">
                    </div>
                    <div class="form-group"> 
                        <label for="homephone">Home Phone<span class="red-color">*</span></label>
                            <input size="3" maxlength="3" name="area" onKeyUp="return SSAutoTab(this, 'prefix', 3, event);" value="<?php echo $PhoneArrary[0]; ?>">
                            <span size="3">-</span>
                            <input  size="3" maxlength="3" name="prefix"  onKeyUp="return SSAutoTab(this, 'suffix', 3, event);"  value="<?php echo $PhoneArrary[1]; ?>">
                            <span size="3">-</span>
                            <input size="4" maxlength="4" name="suffix"   value="<?php echo $PhoneArrary[2]; ?>">
                    </div> 
                    <div class="form-group">    
                             <label for="">Cell Phone</label>
                             <input size="3" maxlength="3" name="Carea" onKeyUp="return SSAutoTab(this, 'Cprefix', 3, event);" value="<?php echo $CPhoneArrary[0]; ?>">
                             <span size="3">-</span>
                             <input size="3" maxlength="3" name="Cprefix"  onKeyUp="return SSAutoTab(this, 'Csuffix', 3, event);"  value="<?php echo $CPhoneArrary[1]; ?>">
                             <span size="3">-</span>
                             <input size="4" maxlength="4" name="Csuffix"   value="<?php echo $CPhoneArrary[2]; ?>">
                    </div>
                    <div class="form-group">
                    <label for="OfficePhone">Office Phone</label>
                        <input size="3" maxlength="3" name="Oarea" onKeyUp="return SSAutoTab(this, 'Oprefix', 3, event);" value="<?php echo $OPhoneArrary[0]; ?>">
                        <span size="3">-</span>
                        <input size="3" maxlength="3" name="Oprefix"  onKeyUp="return SSAutoTab(this, 'Osuffix', 3, event);"  value="<?php echo $OPhoneArrary[1]; ?>">
                        <span size="3">-</span>
                        <input size="4" maxlength="4" name="Osuffix"   value="<?php echo $OPhoneArrary[2]; ?>">
                    </div>
                    <div class="form-group">    
                     <label for="Address">Address: <span class="red-color">*</span></label>
                     <input type="text" size="28" name="Address" value="<?php echo $RSA1[HomeAddress]; ?>">

                    <br> <label for="city">City: <span class="red-color">*</span></label>
                    <input type="text" size="28" name="city" value="<?php echo $RSA1[HomeCity]; ?>">

                     <br><label for="state">State: <span class="red-color">*</span></label>
                     <input type="text" size="28" name="state" value="<?php echo $RSA1[HomeState]; ?>">
                   
                     <br><label for="zip">Zip Code: <span class="red-color">*</span></label>
                     <input type="text" size="5" maxlength="5"  name="zip" value="<?php echo $RSA1[HomeZip]; ?>" >

                     </div>
                      <div class="form-group">    
                        <input type="submit" class="button" value="Update">
                        <input type="button" class="button" width="18"  onClick="window.location.href = 'MemberAccountMain.php'" value="Cancel" />
                    </div>
               </fieldset>
         </form>

    </div>
  </div>
    <?php include("../common/site-footer1.php"); ?>
        
    </body>
</html>

<?php
mysqli_close($conn);
?>
