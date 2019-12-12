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
	$_SESSION['show_financial_page']=1;
	$_SESSION['show_user_page']=0;
	 
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>الأمور المالية</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/headerStyle.css"/>
        <link rel="stylesheet" href="../css/searchsectionStyle.css"/>
        <link rel="stylesheet" href="../css/tablesectionStyle.css"/>
        <link rel="stylesheet" href="../css/show-detials-section.css"/>
        <link rel="stylesheet" href="../css/financialRecords.css?<?php echo time();?>"/>
        <link rel="stylesheet" href="../css/footerPage.css"/>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
        <link href="../css/easy-autocomplete.min.css" rel="stylesheet" type="text/css">
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
                             <li class="active" <?php if($_SESSION["financial_page"]!=1){ echo 'style="display:none"';}?> ><a href="../php/financial.php">الأمور المالية</a></li>
                               <li  <?php if($_SESSION["ended_procecutions"]!=1){ echo 'style="display:none"';}?> ><a href="../html/caseEnded.php">القضايا المنتهية </a></li>
                               <li   <?php if($_SESSION["users_page"]!=1){ echo 'style="display:none"';}?>><a href="../php/Lowyer.php">المستخدمين</a></li>
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
                <div class="row">
                     <form class="form-search">
                        <input type="text" id="val" placeholder="ادخل رقم الهوية او اسم العميل او ادخل رقم القضية" name="search-name-Id" autocomplete="on" style="width:auto"/>
                        <button class="btn btn-primary">ابحث<i class="fas fa-search"></i></button>
                    </form>
                </div>
                

                <div class="row">
                    <button class="btn btn-primary" id="btn-addNewFinancial">اضافة سجل مالي جديد<i class="fas fa-plus"></i></button>
                </div>
            </div>
        </section>
        <!--end search and add new button-->
        
        
        <!--table show finanical records details-->
        <section class="table-section">
            <div class="container">
                <div class="row">
                    <table class="table-section table-bordered table-condensed table-hover" id="user_data">
                        <thead class="thead-light">
                            
                          
                            <th>رقم القضية</th>
                            <th> الية الدفع</th>
                            <th>تم التسديد</th>
                            <th>الأحداث</th>
                        </thead>
                        
                        
                    </table>
                </div>
            </div>
        </section>
        <!--end show finanical records details--->
        
        <!--show anouther details dialog-->
        <section class=" overlay text-center" id="show-details">
            <div class="container">
                <span class="close-btn">
                    <i onclick="document.getElementById('show-details').style.display='none'" class="fa fa-window-close" aria-hidden="true"></i>
                </span>
                <h2 class="super-title">تفاصيل الية الدفع </h2>
                <div class="row opttion-one-checks" id="cheks-details" style="display:none">
                    <h2 class="title-section">شيكات </h2>
                    <form>
                        <div id="alert_message"></div>
                         <table class="table-section table-bordered table-condensed table-hover" id="check_user_data">
                        <thead class="thead-light">
                            
                          
                            <th>اسم صاحب الشك</th>
                            <th>قيمة الشك</th>
                            <th>تاريخ الصرف</th>
                            <th>تاريخ التذكير</th>
                            
                            <th>Actions</th>
                        </thead>
                        
                        
                    </table>
                       
                       
                     
                    
                    </form>
                </div>
                <div class='row option-two-Premiums' id="installment-details" style="display:none">>
                    <h2 class="title-section">أقساط</h2>
                     <form>
                        <div id="alert_message"></div>
                         <table class="table-section table-bordered table-condensed table-hover" id="installment_user_data">
                        <thead class="thead-light">
                            <th>قيمة الدفعة</th>
                            <th>تاريخ الدفعة</th>
                            
                            <th>تاريخ التذكير</th>
                          
                            <th>Actions</th>
                        </thead>
                        
                        
                    </table>
                       
                       
                     
                    
                    </form>
                   
                </div>
            </div>
        </section>
        <!--end anouther details dialog-->

        
        <!--add new financial records-->
        <section class="addNew-section overlay text-center" id="addNew">
        <div class="container">
                <span class="close-btn">
                    <i onclick="document.getElementById('addNew').style.display='none'" class="fa fa-window-close" aria-hidden="true"></i>
                </span>
                <h2 class="super-title">اضافة سجل مالي جديد</h2>
			 <form method="post" action="addfinan.php">
                <div class="search sec-search{">
				
               
                    <div class="row form-search">
                    
                        <input type="text" id="input-prec" placeholder="ادخل رقم القضية" name="search-proc" autocomplete="on"/>
                        	<div id="match2"></div>
                        <datalist id="data-number-case"></datalist>
                      
                </div>
                </div>
                <div class="detailsfinancial">
                   
                      
                        <!--Radio group-->
                        <div class="form-check radio-pink-gap ">
                            <input class="form-check-input with-gap type-of-financial"  onchange="handleChange();" name="groupTypeFinancial" type="radio" id="radio100" value="money">
                            <label class="form-check-label type-of-financial" for="radio100">كاش</label>
                        </div>
                        <div class="form-check radio-pink-gap ">
                            <input class="form-check-input with-gap type-of-financial" name="groupTypeFinancial"   onchange="handleChange();" type="radio" id="radio101" value="prem">
                            <label class="form-check-label" for="radio101">أقساط</label>
                        </div>
                        <div class="form-check radio-pink-gap">
                            <input class="form-check-input type-of-financial"  onchange="handleChange();" name="groupTypeFinancial" type="radio" id="radio102" value="checks">
                            <label class="form-check-label" for="radio102">شيكات </label>
                        </div>
                        <!--Radio group-->
                       <!--<button class="btn btn-primary submit-type-of-financial" type="button" id="submit-type-of-financial">التالي
                            <i class="fas fa-arrow-right" style="margin-left:5px"></i></button>-->
                  
                    <!--div add detials for new checks-->
                    <div  class="checks-add-details">
                        <div class="detail-checks">
                            <h2>شيكات</h2>
                            <div class="info">
                                <label  class="sub-title" for="name">اسم صاحب الشيك </label>
                                <input  class="info-value" type="text" name="check-name[]"/>
                            </div>
							 <div class="info">
                                <label  class="sub-title" for="value">قيمة الشك </label>
                                <input  class="info-value" type="text" name="check-value[]"/>
                            </div>
                            <div class="info">
                                <label class="sub-title" for="date">تاريخ الصرف </label>
                                <input class="info-value" type="date" name="check-date[]"/>
                            </div>
                            <div class="info">
                                <label  class="sub-title" for="time">وقت التذكير</label>
                                <input class="info-value" type="date"  name="check-time[]" date="time"/>
                                </div>
                            </div>
                                <button class="btn btn-primary add-checks-div" type="button">اضافة <i class="fas fa-plus" style="margin-left:5px"></i> </button>
                        </div>
                        <!--end form add details for new checks-->
                        
                        <!-- form add detaild for new prem-->
                        <div  class="prem-add-details">
                            <div class="prem-details">
                                <h2>أقساط</h2>
                                <div class="info">
                                    <label  class="sub-title" for="name">قيمة القسط</label>
                                    <input  class="info-value" type="text" name="prem-name[]"/>
                                </div>

                                <div class="info">
                                    <label class="sub-title" for="date">تاريخ الدفع</label>
                                    <input class="info-value" type="date" name="prem-date[]"/>
                                </div>

                                <div class="info">
                                    <label  class="sub-title" for="time">وقت التذكير</label>
                                    <input class="info-value" type="date" name="prem_rem_date[]" date="time"/>
                                </div>
                            </div>
                                <button class="btn btn-primary add-prem-div" type="button">اضافة
                                    <i class="fas fa-plus" style="margin-left:5px"></i>
                                </button>
                        </div>
                        <!--end form add details for new prem-->
                        <button class="btn btn-success save-pay" onclick="myFunction()" type="submit">حفظ
                                <i class="fas fa-save"  style="margin-left:5px"></i>
                        </button>
                       <script>
