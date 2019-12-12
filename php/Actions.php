<?php
session_start();
include_once("../php/DBConnect.php");

 if(isset($_SESSION['show_user_page'])&&$_SESSION['show_user_page']==1){
$connect = DBConnect::getConnection();
if(isset($_POST["id"])&&$_POST['action']=='delete')
{
 $query = "DELETE FROM users  WHERE id = '".$_POST["id"]."'";
 
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}

else if(isset($_POST["id"])&&isset($_POST["checked"])&&$_POST['checked']=='1')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = " UPDATE privilages  SET ".$_POST["column_name"]." = ".$value." WHERE user_id = ".$_POST["id"]."";
 if(!mysqli_query($connect, $query))
 {
  echo $_POST["column_name"];
  echo "erro 107";
 }else 
 echo 'done';
}

else if(isset($_POST["id"])&&$_POST['action']=='update')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = "UPDATE users  SET ".$_POST["column_name"]."='".$value."' WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data Updated';
 }
}

else if (isset($_POST["name"], $_POST["phone_num"], $_POST["email"])&&$_POST['action']=='insert')
{
   	$image = $_FILES['image']['name'];


    	$target = "image/".basename($image);

    session_start();
 $first_name = mysqli_real_escape_string($connect, $_POST["name"]);
 $phone_number = mysqli_real_escape_string($connect, $_POST["phone_number"]);
 $email = mysqli_real_escape_string($connect, $_POST["email"]);
 $password = mysqli_real_escape_string($connect, $_POST["password"]);
 $office_id=$_SESSION['office_id'];
 $query = "INSERT INTO users (name,phone_number,email,profile_picture_url,office_id,password)  VALUES('$first_name', '$phone_number','$email','$image','$office_id','$password');";
 if(mysqli_query($connect, $query))
 {
    $nextId=mysqli_fetch_array(mysqli_query($connect,'SELECT MAX(Id)  FROM users'))['0'];
   $query2=" INSERT INTO privilages (user_id)  VALUES('$nextId')";
   if(mysqli_query($connect, $query2)){
       if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
  	echo "Image uploaded successfully";
  	}else{
  		echo  "Failed to upload image";
  	}
    echo 'data insert';
   }
 }
 else
 echo 'error 107 ';
 mysqli_close($connect);
}
else if(isset($_POST["id"])&&$_POST['action']=='delete_check')
{
 $query = "DELETE FROM checks  WHERE id = '".$_POST["id"]."'";
 
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}

else if(isset($_POST["id"])&&$_POST['action']=='updatee' && $_POST['type']=='view-check')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = "UPDATE checks  SET ".$_POST["column_name"]." = '".$value."' WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  echo 'Data updated';
 }else{
  echo 'error 101';
 }
}
else if(isset($_POST["id"])&&$_POST['action']=='updatee' &&$_POST['type']=='fees')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query='';
ECHO $value;
 if($value=="check"||$value=="installment"||$value=="chase"||$value=='true'||$value=='false'){
  if ($value=='false')
 $value=0;
 else if($value=='true')
 $value=1;
 $query .= "UPDATE fees  SET ".$_POST["column_name"]." = '$value' WHERE id = '".$_POST["id"]."'";
 }
  if(mysqli_query($connect, $query))
 {
  echo 'done';
 }else{
  echo 'error 101' ;
 }
}



else
echo "erro 105";
 }
 
else if(isset($_SESSION['show_financial_page'])&&$_SESSION['show_financial_page']==1){
 
 $connect = DBConnect::getConnection();
if(isset($_POST["id"])&&$_POST['action']=='delete'&&$_POST['del']=='prem')
{
 $query = "DELETE FROM installments  WHERE id = '".$_POST["id"]."'";
 
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}
if(isset($_POST["id"])&&$_POST['action']=='delete'&&$_POST['del']=='check')
{
 $query = "DELETE FROM checks  WHERE id = '".$_POST["id"]."'";
 
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}


if(isset($_POST["id"])&&$_POST['action']=='delete'&&$_POST['del']=='gen')
{
 $query = "DELETE FROM fees  WHERE id = '".$_POST["id"]."'";
 
 if(mysqli_query($connect, $query))
 {
  echo 'Data Deleted';
 }
}



else if(isset($_POST["id"])&&$_POST['action']=='update' && $_POST['type']=='view-prim')
{
 
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = "UPDATE installments  SET ".$_POST["column_name"]." = '"."$value"."' WHERE id = '".$_POST["id"]."'";

 if(mysqli_query($connect, $query))
 {
  
  echo 'Data updated';
 }else{
   
  echo 'error 101';
 }
}

 
 
 
else if(isset($_POST["id"])&&$_POST['action']=='update' && $_POST['type']=='view-check')
{
 $value = mysqli_real_escape_string($connect, $_POST["value"]);
 $query = "UPDATE checks  SET ".$_POST["column_name"]." = '".$value."' WHERE id = '".$_POST["id"]."'";
 if(mysqli_query($connect, $query))
 {
  
  echo 'Data updated';
 }else{
  
  echo 'error 102';
 }
}

 
 
 
 
 
 }


?>
