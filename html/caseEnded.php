<?php 
session_start();
include_once("../php/classes/Client.php");
Client::insure_logged_in();
if($_SESSION["ended_procecutions"]!= 1){
    header("Location: homePage.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>القضايا المنتهية</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/headerStyle.css"/>
        <link rel="stylesheet" href="../css/searchsectionStyle.css"/>
        <link rel="stylesheet" href="../css/tablesectionStyle.css"/>
        <link rel="stylesheet" href="../css/show-detials-section.css"/>
        <link rel="stylesheet" href="../css/caseEnded.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/footerPage.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    </head>
    <body dir="rtl">

            <!--start header-->
            <header>
            <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                                <img style=" border-radius:15%;" src="<?php echo$_SESSION["get_profile_picture_url"];?>" class="image-header" width="40px" height="40px" id="image-laywer">
                                <a class="navbar-brand" href="homePage.php"><i class="fas fa-gavel"></i><?php echo " ".$_SESSION["office_name"] ?></a>
                    
                        </div>

                     <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                       <li <?php if($_SESSION["financial_page"]!=1){ echo 'style="display:none"';}?> ><a href="../php/financial.php">الأمور المالية</a></li>
                        <li class="active" <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?> ><a href="caseEnded.php">القضايا المنتهية </a></li>
                        <li   <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>><a href="../php/Lowyer.php">المستخدمين</a></li>
                        <li   <?php if($_SESSION["reminds_page"]!=1){ echo 'style="display:none"';}?>><a href="reminds.php">التذكير</a></li>
                        <li   <?php if($_SESSION["sessions_page"]!=1){ echo 'style="display:none"';}?>><a href="records.php">الجلسات</a></li> 
                        <li<?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?> ><a href="customers.php">الزبائن</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo "مرحبا " . $_SESSION["username"] ?>
                                <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="../html/settings.php"><i class="material-icons">settings</i>الاعدادت</a></li>
                                      <li><a href="../php/logout.php"><i class="material-icons">&#xE314;</i>خروج</a></li>
                                    </ul>
                            </li>
                        </ul>
                    </div>
              </div>
            </nav>
        </header>
        <!--end header-->
        
        
        
        
              
        <!--start option section-->
            <div class="option text-center">
                <div class="container">
                    <h2 class="h1">الخيارات</h2>
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <a href="customers_ended.php"><img width="100px" height="100px" class="img-circle" src="../image/cust.png"></a>
                            <p class="text-center">الزبائن </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 even">
                            <a href="#"><img width="100px" height="100px" class="img-circle" src="../image/money.png"/></a>
                            <p class="text-center">الأمور المالية </p>
                        </div>

                        <div class="col-md-12 col-sm-6 col-xs-12 even">
                            <a href="records_ended.php"><img width="105px" height="105px" class="img-circle" src="../image/file.png"/></a>
                            <p class="text-center">الجلسات </p>
                        </div>
                    </div>  
                </div>
            </div>
            
        <!--end option section-->
        
        
        
        
        
        <!-- import the footer file-->
        <?php include_once("footerPage.html"); ?>
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    </body>
</html>