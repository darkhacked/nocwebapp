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
<link href="../css/bootstrap.css" rel="stylesheet">
<head>
	<title>Spector</title>
	<script src="../js/jquery.js"></script>
	<script src="../js/popper.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
</head>
<body>
	<script>
	// tooltip
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	</script>
	<!-- Start NAV BAR -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
	<a class="navbar-brand" href="#"><img src="../images/logo.png"></a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarColor02">

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
  <!-- Content here -->
<div class="container">
		<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
		<div class="row justify-content-md-center">
			<div class="col-md-auto mt-3">
			<h5>เลือกเดือน / ปี</h5>
		</div>
		<div class="col-2 mt-3">
		<select class="custom-select custom-select-sm" name="txt_month">
			<?php
			//Dropdown เดือน
			$month = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
					'05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
					'09' => 'กันยายน ', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
			$txtMonth = isset($_POST['txt_month']) && $_POST['txt_month'] != '' ? $_POST['txt_month'] : date('m');
			foreach($month as $i=>$mName) {
			 $selected = '';
			 if($txtMonth == $i) $selected = 'selected="selected"';
			 echo '<option value="'.$i.'" '.$selected.'>'. $mName .'</option>'."\n";
			}
			//Dropdown เดือน
			?>
		</select>
	</div>
		<div class="col-2 mt-3">
		<select class="custom-select custom-select-sm" name="txt_year">
			<?php
			//Dropdown ปี
			$txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');
			$yearStart = date('Y');
			$yearEnd = $txtYear-2;
			for($year=$yearStart;$year > $yearEnd;$year--){
			 $selected = '';
			 if($txtYear == $year) $selected = 'selected="selected"';
			 echo '<option value="'.$year.'" '.$selected.'>'. ($year) .'</option>'."\n";
			}
			//Dropdown ปี
			?>
		</select>
		</div>
		<div class="col-md-auto mt-3">
		<button class="btn btn-primary btn-sm" type="submit">GO !!</button>
		</div>
	</div>
	</form>
			<?php
			//รับค่าจาก Dropdown เดือน/ปี
			$year = isset($_POST['txt_year']) ? mysqli_real_escape_string($db, $_POST['txt_year']) : '';
			$month = isset($_POST['txt_month']) ? mysqli_real_escape_string($db, $_POST['txt_month']) : '';
			if($year == '' || $month == '') exit('<p><center>กรุณาระบุ "เดือน-ปี" ที่ต้องการเรียกดู</center></p>');
			?>
</div>
	<hr>

	<div class="container" align="center">
	<div class="alert alert-dismissible alert-warning">
		<button type="button" class="close" data-dismiss="alert">&times;</button>
		<h4 class="alert-heading">ประกาศ!</h4>
		<p class="mb-0">เดือนมิถุนายนให้ตำแหน่ง Seat ต่อไปนี้ <strong><u>เข้าทำงานที่ออฟฟิต</u> D0, D1, D2, B1, B4, B6, B7 และ TR</strong></p><p></p>
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Modal1">
			เรื่องปรับตารางใหม่และการ Training
		</button>
		<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#Modal2">
		หน้าที่ของแต่ละ Seat
		</button>
		<!-- Button trigger modal -->
		</div>
	</div>

<!-- Modal1 -->
<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">เรื่องปรับตารางใหม่และการ Training</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<small>1.สลับกะ วริศมาอยู่ AB จัด OT หยุดงาน 31/05 - 01/06 จัด OT แทนวันที่ 1/06/63</small><br>
				<small>2.ปรับชาตรีเข้ากะ CD</small><br>
				<small>3.AB รวมวริศ 13 คน CD รวมชาตรี 12 คน เพื่อ Balance Seat Day 10+Night 3 จัด OD กะ AB 1 Seat</small><br>
				<small>4. ใส่ OG ให้คนสอนงาน Solution 3BB (มีสลับ OT นัตตี้กับโจ้ จาก Sheet เดิม)</small><br><br>
				<small>Train งาน (เพื่อความต่อเนื่อง อบรมวันทำงาน จัด OT แทน)</small><br>
				<small>5. อดิสัย ณรรฏร์ธนน ประกบ HQ Seat D1</small><br>
				<small>6. บรรพต วุฒิชัย กนกวรรณ อาดุลย์ ประกบ Seat SE-ED, GFDD</small><br>
				<small>7. ณัฐวุฒิ ชินกฤต ประกบ HQ 3BB Seat 3-6</small><br>
				<small>8. สกลชัย กิตติ train Hosting</small><br>

			</div>
		</div>
	</div>
