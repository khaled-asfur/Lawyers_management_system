<?php

//fetch.php
session_start();
   include_once("../php/DBConnect.php");
if(isset($_SESSION['show_user_page'])&&$_SESSION['show_user_page']==1){
 $connect = DBConnect::getConnection();
$columns = array('users.name', 'phone_number');

$query = "SELECT users.id,users.name,phone_number,email,customers_page,sessions_page,financial_page,users_page,ended_procecutions FROM users  join offices join privilages ON office_id=offices.ID and users.id=privilages.user_id and office_id=".$_SESSION['office_id'];

$data ;
if(isset($_POST['checked'])&&$_POST['checked']==1){
 $query = "SELECT * FROM  privilages  where user_id = ".$_POST['id']. "";
 $result = mysqli_query($connect, $query );
 while($row = mysqli_fetch_array($result))
{
 $data = array(
                    
                   $row["customers_page"],
                    $row["sessions_page"],
                   $row["financial_page"],
                  $row["users_page"],
                  $row["ended_procecutions"],
                  $row["reminds_page"]
                    );
 }
echo json_encode($data);
}
else{
if(isset($_POST["search"]["value"]))
{
   
 $query .= '
 WHERE users.name LIKE "%'.$_POST["search"]["value"].'%" 
 OR phone_number LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
if(isset($_POST['checked'])&&$_POST['checked']==1){
 while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 
	$sub_array[] = ' <input type="checkbox" class="A1" id='.$row["id"].' checked='.$row["customers_page"].'"> <span class="checkmark"></span> ' ;
 	$sub_array[] = ' <input type="checkbox" class="A2" id='.$row["id"].' checked='.$row["sessions_page"].'"> <span class="checkmark"></span> ' ;
  	$sub_array[] = ' <input type="checkbox" class="A3" id='.$row["id"].' checked='.$row["financial_page"].'"> <span class="checkmark"></span> ' ;
   	$sub_array[] = ' <input type="checkbox" class="A4" id='.$row["id"].' checked='.$row["users_page"].'"> <span class="checkmark"></span> ' ;
   $sub_array[] = ' <input type="checkbox" class="A4" id='.$row["id"].' checked='.$row["ended_procecutions"].'"> <span class="checkmark"></span> ' ;
 $sub_array[] = ' <input type="checkbox" class="A4" id='.$row["id"].' checked='.$row["reminds_page"].'"> <span class="checkmark"></span> ' ;
 $data[] = $sub_array;
 }
}
while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div  id="editor" contenteditable ="true"class="update" data-id="'.$row["id"].'" data-column="name">' . $row["name"] . '</div>';
	$sub_array[] = '<div  id="editor" contenteditable="true" class="update" data-id="'.$row["id"].'" data-column="phone_number">' . $row["phone_number"] . '</div>';
	$sub_array[] = '<div  id="editor" contenteditable ="true"class="update" data-id="'.$row["id"].'" data-column="email">' . $row["email"] . '</div>';
 $sub_array[] = '<button type="button" class="btn btn-primary  btn-xs edit-button " id="'.$row["id"].'">Edit</button> <button type="button" name="delete" class="btn btn-info  btn-xs view-button" id="'.$row["id"].'">View</button> <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
 $data[] = $sub_array;
}

function get_all_data($connect)
{
 $query = "SELECT * FROM users  join offices join privilages ON office_id=offices.ID and users.id=privilages.user_id ";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);
}
}

else if(isset($_SESSION['show_financial_page'])&&$_SESSION['show_financial_page']==1){
 $connect = DBConnect::getConnection();
$columns = array('users.name', 'phone_number');

$query = "SELECT fees.id,fees.paid,payment_mechanism,fees.procecution_id,procecution_number,customers.name,customers.identity_number FROM fees  join procecutions join customers ON procecution_id=procecutions.id and procecutions.ended=0 and customer_id=customers.id and office_id=".$_SESSION['office_id'];

$data =array();

if(isset($_POST['type'])&&$_POST['type']=='view-check'){
 
 $query = "SELECT * FROM checks  where fees_id = ".$_POST['id']. "";
 
$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));
 $result = mysqli_query($connect, $query );
 while($row = mysqli_fetch_array($result))
{$sub_array = array();

	$sub_array[] = '<div  id="editor" contenteditable="true" class="update" data-id="'.$row["id"].'" data-column="check_owner">' . $row["check_owner"] . '</div>';
 	$sub_array[] = '<div   id="editor" contenteditable="true" class="update" data-id="'.$row["id"].'" data-column="value">' . $row["value"] . '</div>';
  $sub_array[] = '<input  id="editor" contenteditable="true" type="date"  class="update" id="pdate'.$row["id"].'" data-id="'.$row["id"].'" data-column="date" value ="' . $row["date"] . '" />';
	$sub_array[] = '<input   id="editor" contenteditable="true" type="date" class="update" id="rdate'.$row["id"].'" data-id="'.$row["id"].'" data-column="check_remind_date" value ="' . $row["check_remind_date"] . '" />';
 
 $sub_array[] = ' <button type="button" name="delete" class="btn btn-danger btn-xs check-delete" id="'.$row["id"].'">Delete</button>';
 $data[] = $sub_array;
 }
