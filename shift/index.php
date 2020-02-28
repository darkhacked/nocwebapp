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
				      <th scope="col">ชื่อพนักงาน</th>
				      <th scope="col">การลา</th>
				      <th scope="col">ประเภท</th>
							<th scope="col">วันที่ลา</th>
							<th scope="col">ผู้ปฏิบัติงานแทน</th>
							<th scope="col">หมายเหตุ</th>
							<th scope="col">สถานะ</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr align="center">
				      <td>Mark</td>
				      <td>ลาพักผ่อน</td>
				      <td>ลาระบุช่วงเวลา</td>
							<td>2020-02-07</td>
				      <td>-</td>
							<td>16:00 - 19:00</td>
				      <td><span class="badge badge-success">Approve</span></td>
				    </tr>
				    <tr align="center">
				      <td>Mark</td>
				      <td>ลาพักผ่อน</td>
				      <td>ลาปกติ</td>
							<td>2020-02-10</td>
				      <td>Jacob</td>
							<td>-</td>
				      <td><span class="badge badge-warning">Pending</span></td>
				    </tr>
				    <tr align="center">
				      <td>Mark</td>
				      <td>ลาป่วย</td>
				      <td>ลาปกติ</td>
							<td>2020-02-11</td>
				      <td>Larry</td>
							<td>-</td>
				      <td><span class="badge badge-danger">Cancel</span></td>
				    </tr>
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
