<?php 
$id=$_GET["session_id"];
include_once($_SERVER['DOCUMENT_ROOT']."/lawyers/"."php/classes/Client.php");
$path=Client::get_path();
include_once($path."php/DBConnect.php");
//if($_SERVER["REQUEST_METHOD"]=="POST"){
    $conn = DBConnect::getConnection();
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 
    $sql = "DELETE FROM `sessions` WHERE id = $id";
  
    if ($conn->query($sql) === TRUE) {
      echo "deleted";
    } else {
        echo "Error while  deleting record: " . $conn->error;
    }
    
    $conn->close();
    ?>
