<?php
include_once("../php/classes/Client.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>التذكير</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/headerStyle.css"/>
        <link rel="stylesheet" href="../css/tablesectionStyle.css"/>
        <link rel="stylesheet" href="../css/Lowyer.css?<?php echo time();?>"/>
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
                     <li  <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?> ><a href="caseEnded.php">القضايا المنتهية </a></li>
                     <li   <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>><a href="../php/Lowyer.php">المستخدمين</a></li>
                     <li  class="active" <?php if($_SESSION["reminds_page"]!=1){ echo 'style="display:none"';}?>><a href="reminds.php">التذكير</a></li>
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
          
        
        <!--table show finanical records details-->
        <section id="reminds_table" class="table-section" style="margin-top:150px">
            <div class="container">
                <div class="row">
                    <table class="table-section table-bordered table-condensed table-hover" style="margin-bottom:90px">
                        <thead class="thead-light">
                            <th>موضوع التذكير</th>
                            <th>اسم الموكل </th>
                            <th>رقم القضية</th>
                            <th> التاريخ </th>
                            <th>تفاصيل</th>
                        </thead>
                        <tbody>
                    

                         <!--   <tr>
                                <td >شيك</td>
                                <td>احمد</td>
                                <td>33</td>
                                <td>30-7-2018</td>
                                <td class="actions">
                                    <button type="button" class="show btn btn-info view-button"   data-toggle="modal" data-target="#exampleModalCenter">
                                        <i class="fas fa-eye" style="margin-left:5px"></i>تفاصيل
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <td colspan="2">يظهر 3 من 10</td>
                            <td colspan="4" class="nextPrevoiusButton">
                                <button type="button" value="arrowLeft" id="arrowRight" class="btn btn-light" disabled>
                                    <i class="fas fa-angle-double-right"></i>
                                </button>
                                <button type="button" value="1" class="btn btn-light" >1</button>
                                <button type="button" value="1" class="btn btn-light">2</button>
                                <button type="button" value="1" class="btn btn-light">3</button>
                                <button type="button" value="arrowLeft" id="arrowLeft" class="btn btn-light">
                                    <i class="fas fa-angle-double-left"></i>
                                </button>
                            </td>
                        </tfoot>-->
                    </table>
                </div>
            </div>
        </section>
        <!--end table-->

          <!-- show  success message start-->
          <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="success_dialog"  class="row">
            <div class="alert alert-success alert-dismissible " role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
                <div id="show_success_msg">
                  <!-- the success error will be printed here-->
                </div> 

               
            </div>
        </div>
         <!-- show  success message end-->
        
        
        
        


        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">تفاصيل التذكير</h5>

              </div>
              <div class="modal-body text-center">
                <label id="details">اسم صاحب الشيك</label><br>

                 <!-- <label>قصي</label><br>
                <label>قيمة الدفعة</label><br>
                  <label>2250</label>-->
              </div>
              <div class="modal-footer text-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
              </div>
            </div>
          </div>
        </div>
        
        
        
         
        <!-- import the footer file-->
        <?php include_once("footerPage.html"); ?>
        
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/reminds.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
        <script src="../js/Lawyer.js"></script>
    </body>
</html>