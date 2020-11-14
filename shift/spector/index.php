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
								<div class="card-header" id="heading7">
						      <h2 class="mb-0">
						        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse7" aria-expanded="true" aria-controls="collapse7">
						          <h5>เดือนธันวาคม</h5>
						        </button>
						      </h2>
						    </div>
								<div id="collapse7" class="collapse" aria-labelledby="heading7" data-parent="#accordionExample">
						      <div class="card-body">
										<small>พนักงาน Helpdesk 3BB ไม่สะดวกทำ OT วันที่ 2 และ 16 ธันวาคม 2563 ติดต่อพนักงาน JI-net แทน รายละเอียด ดังนี้</small><br>
										<small>	•	2/12/63 คุณ ชินกฤต Seat D3 Kbank, ยกเลิก OT คุณ แผ่นดิน และปรับ Seat คุณ พิมพ์พันธุ์ เป็น D4</small><br>
										<small>	•	16/12/63 คุณ อรรถสิทธิ์ Seat D3 Kbank, ปรับคุณ นพวิทย์ เป็น Seat รับ Call</small><br><br>
										<b>เดือน ธันวาคม 2563 เพิ่มเงื่อนไข การจัดอบรมพนักงานเรียนรู้วงจรเช่า 3BB และ JI-net คนละ 2 รอบกะเพื่อให้พนักงานสามารถปฏิบัติงานร่วมกันได้</b><br>
										<b>และแทนอัตราโอนย้ายไปหน่วยงาน BU</b><br>
										<small>รายละเอียดการจัดสรร ดังนี้</small><br>
										<small>1.	สุรศักดิ์ Monitor ลูกค้า ธกส. Seat D6</small><br>
										<small>2.	ปรับลด N วงจรเช่า JI-net เป็น 2 คน</small><br>
										<small>3.	รายละเอียดการเรียนงาน ดังนี้</small><br>
										<small>&emsp;&emsp;1 - 4/12/63&ensp;&ensp;&emsp;&emsp;&emsp;ภิญญาภัทร B4, นรานิน B3, ปาริชาติ (อุ๊) D5, นที D4</small><br>
										<small>&emsp;&emsp;5 – 8/12/63&ensp;&ensp;&emsp;&emsp;&emsp;แผ่นดิน B3, สุรชัย B4, เสถียรพงษ์ B1, ภูวนัย D4, ชาตรี D5</small><br>
										<small>&emsp;&emsp;9 – 12/12/63&ensp;&ensp;&emsp;&emsp;&emsp;ธนพงศ์ B3, พุทธินันท์ B4, ศุภณัฐ D4, วริศ D5</small><br>
										<small>&emsp;&emsp;13 – 16/12/63&emsp;&emsp;&emsp;แผ่นดิน B4, สุรชัย B3, เสถียรพงษ์ B5, ภูวนัย D5, ชาตรี D4</small><br>
										<small>&emsp;&emsp;17 – 20/12/63&emsp;&emsp;&emsp;ธนพงศ์ B4, พุทธินันท์ B3, ศุภณัฐ D5, วริศ D4</small><br>
										<small>&emsp;&emsp;21 – 23/12/63&emsp;&emsp;&emsp;วรัญญู B4, จีราพร B3, กิตติ D5</small><br>
										<small>&emsp;&emsp;24 – 26/12/63&emsp;&emsp;&emsp;วรัญญู B3, จีราพร B4</small><br>
										<small>&emsp;&emsp;3-4, 24/12/63&emsp;&emsp;&emsp;กิตติ D1 (OT เรียนรู้งาน)</small><br>
										<small>4.	รัฐพลและวงศพัทธ์ ลากิจ แต่งงาน 21-24 ธันวาคม 2563</small><br><br>
										<small>หมายเหตุ : B1 = HQ วงจรเช่า JI-net, B3 = minor, B4 = Seed, B5 = Shell, D1 = HQ 3BB, D4 = BBL, D5 = SCB</small><br>
									</div>
								</div>
								<div class="card-header" id="heading6">
						      <h2 class="mb-0">
						        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse6" aria-expanded="true" aria-controls="collapse6">
						          <h5>เดือนพฤศจิกายน</h5>
						        </button>
						      </h2>
						    </div>
								<div id="collapse6" class="collapse" aria-labelledby="heading6" data-parent="#accordionExample">
						      <div class="card-body">
										<b>เดือน พฤศจิกายน 2563 เพิ่มเงื่อนไข การจัดอบรมพนักงานเรียนรู้วงจรเช่า 3BB และ JI-net</b><br>
										<b>คนละ 2 รอบกะและแทนอัตราโอนย้ายไปหน่วยงาน BU</b><br>
										<small>รายละเอียดการจัดสรร ดังนี้</small><br>
										<small>1.	สุรศักดิ์ Monitor ลูกค้า ธกส. Seat D6</small><br>
										<small>2.	รายละเอียดการเรียนงาน ดังนี้</small><br>
										<small>&emsp;&emsp;4 – 6/11/63&ensp;&ensp;&emsp;&emsp;&emsp;กชกร B3, กุลสิริ B4, สุมิตร D4</small><br>
										<small>&emsp;&emsp;7 – 10/11/63&ensp;&emsp;&emsp;&emsp;ภัทรศยา B3, สถิตา B4, กำพล D4, จิรัสย์ D5</small><br>
										<small>&emsp;&emsp;11 – 14/11/63&emsp;&emsp;&emsp;กชกร B4, กุลสิริ B3, สุมิตร D5</small><br>
										<small>&emsp;&emsp;15 – 18/11/63&emsp;&emsp;&emsp;ภัทรศยา B4, สถิตา B3, กำพล D5, จิรัสย์ D4</small><br>
										<small>&emsp;&emsp;19 – 22/11/63&emsp;&emsp;&emsp;ปฐมภพ B3, นพวิทย์ B4, บุญฤทธิ์ D4 </small><br>
										<small>&emsp;&emsp;23 – 26/11/63&emsp;&emsp;&emsp;ภิญญาภัทร B3, นรานิน B4, ปาริชาติ (อุ๊) D4, นที D5</small><br>
										<small>&emsp;&emsp;27 – 30/11/63&emsp;&emsp;&emsp;ปฐมภพ B4, นพวิทย์ B3, บุญฤทธิ์ D5</small><br>
										<small>หมายเหตุ : B3 minor, B4 Seed, D4 BBL, D5 SCB</small><br>
										<img src="images/11-63.png"><br>
										<b>** เนื่องจาก NOC JI-net มี OT แทนอัตราพนักงานโอนย้ายและแทนพนักงานอบรม ทำให้มี OT คนละ 4-6 วัน หากมีความจำเป็นต้องลาเพิ่มเติม ขออนุมัติให้พนักงานติดต่อพนักงาน Helpdesk ปฏิบัติงานแทนนะครับ **</b>
									</div>
								</div>
								<div class="card-header" id="heading5">
						      <h2 class="mb-0">
						        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse5" aria-expanded="true" aria-controls="collapse5">
						          <h5>เดือนตุลาคม</h5>
						        </button>
						      </h2>
						    </div>
								<div id="collapse5" class="collapse" aria-labelledby="heading5" data-parent="#accordionExample">
						      <div class="card-body">
										<small>ปรับ Seat Daytime 10 Seat เป็น 9 Seat, จัดพนักงานปฏิบัติงาน Seat Kbank (3BB เดิมปฏิบัติงาน Seat Minor)</small><br>
									</div>
								</div>
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
				<td>Mon 6 (Minor) + MonHelpdesk 8</td>
	      <td>1</td>
	    </tr>
			<tr align='center'>
	      <td>B4</td>
	      <td>Mon 4 (Seed) + MonHelpdesk 10</td>
	      <td>1</td>
	    </tr>
			<tr align='center'>
	      <td>B5</td>
	      <td>Mon 5 (SHELL MERAKI / RBA)</td>
	      <td>1</td>
	    </tr>
			<tr align='center'>
	      <td>B6</td>
	      <td>Mon 3 (SSUP KM + Hosting)</td>
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
	<!-- End Modal2 -->


