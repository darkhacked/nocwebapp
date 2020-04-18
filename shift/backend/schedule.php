<?php
	include('../Functions/functions.php');

	if (!isLoggedIn()) {
		header('location: ../login.php');
	}elseif (isUser()) {
		header('location: ../schedule.php');
	}

?>
<!DOCTYPE html>
<html>
<link href="../css/bootstrap.css" rel="stylesheet">
<link href="../css/style.css" rel="stylesheet">
<head>
	<title>table</title>
</head>
<body>
	<!-- Start NAV BAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#">อิอิ</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarColor02">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item active">
				<a class="nav-link" href="../moderator/home.php">Home <span class="sr-only">(current)</span></a>
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
			<a class="nav-link" href="../index.php?logout='1'">Logout</a>
		</ul>
	</div>
</nav>
<!-- End NAV BAR -->

<div class="container">
  <!-- Content here -->
		<form method="post" action="pick_month.php">
		<div class="form-row">
			<div class="mt-3">
			<h5>เลือกเดือน / ปี</h5>
		</div>
		<div class="col-md-2 mt-3">
		<select class="custom-select custom-select-sm">
		  <option selected>เดือน</option>
		  <option value="1">มกราคม</option>
		  <option value="2">กุมพาพันธ์</option>
		  <option value="3">มีนาคม</option>
			<option value="4">เมษายน</option>
		  <option value="5">พฤษภาคม</option>
		  <option value="6">มิถุนายน</option>
			<option value="7">กรกฎาคม</option>
		  <option value="8">สิงหาคม</option>
		  <option value="9">กันยายน</option>
			<option value="10">ตุลาคม</option>
		  <option value="11">พฤศจิกายน</option>
		  <option value="12">ธันวาคม</option>
		</select>
	</div>
		<div class="col-md-2 mt-3">
		<select class="custom-select custom-select-sm">
		  <option selected>ปี</option>
		  <option value="2020">2020</option>
		  <option value="2021">2021</option>
		</select>
		</div>
		<div class="col-md-2 mt-3">
		<button class="btn btn-primary btn-sm" type="submit">GO !!</button>
		</div>
	</form>
		</div>
	</div>
	<hr>
	<div class="container">
  <center><h2>Schedule Only MOD + ADMIN $month $year</h2></center>
  <?php
  include('connection.php');
  // Query SHIFT A
  $queryA = "SELECT users.shift, 202001w.*
FROM users
RIGHT JOIN 202001w ON 202001w.member = users.user_name
WHERE users.shift='A'
ORDER BY 202001w.list; " or die("Error:" . mysqli_error());

  $resultA = mysqli_query($con, $queryA);
	// END Query SHIFT A
	// Query SHIFT B
	$queryB = "SELECT users.shift, 202001w.*
FROM users
RIGHT JOIN 202001w ON 202001w.member = users.user_name
WHERE users.shift='B'
ORDER BY 202001w.list; " or die("Error:" . mysqli_error());

  $resultB = mysqli_query($con, $queryB);
	// END Query SHIFT B
  //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
  echo "<table class=\"table table-striped table-hover\" border='1' align='center'>";
  //หัวข้อตาราง
	echo "<thead>";
	echo "<tr class=\"table-primary\" align='center'>";
echo "<th scope=\"col\">Shift</th><th scope=\"col\">member</th><th scope=\"col\">1</th><th scope=\"col\">2</th><th scope=\"col\">3</th><th scope=\"col\">4</th><th scope=\"col\">5</th><th scope=\"col\">6</th><th scope=\"col\">7</th><th scope=\"col\">8</th><th scope=\"col\">9</th><th scope=\"col\">10</th><th scope=\"col\">11</th><th scope=\"col\">12</th><th scope=\"col\">13</th><th scope=\"col\">14</th><th scope=\"col\">15</th><th scope=\"col\">16</th><th scope=\"col\">17</th><th scope=\"col\">18</th><th scope=\"col\">19</th><th scope=\"col\">20</th><th scope=\"col\">21</th><th scope=\"col\">22</th><th scope=\"col\">23</th><th scope=\"col\">24</th><th scope=\"col\">25</th><th scope=\"col\">26</th><th scope=\"col\">27</th><th scope=\"col\">28</th><th scope=\"col\">29</th><th scope=\"col\">30</th><th scope=\"col\">31</th></tr>";
 echo "</thead>";
 echo "</tr>";
 //เนื้อหาที่ query มา
  while($rowA = mysqli_fetch_array($resultA)) {
  echo "<tr align='center' >";
	echo "<th scope=\"row\">".$rowA["Shift"]."</th> ";
  echo "<td>".$rowA["member"]."</td> ";
  echo "<td>".$rowA["1"]."</td> ";
  echo "<td>".$rowA["2"]."</td> ";
	echo "<td>".$rowA["3"]."</td> ";
	echo "<td>".$rowA["4"]."</td> ";
	echo "<td>".$rowA["5"]."</td> ";
	echo "<td>".$rowA["6"]."</td> ";
  echo "<td>".$rowA["7"]."</td> ";
	echo "<td>".$rowA["8"]."</td> ";
	echo "<td>".$rowA["9"]."</td> ";
	echo "<td>".$rowA["10"]."</td> ";
	echo "<td>".$rowA["11"]."</td> ";
  echo "<td>".$rowA["12"]."</td> ";
	echo "<td>".$rowA["13"]."</td> ";
	echo "<td>".$rowA["14"]."</td> ";
	echo "<td>".$rowA["15"]."</td> ";
	echo "<td>".$rowA["16"]."</td> ";
  echo "<td>".$rowA["17"]."</td> ";
	echo "<td>".$rowA["18"]."</td> ";
	echo "<td>".$rowA["19"]."</td> ";
	echo "<td>".$rowA["20"]."</td> ";
	echo "<td>".$rowA["21"]."</td> ";
  echo "<td>".$rowA["22"]."</td> ";
	echo "<td>".$rowA["23"]."</td> ";
	echo "<td>".$rowA["24"]."</td> ";
	echo "<td>".$rowA["25"]."</td> ";
	echo "<td>".$rowA["26"]."</td> ";
  echo "<td>".$rowA["27"]."</td> ";
	echo "<td>".$rowA["28"]."</td> ";
	echo "<td>".$rowA["29"]."</td> ";
	echo "<td>".$rowA["30"]."</td> ";
	echo "<td>".$rowA["31"]."</td> ";
  echo "</tr>";
  }
	echo "<thead>";
	echo "<tr class=\"table-primary\" align='center'>";
