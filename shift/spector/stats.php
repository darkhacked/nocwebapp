<?php
	include('../Functions/functions_spector.php');

	if (!isLoggedIn()) {
		header('location: ../login.php');
	}elseif (!isSpector()) {
		header('location: ../index.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>WORK SCHEDULE WEB APPLICATION</title>
	<link href="../css/bootstrap.css" rel="stylesheet">
	<link href="../css/style.css" rel="stylesheet">
	<script src="../js/jquery.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>
  <!-- Start NAV BAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
	<a class="navbar-brand" href="#"><img src="../images/logo.png"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarColor02">
		<ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">ตารางงาน<span class="sr-only">(current)</span></a>
      </li>
			<li class="nav-item">
				<a class="nav-link" href="stats.php">สถิติ</a>
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
				</div>
			</li>
			<a class="nav-link" href="index.php?logout='1'">Logout</a>
		</ul>
	</div>
</nav>
<!-- End NAV BAR -->

<div class="container">
	<div class="jumbotron">
		<center><h5>UPDATE ล่าสุด <span style="color:red">
			<?php
				date_default_timezone_set("Asia/Bangkok");
				$SQL = "SELECT s_remark FROM stat_all WHERE id = '1'";
				$qry = mysqli_query($db, $SQL);
					while($qrytime = mysqli_fetch_array($qry)){
						$time = $qrytime["s_remark"];
					}
						echo date("d/m/Y H:i:s A", $time);
			?>
		</span>
		<button type="button" class="btn btn-primary btn-sm"><a href="functions/stat_all.php"><span style="color:white">กดเพื่อ Update ข้อมูลใหม่</span></a></button>
		</h5></center>
		<center><h4>สถิติการทำ OT ของพนักงานในปี 2020</h4></center>
		<br>
		<table id="table" class="table">
			<thead class="thead-dark">
				<tr align='center'>
					<th width='60px' scope="col">#</th>
					<th width='100px' scope="col">Code</th>
					<th width='250px' scope="col">NAME</th>
					<th scope="col">OD / ON</th>
					<th width='100px' scope="col">OT ALL</th>
				</tr>
		</thead>

	<?php
	 $in1 = 1;

	 $SQL = "SELECT * FROM stat_all ORDER BY s_otall desc";
 	 $qry = mysqli_query($db, $SQL);
 	 while($row = mysqli_fetch_array($qry)){

			echo '<tbody>';
			echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
			echo '<th scope="row">'. $in1 .'</th>';
			echo '<td class="text-nowrap">'.$row["s_code"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_name"].'</td>';

			echo '<td> <div class="progress" style="height: 20px;">';
			echo '  <div class="progress-bar" role="progressbar" style="width: '.$row["s_od"].'%" aria-valuenow="'.$row["s_od"].'" aria-valuemin="0" aria-valuemax="100">'.$row["s_od"].'</div>';
			echo '    <div class="progress-bar bg-success" role="progressbar" style="width: '.$row["s_on"].'%" aria-valuenow="'.$row["s_on"].'" aria-valuemin="0" aria-valuemax="100">'.$row["s_on"].'</div>';
			echo '  </div></td>';

			echo '<td class="text-nowrap">'.$row["s_otall"].'</td>';
			$in1++;
		}
			echo '</tbody>';
			echo '</tr>';
			echo '</table>';
		?>

		<table id="table" class="table table-bordered table-hover">
			<thead class="thead-dark">
				<tr align='center'>
					<th width='60px' scope="col">#</th>
					<th width='100px' scope="col">Code</th>
					<th width='250px' scope="col">NAME</th>
					<th scope="col">01</th>
					<th scope="col">02</th>
					<th scope="col">03</th>
					<th scope="col">04</th>
					<th scope="col">05</th>
					<th scope="col">06</th>
					<th scope="col">07</th>
					<th scope="col">08</th>
					<th scope="col">09</th>
					<th scope="col">10</th>
					<th scope="col">11</th>
					<th scope="col">12</th>
				</tr>
		</thead>

		<?php
		 $SQL = "SELECT * FROM stat_ot_month";
	 	 $qry = mysqli_query($db, $SQL);
	 	 while($row = mysqli_fetch_array($qry)){

				echo '<tbody>';
				echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
					echo '<th scope="row">'.$row["id"].'</th>';
					echo '<td class="text-nowrap">'.$row["s_code"].'</td>';
					echo '<td class="text-nowrap">'.$row["s_name"].'</td>';
					echo '<td class="text-nowrap">'.$row["01"].'</td>';
					echo '<td class="text-nowrap">'.$row["02"].'</td>';
					echo '<td class="text-nowrap">'.$row["03"].'</td>';
					echo '<td class="text-nowrap">'.$row["04"].'</td>';
					echo '<td class="text-nowrap">'.$row["05"].'</td>';
					echo '<td class="text-nowrap">'.$row["06"].'</td>';
					echo '<td class="text-nowrap">'.$row["07"].'</td>';
					echo '<td class="text-nowrap">'.$row["08"].'</td>';
					echo '<td class="text-nowrap">'.$row["09"].'</td>';
					echo '<td class="text-nowrap">'.$row["10"].'</td>';
					echo '<td class="text-nowrap">'.$row["11"].'</td>';
					echo '<td class="text-nowrap">'.$row["12"].'</td>';
					}
				echo '</tbody>';
			echo '</table>';
	?>

		<hr><br>
		<center><h4>สถิติการลาหยุด ของพนักงานในปี 2020</h4></center>
		<br>
		<table id="table" class="table table-bordered table-hover">
			<thead class="thead-dark">
				<tr align='center'>
					<th width='60px' scope="col">#</th>
					<th width='100px' scope="col">Code</th>
					<th width='250px' scope="col">NAME</th>
					<th scope="col">ลาป่วย</th>
					<th scope="col">ลาพักผ่อน</th>
					<th scope="col">ลากิจ</th>
					<th scope="col">ลาสมรส</th>
					<th scope="col">ลาอื่นๆ</th>
					<th width='100px' scope="col">รวม</th>
				</tr>
		</thead>

	<?php
	 $in1 = 1;

	 $SQL = "SELECT * FROM stat_all ORDER BY s_sum desc";
 	 $qry = mysqli_query($db, $SQL);
 	 while($row = mysqli_fetch_array($qry)){

			echo '<tbody>';
			echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
			echo '<th scope="row">'. $in1 .'</th>';
			echo '<td class="text-nowrap">'.$row["s_code"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_name"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_sick"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_holiday"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_bussiness"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_married"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_other"].'</td>';
			echo '<td class="text-nowrap">'.$row["s_sum"].'</td>';
			$in1++;
		}
			echo '</tbody>';
			echo '</tr>';
			echo '</table>';
		?>
	</div>
</div>
<div><iframe src="../credit.html" width="100%" frameBorder="0"></iframe></div>
</body>
</html>
