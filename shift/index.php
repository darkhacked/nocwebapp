<?php
	include('Functions/functions.php');

	if (!isLoggedIn()) {
		header('location: login.php');
	}elseif (isMod()) {
		header('location: moderator/home.php');
	}elseif (isAdmin()) {
		header('location: admin/home.php');
	}elseif (isSpector()) {
		header('location: spector/index.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script type="text/javascript" src="js/draw_table.js"></script>
	<script src="js/jquery.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</head>
<body>
	<!-- Start NAV BAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="Functions/index.php"><img src="images/logo.png"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">สถานะคำขออนุมัติ<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="schedule.php">ตารางงาน</a>
      </li>
			<li class="nav-item">
				<a class="nav-link" href="ot.php">เบิก OT</a>
			</li>
    </ul>
		<ul class="navbar-nav ml-auto">
      <?php  if (isset($_SESSION['user'])) ; ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['user']['user_name']; ?> <?php echo $_SESSION['user']['username']; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="changepass.php">Change Password</a>
        </div>
      </li>
			<a class="nav-link" href="index.php?logout='1'">Logout</a>
    </ul>
  </div>
</nav>
<!-- End NAV BAR -->
		<div class="container-fluid mt-3">
				  <h3>DASHBOARD</h3>
				  <p class="lead">สถานะคำขออนุมัติของท่าน</p>
					<table class="table table-striped table-hover table-bordered">
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
							<th scope="col">ยกเลิก</th>
				    </tr>
				  </thead>
				  <tbody>
							<?php
							/*แสดงทั้งหมด
							$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry); */


							//เลือกแสดงผลจาก session
							$user = $_SESSION['user']['user_name'];

							$swapQry = "SELECT * FROM swap WHERE c_name_host='$user' AND c_status='Pending' ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry);

							$i = 1;
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
							//echo "<td>".$row["c_status"]."</td>";
							echo "<td><button type=\"button\" onclick=\"return confirm('คุณต้องการยกเลิกคำขออนุมัตินี้ทิ้งใช่หรือไม่ ?');\" class=\"btn btn-danger btn-sm\">
<a href=\"Functions/deleteswap.php?c_id=$row[0]\" style=\"color:#FFFFFF; text-decoration:none;\">Cancel</a></button></td>";
							echo "</tr>";
							$i++;
							}
							?>
				  </tbody>
				</table>
			</div>

			<div class="container-fluid" style="padding-top:100px; padding-bottom:100px">
						<p class="lead">คำขออนุมัติที่ผ่านการพิจารณาแล้ว</p>
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
								/*แสดงทั้งหมด
								$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
								$qry = mysqli_query($db, $swapQry); */
								$sft = $_SESSION['user']['username'];
								//เลือกแสดงผลจาก status Pending

								$swapQry = "SELECT * FROM swap WHERE c_code_host = '$sft' AND c_status IN ('Approve','Cancel') OR c_code_visit = '$sft' AND c_status IN ('Approve','Cancel') ORDER BY c_id desc";
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
				</div>
				<div><iframe src="credit.html" width="100%" frameBorder="0"></iframe></div>
	<script type="text/javascript" src="js/search.js"></script>
</body>
</html>