echo "<th scope=\"col\">Shift</th><th scope=\"col\">member</th><th scope=\"col\">1</th><th scope=\"col\">2</th><th scope=\"col\">3</th><th scope=\"col\">4</th><th scope=\"col\">5</th><th scope=\"col\">6</th><th scope=\"col\">7</th><th scope=\"col\">8</th><th scope=\"col\">9</th><th scope=\"col\">10</th><th scope=\"col\">11</th><th scope=\"col\">12</th><th scope=\"col\">13</th><th scope=\"col\">14</th><th scope=\"col\">15</th><th scope=\"col\">16</th><th scope=\"col\">17</th><th scope=\"col\">18</th><th scope=\"col\">19</th><th scope=\"col\">20</th><th scope=\"col\">21</th><th scope=\"col\">22</th><th scope=\"col\">23</th><th scope=\"col\">24</th><th scope=\"col\">25</th><th scope=\"col\">26</th><th scope=\"col\">27</th><th scope=\"col\">28</th><th scope=\"col\">29</th><th scope=\"col\">30</th><th scope=\"col\">31</th></tr>";
 echo "</thead>";
 echo "</tr>";	while($rowB = mysqli_fetch_array($resultB)) {
	echo "<tr align='center' >";
	echo "<th scope=\"row\">".$rowB["Shift"]."</th> ";
	echo "<td>".$rowB["member"]."</td> ";
	echo "<td>".$rowB["1"]."</td> ";
	echo "<td>".$rowB["2"]."</td> ";
	echo "<td>".$rowB["3"]."</td> ";
	echo "<td>".$rowB["4"]."</td> ";
	echo "<td>".$rowB["5"]."</td> ";
	echo "<td>".$rowB["6"]."</td> ";
	echo "<td>".$rowB["7"]."</td> ";
	echo "<td>".$rowB["8"]."</td> ";
	echo "<td>".$rowB["9"]."</td> ";
	echo "<td>".$rowB["10"]."</td> ";
	echo "<td>".$rowB["11"]."</td> ";
	echo "<td>".$rowB["12"]."</td> ";
	echo "<td>".$rowB["13"]."</td> ";
	echo "<td>".$rowB["14"]."</td> ";
	echo "<td>".$rowB["15"]."</td> ";
	echo "<td>".$rowB["16"]."</td> ";
	echo "<td>".$rowB["17"]."</td> ";
	echo "<td>".$rowB["18"]."</td> ";
	echo "<td>".$rowB["19"]."</td> ";
	echo "<td>".$rowB["20"]."</td> ";
	echo "<td>".$rowB["21"]."</td> ";
	echo "<td>".$rowB["22"]."</td> ";
	echo "<td>".$rowB["23"]."</td> ";
	echo "<td>".$rowB["24"]."</td> ";
	echo "<td>".$rowB["25"]."</td> ";
	echo "<td>".$rowB["26"]."</td> ";
	echo "<td>".$rowB["27"]."</td> ";
	echo "<td>".$rowB["28"]."</td> ";
	echo "<td>".$rowB["29"]."</td> ";
	echo "<td>".$rowB["30"]."</td> ";
	echo "<td>".$rowB["31"]."</td> ";
	echo "</tr>";
	}
  echo "</table>";
  //5. close connection
  mysqli_close($con);
			 ?>
		 </div>
		 <br>
<center><button class="btn btn-info" onclick="history.go(-1);">Back</button></center>

<br><br>
<div class="credit">
	<hr>
    <center>
          <small class="text-muted">© 2020-2021 Management by Mawmasing.<br>This Web application All rights reserved under <a href="https://www.gnu.org/licenses/gpl-3.0.txt" target="_blank"><font color="#444">GNU GENERAL PUBLIC LICENSE V3</font></a>.<br></small>
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/GPLv3_Logo.svg/64px-GPLv3_Logo.svg.png"></a>
    </center>
	</div>
<br>
<script src="../js/jquery.js"></script>
<script src="../js/popper.min.js"></script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
