<?php
	include('../Functions/functions.php');

	if (!isLoggedIn()) {
		header('location: ../login.php');
	}elseif (isUser()) {
		header('location: ../index.php');
	}elseif (isSpector()) {
		header('location: ../spector/index.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#"><img src="../images/logo.png"></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarColor02">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="home.php">สถานะคำขออนุมัติ<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../schedule.php">ตารางงาน</a>
      </li>
    </ul>
		<ul class="navbar-nav ml-auto">
      <?php  if (isset($_SESSION['user'])) ; ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['user']['user_name']; ?> <?php echo $_SESSION['user']['username']; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="../changepass.php">Change Password</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item disabled" href="#">Manage User</a>
        </div>
      </li>
			<a class="nav-link" href="../index.php?logout='1'">Logout</a>
    </ul>
  </div>
</nav>

<div class="container-fluid mt-3">
			<ul class="nav nav-tabs">
			  <li class="nav-item">
			    <a class="nav-link active" data-toggle="tab" href="#menu1">คำขออนุมัติที่รอพิจารณา</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" data-toggle="tab" href="#menu2">คำขออนุมัติที่พิจารณาแล้ว</a>
			  </li>
			</ul>
			<div id="myTabContent" class="tab-content">
			  <div class="tab-pane fade active show" id="menu1">
					<div class="container-fluid" style="padding-top:20px; padding-bottom:100px">
					<p class="lead">คำขออนุมัติแลก / ลา</p> <!-- Table 1 -->
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
							<th scope="col"></th>
							<th scope="col">ID</th>
							<th scope="col">ผู้ปฏิบัติงานแทน</th>
							<th scope="col">วันปฏิบัติงาน</th>
							<th scope="col">สถานะ</th>
							<th scope="col">พิจารณา</th>
						</tr>
					</thead>
					<tbody>
							<?php
							/*แสดงทั้งหมด
							$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry); */

							//เลือกแสดงผลจาก status Pending
							$swapQry = "SELECT * FROM swap WHERE c_status = 'Pending' AND c_label IN ('ลาป่วย', 'ลาพักผ่อน', 'ลากิจ') AND c_labelmain='ลาปกติ (เต็มวัน)' ORDER BY c_id desc";
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
							echo "<td><img src=\"../images/swap2.png\"></td>";
							echo "<td>".$row["c_code_visit"]."</td>";
							echo "<td>".$row["c_name_visit"]."</td>";
							echo "<td>".$row["c_date_visit"]."</td>";
							echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
							echo "<td><button type=\"button\" onclick=\"window.location.href = '../Functions/accept.php?c_id=$row[0]';\" class=\"btn btn-primary btn-sm\">Accept</button> <button type=\"button\" onclick=\"window.location.href = '../Functions/cancel.php?c_id=$row[0]';\" class=\"btn btn-danger btn-sm\" name=\"cancel\">Cancel</button></td>";
							echo "</tr>";
							$i++;
							}
							?>
					</tbody>
				</table> <!-- Table 1 -->
					<br><br><br>
					<p class="lead">คำขออนุมัติแลก / ลาแบบไม่มีคนแทน</p> <!-- Table 2 -->
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
							<th scope="col">สถานะ</th>
							<th scope="col">พิจารณา</th>
						</tr>
					</thead>
					<tbody>
							<?php
							/*แสดงทั้งหมด
							$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry); */

							//เลือกแสดงผลจาก status Pending
							$swapQry = "SELECT * FROM swap WHERE c_status ='Pending' AND c_code_visit='-' ORDER BY c_id desc";
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
							echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
							echo "<td><button type=\"button\" onclick=\"window.location.href = '../Functions/accept2.php?c_id=$row[0]';\" class=\"btn btn-primary btn-sm\">Accept</button> <button type=\"button\" onclick=\"window.location.href = '../Functions/cancel.php?c_id=$row[0]';\" class=\"btn btn-danger btn-sm\" name=\"cancel\">Cancel</button></td>";
							echo "</tr>";
							$i++;
							}
							?>
					</tbody>
				</table> <!-- Table 2 -->
					<br><br><br>
					<p class="lead">คำขออนุมัติสลับกะ</p> <!-- Table 3 -->
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
							<th scope="col"></th>
							<th scope="col">ID</th>
							<th scope="col">ผู้ปฏิบัติงานแทน</th>
							<th scope="col">วันปฏิบัติงาน</th>
							<th scope="col">Seat</th>
							<th scope="col">สถานะ</th>
							<th scope="col">พิจารณา</th>
						</tr>
					</thead>
					<tbody>
							<?php
							/*แสดงทั้งหมด
							$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry); */

							//เลือกแสดงผลจาก status Pending
							$swapQry = "SELECT * FROM swap WHERE c_status ='Pending' AND c_labelmain='สลับกะ' ORDER BY c_id desc";
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
							echo "<td><img src=\"../images/swap2.png\"></td>";
							echo "<td>".$row["c_code_visit"]."</td>";
							echo "<td>".$row["c_name_visit"]."</td>";
							echo "<td>".$row["c_date_visit"]."</td>";
							echo "<td>".$row["c_seat_visit"]."</td>";
							echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
							echo "<td><button type=\"button\" onclick=\"window.location.href = '../Functions/accept3.php?c_id=$row[0]';\" class=\"btn btn-primary btn-sm\">Accept</button> <button type=\"button\" onclick=\"window.location.href = '../Functions/cancel.php?c_id=$row[0]';\" class=\"btn btn-danger btn-sm\" name=\"cancel\">Cancel</button></td>";
							echo "</tr>";
							$i++;
							}
							?>
					</tbody>
				</table> <!-- Table 3 -->
					<br><br><br>
					<p class="lead">คำขออนุมัติยก OT</p> <!-- Table 4 -->
					<table class="table table-striped table-hover table-bordered">
					<thead class="thead-dark js-thead">
						<tr align="center">
							<th scope="col">#</th>
							<th scope="col">ID</th>
							<th scope="col">ชื่อพนักงาน</th>
							<th scope="col">วันปฏิบัติงาน</th>
							<th scope="col">Seat</th>
							<th scope="col">ประเภทคำขอ</th>
							<th scope="col"></th>
							<th scope="col">ID</th>
							<th scope="col">ผู้ปฏิบัติงานแทน</th>
							<th scope="col">วันปฏิบัติงาน</th>
							<th scope="col">สถานะ</th>
							<th scope="col">พิจารณา</th>
						</tr>
					</thead>
					<tbody>
							<?php
							/*แสดงทั้งหมด
							$swapQry = "SELECT * FROM swap ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry); */

							//เลือกแสดงผลจาก status Pending
							$swapQry = "SELECT * FROM swap WHERE c_status = 'Pending' AND c_labelmain='สลับ OT' ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry);

							$i = 1; // รันเลขหน้าตาราง
							while ($row = mysqli_fetch_array($qry)) {
							echo "<tr align='center'>";
							echo "<td>".$i."</td>";
							echo "<td>".$row["c_code_host"]."</td>";
							echo "<td>".$row["c_name_host"]."</td>";
							echo "<td>".$row["c_date_host"]."</td>";
							echo "<td>".$row["c_seat_host"]."</td>";
							echo "<td>".$row["c_labelmain"]."</td>";
							echo "<td><img src=\"../images/swap2.png\"></td>";
							echo "<td>".$row["c_code_visit"]."</td>";
							echo "<td>".$row["c_name_visit"]."</td>";
							echo "<td>".$row["c_date_visit"]."</td>";
							echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
							echo "<td><button type=\"button\" onclick=\"window.location.href = '../Functions/accept4.php?c_id=$row[0]';\" class=\"btn btn-primary btn-sm\">Accept</button> <button type=\"button\" onclick=\"window.location.href = '../Functions/cancel.php?c_id=$row[0]';\" class=\"btn btn-danger btn-sm\" name=\"cancel\">Cancel</button></td>";
							echo "</tr>";
							$i++;
							}
							?>
					</tbody>
				</table> <!-- Table 4 -->


					</div>
				</div>
			  <div class="tab-pane fade" id="menu2">
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
										$swapQry = "SELECT * FROM swap WHERE c_status IN ('Approve', 'Cancel') ORDER BY c_id desc";
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
										echo "<td><img src=\"../images/swap2.png\"></td>";
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
			</div>
	</div>
		<div><iframe src="../credit.html" width="100%" frameBorder="0"></iframe></div>
		<br>

	<script src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/search.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
