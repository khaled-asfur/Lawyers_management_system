<?php
session_start();
include_once("../php/DBConnect.php");


function change_office_name($office_id , $new_name ,$conn){
    $res=0;
    
           $sql = "update offices set name=\"$new_name\" where id =$office_id;";
           if ($conn->query($sql) === TRUE) {
            $_SESSION["office_name"]=$new_name;
               return 1;
           } else {
              return 0;
           }
}
    function get_user_password($user_id,$conn){
        $password=-1;

            $sql="SELECT password FROM users where id = $user_id;";
            $result=$conn->query($sql);
            if ($result->num_rows > 0) {
             while($row = $result->fetch_assoc()) {
                $password=$row["password"];

             }
             }
             return $password;
            
    }
    function change_password($user_id , $new_password ,$conn){
        $res=0;
 
        $sql = "update users set password=\"$new_password\" where id=$user_id";
        
        if ($conn->query($sql) === TRUE) {
            return 1;
        } else {
           return 0;
        }

        
   }
   if($_SERVER["REQUEST_METHOD"]=="POST"){
        $operation=$_POST["operation"];

        //تعديل بيانات الزبون .. الجاهز منها اسم المكتب 
        if($operation=="change_user_settings"){
            $result["message"]="nothing";
            $conn = DBConnect::getConnection();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            $office_id=$_SESSION["office_id"];$office_name=$_POST["office_name"];
           if(change_office_name($office_id , $office_name ,$conn) ==1)
                $result["message"]="office name updated";
            else
                $result["message"]="office name did`t updated";

            DBConnect::closeConnection();
            echo json_encode($result);
        }


        if($operation=="change_user_pass"){
            $result["message"]="nothing";
            $old_pass=$_POST["old_pass"];
            $new_pass=$_POST["new_pass"];
            $confirm_pass=$_POST["confirm_pass"];

            $conn = DBConnect::getConnection();
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $user_id= $_SESSION["user_id"];
            $db_current_pass=get_user_password($user_id,$conn);
            if($db_current_pass != $old_pass){
                $result["message"]="كلمة السر غير صحيحة";
            }
            else if($new_pass !== $confirm_pass){
                $result["message"]="كلمتا السر غير متطابقتان ";
            }else{
                if(change_password($user_id , $new_pass ,$conn)==1){
                    $result["message"]="تم تعديل كلمة السر";
                }
            }
            DBConnect::closeConnection();
            echo json_encode($result);
        }

}