function myFunction() {
    location.reload();
}
</script>
                    </div>
			
                
			</form>
		</div>
      </section>
        <!--end new financial records-->
        
        <!--start footer section-->
        <!--<footer>
            <span>
                تم انتاجه في 2018 .جميع الحقوق محفوظة
                <i class="fa fa-copyright"></i>
            </span>
        </footer>-->
        <?php include('../html/footerPage.html')?>
        <!--end footer section-->
        
        
                    
                
        



  <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.0.0/jq-3.2.1/jszip-2.5.0/dt-1.10.16/af-2.2.2/b-1.5.1/b-colvis-1.5.1/b-flash-1.5.1/b-html5-1.5.1/b-print-1.5.1/cr-1.4.1/fc-3.2.4/fh-3.1.3/kt-2.3.2/r-2.2.1/rg-1.0.2/rr-1.2.3/sc-1.4.4/sl-1.2.5/datatables.min.js"></script>
  
        <script defer src="https://use.fontawesome.com/releases/v5.0.7/js/all.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
        <script src="../js/financialRecords.js"></script>
		<script src="../js/fina-datatable.js"></script>
        <script>
        
           function handleChange(){ 
               var value=$('input[name=groupTypeFinancial]:checked').val() ;
        switch(value){
            case "money":
              var doc1=document.getElementsByClassName("prem-add-details");
                $(doc1).css('display','none');
              var doc1=document.getElementsByClassName("checks-add-details");
                $(doc1).css('display','none');
                break;
            case "checks":
              var doc1=document.getElementsByClassName("prem-add-details");
                $(doc1).css('display','none');
              
                var doc=document.getElementsByClassName("checks-add-details");
                $(doc).css('display','block');
                break;
            case "prem":
                var doc1=document.getElementsByClassName("checks-add-details");
                $(doc1).css('display','none');  
                var doc=document.getElementsByClassName("prem-add-details");
                $(doc).css('display','block');
                break;
        }}
        </script>
        
    </body>
</html>
