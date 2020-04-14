<?php
$db = mysqli_connect('localhost', 'root', 'toor', 'shift');


$c_id = mysqli_real_escape_string($db,$_GET['c_id']);


$sql = "SELECT * FROM swap WHERE c_id='$c_id' ";
$qry = mysqli_query($db, $sql);
while ($qryname = mysqli_fetch_array($qry)) {
  $codeHost = $qryname["c_code_host"];
  $dateHost = $qryname["c_date_host"];
  $seatHost = $qryname["c_seat_host"];

  $codeVisit = $qryname["c_code_visit"];
  $dateVisit = $qryname["c_date_visit"];
  $seatVisit = $qryname["c_seat_visit"];


  $updatewdayVisit = "INSERT INTO work (w_code, w_date, w_type) VALUES ('$codeVisit', '$dateHost', '$seatHost')";
  mysqli_query($db, $updatewdayVisit);

  $updatewdayHost = "UPDATE work SET w_type = '$seatVisit' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
  mysqli_query($db, $updatewdayHost);

  $updateSwap = "UPDATE swap SET c_status ='Approve', c_badge='success' WHERE c_id='$c_id' ";
  mysqli_query($db, $updateSwap);

  header('location: home.php');
}


 ?>
