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
<link href="css/bootstrap.css" rel="stylesheet">
<head>
	<title>WORK SCHEDULE WEB APPLICATION</title>
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
			<li class="nav-item active">
				<a class="nav-link" href="schedule.php">ตารางงาน<span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="ot.php">เบิก OT</a>
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
		<!-- <div class="alert alert-dismissible alert-warning">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <h4 class="alert-heading">ประกาศ!</h4>
			<p class="mb-0">ให้พนักงานเข้าปฏิบัติงานที่ออฟฟิตทุกคน พร้อมนำของที่ยืมไปช่วง WFH กลับมาคืนด้วย</strong></p>
		</div> -->
		<!-- Button trigger modal -->
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal1">Log การปรับตารางและการ Training</button>
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#Modal2">Monitor Seat</button>
		<!-- Button trigger modal -->
	</div>
	<br>

<!-- Modal1 -->
<div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-scrollable">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel1">LOG การปรับตารางและการ Training</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="accordion" id="accordionExample">
					  <div class="card">
							<div class="card-header" id="heading4">
					      <h2 class="mb-0">
					        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="true" aria-controls="collapse4">
					          <h5>เดือนกันยายน</h5>
					        </button>
					      </h2>
					    </div>
							<div id="collapse4" class="collapse" aria-labelledby="heading4" data-parent="#accordionExample">
					      <div class="card-body">
									<b>จัดอบรมพนักงานประกบเพื่อเรียนรู้งาน รายละเอียด ดังนี้</b><br>
									<small>1. ปรับ วงศพัทย์ ย้ายกะ AB to CD</small><br>
									<small>2. คุณ สุรศักดิ์ Monitor Seat SCB (G5)</small><br>
									<small>3. อรรถสิทธิ์ และ พัชร์ดนัย นั่ง B3 (Mon 6) Monitor Project ตัดถ่ายวงจรเช่า JI-net to 3BB เช่น Minor, Caltex etc.</small><br>
									<small>4. กิตติ และปาริชาติ ลากิจ แต่งงาน 8-11 กันยายน 2563</small><br>
								</div>
							</div>
					    <div class="card-header" id="headingOne">
					      <h2 class="mb-0">
					        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					          <h5>เดือนสิงหาคม</h5>
					        </button>
					      </h2>
					    </div>
					    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
					      <div class="card-body">
									<b>Update 24/07/63</b><br>
									<small>คุณปรัชญา ต้องการโอนย้ายพนักงาน คุณ สิทธิศักดิ์ NOC JI-net ไปทีม TSD ต้นเดือน สิงหาคม</small><br>
									<small>จึงต้องมีการจัดการปรับตารางงานดังนี้</small><br>
									<small>1-2 สิงหาคม คุณ สุมิตร TR > B6</small><br>
									<small>7-31 สิงหาคม ปรับคุณ กิตติ นั่ง Seat B6 (เนื่องจากได้รับการอบรม 1 เดือน)</small><br>
									<small>7-31 สิงหาคม ปรับ คุณ บุญฤทธิ์ TR ใช้แทน Seat คุณ กิตต</small>ิ<br>
									<small>ย้าย OT คุณ สิทธิศักดิ์ ให้พนักงานในทีม (19,20 ให้คุณบุญฤทธิ์ / 29,30 ให้คุณมุกดา)</small><br><br>
									<b>Helpdesk Team</b><br>
									<small>1. คุณ สุรศักดิ์ Monitor Seat SCB (G5)</small><br>
									<small>2. จัดอบรมพนักงาน Helpdesk เพิ่มจากเดือนที่แล้ว 1 อัตรา (เดิม 13 ใหม่ 14 คน)</small><br>
									<small>ปรับเรียนงาน SCB เป็น BBL กะ A, B เริ่มวันที่ 11 – 30 สิงหาคม, กะ C, D เริ่ม 7 สิงหา – 3 กันยายน 2563</small><br>
									<small>• ศุภากร, ปิยพงษ์, เอกกวี, กนกฉัตร ประกบ HQ JI-net Seat B1, Minor B3 </small><br>
									<small>• กฤตกร, วิรัช, รัฐพล, วัชรินทร์ ประกบ Seat Seed (B4), Dunkin (B7)</small><br><br>
									<b>JINET Team</b><br>
									<small>1. ปรับ N 31-3 สิงหาคม เป็น B3 เนื่องจาก คุณ กิตติ เตรียมงานแต่งช่วงวันที่ 5 กันยายน</small><br>
									<small>• วงศพัทธ์, อนพัทย์, ปาริชาติ, เจษฎาพร ประกบ HQ 3BB Seat DS, D0-D2, BBL</small><br>
									<small>• สกลชัย (อบรมซ้ำเนื่องจากเดือนมิถุนายน คุณ ศุภณัฐ ลาป่วยไส้ติ่งอักเสบทั้งเดือน, บุญฤทธิ์ ประกบ Hosting (B6)</small><br><br>

									<b>Training</b><br>
									<small>ศุภาวุธ Training SCB (10/07/63 - 06/08/63)</small><br>
									<small>อรรถสิทธิ์ Training HQ 3BB (10/07/63 - 06/08/63)</small><br>
									<small>วริศ Training Hosting Seat B6 (10/07/63 - 06/08/63)</small><br><br>

									<small>สกลชัย Training Hosting Seat B6 (11-30/08/63)</small><br>
									<small>วงศพัทย์ Training HQ 3BB (11-20/08/63) | Training BBL (21-30/08/63)</small><br>
									<small>อนพัทย์ Training BBL (11-20/08/63) | Training HQ 3BB (21-30/08/63)</small><br><br>

									<small>เจษฎาพร Training HQ 3BB (07-18/08/63) | Training BBL (23/08/63 - 03/09/63)</small><br>
									<small>ปาริชาติ Training BBL 3BB (07-18/08/63) | Training HQ 3BB (23/08/63 - 03/09/63)</small><br><br>
									<b>Seat Assist, DS, D0-D2, D4, B1, B3, B4, B6, B7 และ TR เข้าออฟฟิศ</b><br>
									<small><b>Monior ของแต่ละ Seat</b></small><br>
									<img src="images/monitor8-63.png">
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingTwo">
					      <h2 class="mb-0">
					        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					          <h5>เดือนกรกฎาคม</h5>
					        </button>
					      </h2>
					    </div>
					    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
					      <div class="card-body">
									<b>Helpdesk Team</b><br>
									<small>1. ปรับ Seat Call Complaint เป็น Monitor ธกส. (D6) 1 อัตรา (เริ่มวันที่ 2 กรกฎาคม 2563)</small><br>
									<small>2. จัดอบรมพนักงาน Helpdesk เพิ่มจากเดือนที่แล้ว 3 อัตรา (เดิม 10 ใหม่ 13 คน) เพิ่ม Seat Minor, SCB (เริ่มวันที่ 6 กรกฎาคม 2563)</small><br><br>
									<b>JINET Team</b><br>
									<small>1. ปรับ Project Minor + Wine (B6) สลับกับ SSUP KM Interlap (B3) (เริ่มวันที่ 6 กรกฎาคม 2563)</small><br><br>
									<img src="images/july.jpg"><br><br>
									<b>Training</b><br>
									<small>อรรถสิทธิ์ ประกบ HQ (DS, D0-D2) 10/07/63 - 6/08/63</small><br>
									<small>พัชร์ดนัย ประกบ HQ (DS, D0-D2) 6/07/63 - 2/08/63</small><br>
									<small>ศุภาวุธ ประกบ SCB (D5) 10/07/63 - 6/08/63</small><br>
									<small>วริศ ประกบ Hosting (B6) 10/07/63 - 6/08/63</small><br>
									<small>สุมิตร ประกบ Hosting (B6) 6/07/63 - 2/08/63</small><br><br>
									<b>Seat DS, D0-D2, D5, B1, B3, B4, B6, B7 และ TR เข้าออฟฟิศ</b><br><br>
									<small><b>Monior ของแต่ละ Seat</b></small><br>
									<img src="images/monitor7-63.png">
					      </div>
					    </div>
					  </div>
					  <div class="card">
					    <div class="card-header" id="headingThree">
					      <h2 class="mb-0">
					        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
					          <h5>เดือนมิถุนายน</h5>
					        </button>
					      </h2>
					    </div>
					    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
					      <div class="card-body">
									<small>1.สลับกะ วริศมาอยู่ AB จัด OT หยุดงาน 31/05 - 01/06 จัด OT แทนวันที่ 1/06/63</small><br>
									<small>2.ปรับชาตรีเข้ากะ CD</small><br>
									<small>3.AB รวมวริศ 13 คน CD รวมชาตรี 12 คน เพื่อ Balance Seat Day 10+Night 3 จัด OD กะ AB 1 Seat</small><br>
									<small>4. ใส่ OG ให้คนสอนงาน Solution 3BB (มีสลับ OT นัตตี้กับโจ้ จาก Sheet เดิม)</small><br><br>
									<small>Train งาน (เพื่อความต่อเนื่อง อบรมวันทำงาน จัด OT แทน)</small><br>
									<small>5. อดิสัย ณรรฏร์ธนน ประกบ HQ Seat D1</small><br>
									<small>6. บรรพต วุฒิชัย กนกวรรณ อาดุลย์ ประกบ Seat SE-ED, GFDD</small><br>
									<small>7. ณัฐวุฒิ ชินกฤต ประกบ HQ 3BB Seat 3-6</small><br>
									<small>8. สกลชัย กิตติ train Hosting</small><br><br>
									<b>Seat B1, B4, B6, B7 และ TR เข้าออฟฟิศ</b><br><br>
									<small><b>Monior ของแต่ละ Seat</b></small><br>
									<img src="images/monitor6-63.png">
					      </div>
					    </div>
					  </div>
					</div>


			</div>
		</div>
	</div>
</div>

<!-- Modal2 -->
<div class="modal fade" id="Modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Monitor Seat</h5>
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
      <td>D1 (HQ CORP-MPLS)</td>
      <td>2</td>
    </tr>
		<tr align='center'>
      <td>B2</td>
      <td>Mon 2 (JN_SSUP + ORTHER)</td>
      <td>1</td>
    </tr>
		<tr align='center'>
      <td>B3</td>
      <td>Mon 3 (SSUP KM + Hosting)</td>
      <td>1</td>
    </tr>
		<tr align='center'>
      <td>B4</td>
      <td>Mon 4 (Seed)</td>
      <td>1</td>
    </tr>
		<tr align='center'>
      <td>B5</td>
      <td>Mon 5 (SHELL MERAKI / RBA)</td>
      <td>1</td>
    </tr>
		<tr align='center'>
      <td>B6</td>
      <td>Mon 6 (Minor)</td>
      <td>1</td>
    </tr>
		<tr align='center'>
      <td>B7</td>
      <td>Mon 7 (Dunkin + Shell_DO)</td>
      <td>1</td>
    </tr>
		<tr align='center'>
      <td>B8</td>
      <td>Mon 8 (MK)</td>
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
<!-- End Modal3 -->
<!-- start container -->
<div class="container-fluid">
	<div class="row">
		<!-- menu swap -->
		<div class="col-3">
			<div class="accordion" id="menuall"> <!-- menu accordion -->
				 <div class="card border-primary"> <!-- menu 1 -->
				 <div class="card-header border-primary" id="headingOne">
				 <h2 class="mb-0">
					 <center>
						<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#menu1" aria-expanded="true" aria-controls="menu1">
							<h5>ขออนุมัติลาปกติ (เต็มวัน)</h5>
						</button>
				 </center>
				 </h2>
				 </div>
				 <div id="menu1" class="collapse" aria-labelledby="headingOne" data-parent="#menuall">
				 <div class="card-body">
					 <form method="post" action="Functions/shift_functions.php">
						 <div class="form-group">
								 <input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
								 <input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
								 <input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
								 <input type="hidden" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
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
								 <input type="radio" id="customRadio4" value="ลาพักผ่อน" name="c_label" class="custom-control-input">
								 <label class="custom-control-label" for="customRadio4">ลาพักผ่อน (ไม่มีคนแทน)</label>
							 </div>
							 <div class="custom-control custom-radio">
								 <input type="radio" id="customRadio5" value="ลากิจ" name="c_label" class="custom-control-input">
								 <label class="custom-control-label" for="customRadio5">ลากิจ</label>
							 </div>
							 <div class="form-group">
							   <input type="text" class="form-control" id="formGroupExampleInput" name="c_reason" placeholder="หากท่านลากิจโปรดระบุเหตุผล">
							 </div>
							 <hr>
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
						 	เลือกพนักงานแทน (หากไม่มีคนแทนข้ามไปเลยครับ)
							<div>
								<div class="form-row">
								<select name="c_code_visit" class="custom-select custom-select-sm">
									 <option value="-">-</option>
									 <?php
									 $SQL = "SELECT * FROM users WHERE user_type='user' AND shift IN ('A','B','C','D') ORDER BY shift , remark";
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
								</div><br><br>
								 <center><button type="submit" class="btn btn-primary" name="swapmenu1">SEND</button></center>
						 </div>
			 </form>
				 </div>
				 </div>
				 </div>
				 <!-- end menu 1 -->
				 <!-- menu 2 -->
				 <div class="card border-primary">
				 <div class="card-header border-primary" id="headingTwo">
				 <h2 class="mb-0">
					 <center>
							<button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#menu2" aria-expanded="false" aria-controls="menu2">
								<h5>ขออนุมัติลาระบุช่วงเวลา</h5>
							</button>
					 </center>
				 </h2>
				 </div>
				 <div id="menu2" class="collapse" aria-labelledby="headingTwo" data-parent="#menuall">
				 <div class="card-body">
					 <form method="post" action="Functions/shift_functions.php">
						<div class="form-group">
							<input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
							<input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
							<input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
							<input type="hidden" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
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
							</div>
							<div class="form-group">
								<input type="text" class="form-control" id="formGroupExampleInput" name="c_reason" placeholder="หากท่านลากิจโปรดระบุเหตุผล">
							</div>
							<hr>
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
						</div><br><br>
						<center><button type="submit" class="btn btn-primary" name="swapmenu2">SEND</button></center>
								<!--<center><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#submenu2">SEND</button></center>-->
						</div>
			</form>
				 </div>
				 </div>
				 </div>
				 <!-- end menu 2 -->
				 <!-- menu 3 -->
				 <div class="card border-primary">
				 <div class="card-header border-primary" id="headingThree">
				 <h2 class="mb-0">
					 <center>
						 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#menu3" aria-expanded="false" aria-controls="menu3">
							 <h5>ขออนุมัติสลับกะ (กะเดียวกัน)</h5>
						 </button>
					 </center>
				 </h2>
				 </div>
				 <div id="menu3" class="collapse" aria-labelledby="headingThree" data-parent="#menuall">
				 <div class="card-body">
					 <form method="post" action="Functions/shift_functions.php">
							<div class="form-group">
								<input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
								<input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
								<input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
								<input type="hidden" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
								<input type="hidden" name="c_labelmain" value="สลับกะ">
								<input type="hidden" name="c_remark" value="กะเดียวกัน">
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
									 $selectsft = $_SESSION['user']['shift']; // กำหนดตัวแปร
									 if ($selectsft == "A") {
									 	$sft = "'A','B'";
									}elseif ($selectsft == "B") {
										$sft = "'A','B'";
									}elseif ($selectsft == "C") {
										$sft = "'C','D'";
									}else {
										$sft = "'C','D'";
									}

									 $SQL = "SELECT * FROM users WHERE user_type='user' AND shift IN ($sft) ORDER BY shift , remark";
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
								 </div><br><br>
									<center><button class="btn btn-primary" type="submit" name="swapmenu3">SEND</button></center>
							</div>
				</form>
				 </div>
				 </div>
				 </div>
				 <!-- end menu 3 -->
				 <!-- menu 4 -->
				 <div class="card border-primary">
				 <div class="card-header border-primary" id="headingFour">
				 <h2 class="mb-0">
					 <center>
						 <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#menu4" aria-expanded="false" aria-controls="menu4">
							 <h5>ขออนุมัติสลับกะ (ระหว่างกะ)</h5>
						 </button>
					 </center>
				 </h2>
				 </div>
				 <div id="menu4" class="collapse" aria-labelledby="headingFour" data-parent="#menuall">
				 <div class="card-body">
					 <form method="post" action="Functions/shift_functions.php">
							<div class="form-group">
								<input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
								<input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
								<input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
								<input type="hidden" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
								<input type="hidden" name="c_labelmain" value="สลับกะ">
								<input type="hidden" name="c_remark" value="ระหว่างกะ">
							 ระบุวันทำงานของท่าน
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
						 </div><hr>
								เลือกพนักงานที่ต้องการสลับกะ
							 <div class="form-row">
								 <div class="col">
								 <select name="c_code_visit" class="custom-select custom-select-sm">
									 <?php
									 $selectsft = $_SESSION['user']['shift']; // กำหนดตัวแปร
									 if ($selectsft == "A") {
									  $sft = "'C','D'";
									 }elseif ($selectsft == "B") {
									  $sft = "'C','D'";
									 }elseif ($selectsft == "C") {
									  $sft = "'A','B'";
									 }else {
									  $sft = "'A','B'";
									 }

									 $SQL = "SELECT * FROM users WHERE user_type='user' AND shift IN ($sft) ORDER BY shift , remark";
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
								 ระบุวันทำงานของพนักงานที่ต้องการสลับกะ
							 <div class="form-row">
								 <div class="col-md-3">
								 <select name="day_visit" class="custom-select custom-select-sm">
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
							 <select name="month_visit" class="custom-select custom-select-sm">
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
							 <select name="year_visit" class="custom-select custom-select-sm">
								 <option selected>ปี</option>
								 <option value="2020">2020</option>
							 </select>
							 </div>
						 </div><br><br>
									<center><button class="btn btn-primary" type="submit" name="swapmenu4">SEND</button></center>
							</div>
				</form>
				 </div>
				 </div>
			 </div> <!-- End menu 4-->
				 <div class="card border-primary"> <!-- menu 5 -->
				 <div class="card-header border-primary" id="headingFive">
				 <h2 class="mb-0">
				 	<center>
				 	 <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#menu5" aria-expanded="true" aria-controls="menu5">
				 		 <h5>ขออนุมัติสลับ OT</h5>
				 	 </button>
				 </center>
				 </h2>
				 </div>
				 <div id="menu5" class="collapse" aria-labelledby="headingFive" data-parent="#menuall">
				 <div class="card-body">
				 	<form method="post" action="Functions/shift_functions.php">
				 		<div class="form-group">
				 				<input type="hidden" name="c_code_host" value="<?php echo $_SESSION['user']['username']; ?>">
				 				<input type="hidden" name="c_name_host" value="<?php echo $_SESSION['user']['user_name']; ?>">
				 				<input type="hidden" name="c_shift_host" value="<?php echo $_SESSION['user']['shift']; ?>">
								<input type="hidden" name="email" value="<?php echo $_SESSION['user']['email']; ?>">
				 				<input type="hidden" name="c_labelmain" value="สลับ OT">
								<input type="hidden" name="c_label" value="-">
				 			ระบุวัน
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
				 			เลือกพนักงานปฏิบัติงานแทน
				 		 <div>
				 			 <div class="form-row">
				 			 <select name="c_code_visit" class="custom-select custom-select-sm">
				 					<?php
				 					$SQL = "SELECT * FROM users WHERE user_type='user' AND shift IN ('A','B','C','D') ORDER BY shift , remark";
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
				 			 </div><br><br>
				 				<center><button type="submit" class="btn btn-primary" name="swapmenu5">SEND</button></center>
				 		</div>
				 </form>
				 </div>
				 </div>
			 </div>  <!-- End menu 5-->

			 </div> <!-- End menu accordion swap-->
			 <br>
			 <div class="alert alert-dismissible alert-info">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<center><h5>ลาป่วย/ลากิจ/ลาพักผ่อน</h5>
					<h5>ต้องไปกรอกในระบบ JPM ด้วยนะครับ</h5></center><hr>
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
						<td style="background-color:#00a2ff"></td>
						<td>ลากิจ / OT มาแทนคนที่ลากิจ</td>
				  </tr>
					<tr>
						<td style="background-color:#ff7b00"></td>
						<td>ลาไม่มีคนแทน / ลาระบุเวลา</td>
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

			//event สี
			$allColor = array();
			$SQL = "SELECT w_code, DAY(`w_date`) AS w_day, w_status FROM `work`
			WHERE `w_date` LIKE '$year-$month%'	GROUP by w_code,DAY(`w_date`)";
			$qry = mysqli_query($db, $SQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
			while($row = mysqli_fetch_assoc($qry)){
				$allColor[$row['w_code']][$row['w_day']] = $row['w_status'];

			}


			//HTML TABLE HEAD SHIFT AB
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
		      $workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b>'.$allReportData[$empCode][$d].'</b></td>' : '<td style="background-color:lightgray"></td>';
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
		      $workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b>'.$allReportData[$empCode][$d].'</b></td>' : '<td style="background-color:lightgray"></td>';
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



			//HTML TABLE HEAD SHIFT CD
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
					$workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b>'.$allReportData[$empCode][$d].'</b></td>' : '<td style="background-color:lightgray"></td>';					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
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
					$workDay = isset($allReportData[$empCode][$d]) ? '<td style="background-color:'.$allColor[$empCode][$d].'"><b>'.$allReportData[$empCode][$d].'</b></td>' : '<td style="background-color:lightgray"></td>';					// ทำที่บ้านเบ้น $workDay = isset($allReportData[$empCode][$d]) ? '<div style="background-color:'.$tablecl.'">'.$allReportData[$empCode][$d].'</div>' : "";
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
		<div><iframe src="credit.html" width="100%" frameBorder="0"></iframe></div>
</div>
<script src="js/jquery.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
