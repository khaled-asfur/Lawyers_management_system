<?php
include("../DBConnect.php");
$conn = DBConnect::getConnection();
$query="(select distinct name from customers  order by 1)union(select distinct concat(identity_number , '') from customers order by 1);";
$result = $conn->query('SET CHARACTER SET utf8');
$result = $conn->query($query) or die($mysqli->error.__LINE__);

$arr = array();
if($result->num_rows > 0) {
	while($row = $result->fetch_assoc()) {
		$arr[] = $row;	
	}
}


# JSON-encode the response
echo $json_response = json_encode($arr);
?>