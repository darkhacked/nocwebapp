<!DOCTYPE html>
<html>
	<link rel="stylesheet" type="text/css" href="style.css">
<head>
	<title>table</title>
</head>
<body>
  <center><h2>Test query raw data</h2></center>
  <?php
  //1. เชื่อมต่อ database:
  include('connection.php');
  //2. query ข้อมูลจากตาราง users
  $query = "SELECT * FROM users WHERE id >=4 ORDER BY shift asc, id asc" or die("Error:" . mysqli_error());
  //3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result
  $result = mysqli_query($con, $query);

  //4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:
  echo "<table border='1' align='center'>";
  //หัวข้อตาราง
  echo "<tr align='center' bgcolor='#CCCCCC'><td>ID</td><td>username</td><td>password</td><td>user_type</td><td>email</td><td>shift</td><td>user_name</td><td>user_nickname</td><td>edit</td><td>delete</td></tr>";
  //เนื้อหาที่ query มา
  while($row = mysqli_fetch_array($result)) {
  echo "<tr align='center' >";
  echo "<td>".$row["id"]."</td> ";
  echo "<td>".$row["username"]."</td> ";
  echo "<td>".$row["password"]."</td> ";
  echo "<td>".$row["user_type"]."</td> ";
  echo "<td>".$row["email"]."</td> ";
  echo "<td>".$row["shift"]."</td> ";
  echo "<td>".$row["user_name"]."</td> ";
  echo "<td>".$row["user_nickname"]."</td> ";
  //แก้ไขข้อมูล
  echo "<td><a href='#?ID=$row[0]'>edit</a></td> ";
  //ลบข้อมูล
  echo "<td><a href='#?ID=$row[0]'onclick=\"return confirm('Do you want to delete this record? !!!')\">del</a></td> ";
  echo "</tr>";
  }
  echo "</table>";
  //5. close connection
  mysqli_close($con);
  ?>
<br><br>
<center><h2>Test query DB</h2></center>
<?php
//1. เชื่อมต่อ database:
include('connection.php');

//2. query ข้อมูลจากตาราง users
$query = "SELECT * FROM users WHERE shift IN ('a','b') ORDER BY shift asc, id asc" or die("Error:" . mysqli_error());
//3.เก็บข้อมูลที่ query ออกมาไว้ในตัวแปร result
$result = mysqli_query($con, $query);
//4 . แสดงข้อมูลที่ query ออกมา โดยใช้ตารางในการจัดข้อมูล:

echo "<table border='1' align='center'>";
//หัวข้อตาราง
echo "<tr align='center' bgcolor='#CCCCCC'><td>Shift</td><td>username</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td><td>6</td><td>7</td><td>8</td><td>9</td><td>10</td><td>11</td><td>12</td><td>13</td><td>14</td><td>15</td><td>16</td><td>17</td><td>18</td><td>19</td><td>20</td><td>21</td><td>22</td><td>23</td><td>24</td><td>25</td><td>26</td><td>27</td><td>28</td><td>29</td><td>30</td><td>31</td><td>edit</td><td>delete</td></tr>";
//เนื้อหาที่ query มา
while($row = mysqli_fetch_array($result)) {
echo "<tr align='center' >";
echo "<td><a href='#?ID=$row[0]'>".$row["shift"]."</a></td> ";
echo "<td><a href='#?ID=$row[0]'>".$row["username"]."</a></td> ";
echo "<td><a href='#?ID=$row[0]'>".$row["user_name"]."</a></td> ";

//แก้ไขข้อมูล
echo "<td><a href='#?ID=$row[0]'>edit</a></td> ";
//ลบข้อมูล
echo "<td><a href='#?ID=$row[0]' onclick=\"return confirm('Do you want to delete this record? !!!')\">del</a></td> ";
echo "</tr>";
}
echo "</table>";
//5. close connection
mysqli_close($con);
?>
<br><br><br>
<center><button class="btn" onclick="history.go(-1);">Back</button></center>
</body>
</html>
