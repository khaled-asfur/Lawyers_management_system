<?php 

if (session_status() == PHP_SESSION_NONE) {
      session_start();
  }
$path=Client::get_path();
include_once($path."php/DBConnect.php");
include_once($path."php/functions.php");
class Client{

      public static function get_path(){
           return $_SERVER['DOCUMENT_ROOT']."/lawyers/";

      }

public static function insure_logged_in(){
      $t=0;
      if(isset($_SESSION["end_date"])){
      $end_date=$_SESSION["end_date"];
      $t=strtotime( $end_date);
      }
      if(!isset($_SESSION["loged_in"])||$_SESSION["loged_in"]!="yes" || time()>= $t+60*60*24  ){
           if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
         	$uri .= $_SERVER['HTTP_HOST'];
	          header('Location: '.$uri.'/lawyers/html/LogIn.php');
      }
      
      

      
}

 /// reminds  page start 00000000000000000000000000000000000000000000000000000 

 //get procecution ids for a given office id

 public  static function  get_office_procecution_ids($office_id){
       $Procecution_ids = array();
       $conn= DBConnect::getConnection();
       if($conn->connect_error){
            die("Connection failed: " . $conn->connect_error);
       }
       $sql="SELECT procecutions.id from procecutions where customer_id in(select id from customers where office_id=$office_id) ";
       $result=$conn->query($sql);
       if($result->num_rows==0){
             $procecution_ids[] = "there are no procecutions for this office";
       }
       while($row=$result->fetch_assoc()){
            $Procecution_ids[]=$row["id"];
       }
      return  $Procecution_ids;
 }

  /// login page  start 00000000000000000000000000000000000000000000000000000 
/** puts the privilage of thie user in the session */
public static function put_privilages_in_session($user_id){
      $conn= DBConnect::getConnection();
      if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
      }
             $sql="SELECT * FROM privilages where user_id=$user_id";
             $result=$conn->query($sql);
             if ($result->num_rows ==0 ){ 
                echo "Error there are no privilages for this user";
                }
              else{
                  while($row = $result->fetch_assoc()) {
                        $_SESSION["customers_page"]=$row["customers_page"];
                        $_SESSION["sessions_page"]=$row["sessions_page"];
                        $_SESSION["financial_page"]=$row["financial_page"];
                        $_SESSION["users_page"]=$row["users_page"];
                        $_SESSION["ended_procecutions"]=$row["ended_procecutions"];
                        $_SESSION["reminds_page"]=$row["reminds_page"];
                       
                  }  
              /*   echo  $_SESSION["customers_page"];
                  echo $_SESSION["sessions_page"];
                  echo $_SESSION["financial_page"];
                  echo $_SESSION["users_page"];
                  echo $_SESSION["ended_procecutions"];
                  echo $_SESSION["reminds_page"];*/
            }
}