function get_all_data2($connect)
{
 $query = "SELECT * FROM checks  where fees_id = ".$_POST['id']. "";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data2($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);
}



else if(isset($_POST['type'])&&$_POST['type']=='view-prem'){
$query = "SELECT * FROM installments where fees_id=".$_POST['id']. "";

$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));
 $result = mysqli_query($connect, $query );

 while($row = mysqli_fetch_array($result))
{$sub_array = array();


 	$sub_array[] = '<div  id="editor" contenteditable ="true"class="update" data-id="'.$row["id"].'" data-column="value">' . $row["value"] . '</div>';
  $sub_array[] = '<input  id="editor" contenteditable ="true"type="date" id="pdate" class="update" data-id="'.$row["id"].'" data-column="date" value ="' . $row["date"] . '" />';
	$sub_array[] = '<input  id="editor" contenteditable ="true" type="date" id="rdate"class="update" data-id="'.$row["id"].'" data-column="remind_date" value ="' . $row["remind_date"] . '" />';
 $sub_array[] = ' <button type="button" name="delete" class="btn btn-danger btn-xs prem-delete" id="'.$row["id"].'">Delete</button>';
 $data[] = $sub_array;
 }
function get_all_data2($connect)
{
 $query = "SELECT * FROM  installments where fees_id= ".$_POST['id']. "";
 
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data2($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);
}
else{
if(isset($_POST["search"]["value"]))
{
 $query .= '
 WHERE procecution_number LIKE "%'.$_POST["search"]["value"].'%" 
 OR customers.name LIKE "%'.$_POST["search"]["value"].'%"
 OR customers.identity_number LIKE "%'.$_POST["search"]["value"].'%" 
 ';
}

if(isset($_POST["order"]))
{
 $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' 
 ';
}
else
{
 $query .= 'ORDER BY id DESC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}
$number_filter_row = mysqli_num_rows(mysqli_query($connect, $query));

$result = mysqli_query($connect, $query . $query1);

$data = array();
while($row = mysqli_fetch_array($result))
{
 $sub_array = array();
 $sub_array[] = '<div  class="update" data-id="'.$row["id"].'" data-column="name">' . $row["procecution_number"] . '</div>';
	$sub_array[] = '<div  id="editor" contenteditable ="true" name="fees" class="update" data-id="'.$row["id"].'" data-column="payment_mechanism">' . $row["payment_mechanism"] . '</div>';
 if($row['paid']==0)
 	$sub_array[] = '<input type="checkbox"  data-column="paid" name="fees" class="update" id='.$row["id"].'  > <span class="checkmark"></span> ' ;
  else
  $sub_array[] = '<input type="checkbox"  data-column="paid" name="fees" class="update" id='.$row["id"].' checked="checked" > <span class="checkmark"></span> ' ;
 $sub_array[] = ' <button type="button" name="view-'.$row["payment_mechanism"].'" class="btn btn-info  btn-xs view-button" id="'.$row["id"].'">View</button> <button type="button" name="delete" class="btn btn-danger btn-xs delete" id="'.$row["id"].'">Delete</button>';
 $data[] = $sub_array;
 
}

function get_all_data2($connect)
{
 $query = "SELECT * from fees  join procecutions ON procecution_id=procecutions.id  ";
 $result = mysqli_query($connect, $query);
 return mysqli_num_rows($result);
}

$output = array(
 "draw"    => intval($_POST["draw"]),
 "recordsTotal"  =>  get_all_data2($connect),
 "recordsFiltered" => $number_filter_row,
 "data"    => $data
);

echo json_encode($output);
}

}




?>