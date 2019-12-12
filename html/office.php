<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>المكاتب</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css"/>
        <link rel="stylesheet" href="../css/headerStyle.css"/>
        <link rel="stylesheet" href="../css/tablesectionStyle.css"/>
        <link rel="stylesheet" href="../css/office.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/show-detials-section.css"/>
        <link rel="stylesheet" href="../css/footerPage.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    </head>
    <body dir="rtl">
     
      <!--start header-->
      <!--    <header>
            <nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container-fluid">
                 
                <div class="navbar-header">
                     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                     </button>
                      <a class="navbar-brand" href="homePage.php"><i class="fas fa-gavel"></i> نظام المحامين</a>                                        <img src="../image/2.jpeg" class="image-header" width="40px" height="40px" id="image-laywer">
                </div>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav">
                          <li><a href="records.html">الجلسات</a></li>
                          <li><a href="caseEnded.html">القضايا المنتهية </a></li>
                          <li><a href="customers.html">الزبائن</a></li>
                          <li><a href="financial%20Records.html">الأمور المالية</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">مرحبا بعودتك!
                                <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                      <li><a href="#"><i class="material-icons">settings</i>الاعدادت</a></li>
                                      <li><a href="#"><i class="material-icons">&#xE314;</i>خروج</a></li>
                                    </ul>
                            </li>
                        </ul>
                    </div>
                  </div>
            </nav>
        </header>  -->
        <!--end header-->
        
        <!---->
        <div class="container search-add">
            <div class="content text-center">
                
                <div class="row">
                    <div class="col-md-4"></div> 
                    <div class="col-md-4">
                        <input type="text" placeholder="بحث.." id="search"/><span  id="spansearch">ابحث</span>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">اضافة مكتب</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>

                 <div class="row">
                    <div class="col-md-4"></div>
                    <div class="col-md-4">
                        <button type="button" class="btn btn-primary">اظهار كل المكاتب</button>
                    </div>
                    <div class="col-md-4"></div>
                </div>
            </div>
        </div>
        <!---->
        
                
        <!--table show finanical records details-->
        <section class="table-section">
            <div class="container">
                <div class="row">
                    <table class="table-section table-bordered table-condensed table-hover">
                        <thead class="thead-light">
                            <th>اسم المكتب</th>
                            <th>بداية الاشتراك</th>
                            <th>نهاية الاشتراك</th>
                            <th>تم الدفع </th>
                            <th>أحداث</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" value="المكتب الأول"/>
                                </td>
                                <td>
                                    <input type="date" value="2018-05-02"/>
                                </td>
                                <td>
                                    <input type="date" value="2019-05-02"/>
                                </td>
                                <td>
                                    <input type="checkbox" name="" value="" checked>
                                </td>
                                <td class="actions">
                                    <button type="button" class="btn btn-info view-button">
                                        <i class="fas fa-eye" style="margin-left:5px"></i>تفاصيل
                                    </button>
                                     <button type="button" class="btn btn-danger delete button"   data-toggle="modal" data-target="#exampleModalCenter">
                                        <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                    </button>
                                   <button type="button" class="btn btn-primary edit-button">
                                        <i class="fas fa-edit" style="margin-left:5px"></i>تعديل 
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <!--end table--->
        
        
        
         <!-- Modal Delete-->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLongTitle">تأكيد الحذف</h5>

              </div>
              <div class="modal-body text-center">
                  <p>هل تريد حذف هذا المكتب؟</p>
              </div>
              <div class="modal-footer text-center">
                <button type="button" class="btn btn-primary" data-dismiss="modal">اغلاق</button>
                <button type="button" class="btn btn-danger" >حذف</button>
              </div>
            </div>
          </div>
        </div>
        <!---->
        
        
        
   

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <h5 class="modal-title" id="exampleModalLabel">اضافة مكتب</h5>
          </div>
            
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="office-name" class="col-form-label">اسم المكتب</label>
                <input type="text" class="form-control" id="office-name">
              </div>
                
               <div class="form-group">
                <label for="date-start" class="col-form-label">بداية الاشتراك</label>
                <input type="date" class="form-control" id="date-start">
              </div>
                    
               <div class="form-group">
                <label for="date-end" class="col-form-label">نهاية الاشتراك</label>
                <input type="date" class="form-control" id="date-end">
              </div>

              <div class="form-group">
                <label for="office-name1" class="col-form-label">اسم المستخدم الرئيسي</label>
                <input type="text" class="form-control" id="office-name1">
              </div>
              <div class="form-group">
                <label for="office-name2" class="col-form-label">البريد الالكتروني</label>
                <input type="text" class="form-control" id="office-name2">
              </div>
              <div class="form-group">
                <label for="office-name3" class="col-form-label">كلمة المرور</label>
                <input type="text" class="form-control" id="office-name3">
              </div>
              <div class="form-group">
                <label for="office-name4" class="col-form-label">تأكيد كلمة المرور </label>
                <input type="text" class="form-control" id="office-name4">
              </div>
              <div class="form-group">
                <label for="office-name5" class="col-form-label">رقم الهاتف </label>
                <input type="text" class="form-control" id="office-name5">
              </div>
                
              <div class="form-group">
                <label for="message-text" class="col-form-label">تم الدفع</label>
                <input type="checkbox" name="" value="" checked>
              </div>

            </form>  
          </div>
            
          <div class="modal-footer text-center">
            <button type="button" class="btn btn-primary">اضافة مكتب</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
          </div>
        </div>
      </div>
    </div>
        
        
          <!--show anouther details dialog-->
        <section class=" overlay text-center" id="show-details">
            <div class="container">
                <span class="close-btn">
                    <i onclick="document.getElementById('show-details').style.display='none'" class="fa fa-window-close" aria-hidden="true"></i>
                </span>
                <h2 class="super-title">تفاصيل المكتب  </h2>
                <div class="row opttion-one-checks">
                    <h2 class="title-section">المكاتب  </h2>
                    <form autocomplete="off">
                        <div class="info">
                            <label class="sub-title">اسم المستخدم الرئيسي</label>
                            <input class="info-value" type="text" value="" name="name" autocomplete="off"/>
                        </div>
                         <div class="info">
                            <label class="sub-title">البريد الالكتروني</label>
                            <input class="info-value" type="email" value="" name="value"/>
                        </div>
                         <div class="info">
                            <label class="sub-title">تعيين كلمة المورور</label>
                            <input class="info-value" type="password" value="" name="date-checks"/>
                        </div>
                         <div class="info">
                            <label class="sub-title"> رقم الجوال</label>
                            <input class="info-value" type="text" value="" name="date-remember"/>
                        </div>
                        <div class="btn-edit-delete">
                            <button class="btn btn-danger"> 
                                <i class="fas fa-trash-alt" style="margin-left:5px"></i>الغاء 
                            </button>
                            <button class="btn btn-primary show-edit-checks-dialog" > 
                                <i class="fas fa-edit" style="margin-left:5px"></i>حفظ التعديلات
                            </button>
                        </div>
                    
                    </form>
                </div>
            </div>
        </section>
        
        
        <!--start footer section-->
      <?php include_once('footerPage.html');?>
        <!--end footer section-->
        
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
        <script src="../js/Lawyer.js"></script>  
        <script>  
            $('.view-button').click(function(){
        var doc=document.getElementById('show-details');
        $(doc).css('display','block');
    });</script>
    </body>
</html>