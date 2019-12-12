<?php 
        session_start();
        include("../DBConnect.php");
        $conn = DBConnect::getConnection();
        $procecution_numbers=array();
       
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $office_id=$_SESSION["office_id"];
        $sql="SELECT procecution_number FROM procecutions where customer_id in(select id from customers where office_id= $office_id) and ended = 0  ;";
        //echo "<br>".$sql."<br>";
        $result=$conn->query($sql);
        if ($result->num_rows ==0 ){ 
           // echo "لا يوجد مستخدم يحمل نفس رقم القضية ";
        }
        else{
            while($row = $result->fetch_assoc()) {
                  $procecution_numbers[]=$row;        
            }
        }
        $myJSON = json_encode($procecution_numbers);
         echo($myJSON);
?>