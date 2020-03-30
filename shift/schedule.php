<?php
	include('functions.php');

	if (!isLoggedIn()) {
		header('location: login.php');
	}
?>

<!DOCTYPE html>
<html>
<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
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
			<li class="nav-item">
				<a class="nav-link" href="index.php">สถานะคำขออนุมัติ</a>
			</li>
			<li class="nav-item active">
				<a class="nav-link" href="schedule.php">ตารางงาน<span class="sr-only">(current)</span></a>
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
<!-- start container -->
<div class="container-fluid">
	<div class="row">
		<div class="col-9">
			<center><h2>Schedule <?php echo $month; ?> / <?php echo $year; ?></h2></center>
			<?php
			//ดึงข้อมูลพนักงานทั้งหมด
			//ในส่วนนี้จะเก็บข้อมูลโดยใช้คีย์ เป็นรหัสพนักงาน และ value คือชื่อพนักงาน
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


			// แสดงผล array
			/*echo "<pre>";
			print_r($allEmpDataA);
			echo "</pre>";*/

			//เรียกข้อมูลของเดือนที่เลือก
			$allReportData = array();
			//$tablecl = "";
			$SQL = "SELECT w_code, DAY(`w_date`) AS w_day, w_type FROM `work`
			WHERE `w_date` LIKE '$year-$month%'	GROUP by w_code,DAY(`w_date`)";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
				$allReportData[$row['w_code']][$row['w_day']] = $row['w_type'];

		 	// ทำที่บ้านเบ้น
			//$cif = $row['w_type'];

			// if($cif==''){ $tablecl=""; }
			//	elseif($cif=='D'){ $tablecl = "#FF0000";}
			//	elseif ($cif=='N') { $tablecl = "#FFFF00";}
			//	elseif ($cif=='D2') { $tablecl = "#00FF00";}
			//	elseif ($cif=='A1') { $tablecl = "#00FFFF";}
			//	elseif ($cif=='A2') { $tablecl = "#CCFF00";}
			//	elseif ($cif=='OD') { $tablecl = "#FFCC00";}
			//	elseif ($cif=='G') { $tablecl = "#FFFFCC";}
			//	elseif ($cif=='GH') { $tablecl = "#CCFFCC";}
				//echo $tablecl;
			//echo $cif;
			}

			/*if($cif==''){ $tablecl=""; }
			elseif($cif=='D'){ $tablecl = "#FF0000";}
			elseif ($cif=='N') { $tablecl = "#FFFF00";}
			elseif ($cif=='D2') { $tablecl = "#00FF00";}
			elseif ($cif=='A1') { $tablecl = "#00FFFF";}
			elseif ($cif=='A2') { $tablecl = "#CCFF00";}
			elseif ($cif=='OD') { $tablecl = "#FFCC00";}
			elseif ($cif=='G') { $tablecl = "#FFFFCC";}
			elseif ($cif=='GH') { $tablecl = "#CCFFCC";}*/

			//echo ค่าสี่เฉยๆ
			/*$cusColor = "SELECT w_type FROM `work`" or die("Error:" . mysqli_error());
			$qry = mysqli_query($db, $cusColor);
			while ($qry2 = mysqli_fetch_array($qry)) {
				switch ($qry2["w_type"]) {
					case 'N':$ccolor = "#FF0000";break;
					case 'D':$ccolor = "#FFFFFF";break;

					default:$ccolor ="#C0C0C0";
						break;
				}
				//echo "<td>".$ccolor["w_type"]."</td> ";
			}*/




			//HTML TABLE HEAD SHIFT A
			echo "<table class=\"table table-bordered table-hover\" align='center'>";
			echo "<thead>";
			echo "<tr class=\"table-primary\" align='center'>";//เปิดแถวใหม่ ตาราง HTML
			echo "<th scope=\"col\">CODE</th>";
			echo "<th scope=\"col\">MEMBER SHIFT A</th>";

			//คำนวณวันที่สุดท้ายของเดือน
			$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
			$lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
			// echo "$timeDate";  // แสดง timestamp
			//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของเดือน
			for($day=1;$day<=$lastDay;$day++){
			 echo '<th>' . substr("".$day, -2) . '</th>';
			}
			echo "</tr>";
			echo "</thead>";
			//END HTML TABLE HEAD
			//Loopสร้างตารางตามจำนวนรายชื่อพนักงานใน Array
	    foreach($allEmpDataA as $empCode=>$empName){
	     echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
	     echo '<td>'. $empCode .'</td>';
	     echo '<td>'. $empName .'</td>';
	      //เรียกข้อมูลวันทำงานพนักงานแต่ละคน ในเดือนนี้
		     for($d=1;$d<=$lastDay;$d++){
		      //ตรวจสอบว่าวันที่แต่ละวัน $d ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็นว่าง
		      $workDay = isset($allReportData[$empCode][$d]) ? '<div><b>'.$allReportData[$empCode][$d].'</b></div>' : '<div style="background-color:lightgray"><font color="lightgray">.</font></div>';
					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
					//echo "<td style=\"background-color:".$ccolor." \">".$workDay."</td>";
					echo "<td>".$workDay."</td>";
				}
		  }
			echo '</tr>';//ปิดแถวตาราง HTML
			//ไว้แสดงผล array
	    /*echo "<pre>";
			print_r($allEmpDataA);
			echo "allreport data";
			echo "<br>";
	    print_r($allReportData);
	    echo "</pre>";*/

			//HTML TABLE HEAD SHIFT B
			echo "<thead>";
			echo "<tr class=\"table-primary\" align='center'>";//เปิดแถวใหม่ ตาราง HTML
			echo "<th scope=\"col\">CODE</th>";
			echo "<th scope=\"col\">MEMBER SHIFT B</th>";

			//คำนวณวันที่สุดท้ายของเดือน
			$timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
			$lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
			 //echo "$timeDate";  // แสดง timestamp
			//สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของเดือน
			for($day=1;$day<=$lastDay;$day++){
			 echo '<th>' . substr("".$day, -2) . '</th>';
			}

			echo "</tr>";
			echo "</thead>";
			//END HTML TABLE HEAD
			//Loopสร้างตารางตามจำนวนรายชื่อพนักงานใน Array
	    foreach($allEmpDataB as $empCode=>$empName){
	     echo "<tr align='center'>"; //เปิดแถวใหม่ ตาราง HTML
	     echo '<td>'. $empCode .'</td>';
	     echo '<td>'. $empName .'</td>';
	      //เรียกข้อมูลวันทำงานพนักงานแต่ละคน ในเดือนนี้
		     for($d=1;$d<=$lastDay;$d++){
		      //ตรวจสอบว่าวันที่แต่ละวัน $d ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็นว่าง
		      $workDay = isset($allReportData[$empCode][$d]) ? '<div><b>'.$allReportData[$empCode][$d].'</b></div>' : '<div style="background-color:lightgray"><font color="lightgray">.</font></div>';
					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
					echo "<td>", $workDay, "</td>";

					}
		  }
			echo '</tr>';//ปิดแถวตาราง HTML
	    echo "</table>";
			//mysqli_close($db);//ปิดการเชื่อมต่อฐานข้อมูล
			?>
		 </div>

		 <!-- menu swap -->
		 <div class="col-3">
			 <center><h2>ระบบ แลก/ลา<br>(ใช้ไม่ได้ยังทำยังไม่เสร็จ)</h2></center>
			 <div class="accordion" id="menuall"> <!-- menu accordion -->
					<div class="card"> <!-- menu 1 -->
					<div class="card-header" id="headingOne">
					<h2 class="mb-0">
						<center>
						 <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#menu1" aria-expanded="true" aria-controls="menu1">
							 ลาปกติ (เต็มวัน)
						 </button>
				 	</center>
					</h2>
					</div>
					<div id="menu1" class="collapse" aria-labelledby="headingOne" data-parent="#menuall">
					<div class="card-body">
						<form method="post" action="shift_functions.php">
							<div class="form-group">
									<input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
							    <input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
							    <input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
									<input type="hidden" name="c_labelmain" value="ลาปกติ (เต็มวัน)">
								เลือกประเภทการลา
								<div class="custom-control custom-radio">
						      <input type="radio" id="customRadio1" value="ลาป่วย" name="c_label" class="custom-control-input">
						      <label class="custom-control-label" for="customRadio1">ลาป่วย</label>
						    </div>
								<div class="custom-control custom-radio">
						      <input type="radio" id="customRadio2" value="ลาป่วย (ไม่มีคนแทน)" name="c_label" class="custom-control-input">
						      <label class="custom-control-label" for="customRadio2">ลาป่วย (ไม่มีคนแทน)</label>
						    </div>
						    <div class="custom-control custom-radio">
						      <input type="radio" id="customRadio3" value="ลาพักผ่อน" name="c_label" class="custom-control-input">
						      <label class="custom-control-label" for="customRadio3">ลาพักผ่อน</label>
						    </div>
						    <div class="custom-control custom-radio">
						      <input type="radio" id="customRadio4" value="ลากิจ" name="c_label" class="custom-control-input">
						      <label class="custom-control-label" for="customRadio4">ลากิจ</label>
						    </div><hr>
								ระบุวันลา
								<div class="form-row">
									<div class="col-md-3">
									<select name="day_host" class="custom-select custom-select-sm">
										<option selected>วัน</option>
										<option value="01">1</option>
										<option value="02">2</option>
										<option value="03">3</option>
										<option value="04">4</option>
										<option value="05">5</option>
										<option value="06">6</option>
										<option value="07">7</option>
										<option value="08">8</option>
										<option value="09">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
									</div>
								<div class="col-md-4">
								<select name="month_host" class="custom-select custom-select-sm">
									<option selected>เดือน</option>
									<option value="01-">มกราคม</option>
									<option value="02-">กุมพาพันธ์</option>
									<option value="03-">มีนาคม</option>
									<option value="04-">เมษายน</option>
									<option value="05-">พฤษภาคม</option>
									<option value="06-">มิถุนายน</option>
									<option value="07-">กรกฎาคม</option>
									<option value="08-">สิงหาคม</option>
									<option value="09-">กันยายน</option>
									<option value="10-">ตุลาคม</option>
									<option value="11-">พฤศจิกายน</option>
									<option value="12-">ธันวาคม</option>
								</select>
								</div>
								<div class="col-md-3">
								<select name="year_host" class="custom-select custom-select-sm">
									<option selected>ปี</option>
									<option value="2020-">2020</option>
								</select>
								</div>
							</div><hr>
							ระบุ Seat ในวันที่ลาของท่าน
							<div class="form-row">
								<div>
								<select name="c_seat_host" class="custom-select custom-select-sm">
									<option value="A1">A1</option>
									<option value="A2">A2</option>
									<option value="D1">D1</option>
									<option value="D2">D2</option>
									<option value="N">N</option>
									<option value="OD">OD</option>
									<option value="ON">ON</option>
									<option value="G">G</option>
								</select>
								</div>
							</div><hr>
								(หากลาแบบไม่มีคนแทนข้ามไปเลยครับ)
								<div class="form-row">
									<div>
									<select name="c_code_visit" class="custom-select custom-select-sm">
										<option value="-">เลือกผู้ปฏิบัติงานแทน</option>
										<?php
										$SQL = "SELECT * FROM users WHERE user_type='user' ORDER BY shift , remark";
										$qry = mysqli_query($db, $SQL);
										while ($listEmp = mysqli_fetch_array($qry)) {
										?>
										<option value="<?php echo $listEmp["username"]; ?>">
											<?php echo $listEmp["username"]." - ".$listEmp["user_name"]." (".$listEmp["shift"].")"; ?></option>
										<?php
										}
										?>
										</select>
										</div>
										<br>
										</div><hr><br>
									<center><button type="submit" class="btn btn-primary" name="swapmenu1">SEND</button></center>
							</div>
				</form>
					</div>
					</div>
					</div>
					<!-- end menu 1 -->
					<!-- menu 2 -->
					<div class="card">
					<div class="card-header" id="headingTwo">
					<h2 class="mb-0">
						<center>
							 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#menu2" aria-expanded="false" aria-controls="menu2">
								 ลาระบุช่วงเวลา
							 </button>
						</center>
					</h2>
					</div>
					<div id="menu2" class="collapse" aria-labelledby="headingTwo" data-parent="#menuall">
					<div class="card-body">
						<form method="post" action="shift_functions.php">
 						 <div class="form-group">
							 <input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
							 <input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
							 <input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
							 <input type="hidden" name="c_labelmain" value="ลาระบุช่วงเวลา">
 							 เลือกประเภทการลา
							 <div class="custom-control custom-radio">
								 <input type="radio" id="customRadio5" value="ลาป่วย" name="c_label" class="custom-control-input">
								 <label class="custom-control-label" for="customRadio5">ลาป่วย</label>
							 </div>
							 <div class="custom-control custom-radio">
								 <input type="radio" id="customRadio6" value="ลาพักผ่อน" name="c_label" class="custom-control-input">
								 <label class="custom-control-label" for="customRadio6">ลาพักผ่อน</label>
							 </div>
							 <div class="custom-control custom-radio">
								 <input type="radio" id="customRadio7" value="ลากิจ" name="c_label" class="custom-control-input">
								 <label class="custom-control-label" for="customRadio7">ลากิจ</label>
							 </div><hr>
							 ระบุวันลา
							 <div class="form-row">
								 <div class="col-md-3">
								 <select name="day_host" class="custom-select custom-select-sm">
									 <option selected>วัน</option>
									 <option value="01">1</option>
									 <option value="02">2</option>
									 <option value="03">3</option>
									 <option value="04">4</option>
									 <option value="05">5</option>
									 <option value="06">6</option>
									 <option value="07">7</option>
									 <option value="08">8</option>
									 <option value="09">9</option>
									 <option value="10">10</option>
									 <option value="11">11</option>
									 <option value="12">12</option>
									 <option value="13">13</option>
									 <option value="14">14</option>
									 <option value="15">15</option>
									 <option value="16">16</option>
									 <option value="17">17</option>
									 <option value="18">18</option>
									 <option value="19">19</option>
									 <option value="20">20</option>
									 <option value="21">21</option>
									 <option value="22">22</option>
									 <option value="23">23</option>
									 <option value="24">24</option>
									 <option value="25">25</option>
									 <option value="26">26</option>
									 <option value="27">27</option>
									 <option value="28">28</option>
									 <option value="29">29</option>
									 <option value="30">30</option>
									 <option value="31">31</option>
								 </select>
								 </div>
							 <div class="col-md-4">
							 <select name="month_host" class="custom-select custom-select-sm">
								 <option selected>เดือน</option>
								 <option value="01-">มกราคม</option>
								 <option value="02-">กุมพาพันธ์</option>
								 <option value="03-">มีนาคม</option>
								 <option value="04-">เมษายน</option>
								 <option value="05-">พฤษภาคม</option>
								 <option value="06-">มิถุนายน</option>
								 <option value="07-">กรกฎาคม</option>
								 <option value="08-">สิงหาคม</option>
								 <option value="09-">กันยายน</option>
								 <option value="10-">ตุลาคม</option>
								 <option value="11-">พฤศจิกายน</option>
								 <option value="12-">ธันวาคม</option>
							 </select>
							 </div>
							 <div class="col-md-3">
							 <select name="year_host" class="custom-select custom-select-sm">
								 <option selected>ปี</option>
								 <option value="2020-">2020</option>
							 </select>
							 </div>
						 </div><hr>
						 ระบุ Seat ในวันที่ลาของท่าน
						 <div class="form-row">
							 <div>
							 <select name="c_seat_host" class="custom-select custom-select-sm">
								 <option value="A1">A1</option>
								 <option value="A2">A2</option>
								 <option value="D1">D1</option>
								 <option value="D2">D2</option>
								 <option value="N">N</option>
								 <option value="OD">OD</option>
								 <option value="ON">ON</option>
								 <option value="G">G</option>
							 </select>
							 </div>
						 </div><hr>
 							 ระบุช่วงเวลา
 							 <div class="form-row">
								 <div>ตั้งแต่</div>
 								 <div class="col-md-4">
 								 <select name="c_re1" class="custom-select custom-select-sm">
									 <option value="00:00">00:00</option>
									 <option value="00:30">00:30</option>
									 <option value="01:00">01:00</option>
									 <option value="01:30">01:30</option>
									 <option value="02:00">02:00</option>
									 <option value="02:30">02:30</option>
									 <option value="03:00">03:00</option>
									 <option value="03:30">03:30</option>
									 <option value="04:00">04:00</option>
									 <option value="04:30">04:30</option>
									 <option value="05:00">05:00</option>
									 <option value="05:30">05:30</option>
									 <option value="06:00">06:00</option>
									 <option value="06:30">06:30</option>
									 <option value="07:00">07:00</option>
									 <option value="07:30">07:30</option>
									 <option value="08:00">08:00</option>
									 <option value="08:30">08:30</option>
									 <option value="09:00">09:00</option>
									 <option value="09:30">09:30</option>
									 <option value="10:00">10:00</option>
									 <option value="10:30">10:30</option>
									 <option value="11:00">11:00</option>
									 <option value="11:30">11:30</option>
									 <option value="12:00">12:00</option>
									 <option value="12:30">12:30</option>
									 <option value="13:00">13:00</option>
									 <option value="13:30">13:30</option>
									 <option value="14:00">14:00</option>
									 <option value="14:30">14:30</option>
									 <option value="15:00">15:00</option>
									 <option value="15:30">15:30</option>
									 <option value="16:00">16:00</option>
									 <option value="16:30">16:30</option>
									 <option value="17:00">17:00</option>
									 <option value="17:30">17:30</option>
									 <option value="18:00">18:00</option>
									 <option value="18:30">18:30</option>
									 <option value="19:00">19:00</option>
									 <option value="19:30">19:30</option>
									 <option value="20:00">20:00</option>
									 <option value="20:30">20:30</option>
									 <option value="21:00">21:00</option>
									 <option value="21:30">21:30</option>
									 <option value="22:00">22:00</option>
									 <option value="22:30">22:30</option>
									 <option value="23:00">23:00</option>
									 <option value="23:30">23:30</option>
 								 </select>
 								 </div>
								 <div>ถึง</div>
	 							 <div class="col-md-4">
		 							 <select name="c_re2" class="custom-select custom-select-sm">
										 <option value="00:00">00:00</option>
										 <option value="00:30">00:30</option>
										 <option value="01:00">01:00</option>
										 <option value="01:30">01:30</option>
										 <option value="02:00">02:00</option>
										 <option value="02:30">02:30</option>
										 <option value="03:00">03:00</option>
										 <option value="03:30">03:30</option>
										 <option value="04:00">04:00</option>
										 <option value="04:30">04:30</option>
										 <option value="05:00">05:00</option>
										 <option value="05:30">05:30</option>
										 <option value="06:00">06:00</option>
										 <option value="06:30">06:30</option>
										 <option value="07:00">07:00</option>
										 <option value="07:30">07:30</option>
										 <option value="08:00">08:00</option>
										 <option value="08:30">08:30</option>
										 <option value="09:00">09:00</option>
										 <option value="09:30">09:30</option>
										 <option value="10:00">10:00</option>
										 <option value="10:30">10:30</option>
										 <option value="11:00">11:00</option>
										 <option value="11:30">11:30</option>
										 <option value="12:00">12:00</option>
										 <option value="12:30">12:30</option>
										 <option value="13:00">13:00</option>
										 <option value="13:30">13:30</option>
										 <option value="14:00">14:00</option>
										 <option value="14:30">14:30</option>
										 <option value="15:00">15:00</option>
										 <option value="15:30">15:30</option>
										 <option value="16:00">16:00</option>
										 <option value="16:30">16:30</option>
										 <option value="17:00">17:00</option>
										 <option value="17:30">17:30</option>
										 <option value="18:00">18:00</option>
										 <option value="18:30">18:30</option>
										 <option value="19:00">19:00</option>
										 <option value="19:30">19:30</option>
										 <option value="20:00">20:00</option>
										 <option value="20:30">20:30</option>
										 <option value="21:00">21:00</option>
										 <option value="21:30">21:30</option>
										 <option value="22:00">22:00</option>
										 <option value="22:30">22:30</option>
										 <option value="23:00">23:00</option>
										 <option value="23:30">23:30</option>
		 							 </select>
	 							 </div>
 						 </div><hr>
						 <center><button type="submit" class="btn btn-primary" name="swapmenu2">SEND</button></center>
 								 <!--<center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submenu2">SEND</button></center>-->
 						 </div>
 			 </form>
					</div>
					</div>
					</div>
					<!-- end menu 2 -->
					<!-- menu 3 -->
					<div class="card">
					<div class="card-header" id="headingThree">
					<h2 class="mb-0">
						<center>
					 		<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#menu3" aria-expanded="false" aria-controls="menu3">
						 		ขออนุมัติสลับกะ (กะเดียวกัน)
					 		</button>
						</center>
					</h2>
					</div>
					<div id="menu3" class="collapse" aria-labelledby="headingThree" data-parent="#menuall">
					<div class="card-body">
						<form method="post" action="shift_functions.php">
							 <div class="form-group">
								 <input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
								 <input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
								 <input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
								 <input type="hidden" name="c_labelmain" value="สลับกะ (กะเดียวกัน)">
								 ระบุวันที่ต้องการสลับ
 								<div class="form-row">
 									<div class="col-md-3">
 									<select name="day_host" class="custom-select custom-select-sm">
 										<option selected>วัน</option>
 										<option value="01">1</option>
 										<option value="02">2</option>
 										<option value="03">3</option>
 										<option value="04">4</option>
 										<option value="05">5</option>
 										<option value="06">6</option>
 										<option value="07">7</option>
 										<option value="08">8</option>
 										<option value="09">9</option>
 										<option value="10">10</option>
 										<option value="11">11</option>
 										<option value="12">12</option>
 										<option value="13">13</option>
 										<option value="14">14</option>
 										<option value="15">15</option>
 										<option value="16">16</option>
 										<option value="17">17</option>
 										<option value="18">18</option>
 										<option value="19">19</option>
 										<option value="20">20</option>
 										<option value="21">21</option>
 										<option value="22">22</option>
 										<option value="23">23</option>
 										<option value="24">24</option>
 										<option value="25">25</option>
 										<option value="26">26</option>
 										<option value="27">27</option>
 										<option value="28">28</option>
 										<option value="29">29</option>
 										<option value="30">30</option>
 										<option value="31">31</option>
 									</select>
 									</div>
 								<div class="col-md-4">
 								<select name="month_host" class="custom-select custom-select-sm">
 									<option selected>เดือน</option>
 									<option value="01">มกราคม</option>
 									<option value="02">กุมพาพันธ์</option>
 									<option value="03">มีนาคม</option>
 									<option value="04">เมษายน</option>
 									<option value="05">พฤษภาคม</option>
 									<option value="06">มิถุนายน</option>
 									<option value="07">กรกฎาคม</option>
 									<option value="08">สิงหาคม</option>
 									<option value="09">กันยายน</option>
 									<option value="10">ตุลาคม</option>
 									<option value="11">พฤศจิกายน</option>
 									<option value="12">ธันวาคม</option>
 								</select>
 								</div>
 								<div class="col-md-3">
 								<select name="year_host" class="custom-select custom-select-sm">
 									<option selected>ปี</option>
 									<option value="2020">2020</option>
 								</select>
 								</div>
 							</div>
								 <hr>
								 เลือกพนักงานที่ต้องการสลับกะ
 								<div class="form-row">
 									<div class="col">
 									<select name="c_code_visit" class="custom-select custom-select-sm">
										<?php
										$sft = $_SESSION['user']['shift']; // กำหนดตัวแปร
										$SQL = "SELECT * FROM users WHERE user_type='user' AND shift='$sft' ORDER BY shift , remark";
										$qry = mysqli_query($db, $SQL);
										while ($listEmp = mysqli_fetch_array($qry)) {
										?>
										<option value="<?php echo $listEmp["username"]; ?>">
											<?php echo $listEmp["username"]." - ".$listEmp["user_name"]." (".$listEmp["shift"].")"; ?></option>
										<?php
										}
										?>
 										</select>
 										</div>
 									</div><br>
									 <center><button class="btn btn-primary" type="submit" name="swapmenu3">SEND</button></center>
							 </div>
				 </form>
					</div>
					</div>
					</div>
					<!-- end menu 3 -->
					<!-- menu 4 -->
					<div class="card">
					<div class="card-header" id="headingFour">
					<h2 class="mb-0">
						<center>
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#menu4" aria-expanded="false" aria-controls="menu4">
								ขออนุมัติสลับกะ (ระหว่างกะ)
							</button>
						</center>
					</h2>
					</div>
					<div id="menu4" class="collapse" aria-labelledby="headingFour" data-parent="#menuall">
					<div class="card-body">
						<form method="post" action="menu4.php">
							 <div class="form-group">
								 <!--- <fieldset disabled="">
									 <label class="control-label" for="disabledInput">ชื่อ - สกุล</label>
									 <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $_SESSION['user']['user_name']; ?>" disabled="">
									 <label class="control-label" for="disabledInput">WorkID</label>
									 <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $_SESSION['user']['username']; ?>" disabled="">
									 <label class="control-label" for="disabledInput">Shift</label>
									 <input class="form-control" id="disabledInput" type="text" placeholder="<?php echo $_SESSION['user']['shift']; ?>" disabled="">
								 </fieldset> -->
								<div class="mt-3">ระบุวันที่สลับกะของท่าน</div>
								<div class="form-row">
									<div class="col-md-3 mt-3">
									<select class="custom-select custom-select-sm">
										<option selected>วัน</option>
										<option value="01">1</option>
										<option value="02">2</option>
										<option value="03">3</option>
										<option value="04">4</option>
										<option value="05">5</option>
										<option value="06">6</option>
										<option value="07">7</option>
										<option value="08">8</option>
										<option value="09">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
										<option value="31">31</option>
									</select>
									</div>
								<div class="col-md-4 mt-3">
								<select class="custom-select custom-select-sm">
									<option selected>เดือน</option>
									<option value="01">มกราคม</option>
									<option value="02">กุมพาพันธ์</option>
									<option value="03">มีนาคม</option>
									<option value="04">เมษายน</option>
									<option value="05">พฤษภาคม</option>
									<option value="06">มิถุนายน</option>
									<option value="07">กรกฎาคม</option>
									<option value="08">สิงหาคม</option>
									<option value="09">กันยายน</option>
									<option value="10">ตุลาคม</option>
									<option value="11">พฤศจิกายน</option>
									<option value="12">ธันวาคม</option>
								</select>
								</div>
								<div class="col-md-3 mt-3">
								<select class="custom-select custom-select-sm">
									<option selected>ปี</option>
									<option value="2020">2020</option>
								</select>
								</div>
							</div><hr>
								 เลือกพนักงานที่ต้องการสลับกะ
								<div class="form-row">
									<div class="col">
									<select class="custom-select custom-select-sm">
										<option value="">Please Select Item</option>
										<?php
										$SQL = "SELECT * FROM users WHERE user_type='user' ORDER BY shift , remark";
										$qry = mysqli_query($db, $SQL);
										while ($listEmp = mysqli_fetch_array($qry)) {
										?>
										<option value="<?php echo $listEmp["username"]["user_name"]; ?>">
											<?php echo $listEmp["username"]." - ".$listEmp["user_name"]." (".$listEmp["shift"].")"; ?></option>
										<?php
										}
										?>
										</select>
										</div>
									</div>
									<div class="mt-3">ระบุวันที่ต้องการสลับกะ</div>
 								<div class="form-row">
 									<div class="col-md-3 mt-3">
 									<select class="custom-select custom-select-sm">
 										<option selected>วัน</option>
 										<option value="01">1</option>
 										<option value="02">2</option>
 										<option value="03">3</option>
 										<option value="04">4</option>
 										<option value="05">5</option>
 										<option value="06">6</option>
 										<option value="07">7</option>
 										<option value="08">8</option>
 										<option value="09">9</option>
 										<option value="10">10</option>
 										<option value="11">11</option>
 										<option value="12">12</option>
 										<option value="13">13</option>
 										<option value="14">14</option>
 										<option value="15">15</option>
 										<option value="16">16</option>
 										<option value="17">17</option>
 										<option value="18">18</option>
 										<option value="19">19</option>
 										<option value="20">20</option>
 										<option value="21">21</option>
 										<option value="22">22</option>
 										<option value="23">23</option>
 										<option value="24">24</option>
 										<option value="25">25</option>
 										<option value="26">26</option>
 										<option value="27">27</option>
 										<option value="28">28</option>
 										<option value="29">29</option>
 										<option value="30">30</option>
 										<option value="31">31</option>
 									</select>
 									</div>
 								<div class="col-md-4 mt-3">
 								<select class="custom-select custom-select-sm">
 									<option selected>เดือน</option>
 									<option value="01">มกราคม</option>
 									<option value="02">กุมพาพันธ์</option>
 									<option value="03">มีนาคม</option>
 									<option value="04">เมษายน</option>
 									<option value="05">พฤษภาคม</option>
 									<option value="06">มิถุนายน</option>
 									<option value="07">กรกฎาคม</option>
 									<option value="08">สิงหาคม</option>
 									<option value="09">กันยายน</option>
 									<option value="10">ตุลาคม</option>
 									<option value="11">พฤศจิกายน</option>
 									<option value="12">ธันวาคม</option>
 								</select>
 								</div>
 								<div class="col-md-3 mt-3">
 								<select class="custom-select custom-select-sm">
 									<option selected>ปี</option>
 									<option value="2020">2020</option>
 								</select>
 								</div>
 							</div><br>
									 <center><button class="btn btn-primary" data-toggle="modal" data-target="#submenu4"type="button">SEND</button></center>
							 </div>
				 </form>
					</div>
					</div>
					</div>
				</div> <!-- End menu accordion swap-->
				<br>
						<div class="alert alert-dismissible alert-secondary">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<strong>ความหมายอักษรย่อของ Seat</strong>
								<p>* หลัง Seat คือมีการยื่นแลก/ลาไปแล้วอยู่ระหว่างพิจารณา</p>
								<p>D = กะ Day (D1 , D2)</p>
								<p>N = กะ Night</p>
								<p>A1 = Assist 1</p>
								<p>A2 = Assist 2</p>
								<p>OD = OT แทนอัตราสรรหากะ Day</p>
								<p>OD1 = OT แทนอัตราสรรหากะ Day ดู Mon D1</p>
								<p>ON = OT แทนอัตราสรรหากะ Night</p>
								<p>G = เรียนงาน</p>
						</div>  <!-- End menu swap-->
		 </div> <!-- end menu swap -->
	 </div> <!-- end container -->
		 <br>
		 <center><button class="btn btn-info" onclick="history.go(-1);">Back</button></center>
