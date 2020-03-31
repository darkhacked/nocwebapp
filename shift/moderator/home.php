<?php
	include('../functions.php');

	if (!isLoggedIn()) {
		header('location: ../login.php');
	}elseif (isUser()) {
		header('location: ../index.php');
	}elseif (isAdmin()) {
		header('location: ../admin/home.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">LOGO</a>
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
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Change Password</a>
          <div class="dropdown-divider"></div>
        </div>
      </li>
			<a class="nav-link" href="../index.php?logout='1'">Logout</a>
    </ul>
  </div>
</nav>

<div class="container-fluid mt-3">
			<h3>DASHBOARD</h3>
			<p class="lead">สถานะคำขออนุมัติที่รอพิจารณา</p>
			<table class="table table-striped table-bordered">
			<thead class="thead-dark js-thead">
				<tr align="center">
					<th scope="col">#</th>
					<th scope="col">ID</th>
					<th scope="col">ชื่อพนักงาน</th>
					<th scope="col">วันปฏิบัติงาน</th>
					<th scope="col">Seat</th>
					<th scope="col">ประเภทการลา</th>
					<th scope="col">ประเภทคำขอ</th>
					<th scope="col"></th>
					<th scope="col">ID</th>
					<th scope="col">ผู้ปฏิบัติงานแทน</th>
					<th scope="col">วันปฏิบัติงาน</th>
					<th scope="col">Seat</th>
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
					$swapQry = "SELECT * FROM swap WHERE c_status = 'Pending' ORDER BY c_id desc";
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
					echo "<td><img src=\"../images/swap2.png\"></td>";
					echo "<td>".$row["c_code_visit"]."</td>";
					echo "<td>".$row["c_name_visit"]."</td>";
					echo "<td>".$row["c_date_visit"]."</td>";
					echo "<td>".$row["c_seat_visit"]."</td>";
					echo "<td>".$row["c_remark"]."</td>";
					echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
					echo "<td><button type=\"button\" onclick=\"window.location.href = '#';\" class=\"btn btn-primary btn-sm\" name=\"accept\">Accept</button> <button type=\"button\" onclick=\"window.location.href = '#';\" class=\"btn btn-danger btn-sm\" name=\"denied\">Denied</button></td>";
					echo "</tr>";
					$i++;
					}
					?>
			</tbody>
		</table>
	</div>
	<div class="container-fluid" style="padding-top:100px">
				<p class="lead">คำขออนุมัติที่ผ่านการพิจารณาแล้ว</p>
				<input type="text" class="form-control" id="js-search" placeholder="ค้นหา....">
				<table class="table table-striped table-bordered js-table" id="myTable">
				<thead class="thead-dark js-thead">
					<tr align="center">
						<th scope="col">#</th>
						<th scope="col">ID</th>
						<th scope="col">ชื่อพนักงาน</th>
						<th scope="col">วันปฏิบัติงาน</th>
						<th scope="col">Seat</th>
						<th scope="col">ประเภทการลา</th>
						<th scope="col">ประเภทคำขอ</th>
						<th scope="col"></th>
						<th scope="col">ID</th>
						<th scope="col">ผู้ปฏิบัติงานแทน</th>
						<th scope="col">วันปฏิบัติงาน</th>
						<th scope="col">Seat</th>
						<th scope="col">หมายเหตุ</th>
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
						echo "<td><img src=\"../images/swap2.png\"></td>";
						echo "<td>".$row["c_code_visit"]."</td>";
						echo "<td>".$row["c_name_visit"]."</td>";
						echo "<td>".$row["c_date_visit"]."</td>";
						echo "<td>".$row["c_seat_visit"]."</td>";
						echo "<td>".$row["c_remark"]."</td>";
						echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
						echo "</tr>";
						$i++;
						}
						?>
				</tbody>
			</table>
		</div>
<div class="credit" style="padding-top:150px">
<hr>
<center>
			<small class="text-muted">© 2020-2021 Management by Mawmasing. | <a href="changelog.html" target="_blank"><font color="#444">Changelog</font></a>
			<br>This Web application All rights reserved under <a href="https://www.gnu.org/licenses/gpl-3.0.txt" target="_blank"><font color="#444">GNU GENERAL PUBLIC LICENSE V3</font></a>.<br></small>
			<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/GPLv3_Logo.svg/64px-GPLv3_Logo.svg.png"></a>
</center>
</div>
<br>

	<script src="../js/jquery.js"></script>
	<script type="text/javascript" src="../js/search.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</body>
</html>
