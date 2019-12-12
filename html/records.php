<?php 
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//$_SESSION["offfice_id"]=0;
//$_SESSION["username"]="ahmad";

include_once("../php/DBConnect.php");
include_once("../php/functions.php");
include_once("../php/classes/Session.php");
include_once("../php/classes/Client.php");

Client::insure_logged_in();
if($_SESSION["sessions_page"]!= 1){
    header("Location: homePage.php");
    
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الجلسات  </title>
        <!-- the css file  for auto complete -->
        <!--<link rel="stylesheet" href="../js/EasyAutocomplete/easy-autocomplete.min.css">-->

        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
      
        <link rel="stylesheet" href="../css/as-admin-css.css"/>
        <link rel="stylesheet" href="../css/records.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time()?>"/>
        <link rel="stylesheet" href="../css/footerPage.css"/>
          <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
       <!-- <link rel="stylesheet" href="../js/EasyAutocomplete/easy-autocomplete.min.css">-->
                        
                      
    </head>

    <body dir="rtl" style="position: relative; border: 3px solid #73AD21;" >


<!-- jquery from cdn --> 
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<!-- the java script file  for auto complete -->
<script src="../js/EasyAutocomplete/jquery.easy-autocomplete.min.js"></script>


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
                    <li  class="active" <?php if($_SESSION["sessions_page"]!=1){ echo 'style="display:none"';}?>><a href="records.php">الجلسات</a></li> 
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

        <!--Start search box-->
        <div class="container text-center">
                   
                <form class="form-search" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                <div class="row" >
                         <input id="name_or_id_search" type="text"  name="name_or_id" size="40" max-length="40" placeholder="ادخل الاسم او رقم الهوية " class="text-search" />
                         <input type="submit" value="بحث" class="btn-search" style="width:83px"/>
                       
                        </div>
                </form>
       
        <div class="row">
                <form class="form-search" autocomplete="on" METHOD ="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
                    <input id="procecution_number_search" name="procecution_number" type="text" size="20" max-length="20" placeholder="ادخل رقم القضية" class="text-search"/>
                    <input type="submit" value="ابحث" class="btn-search" style="width:83px"/>
                </form>
        </div>
        <div class="row">
            <div class="row">
                <button  class="btn btn-primary" id="addNew">اضافة جلسة جديدة<i class="fas fa-plus"></i></button>
            </div>
        </div>
       <!--end search box-->

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


        <section class="table-section container">
            <table id="my_table" class="table-section table-bordered table-condensed table-hover">
                <thead class="thead-light">
                     <th>الاسم </th>
                     <th>رقم القضية</th>
                     <th >رقم الجلسة</th>
                     <th>تاريخ الجلسة</th>
                     <th>تاريخ التذكير</th>
                     <th>الأحداث</th>
                </thead>
                <tbody>
                        <?php 
                        // ضروري مشان يكتب الاسم ورقم القضية في التكست بوكسز   في ديالوج اضافة جلسة 
                        $name="";
                        $procecution_id="";
                      
                        if($_SERVER["REQUEST_METHOD"]=="POST")
                            {
                                //اذا كانت طريقة البحث هي الاسم او رقم الهوية 
                                if (isset($_POST["name_or_id"])){
                                    $name_or_id=$_POST["name_or_id"];
                                        if(is_numeric($name_or_id)){ 
                                        //اذا كانت هي رقم الهوية 
                                        $identity_number =$_POST["name_or_id"];
                                         $sess=new Session();
                                         // الباراميترالاخير بحدد حالة القضية منتهية او لا .. 0 بحدد اني ببحث عن قضية غير منتهية 
                                        $procecution_ids=Client::get_procecution_idS_using_identity_no($identity_number,$_SESSION["office_id"],0);
                                        if(!empty($procecution_ids) ){
                                        $str_procecution_ids=client:: format_proc_ids($procecution_ids);// تحويل ارقام القضايا من اري الى سترنج واحد فيه ارقام الجلسات مفصولة ب فواصل
                                        $name=Client::get_customer_name_using_identity_no($identity_number);
                                        $sess->show_sessions_info($str_procecution_ids,$name);
                                        }else { Client::show_fail_message( " يرجى التأكد من ان  رقم هوية صحيح وان صاحب رقم الهوية يملك قضايا وان القضية المرتبطة بهذا الموكل غير منتهية  ") ;}
                                        
                                        } else{
                                        // اذا كانت طريقة البحث هي الاسم
                                        $name=$_POST["name_or_id"];
                                        $sess=new Session();
                                        // الباراميترالاخير بحدد حالة القضية منتهية او لا .. 0 بحدد اني ببحث عن قضية غير منتهية 
                                       $procecution_ids=Client::get_procecution_ids_using_name($name,$_SESSION["office_id"],0);
                                       if(!empty($procecution_ids) ){
                                       $str_procecution_ids=client:: format_proc_ids($procecution_ids);// تحويل ارقام القضايا من اري الى سترنج واحد فيه ارقام الجلسات مفصولة ب فواصل
                                       $sess->show_sessions_info($str_procecution_ids,$name);    
                                       } else { Client::show_fail_message("  يرجى التأكد من ان  الاسم الذي ادخلته صحيح وان الموكل يملك قضايا وان القضية المرتبطة بهذا الموكل غير منتهية ");}                            
                                    }


                                }
                                // اذا كانت طريقة البحث هي رقم القضية 
                                if(isset($_POST["procecution_number"])){
                                    $procecution_number=$_POST["procecution_number"];
                                    $sess=new Session();
                                    // الباراميترالاخير بحدد حالة القضية منتهية او لا .. 0 بحدد اني ببحث عن قضية غير منتهية 
                                     $procecution_id=Client::get_procecution_id_using_procecution_no($procecution_number,$_SESSION["office_id"],0);
                                
                                  
                                    if($procecution_id !="ex" && trim($procecution_id )!="" ){
                                       
                                        $name=Client::get_customer_name_using_procecution_id($procecution_id);
                                        $sess->show_sessions_info($procecution_id,$name);
                                    }
                                    else {Client::show_fail_message( "  يرجى التأكد من رقم القضية ");}
                                }
                            
                            }
                            ?>
                   <!-- <tr>
                        <td><input type="text" value="خالد احمد موسى"/></td>
                        <td><input type="text" value="1" class="specialWidth"/></td>
                        <td><input type="text" value="2" class="specialWidth"/></td>
                        <td><input type="date" value="05/12/2018"/></td>
                        <td><input type="date" value="05/12/2018"/></td>
                        <td class="actions">
                            <button type="button" class="btn btn-info view-button"   data-toggle="modal" data-target="#exampleModalCenter">
                                            <i class="fas fa-eye" style="margin-left:5px"></i>حذف
                            </button>
                             <button type="button" class="btn btn-info view-button"   data-toggle="modal" data-target="#exampleModalCenter">
                                            <i class="fas fa-eye" style="margin-left:5px"></i>حذف
                             </button>
                              <button type="button" class="btn btn-info view-button"   data-toggle="modal" data-target="#exampleModalCenter">
                                            <i class="fas fa-eye" style="margin-left:5px"></i>حذف
                            </button>
                        </td>
                    </tr>-->
                </tbody>
            </table>
        </section>
        
       
        <div class="overlay confirm-delete" id="confirm-delete">
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
        
        <!-- ديالوج اضافة جلسة جديدة  -->
        <div class="overlay" class="sec-info" id="add_session_dialog">
            <div class="container">
                <div class="close-icons"><span><i onclick="document.getElementById('add_session_dialog').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">


                <div class="row">
                        <form class="form-search" >
                            <input style="margin-right:100%" id="dialog_search_procecution_number" name="procecution_number" type="text"  size="20" max-length="20" placeholder="ادخل رقم القضية" class="text-search"/>
                         </form>
                </div>

                     <div class="info">
                        <label  class="sub-title">رقم الجلسة</label>
                        <input  id="session_number"class="info-value" type="text" value="" name="session-number"/>
                    </div>
                     <div class="info">
                        <label class="sub-title">تاريخ الجلسة</label>
                        <input id="session_date"class="info-value" type="date" value="" name="date-session"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">تاريخ التذكير</label>
                        <input id="remind_date" class="info-value" type="date" value="" name="date-remember"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">الاجراءات المقررة في الجلسة</label>
                        <textarea id="actions" class="info-value" name="note"></textarea>
                    </div>

                    <!-- start  show error in in add session dialog -->
                    <div style="display:none"   id="add_session_error_dialog"  class=" error_dialog row">
                        <div class="alert alert-danger alert-dismissible show " role="alert">
                             <button type="button" class="close close_fail"  aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <div id="add_session_show_Error">
                                <!-- message -->
                            </div>      
                   
                        </div>
                    </div>
                     <!-- end  show error in in add session dialog -->
                    <div class="btn-info-section">
                        <button class="btn btn-ligth" id="save">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- ديالوج تعديل جلسة -->
        <div class="overlay" class="sec-info" id="update_session_dialog">
            <div class="container">
                <div class="close-icons"><span><i onclick="document.getElementById('update_session_dialog').style.display='none'" class="fas fa-times"></i></span></div>
                <div class="row">

                   <div class="info">
                        <label class="sub-title">اسم الزبون</label>
                        <input id="customer_name_update"  class="info-value" type="text" value=" 
                        <?php if(isset($name)){ echo trim($name);}?>
                        " name="name-customer"/>
                    </div>
                     <div class="info">
                        <label class="sub-title">رقم القضية</label>
                        <input id="procecution_number_update" class="info-value" type="text" value="
                        <?php if(isset($procecution_number)){ echo trim($procecution_number);}?>
                        " name="case-number"/>
                    </div> 

                     <div class="info">
                        <label class="sub-title">رقم الجلسة</label>
                        <input id="session_number_update"class="info-value" type="text" value="" name="session-number"/>
                    </div>
                     <div class="info">
                        <label class="sub-title">تاريخ الجلسة</label>
                        <input id="session_date_update"class="info-value" type="date" value="" name="date-session"/>
                    </div>
                    <div class="info">
                        <label class="sub-title">تاريخ التذكير</label>
                        <input id="remind_date_update" class="info-value" type="date" value="" name="date-remember"/>
                    </div>

                    <div class="info">
                        <label class="sub-title">الاجراءات المقررة على الجلسة</label>
                        <textarea id="actions_update" class="info-value" name="note"></textarea>
                    </div>
                    
                    <div class="btn-info-section">
                        <button  type="submit" class="btn btn-ligth" id="save_update_dialog">حفظ</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- import the footer file-->
       <?php include_once("footerPage.html"); ?>

        
        <script>
           var options = {
		url: "../php/autocomplete/autocomplete_name_identity.php",
		getValue: "name",
		list: {
			match: {
				enabled: true
			}
		},
		theme: "plate-dark"
	};
    $("#name_or_id_search11111111111111").easyAutocomplete(options);

    var options1 = {
		url: "../php/autocomplete/autocomplete_procecution_number.php",
		getValue: "procecution_number",
		list: {
			match: {
				enabled: true
			}
		},
		theme: "plate-dark"
	};
    $("#dialog_search_procecution_number").easyAutocomplete(options1);
        /*
    var options = {
			url: "../php/autocomplete/autocomplete_name_identity.php",
		    getValue: "name",
		    list: {
		        match: {
		            enabled: true
		        }
		    },
		    theme: "plate-dark"
		};
		$("#countries").easyAutocomplete(options);
    
    */
    </script>


        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
       <script src="../js/records.js"></script>
    </body>
</html>