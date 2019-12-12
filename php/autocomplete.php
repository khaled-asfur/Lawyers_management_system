<?php
session_start();
include_once("../php/DBConnect.php");

if(isset( $_POST['input2'])) {
	$input = $_POST['input2'];
	$connect = DBConnect::getConnection();
$columns = array('users.name', 'phone_number');
mysqli_set_charset($connect,"utf8");
 $query= 'SELECT identity_number FROM customers  join offices  ON office_id=offices.ID and offices.ID='.$_SESSION['office_id'].' WHERE identity_number LIKE "%'.$input.'%" OR  customers.name LIKE "%'.$input.'%"';

   $matchString = mysqli_query($connect, $query );

	if (!empty($matchString)) { // If not empty list
		echo '<ul id="matchList">'; // Create UL list
			foreach($matchString as $matchString) { // Loops
				$matchStringBold = preg_replace('/('.$input.')/i', '<strong>$1</strong>', isset($matchString['identity_number'])?$matchString['identity_number']:$matchString['id']); // Replace text field input by bold one
			      // Create the matching list - we put maching name in the ID too
			      if(isset($matchString['name'])){
			       echo '<li id="'.$matchString['identity_number'].'"> <a href="#">'.	$matchStringBold.'</a></li>';}
			       else
			       echo '<li id="'.$matchString['identity_number'].'"><a href="#">'.	$matchStringBold.'</a></li>';
			}
		echo '</ul>';
	}
}
else if($_POST&&isset( $_POST['input2'])) {
	$input = $_POST['input2'];
	$connect = mysqli_connect($servername,$username,$password,$dbname);
$columns = array('users.name', 'phone_number');

 $query= 'SELECT procecution_id FROM fees WHERE users.id LIKE "%'.$input.'%" ';
	  $matchString = mysqli_query($connect, $query );

	if (!empty($matchString)) { // If not empty list
		echo '<ul id="matchList2">'; // Create UL list
			foreach($matchString as $matchString) { // Loops
				$matchStringBold = preg_replace('/('.$input.')/i', '<strong>$1</strong>', $matchString['procecution_id']); // Replace text field input by bold one
				echo '<li id="'.$matchString['procecution_id'].'">'.$matchStringBold.'</li>'; // Create the matching list - we put maching name in the ID too
			}
		echo '</ul>';
	}
}
?>