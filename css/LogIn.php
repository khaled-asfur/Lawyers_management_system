<?php 
session_start();

include_once("../php/functions.php");
include_once("../php/classes/client.php");
include_once("../php/classes/user.php");
$errors=array();
if($_SERVER["REQUEST_METHOD"]=="POST"){ 
    $user= new User();
 $login_info=$user->get_users_login_info();//اري تحتوي على جميع كلمات السر والبريد الالكتروني لجميع المستخدمين
    $email= validate_string($_POST["email"]) ;//from functions file
    $password=validate_string($_POST["password"]) ;//from functions file
    if(!array_key_exists($email,$login_info))      
       $errors[]= " البريدالالكتروني غير موجود";
    
    else{
       // if email is exist
        if($login_info[$email]!==$password){
            $errors[]="كلمة السر غير صحيحة ";
        }else{
           $user->set_email($email);
           $user->get_user_info();// بجيب  معلومات المستخدم الي بحاول يسجل دخول وبخزنها في الاوبجكت يوزر
           $end_date=$user->get_end_date();
           $t=strtotime( $end_date);

           if(time()>= $t+60*60*24 ){
              // $end=$user->get_end_date();
                $errors[]="لقد انتهى اشتراك هذا المكتب يرجى التواصل مع المسؤول لاعادة تفعيل اشتراكك";
           }else{
               // اذا كانت بيانات تسجيل الدخول صحيحة وكان اشتراك المكتب فعال
                $user_id=$user->get_user_id();
                Client::put_privilages_in_session($user_id);//puts the privilages of this user in the session variables $_session......
                $_SESSION["username"]=$user->get_name() ;
                $_SESSION["office_id"]=$user->get_office_id();
                $_SESSION["get_profile_picture_url"]= $user->get_profile_picture_url() ;
                $_SESSION["office_name"]= $user->get_office_name() ;
                $_SESSION["loged_in"]="yes";
                $_SESSION["end_date"]=$end_date;
                header("Location: homePage.php");
           }
        }
       
    }
    
}
?>
<!DOCTYPE>
<html>
    <head>
        <meta charset="utf-8"/>
        <title>Log In</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css"/>
        <link rel="stylesheet" href="../css/as-admin-css.css"/>
        <link rel="stylesheet" href="../css/publicStyle.css"/>
        <link rel="stylesheet" href="../css/LogIn.css"/>
    </head>
    <body dir="rtl">
        
        <!--start Cover Image-->
       <div class="img-cover">
            <img src="../image/3.jpg" class="image"/>
    
        
        <!--start logIn style-->
        <div class="container">
            <div class="row">
                <div class="logIn-section">
                    
                    <div class="leftSide">
                    </div>
                    
                    <div class="rigthSide">
                        <h2 class="h1">تسجيل الدخول</h2>
                            <!--start form-->
                        <img src="../image/logo.png" class="img-circle" width="50px" height="50px"/>
                        <form action=" <?php echo $_SERVER['PHP_SELF'];?> " method="POST">
                               
                         <!--   <div  class="alert alert-warning alert-dismissible show " role="alert">
                                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                  </button>

                                  loololololl
                                        
                            </div>-->
                            <div <?php if(empty($errors)){ echo 'style="display:none !important"';}?> class="alert alert-warning alert-dismissible  show" role="alert">
                            
                            <button type="button" class="close err_div fade" data-dismiss="alert" aria-label="Close">
                             <span aria-hidden="true">&times;</span>
                            </button>
                            <?php 
                                 if(!empty($errors)){
                                     foreach($errors as $err){
                                        echo $err."<br>";
                                        }
                                        }?> 
                          </div>

                            <input type="email" value="khalid_asfur@hotmail.com" placeholder="البريد الالكتروني" name="email"/>
                            <input type="password" placeholder="كلمة المرور" name="password"/>
                            <button type="submit" class="login_btn btn btn-success" id="submit-btn">دخول</button>
                            <span class="wrongInput hidden" >ادخال خاطئ!</span>
                        </form>
                        <!--end form-->
                    </div>
                    
                    <div class="clearfix">     
                    </div>
                    
                </div>
            </div>
        </div>
        <!--end LogIn style-->
       </div>
        <!--end cover Img-->
        
        <script src="../js/jquery-3.3.1.min.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/nicescroll.js"></script>
        <script src="../js/scroll.js"></script>

    </body>
</html>