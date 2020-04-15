<?php
$db = mysqli_connect('localhost', 'root', 'toor', 'shift');


$c_id = mysqli_real_escape_string($db,$_GET['c_id']);


$sql = "SELECT * FROM swap WHERE c_id='$c_id' ";
$qry = mysqli_query($db, $sql);
while ($qrydata = mysqli_fetch_array($qry)) {
  $codeHost = $qrydata["c_code_host"];
  $dateHost = $qrydata["c_date_host"];
  $seatHost = $qrydata["c_seat_host"];
  $codeVisit = $qrydata["c_code_visit"];
  $dateVisit = $qrydata["c_date_visit"];
  $statusHost = $qrydata["c_seat_stahost"];
	$statusVisit = $qrydata["c_seat_stavisit"];


  $updateStatus = "UPDATE work SET w_status = '$statusHost' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
  mysqli_query($db, $updateStatus);

  $updateStatus2 = "UPDATE work SET w_status = '$statusVisit' WHERE w_code = '$codeVisit' AND w_date ='$dateVisit'";
  mysqli_query($db, $updateStatus2);

  $updateSwap = "UPDATE swap SET c_status ='Cancel', c_badge='danger' WHERE c_id='$c_id' ";
  mysqli_query($db, $updateSwap);

  header('location: home.php');

}


 ?>
