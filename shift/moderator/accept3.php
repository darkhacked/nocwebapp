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

  $color = "#00ff00";

  $updatewdayHost = "UPDATE work SET w_type ='$seatVisit', w_status='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
  mysqli_query($db, $updatewdayHost);

  $updatewdayVisit = "UPDATE work SET w_type = '$seatHost', w_status='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateVisit'";
  mysqli_query($db, $updatewdayVisit);

  $updateSwap = "UPDATE swap SET c_status ='Approve', c_badge='success' WHERE c_id='$c_id' ";
  mysqli_query($db, $updateSwap);

  header('location: home.php');
}


 ?>
