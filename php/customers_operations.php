<?php
include("classes/Client.php");
$path=Client::get_path();
//include($path."php/DBConnect.php");

include_once("functions.php");
$msg=" ";

$insert_error_messages= array("court"=>"1", "customer"=>"1", "procecution"=>"1", "discount"=>"1", "discount_agent"=>"1");//بخزن فيها كل جمل الخطا الي رح تظهر
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $operation=$_POST["operation"];
    if($_POST["operation"]=="check_if_there_exist_such_procecuton_for_this_office"){
        $conn = DBConnect::getConnection();
        $procecution_number =$_POST["procecution_number"];
        $office_id=$_SESSION["office_id"];
        $sql="select id from procecutions where
        (select office_id from customers where customers.id = procecutions.customer_id)=$office_id and procecution_number =$procecution_number";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
            // يعني انه لا يوجد قضية تحمل نفس الرقم لهذا المكتب 
            echo  "no such procecution";
        }
        else{
            echo "procecution is exist in database";
            }
        
        
    }
    //اذا كان الزبون صاحب رقم الهوية هذا موجود في الداتابيز بجيب بياناته مشان اعرضها في ديالوج اضافة زبون
    if($operation =="get_customer_info_using_id_no"){
        $conn = DBConnect::getConnection();
        $identity_number =$_POST["identity_number"];
        $customer=array();
        $customer["message"]="not found";
        $sql="SELECT name,id, phone_number,address,notes FROM customers where identity_number= $identity_number;";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
            // معناها ان الزبون الي بحمل رقم الهوية هذا مش موجود بالداتا بيز 
            echo  "no users";
            die();
        }
        else{
             while($row = $result->fetch_assoc()) {
                $customer["customer_id"]=$row["id"];
                $customer["name"]=$row["name"];
                $customer["phone_number"]=$row["phone_number"];
                $customer["address"]=$row["address"];
                $customer["notes"]=$row["notes"];
                $customer["message"]="found";

                }
            }
        
        echo json_encode($customer);
    }
    //تعديل بيانات القضية والمحمة 
    if($operation=="update_procecution_info"){

        $procecution_id=$_POST["procecution_id"];
        $procecution_number=$_POST["procecution_number"];
        $subject=$_POST["subject"];
        $date=$_POST["date"];
        $procecution_value=$_POST["procecution_value"];
        $court_name=$_POST["court_name"];
        $court_address=$_POST["court_address"];

         $conn = DBConnect::getConnection();
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
         $sql = "update procecutions set procecution_number = $procecution_number , 
         subject=\"$subject\",date=\"$date\" where id = $procecution_id";
         
         if ($conn->query($sql) === TRUE) {
            
            //اذا تم اضافة القضية بنجاح بفوت يعدل بيانات المحمة 
                 $sql = "update courts set name=\"$court_name\" ,address=\"$court_address\"
                  where id=(select court_id from procecutions where procecutions.id = $procecution_id)";
                 if ($conn->query($sql) === TRUE) { $msg="procecution_updated";}
                    else {$msg="Error updating court: " . $conn->error;}
         } 
         else {
             $msg="Error updating procecution: " . $conn->error;
         }
         echo $msg;
         $conn->close();
         
    }

    //تعديل بيانات الخصم 
    if($operation=="update_agent_info"){
                   $procecution_id=$_POST["procecution_id"];
                   $agent_name=$_POST["agent_name"];
                   $agent_address=$_POST["agent_address"];
                   $agent_number=$_POST["agent_number"];
                   $agent_notes=$_POST["agent_notes"];
   
                    $conn = DBConnect::getConnection();
                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }
                    $sql = "update discount_agent set name=\"$agent_name\" , number=$agent_number , address=\"$agent_address\",notes =\"$agent_notes\" where procecution_id=$procecution_id";
                    
                    if ($conn->query($sql) === TRUE) {
                        $msg="updated";
                    } else {
                        $msg="Error updating record: " . $conn->error;
                    }
                    echo $msg;
                    $conn->close();
                    
               }
    //تعديل بيانات الخصم 
    if($operation=="update_discount_info"){
 	
                $procecution_id=$_POST["procecution_id"];
                $discount_name=$_POST["discount_name"];
                $discount_number=$_POST["discount_number"];
                $discount_address=$_POST["discount_address"];
                $discount_notes=$_POST["discount_notes"];

                 $conn = DBConnect::getConnection();
                 if ($conn->connect_error) {
                     die("Connection failed: " . $conn->connect_error);
                 }
                 $sql = "update discounts set name=\"$discount_name\" , number=\"$discount_number\" , address=\"$discount_address\",notes =\"$discount_notes\" where procecution_id=$procecution_id";
                 
                 if ($conn->query($sql) === TRUE) {
                     $msg="updated";
                 } else {
                     $msg="Error updating record: " . $conn->error;
                 }
                 echo $msg;
                 $conn->close();
                 
            }

    // تعديل بيانات العميل
    if($operation=="update_customer_info"){

        $customer_id=$_POST["customer_id"];
        $customer_name=$_POST["customer_name"];
        $phone_number=$_POST["phone_number"];
        $identity_number=$_POST["identity_number"];
        $customer_address=$_POST["customer_address"];
        $customer_notes=$_POST["customer_notes"];
         $conn = DBConnect::getConnection();


         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
         $sql = "update customers set name=\"$customer_name\",phone_number=$phone_number ,identity_number=\"$identity_number\" ,address=\"$customer_address\"
          ,notes=\"$customer_notes\" where id=$customer_id; ;";
         
         if ($conn->query($sql) === TRUE) {
             $msg="updated";
         } else {
             $msg="Error updating record: " . $conn->error;
         }
         echo $msg;
         $conn->close();
         
    }
    if($operation=="end_resume_procecution"){
        $procecution_id=$_POST["procecution_id"];
        $ended=1;
        //اذا كانت العملية عملية استعادة بخلي المتغير اندد قيمته صفر
        if($_POST["oper"]=="resume"){
            $ended=0;
        }
         $conn = DBConnect::getConnection();
 
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
         $sql = "update procecutions set ended = $ended where id= $procecution_id;";
         
         if ($conn->query($sql) === TRUE) {
             $msg="updated";
         } else {
             $msg="Error updating record: " . $conn->error;
         }
         echo $msg;
         $conn->close();
    }
    if($operation == "view_customer_info"){
      
        $procecution_id=$_POST["procecution_id"];
        $customer_id=$_POST["customer_id"];
        $conn= DBConnect::getConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

       $customer= get_customer_info($customer_id , $conn);
        $procecution= get_procecution_info($procecution_id ,$conn);
        $discount=get_discount_info($procecution_id , $conn);
        $discount_agent=get_discount_agent_info($procecution_id , $conn);

        $data["customer"]=$customer;
        $data["procecution"]=$procecution;
        $data["discount"]=$discount;
        $data["discount_agent"]=$discount_agent;
        echo json_encode($data);
    }

    if($operation == "update_identity_number"){
        $identity_number=$_POST["identity_number"];
        $customer_id=$_POST["customer_id"];
         $conn = DBConnect::getConnection();
 
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
         $sql = "update customers set identity_number=$identity_number where id=$customer_id ;";
         
         if ($conn->query($sql) === TRUE) {
             $msg="updated";
         } else {
             $msg="Error updating record: " . $conn->error;
         }
         echo $msg;
         $conn->close();
         
     }
 //update name
    if($operation == "update_name"){
        $name=$_POST["name"];
        $customer_id=$_POST["customer_id"];
         $conn = DBConnect::getConnection();
  
        
         if ($conn->connect_error) {
             die("Connection failed: " . $conn->connect_error);
         }
         $sql = "update customers set name=\"$name\" where id=$customer_id ;";
         
         if ($conn->query($sql) === TRUE) {
             $msg="updated";
         } else {
             $msg="Error updating record: " . $conn->error;
         }
         echo $msg;
         $conn->close();
         
     }

      //update procecution number
    if($operation == "update_procecution_number"){
       $procecution_number=$_POST["procecution_number"];
       $procecution_id=$_POST["procecution_id"];
        $conn = DBConnect::getConnection();

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "update procecutions set procecution_number = $procecution_number where id= $procecution_id;";
        
        if ($conn->query($sql) === TRUE) {
            $msg="updated";
        } else {
            $msg="Error updating record: " . $conn->error;
        }
        echo $msg;
        $conn->close();
        
    }
    
    if($operation == "delete"){
        $msg=" ";
        $procecution_id = $_POST["procecution_id"];
        $conn = DBConnect::getConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } 
        $sql = "delete FROM procecutions where id= $procecution_id ;";
      
        if ($conn->query($sql) === TRUE) {
          $msg="deleted";
        } else {
            $msg= "Error while  deleting procecution: " . $conn->error;
        }
        echo $msg;
        $conn->close();

    }

    if($operation =="insert"){
      
       
                // validate_string() from functions file
                  $office_id=$_SESSION["office_id"];

                  /** customer info */
                   $customer=json_decode($_POST["customer"]);// وصل من البوست اوبجكت كستمر ك سترنج وبهاي العملية بحوله لاوبجكت 
                   $first_name= validate_string($customer->first_name);
                    $father_name= validate_string($customer->father_name);
                    $grand_name=validate_string($customer->grand_name);
                    $family_name=validate_string($customer->family_name);
                    $identity_number=validate_string($customer->identity_number);
                     $phone_number=validate_string($customer->phone_number);
                    $customer_address= validate_string($customer->customer_address);
                    $customer_notes= validate_string($customer->customer_notes);
      //echo $first_name."<br>".$father_name."<br>".$grand_name."<br>".$family_name."<br>".$identity_number."<br>".$phone_number."<br>".$customer_address."<br>".$customer_notes."<br>";

                   /*** discount info */
                   $discount=json_decode($_POST["discount"]);// وصل من البوست سترنج كستمر وبهاي العملية بحوله لاوبجكت 
                   $discount_name= validate_string($discount->discount_name);
                    $discount_number= validate_string($discount->discount_number);
                    $discount_address=validate_string($discount->discount_address);
                    $discount_notes=validate_string($discount->discount_notes);
                    

              // echo $discount_name."<br>".$discount_number."<br>".$discount_address."<br>".$discount_notes."<br>";

                   /**** agent info */
                   $agent=json_decode($_POST["agent"]);// وصل من البوست سترنج كستمر وبهاي العملية بحوله لاوبجكت 
                   $agent_name= validate_string($agent->agent_name);
                   $agent_number= validate_string($agent->agent_number);
                    $agent_address= validate_string($agent->agent_address);
                    $agent_notes=validate_string($agent->agent_notes);
                    // echo $agent_name."<br>".$agent_number."<br>".$agent_address."<br>".$agent_notes."<br>";

                   /**  court info */
                    $court= json_decode($_POST["court"]);
                    $court_address= validate_string($court->court_address);
                     $procecution_number= validate_string($court->procecution_number);
                     $court_name=validate_string($court->court_name);
                     $procecution_subject=validate_string($court->procecution_subject);
                     $procecution_value=validate_string($court->procecution_value);
                     $procecution_date=$court->procecution_date;
                     

                    // echo $court_address."<br>".$procecution_number."<br>".$court_name."<br>".$procecution_subject."<br>".$procecution_value."<br>".$procecution_date."<br>";

                    $conn =  DBConnect::getConnection();
                     if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    } 
                   
                   $court_id= insert_court($court_address,$court_name,$conn);
                   $customer_id=0;
                    //اذا كانت قيمة الكستمر اي دي سالب واحد بكون الكستمر الي بدي اضيفله قضية مش  موجود يعني بدي اضيف كستمر جديد 
                    // واذا كانت قيمة الكستمر اي دي مش سالب واحد بكون الكستمر الي بدي اضيفله قضية مضيوف عالداتا بيز سابقا 
                   if($_POST["customer_id"]!= -1){
                      
                    $customer_id=$_POST["customer_id"];
                    }else{
                        $customer_id=insert_customer($first_name,$father_name,$grand_name,$family_name,$identity_number,$phone_number,$customer_address,$customer_notes,$conn);
                    }
                    $procecution_id=insert_procecution($procecution_number,$court_id,$procecution_subject,$procecution_value,$procecution_date, $customer_id,$conn);
                    insert_discount($discount_name,$discount_number,$discount_address,$discount_notes,$procecution_id,$conn);  
                    insert_discount_agent($agent_name,$agent_number,$agent_address,$agent_notes,$procecution_id,$conn);

                    
                    $conn->close();
                    
                    echo json_encode($insert_error_messages);
        }





}