</div>

<!-- Modal2 -->
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">หน้าที่ของแต่ละ Seat</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="modal-body">
			<table class="table table-bordered" align='center'>
	<thead>
		<tr class="table-primary" align='center'>
			<th scope="col">ตัวแปร</th>
			<th scope="col"></th>
			<th scope="col">หน้าที่</th>
			<th scope="col">จำนวน Seat</th>
		</tr>
	</thead>
	<tbody>
		<tr align='center'>
			<td>B</td>
			<td style="vertical-align : middle;text-align:center;" rowspan="9">Daytime</td>
			<td>Assist</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B1</td>
			<td>D1</td>
			<td>2</td>
		</tr>
		<tr align='center'>
			<td>B2</td>
			<td>D2 Mon 2 (SSUP)</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B3</td>
			<td>D2 Mon 3 (SSUP KM_Interlap)</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B4</td>
			<td>D2 Mon 4 (Seed)</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B5</td>
			<td>D2 Mon 5 (Shell)</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B6</td>
			<td>D2 Mon 6 (Minor) + Hosting</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B7</td>
			<td>D2 Mon 7 (Dunkin GFDD)</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>B8</td>
			<td>D2 Mon 8 (MK)</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>N7</td>
			<td style="vertical-align : middle;text-align:center;" rowspan="3">Nighttime</td>
			<td>Assist+B1+B2</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>N8</td>
			<td>B3+B4+B5</td>
			<td>1</td>
		</tr>
		<tr align='center'>
			<td>N9</td>
			<td>B6+B7+B8</td>
			<td>1</td>
		</tr>
			</table>
		</div>
	</div>
</div>
</div>


