<?php
$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

//หากมีการอัพเดตชื่อพนักงานใหม่ให้ไปใช้คำสั่งนี้ใน mysql แมนนวลไปก่อนยังไม่ได้ทำหน้า query ใหม่
//โดยให้ล้างข้อมูลออกให้หมดแล้ว INSERT ใหม่
//DELETE FROM stat_all
//INSERT INTO stat_all (s_code, s_name) SELECT username, user_name FROM users WHERE shift IN ('A','B','C','D')
//DELETE FROM stat_month
//INSERT INTO stat_month (s_code, s_name) SELECT username, user_name FROM users WHERE shift IN ('A','B','C','D')

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

$CountOTDay = $qc1 + $qc2;

$SQL3 = "UPDATE stat_all SET stat_all.s_od='$CountOTDay' WHERE s_code='$member'";
$qry3 = mysqli_query($db, $SQL3);

$SQL4 = "UPDATE stat_all SET stat_all.s_on=(SELECT COUNT(w_type) FROM work WHERE w_code='$member' AND w_type LIKE 'ON' AND w_date LIKE '2020%') WHERE s_code='$member'";
$qry4 = mysqli_query($db, $SQL4);

}
?>
