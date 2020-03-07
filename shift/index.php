<?php
	include('functions.php');

	if (!isLoggedIn()) {
		header('location: login.php');
	}elseif (isMod()) {
		header('location: moderator/home.php');
	}elseif (isAdmin()) {
		header('location: admin/home.php');
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
	<script type="text/javascript" src="js/draw_table.js"></script>
</head>
<body>
	<!-- Start NAV BAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="#">LOGO</a>
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
    </ul>
		<ul class="navbar-nav ml-auto">
      <?php  if (isset($_SESSION['user'])) ; ?>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <?php echo $_SESSION['user']['user_name']; ?> <?php echo $_SESSION['user']['username']; ?>
        </a>
        <div class="dropdown-menu dropdown-menu-lg-right" aria-labelledby="navbarDropdown">
          <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Change Password</a>
        </div>
      </li>
			<a class="nav-link" href="index.php?logout='1'">Logout</a>
    </ul>
  </div>
</nav>
<!-- End NAV BAR -->
		<div class="container-xl mt-3">
				  <h3>DASHBOARD</h3>
				  <p class="lead">สถานะคำขออนุมัติของท่าน</p>
				  <hr class="my-4">
					<input type="text" class="form-control" id="js-search" placeholder="ค้นหา....">
					<table class="table table-striped table-bordered js-table" id="myTable">
				  <thead class="thead-dark js-thead">
						<tr align="center">
							<th scope="col">ID</th>
				      <th scope="col">ชื่อพนักงาน</th>
							<th scope="col">วันที่ลา</th>
							<th scope="col">Seat</th>
							<th scope="col">การลา</th>
				      <th scope="col">ประเภท</th>
							<th scope="col">ID</th>
							<th scope="col">ผู้ปฏิบัติงานแทน</th>
							<th scope="col">วันที่แลก</th>
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


							//เลือกแสดงผลจาก session
							$user = $_SESSION['user']['user_name'];

							$swapQry = "SELECT * FROM swap WHERE c_name_host = '$user' ORDER BY c_id desc";
							$qry = mysqli_query($db, $swapQry);


							while ($row = mysqli_fetch_array($qry)) {
							echo "<tr align='center'>";
				      echo "<td>".$row["c_code_host"]."</td>";
							echo "<td>".$row["c_name_host"]."</td>";
							echo "<td>".$row["c_date_host"]."</td>";
							echo "<td>".$row["c_seat_host"]."</td>";
							echo "<td>".$row["c_label"]."</td>";
							echo "<td>".$row["c_labelmain"]."</td>";
							echo "<td>".$row["c_code_visit"]."</td>";
							echo "<td>".$row["c_name_visit"]."</td>";
							echo "<td>".$row["c_date_visit"]."</td>";
							echo "<td>".$row["c_seat_visit"]."</td>";
				      echo "<td>".$row["c_remark"]."</td>";
							echo "<td><span class=\"badge badge-".$row["c_badge"]."\">".$row["c_status"]."</span></td>";
							//echo "<td>".$row["c_status"]."</td>";
							echo "</tr>";
							}
							?>
				  </tbody>
				</table>
				<br><br><br><br><br><br>
			</div>
<div class="credit">
	<hr>
    <center>
          <small class="text-muted">© 2020-2021 Management by Mawmasing.<br>This Web application All rights reserved under <a href="https://www.gnu.org/licenses/gpl-3.0.txt" target="_blank"><font color="#444">GNU GENERAL PUBLIC LICENSE V3</font></a>.<br></small>
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/GPLv3_Logo.svg/64px-GPLv3_Logo.svg.png"></a>
    </center>
	</div>
<br>
	<script src="js/jquery.js"></script>
	<script type="text/javascript" src="js/search.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