<!-- start container -->
<div class="container-fluid">
	<div class="row">
		<!-- menu swap -->
		<div class="col-3">
			 <div class="alert alert-dismissible alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<h5>Status color</h5>
					<table>
				  <tr>
					<tr>
						<td style="background-color:#fff" width="20px"></td>
						<td>Seat A1 / A2 / D1 / D2</td>
					</tr>
					<tr>
						<td style="background-color:#ffcccc"></td>
						<td>Seat N</td>
				  </tr>
					<tr>
						<td style="background-color:#b7dee8"></td>
						<td>Seat GH</td>
				  </tr>
					<tr>
						<td style="background-color:#ff96ff"></td>
						<td>OD / ON จัดสรร</td>
				  </tr>
					<tr>
						<td style="background-color:#ff66cc"></td>
						<td>OT Training</td>
				  </tr>
					<tr>
						<td style="background-color:#ffff00"></td>
						<td>คำขออยู่ระหว่างพิจารณา</td>
				  </tr>
					<tr>
						<td style="background-color:#00ff00"></td>
						<td>คำขออนุมัติแล้ว / OT ที่ได้จากการแลกหรือลา</td>
				  </tr>
					<tr>
						<td style="background-color:#ff7b00"></td>
						<td>ลาไม่มีคนแทน / ลาระบุช่วงเวลา</td>
				  </tr>
					<tr>
						<td style="background-color:#ff0000"></td>
						<td>ขาดงาน</td>
				  </tr>
					<tr>
						<td style="background-color:#d3d3d3"></td>
						<td>วันหยุด</td>
				  </tr>
				</table>
				</div>  <!-- End menu swap-->
		</div> <!-- end menu swap -->

		<div class="col-9"><!-- Shift table -->
			<?php
			//ดึงข้อมูลพนักงานทั้งหมด
			//ในส่วนนี้จะเก็บข้อมูลโดยใช้คีย์ เป็นรหัสพนักงาน และ value คือชื่อพนักงาน
			$in1 = 1;
			$in2 = 1;
			$ia = 1;
			$ib = 1;
			$ic = 1;
			$id = 1;

			$allEmpDataA = array();
			$SQL = "SELECT * FROM users WHERE shift='A' ORDER BY shift , remark";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
			 $allEmpDataA[$row['username']] = $row['user_name'];
			}

			$allEmpDataB = array();
			$SQL = "SELECT * FROM users WHERE shift='B' ORDER BY shift , remark";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
			 $allEmpDataB[$row['username']] = $row['user_name'];
			}

			$allEmpDataC = array();
			$SQL = "SELECT * FROM users WHERE shift='C' ORDER BY shift , remark";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
			 $allEmpDataC[$row['username']] = $row['user_name'];
			}

			$allEmpDataD = array();
			$SQL = "SELECT * FROM users WHERE shift='D' ORDER BY shift , remark";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
			 $allEmpDataD[$row['username']] = $row['user_name'];
			}


			//เรียกข้อมูลของเดือนที่เลือก
			$allReportData = array();
			$SQL = "SELECT w_code, DAY(`w_date`) AS w_day, w_type FROM `work`
			WHERE `w_date` LIKE '$year-$month%'	GROUP by w_code,DAY(`w_date`)";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
				$allReportData[$row['w_code']][$row['w_day']] = $row['w_type'];

			}


			//tooltips
			$tools = array();
			$SQL = "SELECT w_code, DAY(`w_date`) AS w_day, w_tools FROM `work`
			WHERE `w_date` LIKE '$year-$month%'	GROUP by w_code,DAY(`w_date`)";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
				$tools[$row['w_code']][$row['w_day']] = $row['w_tools'];

			}


			//event สี
			$allColor = array();
			$SQL = "SELECT w_code, DAY(`w_date`) AS w_day, w_status FROM `work`
			WHERE `w_date` LIKE '$year-$month%'	GROUP by w_code,DAY(`w_date`)";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
				$allColor[$row['w_code']][$row['w_day']] = $row['w_status'];

			}


			//HTML TABLE HEAD SHIFT A
			echo "<table class=\"table table-bordered table-hover\" align='center'>";
			echo "<thead>";
			echo "<tr class=\"table-primary\" align='center'>";//เปิดแถวใหม่
			echo "<th rowspan=\"2\" scope=\"col\">No.</th>";
			echo "<th rowspan=\"2\" scope=\"col\">Sft</th>";
			echo "<th rowspan=\"2\" scope=\"col\">CODE</th>";
			echo "<th rowspan=\"2\" scope=\"col\">MEMBER GROUP 1</th>";

			//ตารางวันที่คำนวณวันที่สุดท้ายของเดือน
			$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
			$lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
			// echo "$timeDate";  // แสดง timestamp
			//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของเดือน
			for($day=1;$day<=$lastDay;$day++){
			 echo '<th>' . substr("".$day, -2) . '</th>';
			}

			echo "</tr>";



			echo "<tr class=\"table-primary\" align='center'>";//เปิดแถวใหม่ ตาราง HTML

			// ตารางวัน
			$Dday=date('w',strtotime($year.'-'.$month.'-01'));
			$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
			$numsday = date("t", $timeDate);                //จำนวนวันของเดือน
			for($day=1;$day<=$numsday;$day++); //หาวันที่ 1 ถึงวันที่สุดท้ายของดือน  เพื่อตัดวัน ( อา , จ, ..., ส ) ให้พอดีกับวันที่สุดท้าย (28, 29, 30, 31) ของเดือน
			//1
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//2
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//3
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//4
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//5
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//6
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//7
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//8
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//9
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//10
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//11
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//12
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//13
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//14
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//15
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//16
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//17
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//18
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//19
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//20
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//21
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//22
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//23
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//24
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//25
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//26
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//27
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//28
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//29
			if ($numsday<=28){echo" ";} else {
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//30
			if ($numsday<=29){echo" ";} else {
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//31
			if ($numsday<=30){echo" ";} else {
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";};};};}
			echo '</th>';
			// ตารางวัน



			echo "</tr>";
			echo "</thead>";
			//END HTML TABLE HEAD
			//Loopสร้างตารางตามจำนวนรายชื่อพนักงานใน Array
			foreach($allEmpDataA as $empCode=>$empName){
	     echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
			 echo '<td>'. $in1 .'</td>';
			 echo '<td>A'. $ia .'</td>';
	     echo '<td class="text-nowrap">'. $empCode .'</td>';
	     echo '<td class="text-nowrap">'. $empName .'</td>';
	      //เรียกข้อมูลวันทำงานพนักงานแต่ละคน ในเดือนนี้
		     for($d=1;$d<=$lastDay;$d++){
		      //ตรวจสอบว่าวันที่แต่ละวัน $d ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็นว่าง
		      $workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b><span data-toggle="tooltip" data-placement="top" title="'.$tools[$empCode][$d].'">'.$allReportData[$empCode][$d].'</span></b></td>' : '<td style="background-color:lightgray"></td>';
					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
					//echo "<td style=\"background-color:".$ccolor." \">".$workDay."</td>";
				echo $workDay;
				}
				$in1++;
				$ia++;
				echo '</tr>';//ปิดแถวตาราง HTML
		  }

			foreach($allEmpDataB as $empCode=>$empName){
	     echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
			 echo '<td>'. $in1 .'</td>';
			 echo '<td>B'. $ib .'</td>';
	     echo '<td class="text-nowrap">'. $empCode .'</td>';
	     echo '<td class="text-nowrap">'. $empName .'</td>';
	      //เรียกข้อมูลวันทำงานพนักงานแต่ละคน ในเดือนนี้
		     for($d=1;$d<=$lastDay;$d++){
		      //ตรวจสอบว่าวันที่แต่ละวัน $d ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็นว่าง
		      $workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b><span data-toggle="tooltip" data-placement="top" title="'.$tools[$empCode][$d].'">'.$allReportData[$empCode][$d].'</span></b></td>' : '<td style="background-color:lightgray"></td>';
					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
					//echo "<td style=\"background-color:".$ccolor." \">".$workDay."</td>";
				echo $workDay;
				}
				$in1++;
				$ib++;
				echo '</tr>';//ปิดแถวตาราง HTML
		  }

			/*echo "<tr align='center'>";
			echo '<td style="background-color:#ffff00" colspan="35" class="text-nowrap">รออัตราสรรหา</td>';
			echo '</tr>';*/



			//HTML TABLE HEAD SHIFT B
			echo "<thead>";
			echo "<tr class=\"table-primary\" align='center'>";//เปิดแถวใหม่ ตาราง HTML
			echo "<th rowspan=\"2\" scope=\"col\">No.</th>";
			echo "<th rowspan=\"2\" scope=\"col\">Sft</th>";
			echo "<th rowspan=\"2\" scope=\"col\">CODE</th>";
			echo "<th rowspan=\"2\" scope=\"col\">MEMBER GROUP 2</th>";

			//คำนวณวันที่สุดท้ายของเดือน
			$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
			$lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
			 //echo "$timeDate";  // แสดง timestamp
			//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของเดือน
			for($day=1;$day<=$lastDay;$day++){
			 echo '<th>' . substr("".$day, -2) . '</th>';
			}

			echo "</tr>";


			echo "<tr class=\"table-primary\" align='center'>";//เปิดแถวใหม่ ตาราง HTML

			// ตารางวัน
			$Dday=date('w',strtotime($year.'-'.$month.'-01'));
			$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
			$numsday = date("t", $timeDate);                //จำนวนวันของเดือน
			for($day=1;$day<=$numsday;$day++); //หาวันที่ 1 ถึงวันที่สุดท้ายของดือน  เพื่อตัดวัน ( อา , จ, ..., ส ) ให้พอดีกับวันที่สุดท้าย (28, 29, 30, 31) ของเดือน
			//1
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//2
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//3
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//4
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//5
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//6
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//7
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//8
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//9
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//10
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//11
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//12
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//13
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//14
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//15
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//16
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//17
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//18
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//19
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//20
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//21
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//22
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//23
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//24
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//25
			if($Dday==4){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==5){echo "<th>จ";}else if($Dday==6){echo "<th>อ";}else if($Dday==0){echo "<th>พ";}else if($Dday==1){echo "<th>พฤ</font>";}else if($Dday==2){echo "<th>ศ";}else if($Dday==3){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//26
			if($Dday==3){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==4){echo "<th>จ";}else if($Dday==5){echo "<th>อ";}else if($Dday==6){echo "<th>พ";}else if($Dday==0){echo "<th>พฤ</font>";}else if($Dday==1){echo "<th>ศ";}else if($Dday==2){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//27
			if($Dday==2){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==3){echo "<th>จ";}else if($Dday==4){echo "<th>อ";}else if($Dday==5){echo "<th>พ";}else if($Dday==6){echo "<th>พฤ</font>";}else if($Dday==0){echo "<th>ศ";}else if($Dday==1){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//28
			if($Dday==1){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==2){echo "<th>จ";}else if($Dday==3){echo "<th>อ";}else if($Dday==4){echo "<th>พ";}else if($Dday==5){echo "<th>พฤ</font>";}else if($Dday==6){echo "<th>ศ";}else if($Dday==0){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//29
			if ($numsday<=28){echo" ";} else {
			if($Dday==0){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==1){echo "<th>จ";}else if($Dday==2){echo "<th>อ";}else if($Dday==3){echo "<th>พ";}else if($Dday==4){echo "<th>พฤ</font>";}else if($Dday==5){echo "<th>ศ";}else if($Dday==6){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//30
			if ($numsday<=29){echo" ";} else {
			if($Dday==6){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==0){echo "<th>จ";}else if($Dday==1){echo "<th>อ";}else if($Dday==2){echo "<th>พ";}else if($Dday==3){echo "<th>พฤ</font>";}else if($Dday==4){echo "<th>ศ";}else if($Dday==5){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";}
			echo '</th>';
			//31
			if ($numsday<=30){echo" ";} else {
			if($Dday==5){echo"<th><font color='orange'><b>อา</b></font>";}else if($Dday==6){echo "<th>จ";}else if($Dday==0){echo "<th>อ";}else if($Dday==1){echo "<th>พ";}else if($Dday==2){echo "<th>พฤ</font>";}else if($Dday==3){echo "<th>ศ";}else if($Dday==4){echo "<th align='center'><font color='orange'><b>ส</b></font>";}else{echo " ";};};};}
			echo '</th>';
			// ตารางวัน



			echo "</tr>";
			echo "</thead>";
			//END HTML TABLE HEAD
			//Loopสร้างตารางตามจำนวนรายชื่อพนักงานใน Array

			foreach($allEmpDataC as $empCode=>$empName){
	     echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
			 echo '<td>'. $in2 .'</td>';
			 echo '<td>C'. $ic .'</td>';
	     echo '<td>'. $empCode .'</td>';
	     echo '<td>'. $empName .'</td>';
	      //เรียกข้อมูลวันทำงานพนักงานแต่ละคน ในเดือนนี้
		     for($d=1;$d<=$lastDay;$d++){
		      //ตรวจสอบว่าวันที่แต่ละวัน $d ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็นว่าง
					$workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b><span data-toggle="tooltip" data-placement="top" title="'.$tools[$empCode][$d].'">'.$allReportData[$empCode][$d].'</span></b></td>' : '<td style="background-color:lightgray"></td>';					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
					echo $workDay;

					}
					$in2++;
					$ic++;
				echo '</tr>';//ปิดแถวตาราง HTML
		  }

			foreach($allEmpDataD as $empCode=>$empName){
	     echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
			 echo '<td>'. $in2 .'</td>';
			 echo '<td>D'. $id .'</td>';
	     echo '<td>'. $empCode .'</td>';
	     echo '<td>'. $empName .'</td>';
	      //เรียกข้อมูลวันทำงานพนักงานแต่ละคน ในเดือนนี้
		     for($d=1;$d<=$lastDay;$d++){
		      //ตรวจสอบว่าวันที่แต่ละวัน $d ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็นว่าง
					$workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b><span data-toggle="tooltip" data-placement="top" title="'.$tools[$empCode][$d].'">'.$allReportData[$empCode][$d].'</span></b></td>' : '<td style="background-color:lightgray"></td>';					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
					echo $workDay;

					}
					$in2++;
					$id++;
				echo '</tr>';//ปิดแถวตาราง HTML
		  }

			echo "<tr align='center'>";
			echo '<td style="background-color:#ffff00" colspan="35" class="text-nowrap">รออัตราสรรหา</td>';
			echo '</tr>';


	    echo "</table>";
			//mysqli_close($db);//ปิดการเชื่อมต่อฐานข้อมูล
			?>
		</div><!-- End Shift table -->
	 </div> <!-- end container -->
		 <br>
		<div><iframe src="../credit.html" width="100%" frameBorder="0"></iframe></div>
		<br>
</div>
</body>
</html>