<!-- start container -->
<div class="container-fluid">
	<div class="row">
		<!-- menu swap -->
		<div class="col-3">
			 <div class="alert alert-info">
				 <!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->
					<center><h5>ลาป่วย/ลากิจ/ลาพักผ่อน</h5>
					<h5>ต้องไปกรอกในระบบ JPM ด้วยนะครับ</h5></center><hr>
					<h5>Status color</h5>
					<table>
				  <tr>
						<td style="background-color:#fff" width="20px"></td>
						<td>Seat B-B8</td>
				  </tr>
					<tr>
						<td style="background-color:#ffcccc"></td>
						<td>Seat N</td>
				  </tr>
					<tr>
						<td style="background-color:#ff96ff"></td>
						<td>OD (OT Day) / ON (OT Night) จัดสรร</td>
				  </tr>
					<tr>
						<td style="background-color:#ff66cc"></td>
						<td>TR (Training ไม่ได้ OT)</td>
				  </tr>
					<tr>
						<td style="background-color:#ff66cc"></td>
						<td>OTR (Training ได้ OT)</td>
				  </tr>
					</table>
					<hr>
					<table>
					<tr>
						<td style="background-color:#ffff00" width="20px"></td>
						<td>คำขออยู่ระหว่างพิจารณา</td>
				  </tr>
					<tr>
						<td style="background-color:#00ff00"></td>
						<td>คำขออนุมัติแล้ว</td>
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
