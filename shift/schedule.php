<?php
	include('functions.php');

	if (!isLoggedIn()) {
		header('location: login.php');
	}
?>
<!DOCTYPE html>
<html>
	<link rel="stylesheet" type="text/css" href="style.css">
<head>
	<title>table</title>
</head>
<body>
  <center><h2>Schedule user only</h2></center>
  <?php
  //1. เชื่อมต่อ database:
  include('connection.php');
  //2. query ข้อมูลจากตาราง users
  $query = "SELECT * FROM 202001W WHERE list " or die("Error:" . mysqli_error());
  //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result
  $result = mysqli_query($con, $query);

  //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
  echo "<table border='1' align='center'>";
  //หัวข้อตาราง
	echo "<tr align='center' bgcolor='#CCCCCC'><td>Shift</td><td>member</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td></tr>";
  //เนื้อหาที่ query มา
  while($row = mysqli_fetch_array($result)) {
  echo "<tr align='center' >";
	echo "<td>".$row["Shift"]."</td> ";
  echo "<td>".$row["member"]."</td> ";
  echo "<td>".$row["1"]."</td> ";
  echo "<td>".$row["2"]."</td> ";
	echo "<td>".$row["3"]."</td> ";
	echo "<td>".$row["4"]."</td> ";
	echo "<td>".$row["5"]."</td> ";
	echo "<td>".$row["6"]."</td> ";
  echo "<td>".$row["7"]."</td> ";
	echo "<td>".$row["8"]."</td> ";
	echo "<td>".$row["9"]."</td> ";
	echo "<td>".$row["10"]."</td> ";
	echo "<td>".$row["11"]."</td> ";
  echo "<td>".$row["12"]."</td> ";
	echo "<td>".$row["13"]."</td> ";
	echo "<td>".$row["14"]."</td> ";
	echo "<td>".$row["15"]."</td> ";
	echo "<td>".$row["16"]."</td> ";
  echo "<td>".$row["17"]."</td> ";
	echo "<td>".$row["18"]."</td> ";
	echo "<td>".$row["19"]."</td> ";
	echo "<td>".$row["20"]."</td> ";
	echo "<td>".$row["21"]."</td> ";
  echo "<td>".$row["22"]."</td> ";
	echo "<td>".$row["23"]."</td> ";
	echo "<td>".$row["24"]."</td> ";
	echo "<td>".$row["25"]."</td> ";
	echo "<td>".$row["26"]."</td> ";
  echo "<td>".$row["27"]."</td> ";
	echo "<td>".$row["28"]."</td> ";
	echo "<td>".$row["29"]."</td> ";
	echo "<td>".$row["30"]."</td> ";
	echo "<td>".$row["31"]."</td> ";
  echo "</tr>";
  }
  echo "</table>";
  //5. close connection
  mysqli_close($con);
  ?>
<br><br><br>
<h2>แลก / ลา</h2>
<div></div>
<center><button class="btn" onclick="history.go(-1);">Back</button></center>

</body>
</html>
