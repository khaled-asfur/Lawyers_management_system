<?php
include_once("../php/classes/Client.php");
Client::insure_logged_in();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الاعدادات</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/headerStyle.css"/>
        <link rel="stylesheet" href="../css/setting.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/footerPage.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>
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
                    <li  <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?> ><a href="caseEnded.php">القضايا المنتهية </a></li>
                    <li   <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>><a href="../php/Lowyer.php">المستخدمين</a></li>
                    <li   <?php if($_SESSION["reminds_page"]!=1){ echo 'style="display:none"';}?>><a href="reminds.php">التذكير</a></li>
                    <li   <?php if($_SESSION["sessions_page"]!=1){ echo 'style="display:none"';}?>><a href="records.php">الجلسات</a></li> 
                    <li  <?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?> ><a href="customers.php">الزبائن</a></li>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo "مرحبا ". $_SESSION["username"] ?>
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


        <section class="setting">
            <div class="container text-center">
                <h2 class="title-section">الاعدادات</h2><hr>
              <!-- <div class="img-sec">
                   <img src="../image/2.jpeg" id="img_header"/>
                </div>
              -->
                
                    <div class="info">
                        <label class="sub-title">اسم المكتب</label>
                        <input type="text" class="info-value" value="<?php echo $_SESSION["office_name"] ?>" id="office_name"/>
                    </div>
                <!--
                    <div class="info">
                        <label class="sub-title">اسم المستخدم</label>
                        <input type="text" class="info-value" name="user_name"/>
                    </div>
                
                    <div class="info">
                        <label class="sub-title">البريد الالكتروني</label>
                        <input type="text" class="info-value" name="email"/>
                    </div>
                    
                    <div class="info">
                        <label class="sub-title">رقم الهاتف</label>
                        <input type="text" class="info-value" name="phone_number"/>
                    </div>
                                       <div class="info info-image">
                        <label class="sub-title">اختيار صورة جديدة</label>
                        <input type="file"  name="pic"  accept="image/gif, image/jpeg, image/png, image/jpg" onchange="readURL(this)"/>
                    </div>
                -->
                                <!-- show  error message start-->
            <div  style="display:none; margin-left:5%;margin-right:5%;" id="error_dialog"  class="row">
           
            <div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_fail_dialog"  aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div id="show_Error">
                <!-- the delete error wil be printed here-->
            </div>      
                
            </div>
        </div>
         <!-- show  error message end-->
         
  <!-- show  success message start-->
  <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="success_dialog"  class="row">
  <div class="alert alert-success alert-dismissible " role="alert">
      <button type="button" class="close close_success_dialog"  aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      <div id="show_success_msg">
        <!-- the success error will be printed here-->
      </div> 

     
  </div>
</div>
<!-- show  success message end-->
                    <div class="info">
                        <button id="save"class="btn btn-success">حفظ التغيرات</button>
                    </div>


                    <div class="info">
                        <label class="sub-title">كلمة المرور</label>
                        <input type="password" placeholder="كلمة المرور الحالية" class="info-value" id="old_password"/>
                    </div>
                    <div class="info">
                        <label class="sub-title"></label>
                        <input type="password"  placeholder="كلمة المرور الجديدة" class="info-value_pass" id="new_password"/>
                    </div>
                    <div class="info">
                         <label class="sub-title"></label>
                        <input type="password" placeholder="تأكيد كلمة المرور" class="info-value_pass" id="confirm_new_password"/>
                    </div>
            <!-- show  error message start-->
            <div  style="display:none; margin-left:5%;margin-right:5%;" id="password_error_dialog"  class="row">
           
            <div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_pass_fail_dialog"  aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div id="password_show_Error">
                <!-- the delete error wil be printed here-->
            </div>      
                
            </div>
        </div>
         <!-- show  error message end-->
         
  <!-- show  success message start-->
  <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="password_success_dialog"  class="row">
  <div class="alert alert-success alert-dismissible " role="alert">
      <button type="button" class="close close_pass_success_dialog"  aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      <div id="password_show_success_msg">
        <!-- the success error will be printed here-->
      </div> 

     
  </div>
</div>
<!-- show  success message end-->

                    <div class="info">
                        <button id="save_password"class="btn btn-success">تعديل كلمة المرور </button>
                    </div>
                
                
            </div>
            
        
        </section>
        <?php include_once('footerPage.html')?>
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/settings.js"></script>
        <script>
            function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#img_header')
                    .attr('src', e.target.result)
                    .width(120)
                    .height(120);
            };

            reader.readAsDataURL(input.files[0]);
        }
}
        </script>
    </body>
</html>