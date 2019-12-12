<?php
session_start();
include_once("../php/classes/Client.php");
Client::insure_logged_in();


/* //--- all sessions which was bringed when the user logged in are listed here ---
echo $_SESSION["username"] ."<br>";
echo $_SESSION["office_id"] ."<br>";
echo $_SESSION["get_profile_picture_url"] ."<br>";
echo $_SESSION["office_name"]."<br>";
echo $_SESSION["loged_in"]."<br>"; 
echo $_SESSION["end_date"]."<br>"; 
echo "user id=".$_SESSION["user_id"]."<br>"; 

//- privilages sessions
echo $_SESSION["customers_page"]."<br>";
echo $_SESSION["sessions_page"]."<br>";
echo $_SESSION["financial_page"]."<br>";
echo $_SESSION["users_page"]."<br>";
echo $_SESSION["ended_procecutions"]."<br>";
echo $_SESSION["reminds_page"]."<br>";


/**/
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الصفحة الرئيسية </title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <!---fonts-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <!--end font-->
        <link rel="stylesheet" href="../css/as-admin-css.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/homePage.css"/>
        <link rel="stylesheet" href="../css/footerPage.css"/>
        <style>
        </style>
    </head>
    <body dir="rtl">
        <header>
            <!--start navbar-->
                <nav class="navbar navbar-default" id="the-sticky-div">
                <div class="container-fluid">
                        <div class="navbar-header navbar-right">
                                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                </button>
                                <img  src="<?php echo$_SESSION["get_profile_picture_url"];?>" style=" border-radius:15%;" class="image-header" width="40px" height="40px" id="image-laywer">
                                <a class="navbar-brand" href="homePage.php"><i class="fas fa-gavel"></i><?php echo " ".$_SESSION["office_name"] ?></a>
                    
                        </div>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                               <ul class="nav navbar-nav navbar-left">
                                <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo "مرحبا " . $_SESSION["username"] ?> <span class="caret"></span></a>
                                  <ul class="dropdown-menu navbar-inverse">
                                    <li><a href="../html/settings.php"><i class="material-icons">settings</i>الاعدادات</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="../php/logout.php"><i class="material-icons">&#xE314;</i>خروج</a></li>
                                  </ul>
                                </li>
                              </ul>
                        </div><!-- /.navbar-collapse -->
                  
              </div><!-- /.container-fluid -->
            </nav>
            <!--end navbar-->
            
                <div class="container">
                <div class="row">
                    <section class="header-intro">
                        <div class="img-intro col-md-6 col-xs-12">
                            <img style ="border-radius: 10%; " class="img-thumbnail" src="<?php echo $_SESSION["get_profile_picture_url"];?>"/>
                        </div>
                        <div class="col-md-6 col-xs-12">
                            <h2 class="h1">نظام إدارة المحامين!</h2>
                            <p>استخدام هذا النظام يسهل عليك سرعة الوصول الى بيانات الموكلين والى القضايا .
ويعمل هذا النظام ضمن تقنية حديثة حيث تعمل على تذكيرك بموعد القضايا وغيرها من التقنيات الحديثة . </p>
                            <button class="btn btn-ligth btn-lg">التعرف على المزيد</button>
                        </div>
                    </section>
                </div>
            </div>
        </header>
        <!--end header section-->
        
        
        <!--start option section-->
            <div class="option text-center">
                <div class="container">
                    <h2 class="h1">الخيارات</h2>
                    <div class="row">

                 
                        <div class="col-md-6 col-sm-6 col-xs-12"  <?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?>>
                          <a href="customers.php"><img width="105px" height="105px" class="img-circle" src="../image/cust.png"></a>
                            <p class="text-center">الزبائن </p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12"  <?php if($_SESSION["financial_page"]!=1){ echo 'style="display:none"';}?>>
                          <a href="../php/financial.php"><img width="105px" height="105px" class="img-circle" src="../image/money.png"></a>
                            <p class="text-center">الامور المالية </p>
                        </div>

                        <div class="col-md-6 col-sm-6 col-xs-12 even"  <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?>>
                            <a href="caseEnded.php"><img width="105px" height="105px" class="img-circle" src="../image/endfile.png"/></a>
                            <p class="text-center">القضايا المنتهية</p>
                        </div>
                          <div class="col-md-6 col-sm-6 col-xs-12 even"  
                               <?php if($_SESSION["sessions_page"]!=1){ echo 'style="display:none"';}?>>
                            <a href="records.php"><img width="105px" height="105px" class="img-circle" src="../image/file.png"/></a>
                            <p class="text-center">الجلسات</p>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12"  <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>>
                            <a href="../php/Lowyer.php"><img width="105px" height="105px" class="img-circle" src="../image/users.png"/></a>
                            <p class="text-center">المستخدمين</p>
                        </div>
                         <div class="col-md-6 col-sm-6 col-xs-12"  <?php if($_SESSION["reminds_page"]!=1){ echo 'style="display:none"';}?>>
                            <a href="reminds.php"><img width="105px" height="105px" class="img-circle" src="../image/reminds.jpg"/></a>
                            <p class="text-center">التذكير</p>
                        </div>
                    </div>  
                </div>
            </div>
            
        <!--end option section-->
           <?php include_once('footerPage.html');?>
        <!-- import the footer file-->
     
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script src="../js/scroll.js"></script>
        <script src="../js/homePage.js"></script>
    
    </body>
</html>