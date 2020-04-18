<?php
	include('Functions/functions.php');

	if (!isLoggedIn()) {
		header('location: login.php');
	}elseif (isSpector()) {
		header('location: spector/index.php');
	}

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/style.css" rel="stylesheet">
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
			<li class="nav-item">
				<a class="nav-link" href="index.php">สถานะคำขออนุมัติ</a>
			</li>
			<li class="nav-item mr-auto">
				<a class="nav-link" href="schedule.php">ตารางงาน</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="ot.php">เบิก OT<span class="sr-only">(current)</span></a>
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

<div class="container">
	<div class="jumbotron">
		<center>
		<h4>Download ใบเบิก OT</h4>
		<small>กด DOWNLOAD แล้วแก้ไขข้อมูลตามเวลางานจากระบบ JPM</small><br><br>
				<a href="https://www.google.com/url?q=https://www.dropbox.com/scl/fi/g9go2frhulx91azk8tr3k/Update-29-02-63.docx?dl%3D0%26rlkey%3Drog1qsz89o7rv2eexz3hd06zs&sa=D&ust=1587246227273000&usg=AFQjCNGfSQ9vGUldJRcz1Ij37kjBgnsRAg" target="_blank"><b>ใบขออนุมัติทำงาน</b></a><br>
				<a href="https://www.google.com/url?q=https://www.dropbox.com/scl/fi/3n41lgepxlm6mjdadac1b/OT-Engineer-NocOfficer.xls?dl%3D0%26rlkey%3Dh0o18ywviqom35jlnrh6y825z&sa=D&ust=1587246227274000&usg=AFQjCNF6l-7IL0nNQ2x0JblM_-gLQAR2mw" target="_blank"><b>ใบขออนุมัติ โอทีของ Engineer-NOC Officer</b></a><br>
				<a href="https://www.google.com/url?q=https://www.dropbox.com/scl/fi/of00p8167ajktrp9kj2ec/OT-Senior-Officer2.xls?dl%3D0%26rlkey%3Dbaycn0an6fip5ohmdqghw8hag&sa=D&ust=1587246227273000&usg=AFQjCNG1T_4AKAL8cEfq8rlCLsNkmoXMMQ"><b>ใบขออนุมัติ โอทีของ Senior Officer</b></a>
		</center><hr>

		<table class="table table-bordered table-striped">
				<tr class="table-dark" align="center">
						<th>เงื่อนไขการเบิกโอที</th>
						<th>เวลาเข้างาน</th>
						<th>อัตราเบิก OT</th>
				</tr>
				<tr align="center">
						<td>เวลาเข้างานปกติ</th>
						<td>07:00 - 19:00</td>
						<td>11 ชม.</td>
				</tr>
				<tr align="center">
						<td>เข้างานสาย 1 นาที ไม่เกิน 14 นาที ไม่หัก</th>
						<td>07:14 - 19:00</td>
						<td>11 ชม.</td>
				</tr>
				<tr align="center">
						<td>เข้างานสาย 15 นาที ไม่เกิน 44 นาที หัก 30 นาที</th>
						<td>07:15 - 19:00</td>
						<td>10.5 ชม.</td>
				</tr>
				<tr align="center">
						<td>เข้างานสาย 45 นาที ขึ้นไป หัก 1 ชม.</th>
						<td>07:45 - 19:00</td>
						<td>10 ชม.</td>
				</tr>
		</table>
		<hr>
		<table class="table table-bordered table-striped">
				<tr class="table-dark" align="center">
						<th>SHIFT TIME</th>
						<th>เวลาพักเที่ยงรอบ 1</th>
						<th>เวลาพักเที่ยงรอบ 2</th>
						<th>เวลาพักช่วงเย็นรอบ 1</th>
						<th>เวลาพักช่วงเย็นรอบ 1</th>
				</tr>
				<tr align="center">
						<td>07:00 - 19:00 (D)</th>
						<td>12:30 - 13:30 (1 ชม.)</td>
						<td>13:30 - 14:30 (1 ชม.)</th>
						<td>17:30 - 18:00 (30 นาที)</td>
						<td>18:00 - 18:30 (30 นาที)</td>
				</tr>
				<tr align="center">
						<td>19:00 - 07:00 (N)</th>
						<td>1 ชั่วโมง</td>
						<td>1 ชั่วโมง</th>
						<td>30 นาที</td>
						<td>30 นาที</td>
				</tr>
		</table><br>
		<center>
		<h4>ข้อกำหนดการทำงานกะ สำหรับพนักงาน NOC</h4>
		</center>
					1. สามารถสลับกะได้ 4 วันต่อเดือน (นับรวมผู้ที่ถูกขอสลับกะด้วย) โดยต้องระบุภายในเดือนเดียวกันเท่านั้น สลับมากกว่า 4 วันแจ้งคุณปรัชญา ขออนุมัติเพิ่ม<br>
					2. ลากิจ/ลาพักผ่อน ต้องมีคนปฏิบัติงานแทนและแจ้งล่วงหน้าอย่างน้อย 3 วัน ให้บันทึกคำร้องใน JPM และส่งคำขออนุมัติในระบบตารางกะ<br>
					3. ลาหยุด/ลาป่วย ให้บันทึกคำร้องใน JPM และ และส่งคำขออนุมัติในระบบตารางกะ<br>

	</div>
</div>
<div><iframe src="credit.html" width="100%" frameBorder="0"></iframe></div>
  <script src="js/jquery.js"></script>
	<script src="js/popper.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
