<?php
$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

//หากมีการอัพเดตชื่อพนักงานใหม่ให้ไปใช้คำสั่งนี้ใน mysql แมนนวลไปก่อนยังไม่ได้ทำหน้า query ใหม่
//โดยให้ล้างข้อมูลออกให้หมดแล้ว INSERT ใหม่
//DELETE FROM stat_all
//INSERT INTO stat_all (s_code, s_name) SELECT username, user_name FROM users WHERE shift IN ('A','B','C','D')
//DELETE FROM stat_ot_month
//INSERT INTO stat_ot_month (s_code, s_name) SELECT username, user_name FROM users WHERE shift IN ('A','B','C','D')


//Update times
$time = strtotime("Now");
$SQL = "UPDATE stat_all SET s_remark = '$time' WHERE stat_all.id = 1";
$qry = mysqli_query($db, $SQL);

// query OT
$SQL = "SELECT username FROM users WHERE username AND shift IN ('A','B','C','D') ORDER BY shift , remark";
$qry = mysqli_query($db, $SQL);
while($qrymember = mysqli_fetch_array($qry)){
  $member = $qrymember["username"];

$SQL2 = "UPDATE stat_all SET stat_all.s_otall=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020%') WHERE s_code='$member'";
$qry2 = mysqli_query($db, $SQL2);


$count1 = "SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'OB%' AND w_date LIKE '2020%'";
$Cqry1 = mysqli_query($db, $count1);
while($C1 = mysqli_fetch_array($Cqry1)){
  $qc1 = $C1['COUNT(w_type)'];
}

$count2 = "SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'OT%' AND w_date LIKE '2020%'";
$Cqry2 = mysqli_query($db, $count2);
while($C2 = mysqli_fetch_array($Cqry2)){
  $qc2 = $C2['COUNT(w_type)'];
}

$count3 = "SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'OD%' AND w_date LIKE '2020%'";
$Cqry3 = mysqli_query($db, $count3);
while($C3 = mysqli_fetch_array($Cqry3)){
  $qc3 = $C3['COUNT(w_type)'];
}

$CountOTDay = $qc1 + $qc2 + $qc3;

$SQL3 = "UPDATE stat_all SET stat_all.s_od='$CountOTDay' WHERE s_code='$member'";
$qry3 = mysqli_query($db, $SQL3);

$SQL4 = "UPDATE stat_all SET stat_all.s_on=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'ON' AND w_date LIKE '2020%') WHERE s_code='$member'";
$qry4 = mysqli_query($db, $SQL4);


// query OT month
$JAN = "UPDATE stat_ot_month SET stat_ot_month.01=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-01%') WHERE s_code='$member'";
$qryJAN = mysqli_query($db, $JAN);

$FEB = "UPDATE stat_ot_month SET stat_ot_month.02=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-02%') WHERE s_code='$member'";
$qryFEB = mysqli_query($db, $FEB);

$MAR = "UPDATE stat_ot_month SET stat_ot_month.03=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-03%') WHERE s_code='$member'";
$qryMAR = mysqli_query($db, $MAR);

$APR = "UPDATE stat_ot_month SET stat_ot_month.04=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-04%') WHERE s_code='$member'";
$qryAPR = mysqli_query($db, $APR);

$MAY = "UPDATE stat_ot_month SET stat_ot_month.05=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-05%') WHERE s_code='$member'";
$qryMAY = mysqli_query($db, $MAY);

$JUN = "UPDATE stat_ot_month SET stat_ot_month.06=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-06%') WHERE s_code='$member'";
$qryJUN = mysqli_query($db, $JUN);

$JUL = "UPDATE stat_ot_month SET stat_ot_month.07=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-07%') WHERE s_code='$member'";
$qryJUL = mysqli_query($db, $JUL);

$AUG = "UPDATE stat_ot_month SET stat_ot_month.08=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-08%') WHERE s_code='$member'";
$qryAUG = mysqli_query($db, $AUG);

$SEP = "UPDATE stat_ot_month SET stat_ot_month.09=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-09%') WHERE s_code='$member'";
$qrySEP = mysqli_query($db, $SEP);

$OCT = "UPDATE stat_ot_month SET stat_ot_month.10=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-10%') WHERE s_code='$member'";
$qryOCT = mysqli_query($db, $OCT);

$NOV = "UPDATE stat_ot_month SET stat_ot_month.11=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-11%') WHERE s_code='$member'";
$qryNOV = mysqli_query($db, $NOV);

$DEC = "UPDATE stat_ot_month SET stat_ot_month.12=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'O%' AND w_date LIKE '2020-12%') WHERE s_code='$member'";
$qryDEC = mysqli_query($db, $DEC);



// query holiday
$Sick = "UPDATE stat_all SET stat_all.s_sick=(SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลาป่วย%' AND c_date_host LIKE '2020%') WHERE s_code='$member'";
$qry5 = mysqli_query($db, $Sick);


$Holiday = "UPDATE stat_all SET stat_all.s_holiday=(SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลาพักผ่อน%' AND c_date_host LIKE '2020%') WHERE s_code='$member'";
$qry6 = mysqli_query($db, $Holiday);


$Bussi = "UPDATE stat_all SET stat_all.s_bussiness=(SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลากิจ%' AND c_date_host LIKE '2020%') WHERE s_code='$member'";
$qry7 = mysqli_query($db, $Bussi);


$Marrie= "UPDATE stat_all SET stat_all.s_married=(SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลาสมรส%' AND c_date_host LIKE '2020%') WHERE s_code='$member'";
$qry8 = mysqli_query($db, $Marrie);


$Other= "UPDATE stat_all SET stat_all.s_other=(SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label IN ('ลาคลอด','ลาบวช') AND c_date_host LIKE '2020%') WHERE s_code='$member'";
$qry9 = mysqli_query($db, $Other);


//SELECT data to Sum
$SumLeave1 = "SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลาป่วย%' AND c_date_host LIKE '2020%'";
$qryLeave = mysqli_query($db, $SumLeave1);
while($S1 = mysqli_fetch_array($qryLeave)){
  $S_sick = $S1['COUNT(c_label)'];
}

$SumLeave2 = "SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลาพักผ่อน%' AND c_date_host LIKE '2020%'";
$qryLeave = mysqli_query($db, $SumLeave2);
while($S2 = mysqli_fetch_array($qryLeave)){
  $S_holi = $S2['COUNT(c_label)'];
}

$SumLeave3 = "SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลากิจ%' AND c_date_host LIKE '2020%'";
$qryLeave = mysqli_query($db, $SumLeave3);
while($S3 = mysqli_fetch_array($qryLeave)){
  $S_bussi = $S3['COUNT(c_label)'];
}

$SumLeave4 = "SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label LIKE 'ลาสมรส%' AND c_date_host LIKE '2020%'";
$qryLeave = mysqli_query($db, $SumLeave4);
while($S4 = mysqli_fetch_array($qryLeave)){
  $S_marr = $S4['COUNT(c_label)'];
}

$SumLeave5 = "SELECT COUNT(c_label) FROM swap WHERE c_code_host='$member' AND c_label IN ('ลาคลอด','ลาบวช') AND c_date_host LIKE '2020%'";
$qryLeave = mysqli_query($db, $SumLeave5);
while($S5 = mysqli_fetch_array($qryLeave)){
  $S_oth = $S5['COUNT(c_label)'];
}

//Sum all leave
$CountLeave = $S_sick + $S_holi + $S_bussi + $S_marr + $S_oth;

$AllLeave= "UPDATE stat_all SET stat_all.s_sum='$CountLeave' WHERE s_code='$member'";
$qry10 = mysqli_query($db, $AllLeave);

header("location:../stats.php");
}

?>
