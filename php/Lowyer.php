<?php
session_start();
include_once("../php/classes/Client.php");

Client::insure_logged_in();
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}if(!isset($_SESSION['users_page'])){
	$uri .= $_SERVER['HTTP_HOST'];
	header('Location: '.$uri.'/lawyers/html/login.php');
	exit;
    }
    else{
      $_SESSION['show_financial_page']=0;
	$_SESSION['show_user_page']=1;
    }




?>

<!DOCTYPE html>

<html>
    <head>
        <meta charset="utf-8"/>
        <title>المحامين</title>
            <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/jq-3.2.1/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/cr-1.4.1/kt-2.3.2/r-2.2.1/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.css"/>

        
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/headerStyle.css"/>
        <link rel="stylesheet" href="../css/searchsectionStyle.css"/>
        <link rel="stylesheet" href="../css/tablesectionStyle.css"/>
        <link rel="stylesheet" href="../css/show-detials-section.css"/>
        <link rel="stylesheet" href="../css/Lowyer.css"/>
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
                                       <a class="navbar-brand" href="../html/homePage.php"><i class="fas fa-gavel"></i><?php echo " ".$_SESSION["office_name"] ?></a>
                           
                               </div>
       
                            <div class="collapse navbar-collapse" id="myNavbar">
                               <ul class="nav navbar-nav">
                            <li  <?php if($_SESSION["financial_page"]!=1){ echo 'style="display:none"';}?> ><a href="../php/financial.php">الأمور المالية</a></li>
                               <li  <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?> ><a href="../html/caseEnded.php">القضايا المنتهية </a></li>
                               <li  class="active" <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>><a href="../php/Lowyer.php">المستخدمين</a></li>
                               <li   <?php if($_SESSION["reminds_page"]!=1){ echo 'style="display:none"';}?>><a href="../html/reminds.php">التذكير</a></li>
                               <li   <?php if($_SESSION["sessions_page"]!=1){ echo 'style="display:none"';}?>><a href="../html/records.php">الجلسات</a></li> 
                               <li<?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?> ><a href="../html/customers.php">الزبائن</a></li>
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

              <!--start search and add new button-->
        <section class="sec-search text-center">
            <div class="container">
                <div class="row form-search">
                         <input type="text" placeholder="ادخل اسم المحامي او رقم هاتفه" name="search-name-Id" autocomplete="on" id="val"/>
                     
                </div>
                
                <div class="row">
                    <button type="button" name="add" id="addd" class="btn btn-info fas fa-plus">اضافة محامي جديد</button>
                </div>
            </div>
        </section>
        <!--end search and add new button-->
        
        
        
    <!--table show finanical records details-->
    
   <br />
        <section class="table-section">
            <div class="container">
                     <div class="row">
                        <div class="container box">
                     <div id="alert_message"></div>

   
                      <table id="user_data" class="table datatable">
     <thead>
      <tr>
   
       <th>Name</th>
        <th>phone_num</th>
         <th>email</th>
       <th>Actions</th>
      
      </tr>
     </thead>
    </table>
                </div>
            </div>
        </section>
        <!--end show finanical records details--->
        
        <!--dialog show anouther details--->
        <section class="overlay show-details text-center" id="show-details" >
            <div class="container">
                <span class="close-btn">
                    <i onclick="document.getElementById('show-details').style.display='none'" class="fa fa-window-close" aria-hidden="true"></i>
                </span>
                
                <h2 class="super-title">صلاحيات المستخدم</h2>
                <div class="row">
                     <label class="cont">عرض المستخدمين
                          <input type="checkbox" class="updatecheckbox" name="users_page"  id="group1">
                          <span class="checkmark"></span>
                        </label>

                        <label class="cont">عرض الجلسات
                          <input type="checkbox" class="updatecheckbox"  name="sessions_page">
                          <span class="checkmark"></span>
                        </label>

                        <label class="cont">عرض العملاء
                          <input type="checkbox" class="updatecheckbox"  name="customers_page">
                          <span class="checkmark"></span>
                        </label>

                        <label class="cont">عرض القضايا المنتهية
                          <input type="checkbox" class="updatecheckbox"  name="ended_procecutions">
                          <span class="checkmark"></span>
                        </label> 
                        <label class="cont">عرض السجلات المالية
                          <input type="checkbox" class="updatecheckbox"  name="financial_page">
                          <span class="checkmark"></span>
                        </label>
																								<label class="cont">عرض التذكيرات 
                          <input type="checkbox" class="updatecheckbox"  name="reminds_page">
                          <span class="checkmark"></span>
                        </label> 

                </div>
            </div>
        </section>
        <!--dialog end anouther details--->
        
        <!--section add new Lawyer-->
        <section class="overlay addLawyer text-center" id="addLawyer" >
            <div class="container">
                   <h2 class="title-section">اضافة محامي جديد</h2>
                <span class="close-btn">
                    <i onclick="document.getElementById('addLawyer').style.display='none'" class="fa fa-window-close" aria-hidden="true"></i>
                </span>
              



<style>
.avatar {
    vertical-align: middle;
    width: 50px;
    height: 50px;
    border-radius: 50%;
}
</style>

<script>
    function myFun()
{
	document.getElementById('myPhoto').src=URL.createObjectURL(event.target.files[0]);
}
</script>
<div class="info">
              <input type="file" name="image" id="photo" onchange="myFun();"/>

                <img src="" id="myPhoto"   alt="my photo" class='avatar'/>
</div>
                        <div class="info">
                            <label class="sub-title">الاسم</label>
                            <input class="info-value" id="usename" type="text" value="" name="name"/>
                        </div>
                         <div class="info">
                            <label class="sub-title"> رقم الجوال</label>
                            <input class="info-value" id="phone_number" type="text" value="" name="value"/>
                        </div>
                         <div class="info">
                            <label class="sub-title">الايميل</label>
                            <input class="info-value" id="email"type="email" value="" name="email"/>
                        </div>
                         <div class="info">
                            <label class="sub-title"> كلمة المرور</label>
                            <input class="info-value" id="password" type="password" value="" name="date-remember"/>
                        </div>
                             <div class="info">
                            <label class="sub-title"> تأكيد الكلمة</label>
                            <input class="info-value" type="password" value="" name="date-remember"/>
							 </div>
                <div class="info">
                    <button class="btn btn-primary show-edit-checks-dialog"  id="insert"> 
                                <i class="fas fa-edit" style="margin-left:5px"></i>حفظ التعديلات
                    </button>
               </div>
            </div>
        </section>
        <!--end section add new Lawyer-->
        
        
          <!--start footer section-->
             <?php include_once('../html/footerPage.html');?>
        <!--end footer section-->
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>



<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js"></script>
<script>
 
</script>
<script type="text/javascript" language="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js">
   
 </script>
<script type="text/javascript" language="javascript" src="../js/mydataTable.js"></script>
 <script type="text/javascript" language="javascript" src="../js/Lawyer.js">
   
 </script>




</html>


























