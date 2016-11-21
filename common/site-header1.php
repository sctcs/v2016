<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=gb2312" />
        <meta name="description" content="southern connecticut Chinese School, chinese, school, education, 中文，汉语，教育，学校">
        <title>Southern Connecticut Chinese School</title>
        <link href="../common/bootstrap.min.css" rel="stylesheet" />
        <link href="../common/index.css" rel="stylesheet" type="text/css" />
        <link href="../common/menu.css" rel="stylesheet" type="text/css" />
        <link href="../common/ynhc_addoncss.css" rel="stylesheet" type="text/css"/>
        
        <!--For debugging purpose-->
       <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
           <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
           <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="container" id="header">
            <!--            <div class="row">-->
            <div class="col-md-10 clearfix">
                <div class="logo">
                    <p class="text-center">  <a href="../../../prod_v14/index.php">
                            <img src="../Image/School_Logo.jpg" alt="logo" height="140">
                        </a>
                    </p>
                </div>
            </div>
            <!--                </div>-->
        </div>
        <div class="clearfix"></div>
        <div class="navbar navbar-default navbar-custom" role="navigation">
            <div class="container">
                 <!--Brand and toggle get grouped for better mobile display-->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--   <a class="navbar-brand" href="#"></a>-->
                </div>
<!--                <div class="navbar" style="margin: 0 auto;">-->
                    <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav" >
                        <li><a href="../../../prod_v14/index.php">Home</a></li>
                        <li><a href="../../../prod_v14/StudentRule.php">Rules</a></li>
                        <li><a href="../../../prod_v14/Announcement2016.php">News/Announcement</a></li>
                        <li><a href="../../../prod_v14/AboutSouthernCT.php">Community</a></li>

                        <li>
                            <?php if (isset($_SESSION['logon'])) { ?>
                                <a href="../MemberAccount/Logoff.php" >Logout</a><span style="color: white;">|</span><a href="../MemberAccount/MemberAccountMain.php" >My Account</a>
                            <?php } else {
                                ?>
                                <a href="../MemberAccount/MemberLoginForm.php" >Member Login</a>
                            <?php } ?>
                        </li>     

                    </ul>
                </div>
            </div>
        </div>
    
