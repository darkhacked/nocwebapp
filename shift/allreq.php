<?php
	include('Functions/functions.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script src="js/jquery.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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
						<th scope="col">สาเหตุการลา</th>
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
						//แสดงผล 100 ค่าต่อหน้า
						$perpage = 100;
							if (isset($_GET['page'])) {
							$page = $_GET['page'];
							} else {
							$page = 1;
							}

							$start = ($page - 1) * $perpage;

							$swapQry = "SELECT * FROM swap ORDER BY c_id desc limit {$start} , {$perpage}";
							$qry = mysqli_query($db, $swapQry);


						//เลือกแสดงผลทั้งหมด
            //$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
            //$qry = mysqli_query($db, $swapQry);


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
						echo "<td>".$row["c_reason"]."</td>";
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
			<!-- Pagination button-->
			<?php
			 $sql2 = "SELECT * FROM swap";
			 $query2 = mysqli_query($db, $sql2);
			 $total_record = mysqli_num_rows($query2);
			 $total_page = ceil($total_record / $perpage);
			 ?>

			 <nav>
				<ul class="pagination">
						<li class="page-item">
							<a class="page-link" href="allreq.php?page=1" aria-label="Previous">
								<span aria-hidden="true">&laquo;</span>
							</a>
						</li>
				<?php for($i=1;$i<=$total_page;$i++){ ?>
						<li class="page-item">
							<a class="page-link" href="allreq.php?page=<?php echo $i; ?>"><?php echo $i; ?>
							</a>
					</li>
				<?php } ?>
						<li class="page-item">
							<a class="page-link" href="allreq.php?page=<?php echo $total_page;?>" aria-label="Next">
								<span aria-hidden="true">&raquo;</span>
							</a>
						</li>
				</ul>
				</nav>
				<!-- Pagination button-->
    </div>
<div><iframe src="credit.html" width="100%" frameBorder="0"></iframe></div>
<script type="text/javascript" src="js/search.js"></script>
</body>
</html>
