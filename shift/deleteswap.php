<?php

$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

$Cid = $_REQUEST["c_id"];

$selectSeat = "SELECT * FROM swap WHERE c_id = '$Cid'";
$qry = mysqli_query($db, $selectSeat);
while ($qrydata = mysqli_fetch_array($qry)) {
	$codeHost = $qrydata["c_code_host"];
	$dateHost = $qrydata["c_date_host"];
	$codeVisit = $qrydata["c_code_visit"];
	$dateVisit = $qrydata["c_date_visit"];
	$statusHost = $qrydata["c_seat_stahost"];
	$statusVisit = $qrydata["c_seat_stavisit"];

$updateStatus = "UPDATE work SET w_status = '$statusHost' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
mysqli_query($db, $updateStatus);

$updateStatus2 = "UPDATE work SET w_status = '$statusVisit' WHERE w_code = '$codeVisit' AND w_date ='$dateVisit'";
mysqli_query($db, $updateStatus2);

echo $seat;
//ลบข้อมูลออกจาก database ตาม id ที่ส่งมา
$sql = "DELETE FROM swap WHERE c_id='$Cid' ";
$result = mysqli_query($db, $sql) or die ("Error in query: $sql " . mysqli_error());

header('location: index.php');

}

?>
