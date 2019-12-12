<?php 
session_start();
include_once("../php/classes/Client.php");
Client::insure_logged_in();
if($_SESSION["customers_page"]!= 1){
    header("Location: homePage.php");
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الزبائن</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?echo time()?>"/>
        <link rel="stylesheet" href="../css/customers.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="../css/footerPage.css"/>
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
                    <li class="active" <?php if($_SESSION["customers_page"]!=1){ echo 'style="display:none"';}?> ><a href="customers.php">الزبائن</a></li>
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
        <!--start section search-->

        <section class="sec-search">
            <div class="container text-center">
                <div class="row">
                    <form class="form-search"  autocomplete="on" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input id="txt_srch" type="text" placeholder="ادخل رقم الهوية او اسم العميل" name="name_or_id" autocomplete="on"/>
                        <button class="btn btn-primary">ابحث<i class="fas fa-search"></i></button>
                    </form>
                </div>
                <div class="row">
                    <form class="form-search"  autocomplete="on" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <input type="text" placeholder="ادخل رقم القضية" name="procecution_number" autocomplete="on"/>
                        <button class="btn btn-primary">ابحث<i class="fas fa-search"></i></button>
                    </form>
                </div>

                <div class="row">
                    <button class="btn btn-primary" id="btn-addNewCustomer">  اضافة عميل/قضية <i class="fas fa-plus"></i></button>
                </div>

                <div class="row">
                    <form   autocomplete="on" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <button class="btn btn-primary"> عرض جميع القضايا </button>
                        <input id="txt_srch" type="hidden" name="all_procecutions" value="1"/>
                    </form>
                </div>

            </div>
        </section>
        <!--end section search-->
            <!-- show  error message start-->
            <div  style="display:none; margin-left:5%;margin-right:5%;" id="error_dialog"  class="row">
           
            <div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_fail"  aria-label="Close">
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
      <button type="button" class="close close_success"  aria-label="Close">
      <span aria-hidden="true">&times;</span>
      </button>
      <div id="show_success_msg">
        <!-- the success error will be printed here-->
      </div> 

     
  </div>
</div>
<!-- show  success message end-->

        
        <!--start section table-->
        <section class="sec-table">
            <div class="container">
                <table class="table-section table-bordered table-condensed table-hover" id="my_table" style="margin-bottom:90px">
                    <thead class="thead-light">
                        <th>#الرقم</th>
                        <th>الاسم </th>
                        <th>رقم الهوية</th>
                        <th>رقم القضية</th>
                        <th>تمت </th>
                        <th>الأحداث</th>
                    </thead>
                    <tbody>
                       <!-- <tr>
                            <th scope="row">#1</th>
                            <td><input class="cust_name" type="text" value=" " name="name-customer" /></td>
                            <td><input class="cust_identity" type="text" value=" " name="IdIdentifiction"/></td>
                            <td><input class="proc_number" type="text" value=" " name="numberOfCase"/></td>
                            <td><button name="done" ><i class="fas fa-check-circle"></i></button></td>
                            <td class="actions">

                                <button type="button" class="btn btn-info view-button" id="view-button">
                                    <i class="fas fa-eye" style="margin-legt:5px"></i>تفاصيل
                                </button>
                                <button type="button"  class="btn btn-danger delete-button" id="delete-button" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                </button>
                            </td>
                        </tr>-->
                    <?php 
                        // ضروري مشان يكتب الاسم ورقم القضية في التكست بوكسز   في ديالوج اضافة جلسة 
                       $name="";
                        $procecution_id="";
                        $office_id=$_SESSION["office_id"];
                        if($_SERVER["REQUEST_METHOD"]=="POST")
                            {
                               
                                //اذا كانت طريقة البحث هي الاسم او رقم الهوية 
                                if (isset($_POST["name_or_id"])){
                                    $name_or_id=$_POST["name_or_id"];
                                        if(is_numeric($name_or_id)){ 
                                        // طريقة البحث هي رقم الهوية 
                                        $identity_number = $_POST["name_or_id"];
                                        // 0 باراميتر بحدد فيه اني بدي اعرض القضايا غير المنتهية 
                                        Client::show_customers_info_using_identity_no($identity_number,$office_id,0);
                                        } else{
                                        // طريقة البحث هي الاسم
                                        $name=$_POST["name_or_id"];
                                        Client::show_customers_info_using_name($name,$office_id,0);                        
                                    }


                                }
                                // اذا كانت طريقة البحث هي رقم القضية 
                                if(isset($_POST["procecution_number"])){
                                    $procecution_number=$_POST["procecution_number"];
                                    Client::show_customers_info_using_procecution_number($procecution_number,$office_id,0);
                                }
                                if(isset($_POST["all_procecutions"])){
                                   
                                    Client::show_all_procecutions($office_id,0);
                                }


                            
                            }
                            else{
                                Client::show_all_procecutions($office_id,0);
                            }
                            ?>
                      <!--    <tr>
                            <th scope="row">#1</th>
                            <td><input class="cust_name" type="text" value=" " name="name-customer" /></td>
                            <td><input class="cust_identity" type="text" value=" " name="IdIdentifiction"/></td>
                            <td><input class="proc_number" type="text" value=" " name="numberOfCase"/></td>
                            <td><button name="done" ><i class="fas fa-check-circle"></i></button></td>
                            <td class="actions">

                                <button type="button" class="btn btn-info view-button" id="view-button">
                                    <i class="fas fa-eye" style="margin-legt:5px"></i>تفاصيل
                                </button>
                                <button type="button"  class="btn btn-danger delete-button" id="delete-button" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                </button>
                            </td>
                        </tr>
                                          <tr>
                            <th scope="row">#1</th>
                            <td><input type="text" value="احمد السيد" name="name-customer" /></td>
                            <td><input type="text" value="29785631" name="IdIdentifiction"/></td>
                            <td><input type="text" value="1" name="numberOfCase"/></td>
                            <td><button name="done" ><i class="fas fa-check-circle"></i></button></td>
                            <td class="actions">
                                <button type="button" class="btn btn-info view-button" >
                                    <i class="fas fa-eye" style="margin-left:5px"></i>تفاصيل
                                </button>
                                <button type="button"  class="btn btn-danger delete-button" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                </button>
                            </td>
                        </tr>
                   
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2">يظهر 3 من 10</td>
                            <td colspan="4" class="nextPrevoiusButton">
                            <button type="button" value="arrowLeft" id="arrowRight" class="btn btn-light" disabled><i class="fas fa-angle-double-right"></i></button>
                            <button type="button" value="1" class="btn btn-light" >1</button>
                            <button type="button" value="1" class="btn btn-light">2</button>
                            <button type="button" value="1" class="btn btn-light">3</button>
                            <button type="button" value="arrowLeft" id="arrowLeft" class="btn btn-light"><i class="fas fa-angle-double-left"></i></button>
                            </td>
                        </tr>
                    </tfoot>-->
                </table>
            </div>
        </section>
        <!--end section table-->
        
        <!--start dialog add customers (insert) -->
        <section class="overlay sec-addcustomer" id="addsec">
                <div class="container">
                    <span class="close-btn"><i onclick="document.getElementById('addsec').style.display='none'" class="fa fa-window-close" aria-hidden="true"></i></span>

                    
                    <div class="row">
                            <ul class="progressbar" id="progressbar">
                                <li class="active">الخطوة الأولى</li>
                                <li>الخطوة الثانية</li>
                                <li>الخطوة الثالثة</li>
                                <li>الخطوة الرابعة</li>
                            </ul>
                    </div>
                    
                    <div class="row">
                        <div class="form-devision">
                            <form name = "forml"  method="post">
                                
                                <fieldset>
                                    <h2 class="super-title">بيانات الزبون </h2>
                                    <h3 class="sub-title">من فضلك يجب ادخال كل البيانات الضرورية</h3>
                                    <input type="text" id="customer_identiy_number" value="" placeholder="رقم الهوية" required/>
                                  
                                    <input type="text" id="first-name-customer" value="" placeholder="الاسم الاول " required/>
                                    <input type="text" id="father-name-customer" value="" placeholder="اسم الأب " required/>
                                    <input type="text" id="grandfather-name-customer" value="" placeholder="اسم الجد " required/>
                                    <input type="text" id="family-name-customer" value="" placeholder="اسم العائلة" required/>

                                    <input type="text" id="contact-number-customer" value="" placeholder="رقم الجوال"/>
                                    <input type="text"  id="address-customer" value="" placeholder="العنوان"/>
                                    <textarea id="note-about-customer" value="" placeholder="ملاحظات "></textarea>
                                    <button type="button" id="client_btn" class="btn btn-success next" >التالي </button>
                                </fieldset>
                                
                                <fieldset>
                                    <h2 class="super-title">تفاصيل الخصم </h2>
                                    <h3 class="sub-title">قم بادخال المعلومات الشخضية للخصم</h3>
                                    <input type="text" id="name-discount" value="" placeholder="اسم الخصم"/>
                                    <input type="text" id="number-discount" value="" placeholder="رقم الخصم"/>
                                    <input type="text" id="address-discount" value=""placeholder="عنوان الخصم"/>
                                    <textarea type="text" id="note-discount" value="" placeholder="ملاحظات "></textarea>
                                    <button type="button" class="btn btn-success previous">السابق</button>
                                    <button type="button" id="discount_btn" class="btn btn-success next" >التالي </button>
                                </fieldset>
                                
                                <fieldset>
                                    <h2 class="super-title">بيانات وكيل الخصم </h2>
                                    <h3 class="sub-title">قم بادخال بيانات وكيل الخصم</h3>
                                    <input type="text" id="agent-name" placeholder="اسم وكيل الخصم"/>
                                    <input type="text" id="number-agent" placeholder="رقم وكيل  الخصم"/>
                                    <input type="text" id="address-agent" placeholder="عنوان وكيل  الخصم"/>
                                    <textarea id="note-agent" placeholder="ملاحظات"></textarea>
                                    <button type="button" class="btn btn-success previous">السابق</button>
                                    <button type="button" id="discount_agent_btn" class="btn btn-success next" >التالي </button>
                                </fieldset>
                                
                                <fieldset>
                                    <h2 class="super-title">بيانات المحكمة </h2>
                                    <h3 class="sub-title">قم بادخال  بيانات المحكمة</h3>
                                    <input type="text" id="address-court" placeholder="عنوان المحكمة"/>
                                    <input type="text" id="number-session" placeholder="رقم القضية "/>
                                    <input type="text" id="name-court" placeholder="اسم المحكمة"/>
                                    <input type="text" id="theme-court" placeholder="موضوع الدعوى"/>
                                    <input type="text" id="value-court" placeholder="قيمة الدعوى"/>
                                    <input type="date" id="date-court" placeholder="تاريخ الدعوى"/>
                                    <button type="button" class="btn btn-success previous">السابق</button>
                                    <button type="submit" id="court_btn" class="btn btn-success submit">حفظ</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
        </section>
        <!--end dialog add customers-->
        
        <!--show details Dialog-->
        <section class="sec-show-details" >
            <div class="overlay" id="show-details">
                <div class="container">
                    <h1 class="super-title">تفاصيل القضية</h1>
                    <div class="close-icons">
                        <span>
                            <i onclick="document.getElementById('show-details').style.display='none'" class="fas fa-times"></i>
                        </span>
                    </div>
                    <div class="row">
                        <h2 class="title-section">بيانات الزبون</h2><hr>
                        <div class="info">
                            <label class="sub-title">رقم الهوية </label>
                            <input id="identity_number" class="info-value" type="text" value="" name="Id-customer"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">اسم الزبون</label>
                            <input id="customer_name" class="info-value" type="text" value="" name="name-customer"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">رقم الجوال </label>
                            <input id="phone_number" class="info-value" type="text" value="" name="number-customer"/>
                        </div>

                        <div class="info">
                            <label class="sub-title">العنوان </label>
                            <input id="address" class="info-value" type="text" value="" name="address-customer"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">ملاحظات  </label>
                            <textarea id="notes" name="note-customer" placeholder="" class="info-value"></textarea>
                        </div>
                        <div>
                            <button id="save_customer_btn" class="btn btn-success" style="margin-top:15px ;padding:15px;width:200px"> حفظ بيانات الزبون </button>
                        </div>
        <!-- show  error message start-->
            <div  style="display:none; margin-left:5%;margin-right:5%;" id="error_dialog_customer"  class="d_error_dialog row"><div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_fail"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div id="msg_error_dialog_customer"> <!-- the delete error wil be printed here--> </div></div></div>
         <!-- show  error message end-->

         <!-- show  success message start-->
         <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="success_dialog_custmer"  class="d_success_dialog row"><div class="alert alert-success alert-dismissible " role="alert">
         <button type="button" class="close close_dialog_success"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div id="msg_success_dialog_custmer"><!-- the success error will be printed here--></div> </div> </div>
         <!-- show  success message end-->

                    </div>
                    <div class="row">
                        <h2 class="title-section">تفاصيل الخصم </h2><hr>
                        <div class="info">
                            <label class="sub-title">اسم الخصم</label>
                            <input id="discount_name"class="info-value" type="text" value="" name="name-dis"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">رقم الخصم </label>
                            <input id="discount_number"class="info-value" type="text" value="" name="number-dis"/>
                        </div>
                        <div class="info">
                            <label class="sub-title"> عنوان الخصم </label>
                            <input id="discount_address"class="info-value" type="text" value="" name="address-dis"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">ملاحظات  </label>
                            <textarea id="discount_notes"name="note-dis" placeholder="" class="info-value"></textarea>
                        </div>
                        <div>
                            <button id="save_discount_btn" class="btn btn-success" style="margin-top:15px ;padding:15px;width:200px">حفظ بيانات الخصم  </button>
                        </div>
        <!-- show  error message start-->
            <div  style="display:none; margin-left:5%;margin-right:5%;" id="error_dialog_discount"  class="d_error_dialog row"><div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_fail"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div id="msg_error_dialog_discount"> <!-- the delete error wil be printed here--> </div></div></div>
         <!-- show  error message end-->

         <!-- show  success message start-->
         <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="success_dialog_discount"  class="d_success_dialog row"><div class="alert alert-success alert-dismissible " role="alert">
         <button type="button" class="close close_dialog_success"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div id="msg_success_dialog_discount"><!-- the success error will be printed here--></div> </div> </div>
         <!-- show  success message end-->

                    </div>
                    <div class="row">
                    
                        <h2 class="title-section"> بيانات وكيل الخصم </h2><hr>
                        <div class="info">
                            <label class="sub-title">اسم وكيل الخصم</label>
                            <input id="agent_name" class="info-value" type="text" value="" name="name-agent"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">رقم  وكيل الخصم </label>
                            <input id="agent_number" class="info-value" type="text" value="" name="number-agnet"/>
                        </div>
                        <div class="info">
                            <label class="sub-title"> عنوان  وكيل الخصم </label>
                            <input id="agent_address" class="info-value" type="text" value="" name="address-agent"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">ملاحظات  </label>
                            <textarea id="agent_notes" name="note-agent" placeholder="" class="info-value"></textarea>
                        </div>
                        <div>
                            <button id="save_agent_btn" class="btn btn-success" style="margin-top:15px ;padding:15px;width:200px">حفظ بيانات وكيل الخصم</button>
                        </div>
         <!-- show  error message start-->
            <div  style="display:none; margin-left:5%;margin-right:5%;" id="error_dialog_agent"  class="d_error_dialog row"><div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_fail" aria-label="Close close_fail"><span aria-hidden="true">&times;</span></button>
            <div id="msg_error_dialog_agent"> <!-- the delete error wil be printed here--> </div></div></div>
         <!-- show  error message end-->

         <!-- show  success message start-->
         <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="success_dialog_agent"  class="d_success_dialog row"><div class="alert alert-success alert-dismissible " role="alert">
         <button type="button" class="close close_dialog_success" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div id="msg_success_dialog_agent"><!-- the success error will be printed here--></div> </div> </div>
         <!-- show  success message end-->
                    </div>
                    <div class="row">
               
                        <h2 class="title-section">بيانات المحكمة </h2><hr>
                       <div class="info">
                            <label class="sub-title">اسم المحكمة</label>
                            <input  id="court_name" class="info-value" type="text" value="" name="name-court"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">عنوان المحكمة</label>
                            <input id="court_address" class="info-value" type="text" value="" name="address-court"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">رقم القضية في المحكمة</label>
                            <input id="procecution_number" class="info-value" type="text" value="" name="value-court"/>
                        </div>
               
                        <div class="info">
                            <label class="sub-title"> موضوع الدعوى</label>
                            <input id="subject" class="info-value" type="text" value="" name="theme-issue"/>
                        </div>
                        <div class="info">
                            <label class="sub-title">قيمة الدعوى</label>
                            <input id="procecution_value" class="info-value" type="text" value="" name="value-issue"/>
                        </div>
                            <div class="info">
                            <label class="sub-title">تاريخ الورود</label>
                            <input id="date" class="info-value" type="date" value="" name="date-agent"/>
                        </div>
                          <div>
                            <button id="save_procecution_btn" class="btn btn-success" style="margin-top:15px ;padding:15px;width:200px">حفظ بيانات القضية </button>
                        </div>
                        <div>
                            <button id="close_view_btn" class="btn btn-success" style="margin-top:15px ;padding:15px;width:200px">اغلاق</button>
                        </div>
        <!-- show  error message start-->
             <div  style="display:none; margin-left:5%;margin-right:5%;" id="error_dialog_procecution"  class="d_error_dialog row"><div class="alert alert-danger alert-dismissible show " role="alert">
            <button type="button" class="close close_fail"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div id="msg_error_dialog_procecution"> <!-- the delete error wil be printed here--> </div></div></div>
         <!-- show  error message end-->

         <!-- show  success message start-->
         <div  style="display:none;  margin-left:5%;margin-right:5%;"   id="success_dialog_procecution"  class=" d_success_dialog row"><div class="alert alert-success alert-dismissible " role="alert">
         <button type="button" class="close close_dialog_success"  aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <div id="msg_success_dialog_procecution"><!-- the success error will be printed here--></div> </div> </div>
         <!-- show  success message end-->
                    </div>
                </div>
            </div>
        </section>
        <!--end show details Dialog-->
          
        <!-- <div class="overlay confirm-delete" id="confirm-delete">
            <div class="container">
                     <div class="close-icons"><span><i onclick="document.getElementById('confirm-delete').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">
                    <p class="text-center">هل تريد فعلا حذف هذه الجلسة</p>
                </div>
                <div class="row btn-confirm-delete">
                    <button class="btn btn-success" id="confirm-yes-delete">نعم</button>
                    <button class="btn btn-danger"  onclick="document.getElementById('confirm-delete').style.display='none'">لا</button>
                </div>
            </div>
        </div>-->
        
        <!-- Button trigger modal -->
                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">رسالة تأكيد الحذف</h5>
                      </div>
                      <div class="modal-body">
                        هل تريد فعلا حذف هذه الجلسة؟
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">لا أريد</button>
                        <button type="button" class="btn btn-primary" id="confirm-yes-delete">أحفظ التغيرات</button>
                      </div>
                    </div>
                  </div>
                </div>
        
        
        
        
          <div class="overlay confirm-edit" id="confirm-edit">
            <div class="container">
                     <div class="close-icons"><span><i onclick="document.getElementById('confirm-edit').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">
                    <p class="text-center">هل تريد حفظ التعديلات</p>
                </div>
                <div class="row btn-confirm-delete">
                    <button class="btn btn-success" id="confirm-yes-edit">نعم </button>
                    <button class="btn btn-danger" id="confirm-no" onclick="document.getElementById('confirm-edit').style.display='none'">لا</button>
                </div>
            </div>
        </div>
        
        <!-- import the footer file-->
        <?php include_once("footerPage.html"); ?>
        
    </body>
    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src='http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js'></script>
    <script src="../js/bootstrap.min.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
    <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
    <script src="../js/customer.js"></script>
</html>