<br><br>
<!-- modal menu 1
<div class="modal fade bd-example-modal-lg" id="submenu1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">โปรดตรวจสอบข้อมูลให้ถูกต้อง / ลาปกติ (เต็มวัน)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <tr>
					<th>
						ID : <?php echo $_SESSION['user']['username']; ?><br>
						Name : <?php echo $_SESSION['user']['user_name']; ?><br>
						ประเภทการลา : <?php echo $_SESSION['user']['user_name']; ?><br>
						วันที่ลา : <?php echo $_SESSION['user']['user_name']; ?><br>
						ผู้ปฏิบัติงานแทน : <?php echo $_SESSION['user']['user_name']; ?><br>
						รูปลาในระบบ JPM : <?php echo $_SESSION['user']['user_name']; ?><br>
					</th>
				</tr>
      </div>
      <div class="modal-footer">
				<button type="submit" class="btn btn-primary" name="#">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 End modal menu 1 -->
<!-- modal menu 2
<div class="modal fade bd-example-modal-lg" id="submenu2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">โปรดตรวจสอบข้อมูลให้ถูกต้อง / ลาระบุช่วงเวลา</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<table class="table">
				<td>
						ID : <?php echo $_SESSION['user']['user_name']; ?><br>
						Name : <?php echo $_SESSION['user']['user_name']; ?><br>
						ประเภทการลา : <?php echo $_SESSION['user']['user_name']; ?><br>
						วันที่ลา : <?php echo $_SESSION['user']['user_name']; ?><br>
						ผู้ปฏิบัติงานแทน : <?php echo $_SESSION['user']['user_name']; ?><br>
						รูปลาในระบบ JPM : <?php echo $_SESSION['user']['user_name']; ?><br>
				</td>
				<td>
					...
				</td>
				<td>
						ID : <?php echo $_SESSION['user']['user_name']; ?><br>
						Name : <?php echo $_SESSION['user']['user_name']; ?><br>
						ประเภทการลา : <?php echo $_SESSION['user']['user_name']; ?><br>
						วันที่ลา : <?php echo $_SESSION['user']['user_name']; ?><br>
						ผู้ปฏิบัติงานแทน : <?php echo $_SESSION['user']['user_name']; ?><br>
						รูปลาในระบบ JPM : <?php echo $_SESSION['user']['user_name']; ?><br>
				</td>
			</table>
      </div>
      <div class="modal-footer">
				<button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 End modal menu 2
 modal menu 3
<div class="modal fade bd-example-modal-lg" id="submenu3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">โปรดตรวจสอบข้อมูลให้ถูกต้อง / ขออนุมัติสลับวันทำงาน (กะเดียวกัน)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
				<button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 End modal menu 3
 modal menu 4
<div class="modal fade bd-example-modal-lg" id="submenu4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">โปรดตรวจสอบข้อมูลให้ถูกต้อง / ขออนุมัติสลับวันทำงาน (ระหว่างกะ)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
				<button type="button" class="btn btn-primary">Submit</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>
 End modal menu 4 -->
<div class="credit">
	<hr>
    <center>
          <small class="text-muted">© 2020-2021 Management by Mawmasing.<br>This Web application All rights reserved under <a href="https://www.gnu.org/licenses/gpl-3.0.txt" target="_blank"><font color="#444">GNU GENERAL PUBLIC LICENSE V3</font></a>.<br></small>
          <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/GPLv3_Logo.svg/64px-GPLv3_Logo.svg.png"></a>
    </center>
	</div>
<br>
</div>
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
