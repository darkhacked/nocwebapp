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
		<center>
		<h4>สถิติการทำ OT ของพนักงานในปี 2020</h4>
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
	</div>
</div>
<div><iframe src="../credit.html" width="100%" frameBorder="0"></iframe></div>
</body>
</html>