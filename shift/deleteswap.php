<?php

$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

$Cid = $_REQUEST["c_id"];

$selectSeat = "SELECT c_seat_host,c_code_host,c_date_host FROM swap WHERE c_id = '$Cid'";
$qry = mysqli_query($db, $selectSeat);
while ($qryseat = mysqli_fetch_array($qry)) {
	$seat = $qryseat["c_seat_host"];
	$codeHost = $qryseat["c_code_host"];
	$dateHost = $qryseat["c_date_host"];
}

$updateTable = "UPDATE work SET w_type = '$seat' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
mysqli_query($db, $updateTable);

echo $seat;
//ลบข้อมูลออกจาก database ตาม id ที่ส่งมา
$sql = "DELETE FROM swap WHERE c_id='$Cid' ";
$result = mysqli_query($db, $sql) or die ("Error in query: $sql " . mysqli_error());

header('location: index.php');

?>