function insert_court($court_address,$court_name,$conn){
    global $insert_error_messages;
    $id;
    $sql = "insert into courts (`name`,address) values (\" $court_address\",\"$court_name\")  ;";
    $conn->query($sql);
    if ($conn->query($sql) !== TRUE){
        $insert_error_messages["court"]=$conn->error . "on line".__LINE__; 
        echo json_encode($insert_error_messages); 
       die();
    }
    $sql2="select last_insert_id() as court_id ";
    $result=$conn->query($sql2);
    if($row = $result->fetch_assoc())
    $id=$row["court_id"];
    return $id;
}

function insert_customer($first_name,$father_name,$grand_name,$family_name,$identity_number,$phone_number,$customer_address,$customer_notes,$conn)
{    global $insert_error_messages;
    $office_id=$_SESSION["office_id"];
    $name=$first_name." ".$father_name." ".$grand_name." ".$family_name;
    $id;


    $sql = "insert into customers (name, phone_number,identity_number,address,notes,office_id)
     values(\"$name\",\"$phone_number\",$identity_number,\"$customer_address\",\"$customer_notes\", $office_id)  ;";
    if ($conn->query($sql) !== TRUE){
        $insert_error_messages["customer"]=$conn->error ."<br>".$sql ."<br>". " on line".__LINE__; 
        echo json_encode($insert_error_messages);
       die( );
    }
    $sql2="select last_insert_id() as customert_id ";
    $result=$conn->query($sql2);
    if($row = $result->fetch_assoc())
    $id=$row["customert_id"];
    return $id;
}
function insert_procecution($procecution_number,$court_id,$procecution_subject,$procecution_value,$procecution_date, $customer_id,$conn){
    global $insert_error_messages;
    $id;
    $sql = "insert into procecutions (procecution_number,court_id,`subject`,`date`,`value`,customer_id) 
    values($procecution_number,$court_id,\"$procecution_subject\",'$procecution_date',\"$procecution_value\",$customer_id);";
    if ($conn->query($sql) !== TRUE) {
        $insert_error_messages["procecution"]=$conn->error ."<br>".$sql ."<br>". " on line".__LINE__; 
        echo json_encode($insert_error_messages);
        die();
    }
    $sql2="select last_insert_id() as procecution_id ";
    $result=$conn->query($sql2);
    if($row = $result->fetch_assoc())
    $id=$row["procecution_id"];
    return $id;
}
function insert_discount($discount_name,$discount_number,$discount_address,$discount_notes,$procecution_id,$conn){
    global $insert_error_messages;
     $sql = "insert into discounts (name,number,address,notes,procecution_id)
     values(\"$discount_name\",\"$discount_number\",\"$discount_address\",\"$discount_notes\",$procecution_id); ";
      if ($conn->query($sql) !== TRUE) {
        
        $insert_error_messages["discount"]=$conn->error .$sql. " on line".__LINE__; 
        echo json_encode($insert_error_messages);
        die();
    }
}
function insert_discount_agent($agent_name,$agent_number,$agent_address,$agent_notes,$procecution_id,$conn){
    global $insert_error_messages;
     $sql = "insert into discount_agent (name,number,address,notes,procecution_id)
    values(\"$agent_name\",\"$agent_number\",\"$agent_address\",\"$agent_notes\",$procecution_id); ";
     if ($conn->query($sql) !== TRUE) {
        $insert_error_messages["discount_agent"]=$conn->error . " on line".__LINE__; 
        echo json_encode($insert_error_messages);
        
       die();
}
}

function get_customer_info($customer_id , $conn){
    
    $customer=array();
    $sql="SELECT name, phone_number,identity_number,address,notes FROM customers where id= $customer_id;";
    $result=$conn->query($sql);
    if ($result->num_rows ==0 ){ 
        $msg="Error while getting customer info";
    }
    else{
         while($row = $result->fetch_assoc()) {
            $customer["name"]=$row["name"];
            $customer["phone_number"]=$row["phone_number"];
            $customer["identity_number"]=$row["identity_number"];
            $customer["address"]=$row["address"];
            $customer["notes"]=$row["notes"];
            }
        }
    
        return $customer;
    }
    function get_procecution_info($procecution_id , $conn){
        
        $procecution=array();
        $sql="SELECT procecution_number,subject,date,value ,courts.name , courts.address FROM procecutions
        inner join courts on procecutions.id=$procecution_id and courts.id = procecutions.court_id";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
            $msg="Error while getting procecution info";
        }
        else{
             while($row = $result->fetch_assoc()) {
                $procecution["procecution_number"]=$row["procecution_number"];
                $procecution["subject"]=$row["subject"];
                $procecution["date"]=$row["date"];
                $procecution["value"]=$row["value"];
                $procecution["name"]=$row["name"];
                $procecution["address"]=$row["address"];
                }
            }
        
            return $procecution;
        }
    
        function get_discount_info($procecution_id , $conn){
        
        $discount=array();
        $sql="SELECT name,number,address,notes FROM discounts where procecution_id=$procecution_id ;";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
            $msg="Error while getting discount  info";
        }
        else{
             while($row = $result->fetch_assoc()) {
                $discount["name"]=$row["name"];
                $discount["number"]=$row["number"];
                $discount["address"]=$row["address"];
                $discount["notes"]=$row["notes"];
                }
            }
        
            return $discount;
        }
        function get_discount_agent_info($procecution_id , $conn){
        
        $discount_agent=array();
        $sql="SELECT name,number,address,notes FROM discount_agent where procecution_id=$procecution_id ;";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
            $msg="Error while getting discount agent info";
        }
        else{
             while($row = $result->fetch_assoc()) {
                $discount_agent["name"]=$row["name"];
                $discount_agent["number"]=$row["number"];
                $discount_agent["address"]=$row["address"];
                $discount_agent["notes"]=$row["notes"];
                }
            }
        
            return $discount_agent;
        }
    
