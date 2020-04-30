<?php
	include('Functions/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
</head>
<body>
  <div class="container-fluid" style="padding-top:20px; padding-bottom:100px">
        <input type="text" class="form-control" id="js-search" placeholder="ค้นหา....">
        <table class="table table-striped table-hover table-bordered js-table" id="myTable">
        <thead class="thead-dark js-thead">
          <tr align="center">
            <th scope="col">#</th>
            <th scope="col">ID</th>
            <th scope="col">ชื่อพนักงาน</th>
            <th scope="col">วันปฏิบัติงาน</th>
            <th scope="col">Seat</th>
            <th scope="col">ประเภทการลา</th>
            <th scope="col">ประเภทคำขอ</th>
            <th scope="col">หมายเหตุ</th>
            <th scope="col"></th>
            <th scope="col">ID</th>
            <th scope="col">ผู้ปฏิบัติงานแทน</th>
            <th scope="col">วันปฏิบัติงาน</th>
            <th scope="col">Seat</th>
            <th scope="col">สถานะ</th>
          </tr>
        </thead>
        <tbody>
            <?php
            /*แสดงทั้งหมด
            $swapQry = "SELECT * FROM swap ORDER BY c_id desc";
            $qry = mysqli_query($db, $swapQry); */

            //เลือกแสดงผลจาก status Pending
            $swapQry = "SELECT * FROM swap WHERE c_status='Approve' ORDER BY c_id desc";
            $qry = mysqli_query($db, $swapQry);

            $i = 1; // รันเลขหน้าตาราง
            while ($row = mysqli_fetch_array($qry)) {
            echo "<tr align='center'>";
            echo "<td>".$i."</td>";
            echo "<td>".$row["c_code_host"]."</td>";
            echo "<td>".$row["c_name_host"]."</td>";
            echo "<td>".$row["c_date_host"]."</td>";
            echo "<td>".$row["c_seat_host"]."</td>";
            echo "<td>".$row["c_label"]."</td>";
            echo "<td>".$row["c_labelmain"]."</td>";
            echo "<td>".$row["c_remark"]."</td>";
            echo "<td><img src=\"images/swap2.png\"></td>";
            echo "<td>".$row["c_code_visit"]."</td>";
            echo "<td>".$row["c_name_visit"]."</td>";
            echo "<td>".$row["c_date_visit"]."</td>";
            echo "<td>".$row["c_seat_visit"]."</td>";
            echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
            echo "</tr>";
            $i++;
            }
            ?>
        </tbody>
      </table>
    </div>
</div>
<div><iframe src="credit.html" width="100%" frameBorder="0"></iframe></div>

<script src="js/jquery.js"></script>
<script type="text/javascript" src="js/search.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