/****** end login page methods */

 /// RECORDS  PAAAGE 00000000000000000000000000000000000000000000000000000
      public static function show_fail_message($mesage){
           echo ' <div   id="error_dialog"  class=" client_error_dialog row">
            
             <div class="alert alert-danger alert-dismissible show " role="alert">
             <!--data-dismiss="alert"-->
             <button type="button" class="close client_close_fail"  aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
             <div id="show_Error">
                '.$mesage.'
             </div>      
                 
             </div>
         </div>';
      }
    public static function get_customer_name_using_identity_no($identity_number){
        $name="";
        $conn= DBConnect::getConnection();
        if ($conn->connect_error) {
              echo "Connection failed: " . $conn->connect_error;
              }else{
                     $sql=" SELECT name FROM customers where identity_number = $identity_number;";
                     $result=$conn->query($sql);
                     if ($result->num_rows ==0 ) { Client::show_fail_message(" لا يوجد مستخدم يحمل رقم الهوية هذا \"$identity_number\" ");}
                     else{
                      while($row = $result->fetch_assoc()) {
                      $name=$row["name"];
                      }
                      return $name;
                  }
            }

     }
    public static function get_customer_name_using_procecution_id($procecution_id){
        $name="";
        $conn= DBConnect::getConnection();
              if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
              }
                     $sql="SELECT `name` FROM customers where id=
                     (SELECT customer_id FROM procecutions where id = $procecution_id);";

                     $result=$conn->query($sql);
                     if ($result->num_rows ==0 ) { //echo " يرجى التاكد من procecution id لا يوجد مستخدمين "
                        ;}
                     else{
                      while($row = $result->fetch_assoc()) {
                      $name=$row["name"];
                      }
                      return $name;
                  }
    }
    

         // gets all procecution ids for this customer using his identity number
         public static function get_procecution_ids_using_identity_no($identity_number,$office_id,$ended){
            $identity_number=validate_string($identity_number);
            $Procecution_ids=array();
         $conn= DBConnect::getConnection();
               if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
               }
                      $sql="SELECT  id  FROM procecutions where customer_id=(
                      SELECT id FROM customers where identity_number= $identity_number and  office_id = $office_id ) and   ended=$ended;";
                      $result=$conn->query($sql);
                      if ($result->num_rows ==0 ) { 
                            //echo " p u identity error" ;
                      }else{
                       while($row = $result->fetch_assoc()) {
                        $Procecution_ids[]=$row["id"];
                       }
                  }
                       return $Procecution_ids;

               }
    
    
            // gets all procecution ids for this customer using his name
               public static  function get_procecution_ids_using_name($name,$office_id, $ended){
                     $name=validate_string($name);
                $Procecution_ids=array();
             $conn= DBConnect::getConnection();
                   if ($conn->connect_error) {
                   die("Connection failed: " . $conn->connect_error);
                   }
                          $sql="SELECT id FROM procecutions where customer_id=(
                          SELECT id FROM customers where name= \"$name\" and  office_id = $office_id  ) and   ended=$ended;";   
                        //  echo "<br>".$sql."<br>";
                          $result=$conn->query($sql);
                          if ($result->num_rows ==0 ) {// echo " لا يوجد قضايا لهذا المستخدم  ";
                          }
                               else{
                           while($row = $result->fetch_assoc()) {
                            $Procecution_ids[]=$row["id"];
                           }
                           return $Procecution_ids;
                        }
                   }
                           // gets  procecution id  using  procecution number
         public static function get_procecution_id_using_procecution_no($procecution_number,$office_id,$ended){
            $procecution_number=validate_string($procecution_number);
            $Procecution_id="ex" ;
         $conn= DBConnect::getConnection();
               if ($conn->connect_error) {
               die("Connection failed: " . $conn->connect_error);
               }
              $sql=" SELECT procecutions.id ,ended
              FROM procecutions
              INNER JOIN customers ON customer_id = customers.id
              AND office_id =$office_id
              AND procecution_number =$procecution_number";
                //  echo "<br>".$sql."<br>";

                      $result=$conn->query($sql);
                      if ($result->num_rows == 0 ) { echo $procecution_number.' لا يوجد قضية تحمل هذا الرقم يرجى التأكد من رقم القضية  ';
                        ;}
                      else{
                       while($row = $result->fetch_assoc()) {
                              if($row["ended"]==1 && $ended == 0){
                                    Client::show_fail_message( " انت تبحث عن قضية منتهية يرجى البحث عنها في صفحة القضايا المنتهية ");
                              }
                               else  if($row["ended"]==0 && $ended == 1){
                                    Client::show_fail_message( " انت تبحث عن قضية غير منتهية يرجى البحث عنها في صفحة القضايا غير المنتهية ");
                              }else{
                                    $Procecution_id=$row["id"];
                              }
                       }
                     
                       return $Procecution_id;
                  }
               }
    
    
                    //  اضافة فاصلة بعد كل رقم قضية وبحطها كلها في سترنج كونديشن
                    public static function format_proc_ids($Procecution_ids){
                        $condition="";
                        foreach($Procecution_ids as $id){
                             $condition.=$id.",";
                        }
                        
                       $condition= substr($condition,0,strlen($condition)-1) ; // delete last index (which will be a , )
                    return $condition;
                  }

                  // برجع ارري فيها ارقام القضايا لهذا المستخدم حسب الاسم او رقم الهوية 
                  public static function get_procecution_numbers_using($key,$office_id){

                        $key_type="name";
                        $msg="يرجى التاكد من أن الاسم صحيح وان هذا المستخدم يوجد له قضايا مسجلة من قبل";
                        // اذا كان الكيي رقم يعني بدو يبحث في رقم الهوية 
                        if(is_numeric($key)){
                              $key_type="identity_number";
                              $msg="يرجى التاكد من أن رقم الهوية صحيح وان هذا المستخدم يوجد له قضايا مسجلة من قبل";
                        }
                        $Procecution_numbers=array();
                     $conn= DBConnect::getConnection();
                           if ($conn->connect_error) {
                           die("Connection failed: " . $conn->connect_error);
                           }
                                  $sql="SELECT procecution_number FROM procecutions where customer_id=(
                                  SELECT id FROM customers where name= \"$name\" and  office_id = $office_id )  and   ended=0;";   
                                  $result=$conn->query($sql);
                                  if ($result->num_rows ==0 ) { echo $msg;}
                                  else{
                                   while($row = $result->fetch_assoc()) {
                                    $Procecution_numbers[]=$row["id"];
                                   }
                                   return $Procecution_numbers;
                                }
                           }





                                                 /// customers  page 00000000000000000000000000000000000000000000000000000
                           public static  function show_customers_info_using_identity_no($identity_number,$office_id,$ended){
                                 // ended must be 1 if you search for an ended procecution 
                                 // 0 otherwise
                                    $counter=1;
                                    $conn= DBConnect::getConnection();
                                    if ($conn->connect_error) {
                                    die("Connection failed: " . $conn->connect_error);
                                    }
                                          $sql="SELECT customers.name , customers.id as cust_id ,procecutions.id as proc_id ,procecution_number FROM customers
                                          inner join procecutions on identity_number = $identity_number and customer_id = customers.id and ended = $ended and office_id=$office_id";
                                   // echo "<br>".$sql."<br>";
                                    $result=$conn->query($sql);
                                     if ($result->num_rows ==0 ){ 
                                         echo "يرجى التأكد من صحة المعلومات لا يوجد قضايا ";
                                        }
                                      else{
                                          while($row = $result->fetch_assoc()) {
                                                $name=$row["name"]; 
                                                $procecution_number = $row["procecution_number"];
                                                $customer_id = $row["cust_id"];
                                                $procecution_id = $row["proc_id"];

                                                $button_id="end_procecution";
                                                if($ended==1){
                                                      $button_id="resume_procecution";
                                                }

                                                    echo '
                                                    <tr>
                                                    <th scope="row"> '.$counter .'</th>
                                                    <td><input class="cust_name"  type="text" value="'.$name.'"  /></td>
                                                    <td><input class="cust_identity" type="text" value=" '.$identity_number.'" /></td>
                                                    <td><input class="proc_number" type="text" value="'.$procecution_number.'" /></td>
                                                    <td style="display:none" ><input  type="text" value="'.$customer_id.' " /></td>
                                                    <td style="display:none" ><input type="text" value="'.$procecution_id.'"/></td>
                                                    <td><button name="done" ><i class="'.$button_id.' fas fa-check-circle"></i></button></td>
                                                    <td class="actions">


                                                    <button  type="button" class=" customer_details btn btn-info view-button">
                                                    <i class="fas fa-eye" style="margin-legt:5px"></i>تفاصيل
                                              </button>
                                              <button  type="button"  class="btn btn-danger delete-button" id="delete-button" data-toggle="modal" data-target="#exampleModal">
                                                 <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                              </button>
                                                    </td>
                                                </tr>
                                                 ';
                                                $counter++;
                                                    }
                                                  }
                                                   
                                                }
       public static function show_customers_info_using_name($name,$office_id,$ended){
            // ended must be 1 if you search for an ended procecution 
            // 0 otherwise
            $counter=1;
            $conn= DBConnect::getConnection();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $sql="SELECT customers.identity_number , customers.id as cust_id ,procecutions.id as proc_id ,procecution_number FROM customers
                   inner join procecutions on customers.name = \"$name\" and customer_id = customers.id and ended = $ended and office_id=$office_id";
            $result=$conn->query($sql);
            if ($result->num_rows ==0 ){ 
                echo "يرجى التأكد من كتابة الاسم  لا يوجد قضايا ";
            }
            else{
                 while($row = $result->fetch_assoc()) {
                        $identity_number=$row["identity_number"]; 
                        $procecution_number = $row["procecution_number"];
                        $customer_id = $row["cust_id"];
                        $procecution_id = $row["proc_id"];

                        $button_id="end_procecution";
                        if($ended==1){
                              $button_id="resume_procecution";
                        }
                        echo '
                              <tr>
                              <th scope="row"> '.$counter .'</th>
                              <td><input class="cust_name"  type="text" value="'.$name.'"  /></td>
                              <td><input class="cust_identity" type="text" value=" '.$identity_number.'" /></td>
                              <td><input class="proc_number" type="text" value="'.$procecution_number.'" /></td>
                              <td style="display:none" ><input  type="text" value="'.$customer_id.' " /></td>
                              <td style="display:none" ><input type="text" value="'.$procecution_id.'"/></td>
                              <td><button name="done" ><i class="'.$button_id.' fas fa-check-circle"></i></button></td>
                              <td class="actions">
                             

                              <button  type="button" class=" customer_details btn btn-info view-button">
                              <i class="fas fa-eye" style="margin-legt:5px"></i>تفاصيل
                        </button>
                        <button type="button"  class="btn btn-danger delete-button" id="delete-button" data-toggle="modal" data-target="#exampleModal">
                              <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                        </button>
                               </td>
                              </tr>
                              ';
                        $counter++;
                        }
                  }
                  }

                  public static  function show_customers_info_using_procecution_number($procecution_number,$office_id,$ended){
                        // ended must be 1 if you search for an ended procecution 
                        // 0 otherwise
                        $counter=1;
                        $conn= DBConnect::getConnection();
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
                        $sql="SELECT customers.name, customers.identity_number , customers.id as cust_id ,procecutions.id as proc_id ,ended FROM customers
                               inner join procecutions on procecutions.procecution_number = $procecution_number and customer_id = customers.id  and office_id=$office_id";
                        $result=$conn->query($sql);
                        if ($result->num_rows ==0 ){ 
                            echo "يرجى التأكد من رقم القضية ، لا يوجد قضايا تحمل هذا الرقم ";
                        }
                        else{
                             while($row = $result->fetch_assoc()) {
                                   if($row["ended"]==1 && $ended == 0){
                                    echo " انت تبحث عن قضية منتهية يرجى البحث عنها في صفحة القضايا المنتهية ";
                                   }
                                 else  if($row["ended"]==0 && $ended == 1){
                                    echo " انت تبحث عن قضية غير منتهية يرجى البحث عنها في صفحة القضايا غير المنتهية ";
                              }else{

                                    $identity_number=$row["identity_number"]; 
                                    $name = $row["name"];
                                    $customer_id = $row["cust_id"];
                                    $procecution_id = $row["proc_id"];

                                   

                                    $button_id="end_procecution";
                                    if($ended==1){
                                          $button_id="resume_procecution";
                                    }
                                    echo '
                                          <tr>
                                          <th scope="row"> '.$counter .'</th>
                                          <td><input class="cust_name"  type="text" value="'.$name.'"  /></td>
                                          <td><input class="cust_identity" type="text" value=" '.$identity_number.'" /></td>
                                          <td><input class="proc_number" type="text" value="'.$procecution_number.'" /></td>
                                          <td style="display:none" ><input  type="text" value="'.$customer_id.' " /></td>
                                          <td style="display:none" ><input type="text" value="'.$procecution_id.'"/></td>
                                          <td><button name="done" ><i class="'.$button_id.' fas fa-check-circle"></i></button></td>
                                          <td class="actions">

                                          <button  type="button" class=" customer_details btn btn-info view-button">
                                                <i class="fas fa-eye" style="margin-legt:5px"></i>تفاصيل
                                          </button>
                                          <button type="button"  class="btn btn-danger delete-button" id="delete-button" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                          </button>
                                           </td>
                                          </tr>
                                          ';
                                    $counter++;
                                    }
                              }
                              }
                              }

                              public static  function show_all_procecutions($office_id,$ended){
                                    // ended must be 1 if you search for an ended procecution 
                                    // 0 otherwise
                                    $counter=1;
                                    $conn= DBConnect::getConnection();
                                    if ($conn->connect_error) {
                                        die("Connection failed: " . $conn->connect_error);
                                    }
                                    $sql="SELECT customers.name, procecutions.procecution_number, customers.identity_number , customers.id as cust_id ,procecutions.id as proc_id ,ended FROM customers
                                           inner join procecutions  on customer_id = customers.id  and office_id=$office_id and ended=$ended order by identity_number";
                                    $result=$conn->query($sql);
                                    if ($result->num_rows ==0 ){ 
                                          Client::show_fail_message(" لا يوجد قضايا  ");
                                          
                                         
                                    }
                                    else{
                                         while($row = $result->fetch_assoc()) {
                                              
            
                                                $identity_number=$row["identity_number"]; 
                                                $name = $row["name"];
                                                $customer_id = $row["cust_id"];
                                                $procecution_id = $row["proc_id"];
                                                $procecution_number=$row["procecution_number"];
                                               
            
                                                $button_id="end_procecution";
                                                if($ended==1){
                                                      $button_id="resume_procecution";
                                                }
                                                echo '
                                                      <tr>
                                                      <th scope="row"> '.$counter .'</th>
                                                      <td><input class="cust_name"  type="text" value="'.$name.'"  /></td>
                                                      <td><input class="cust_identity" type="text" value=" '.$identity_number.'" /></td>
                                                      <td><input class="proc_number" type="text" value="'.$procecution_number.'" /></td>
                                                      <td style="display:none" ><input  type="text" value="'.$customer_id.' " /></td>
                                                      <td style="display:none" ><input type="text" value="'.$procecution_id.'"/></td>
                                                      <td><button name="done" ><i class="'.$button_id.' fas fa-check-circle"></i></button></td>
                                                      <td class="actions">
            
                                                      <button  type="button" class=" customer_details btn btn-info view-button">
                                                            <i class="fas fa-eye" style="margin-legt:5px"></i>تفاصيل
                                                      </button>
                                                      <button type="button"  class="btn btn-danger delete-button" id="delete-button" data-toggle="modal" data-target="#exampleModal">
                                                            <i class="fas fa-trash-alt" style="margin-left:5px"></i>حذف
                                                      </button>
                                                       </td>
                                                      </tr>
                                                      ';
                                                $counter++;
                                                
                                          }
                                          }
                                          }
                                                                    
}
