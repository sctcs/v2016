<?php
if ($_SERVER["SERVER_NAME"] != "localhost") {
    session_save_path("/home/users/web/b2271/sl.ynhchine/phpsessions");
}
session_start();

if (isset($_SESSION['logon']) && $_SESSION['logon'] != "") {
    header('Location: MemberAccountMain.php');
}
include("../common/CommonParam/params.php");
?>
<header>
    <?php include("../common/site-header1.php"); ?>
</header>

<div class="container-fuild">
    <h3 class="text-center"><?php echo $SCHOOLNAME; ?> Member Login Page</h3>
    <div class="main-body">
        
        <p class="alert alert-info">Please Enter your Login ID (not email address) and Password</p>   

        <?php if ($_GET["error"] == 1) { ?>
            <p class="alert alert-info">Can not have empty space in LoginID or Password Field.</p>

        <?php } ?>
        <?php if ($_GET["error"] == 2) { ?>
            <p class="text-center red-color">Either the Login ID or the Password that you supplied was incorrect.</p>
        <?php } ?>
        <div class="login_wrapper">
            <form  action="Login.php" method="post" onsubmit="return Validate(this);">
                <label for="loginID">Login ID:</label>
                <input type="text" name="loginID" size="20" /><br />

                <label for="userPW">Password:</label>
                <input type="password" name="userPW" size="20"/><br />

                <label for="submit"></label>
                <input type="submit" value="Login" /><br />
            </form>  
        </div>
        <p class="alert alert-info">Help Notes</p>       
        <div class="help-block">
            <ol>
                <li> Forgot your login ID or password? <a href="retrieveLoginID.php">Retrieve it</a>.
                    <ul>
                        <li> (Please note that our hosting site IP has been in Yahoo and possibly other free email providers' block list and therefore you may have trouble receiving the retrival email if you are using one of these free email accounts.
                        </li><li> If this is the case, you should contact school web support <a href="maito:support@ynhchineseschool.org">support@ynhchineseschool.org</a> for help). 
                        </li><li>If you are a former member (none of your children took any class last term), please contact support, too.
                        </li>
                    </ul>
                </li>
                <li>Not sure if you have a login? Use <a href="MemberLookupForm.php">Member Lookup</a> to verify.
                </li>    
                <li>Not a registered member yet? You can <a href="NewProfile.php">register</a> now as a new member. (Please note that only ONE parent per family, as the Primary Contact parent, should register for new membership first, when approved this parent should then login and update the family data by adding spouse and children profiles.)
                    <!-- See <a href="NewMemberInstruction.php">instruction</a> on how to join.-->
                </li>
            </ol>
        </div>
    </div>
</div>
<?php include("../common/site-footer1.php"); ?>
    