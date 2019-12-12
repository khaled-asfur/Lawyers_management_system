<?php 
session_start();
include_once("classes/Client.php");
include_once("DBConnect.php");

if(isset($_POST)&&$_SERVER["REQUEST_METHOD"]=="POST"){
   
    
   $proc_id=$_POST['search-proc'];
     $conn= DBConnect::getConnection();
    $sql="select procecutions.id from  procecutions join customers on customer_id=customers.id where office_id=".$_SESSION['office_id'];
  
       $result=$conn->query($sql);
           $fees_id=$result->fetch_assoc();
    
     $proc_id=$fees_id['id'];
    $type=$_POST['groupTypeFinancial'];
     
    $type=$_POST['groupTypeFinancial'];
    
    
    
   if($type=='money'){
     $conn= DBConnect::getConnection();
        if($conn->connect_error){
            die("Connection failed: " );
        }
        else{
            $sql="INSERT INTO fees (paid,payment_mechanism,procecution_id) VALUES(1,'$type',$proc_id)";
            $conn->query($sql);
           $referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
        }
    
   }
   
   
   elseif($type=='prem'){
     $sql="select procecutions.id from  procecutions join customers on customer_id=customers.id where office_id=".$_SESSION['office_id'];
  
       $result=$conn->query($sql);
           $fees_id=$result->fetch_assoc();
    
     $proc_id=$fees_id['id'];
         $sql="select payment_mechanism from  fees where procecution_id='$proc_id'";
      $conn->query($sql);
       while($row = $result->fetch_assoc()) {
        if($row['payment_mechanism']=="prem"){
         $x="prem";
         break;
        }
        else
        $x=$row['payment_mechanism'];
        
    }
           if(!($x=="prem")){
         $sql="insert into fees (paid,payment_mechanism,procecution_id) VALUES(1,'$type',$proc_id) ";
    $conn->query($sql);
           }
    
    $sql="select id from  fees where procecution_id='$proc_id'and payment_mechanism ='prem'";
    
       $result=$conn->query($sql);
           $fees_id=$result->fetch_assoc();
   
      
    $prem_val =$_POST['prem-name'];
     $prem_date =$_POST['prem-date'];
    $prem_rem_date =$_POST['prem_rem_date'];
  
    foreach ($prem_val as $key => $value)
    
    if(isset($prem_val[$key],$prem_date[$key],$prem_rem_date[$key])){
        $sql='INSERT INTO installments (date,value,remind_date,fees_id) VALUES('."'$prem_date[$key]'".','. $value.','."'$prem_rem_date[$key]'".','.$fees_id['id'].')';
         
          $conn->query($sql);
 $referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
   
         
    }
   }
  
  
  
 
 
  elseif($type=='checks'){
      $sql="select payment_mechanism from  fees where procecution_id='$proc_id'";
      $conn->query($sql);
      $result=$conn->query($sql);
       while($row = $result->fetch_assoc()) {
        if($row['payment_mechanism']=="checks"){
         $x="checks";
         break;
        }
        else
        $x=$row['payment_mechanism'];
        
    }
           if(!($x=="checks")){
         $sql="insert into fees (paid,payment_mechanism,procecution_id) VALUES(1,'$type',$proc_id) ";
         echo $x;
    $conn->query($sql);}
    $sql="select id from  fees where procecution_id='$proc_id' and payment_mechanism ='checks'";
    
       $result=$conn->query($sql);
           $fees_id=$result->fetch_assoc();
    
     
    
    $check_name =$_POST['check-name'];
    
     $check_date =$_POST['check-date'];
    $check_time =$_POST['check-time'];
    $check_value =$_POST['check-value'];
    foreach($check_name as $key => $value)
    
    if(isset($check_name[$key],$check_date[$key],$check_time[$key],$check_value [$key])){
        $sql='INSERT INTO checks (date,check_owner,check_remind_date,fees_id,value) VALUES('."'$check_date[$key]'".', '."'$check_name[$key]'".','."'$check_time[$key]'".','.$fees_id['id'].','.$check_value[$key].')';
          $conn->query($sql);
   
    $referer = $_SERVER['HTTP_REFERER'];
header("Location: $referer");
         
    }
   
  

}
}
