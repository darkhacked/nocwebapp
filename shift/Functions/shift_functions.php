<?php
	session_start();

	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	// Load Composer's autoloader
	require 'PHPMailer/src/Exception.php';
	require 'PHPMailer/src/PHPMailer.php';
	require 'PHPMailer/src/SMTP.php';

	$db = mysqli_connect('localhost', 'root', 'toor', 'shift');

	if (isset($_POST['swapmenu1'])) {
		$codeHost    =  ($_POST['c_code_host']);
		$nameHost  =  ($_POST['c_name_host']);
		$shiftHost  =  ($_POST['c_shift_host']);
		$emailHost	=	($_POST['email']);
		$labelM    =  ($_POST['c_labelmain']);
		$label    =  ($_POST['c_label']);
		$day			=  ($_POST['day_host']);
		$month			=  ($_POST['month_host']);
		$year 	=  ($_POST['year_host']);
		$codeVisit	=  ($_POST['c_code_visit']);
		$color = "#ffff00";

		$dateHost = $year.$month.$day;

		// function ดึงชื่อพนักงานมาใส่ field c_name_visit
		$selectNamevisit = "SELECT user_name, email FROM users WHERE username = '$codeVisit'";
		$qry = mysqli_query($db, $selectNamevisit);
		while ($qrydata = mysqli_fetch_array($qry)) {
			$nameVisit = $qrydata["user_name"];
			$emailVisit = $qrydata["email"];
		}

		// select seat + status host
		$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
		$qry = mysqli_query($db, $selectSeathost);
		while ($qrydata = mysqli_fetch_array($qry)) {
			$seatHost = $qrydata["w_type"];
			$statusHost = $qrydata["w_status"];
		}


		$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit, c_date_visit)
				VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit', '$dateHost') ";
				mysqli_query($db, $insSQL);

		$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
		mysqli_query($db, $updateStatus);

		$updateStatus2 = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateHost'";
		mysqli_query($db, $updateStatus2);


		if ($codeVisit == "-") {

			$mail = new PHPMailer(true);

			try {
			    $mail->CharSet = "utf-8";
			    $mail->isSMTP();                                            // Send using SMTP
			    $mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
			    $mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
			    $mail->Password   = 'darkhacked_123';                               // SMTP password
			    $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			    //Recipients
			    $mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
			    $mail->addAddress('panyaphol.s@jasmine.com');     // TO พี่ดิท
			    $mail->addCC('pacharaporn.w@jasmine.com');          // CC พี่เจน
			    $mail->addCC($emailHost);						// CC Host
					$mail->addCC('nocchief@ji-net.com');						// CC Visit

			    // Content
			    $mail->isHTML(true);                                  // Set email format to HTML
			    $mail->Subject = '[REQ] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
			    $mail->Body    = '
			    <!DOCTYPE html>
			    <html>
			    <head>
			      <meta charset=\'utf-8\'>
			      <style>
			        table {
			            border-collapse: collapse;
			            border: 1px solid black;
			        }

			        table, th, td {
			            padding-right:5px;
			            padding-left:5px;
			        }
			        span {
			          font-size: 10.0pt;
			          font-family: Tahoma;
			        }
			      </style>
			    </head>
			    <body>
			    <span>เรียน คุณปรัชญา สีทอง</span><br>
			    <span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameHost.'</span><br>
			    <br><br>
			    <span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
			    <table>
			      <tr>
			        <th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
			      </tr>
			      <tr>
			        <td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
			        <td style="background-color:#d4d4d4;"><span>'.$labelM.' | '.$label.'</span></td>
			      </tr>
			      <tr>
			        <td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
			        <td style="background-color:#e3e3e3;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatHost.')</b></span></td>
			      </tr>
			      <tr>
			        <td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
			        <td style="background-color:#d4d4d4;"><span>['.$codeHost.'] <b>'.$nameHost.'</b></span></td>
			      </tr>
			      <tr>
			        <td align="right" style="background-color:#bababa;"><span>สถานะ :</span></td>
			        <td style="background-color:#ffff00;"><span><b>Pending</b></span></td>
			      </tr>
			    </table>
			    <br><br><br>
			    <span>This is an automated email, please don\'t reply.</span><br>
			    <span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
			    </body>
			    </html>

			    ';

			    $mail->send();
			    header('location: ../index.php');
			} catch (Exception $e) {
			    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}


		}else {

			$mail = new PHPMailer(true);

			try {
					$mail->CharSet = "utf-8";
					$mail->isSMTP();                                            // Send using SMTP
					$mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
					$mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
					$mail->Password   = 'darkhacked_123';                               // SMTP password
					$mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

					//Recipients
					$mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
					$mail->addAddress('panyaphol.s@jasmine.com');     // TO พี่ดิท
					$mail->addCC('pacharaporn.w@jasmine.com');          // CC พี่เจน
					$mail->addCC($emailHost);						// CC Host
					$mail->addCC($emailVisit);						// CC Visit
					$mail->addCC('nocchief@ji-net.com');

					// Content
					$mail->isHTML(true);                                  // Set email format to HTML
					$mail->Subject = '[REQ] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
					$mail->Body    = '
					<!DOCTYPE html>
					<html>
					<head>
						<meta charset=\'utf-8\'>
						<style>
							table {
									border-collapse: collapse;
									border: 1px solid black;
							}

							table, th, td {
									padding-right:5px;
									padding-left:5px;
							}
							span {
								font-size: 10.0pt;
								font-family: Tahoma;
							}
						</style>
					</head>
					<body>
					<span>เรียน คุณปรัชญา สีทอง</span><br>
					<span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameHost.', คุณ'.$nameVisit.'</span><br>
					<br><br>
					<span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
					<table>
						<tr>
							<th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
						</tr>
						<tr>
							<td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
							<td style="background-color:#d4d4d4;"><span>'.$labelM.' | '.$label.'</span></td>
						</tr>
						<tr>
							<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
							<td style="background-color:#e3e3e3;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatHost.')</b></span></td>
						</tr>
						<tr>
							<td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
							<td style="background-color:#d4d4d4;"><span>['.$codeHost.'] <b>'.$nameHost.'</b></span></td>
						</tr>
						<tr>
							<td align="right" style="background-color:#bababa;"><span>ผู้ปฏิบัติงานแทน :</span></td>
							<td style="background-color:#e3e3e3;"><span>['.$codeVisit.'] <b>'.$nameVisit.'</b></span></td>
						</tr>
						<tr>
							<td align="right" style="background-color:#bababa;"><span>สถานะ :</span></td>
							<td style="background-color:#ffff00;"><span><b>Pending</b></span></td>
						</tr>
					</table>
					<br><br><br>
					<span>This is an automated email, please don\'t reply.</span><br>
					<span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
					</body>
					</html>

					';

					$mail->send();
					header('location: ../index.php');
			} catch (Exception $e) {
					echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
			}



		}

	}




if (isset($_POST['swapmenu2'])) {
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$emailHost	=	($_POST['email']);
	$labelM    =  ($_POST['c_labelmain']);
	$label    =  ($_POST['c_label']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);
	$re   =  ($_POST['c_re1']);
	$re2   =  ($_POST['c_re2']);
	$color = "#ffff00";

	$dateHost = $year.$month.$day;
	$remark  = $re." - ".$re2;

	// select seat + status host
	$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qrydata = mysqli_fetch_array($qry)) {
		$seatHost = $qrydata["w_type"];
		$statusHost = $qrydata["w_status"];
	}

	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_shift_host, c_seat_host, c_seat_stahost, c_labelmain, c_label, c_remark)
	VALUES('$codeHost', '$nameHost', '$dateHost', '$shiftHost', '$seatHost', '$statusHost', '$labelM', '$label', '$remark') ";
	mysqli_query($db, $insSQL);

	$updateStatus = "UPDATE work SET w_status = '$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus);


	$mail = new PHPMailer(true);

	try {
			$mail->CharSet = "utf-8";
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
			$mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
			$mail->Password   = 'darkhacked_123';                               // SMTP password
			$mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
			$mail->addAddress('panyaphol.s@jasmine.com');     // TO พี่ดิท
			$mail->addCC('pacharaporn.w@jasmine.com');          // CC พี่เจน
			$mail->addCC($emailHost);						// CC Host
			$mail->addCC('nocchief@ji-net.com');
			//$mail->addCC($emailVisit);						// CC Visit

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = '[REQ] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
			$mail->Body    = '
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset=\'utf-8\'>
				<style>
					table {
							border-collapse: collapse;
							border: 1px solid black;
					}

					table, th, td {
							padding-right:5px;
							padding-left:5px;
					}
					span {
						font-size: 10.0pt;
						font-family: Tahoma;
					}
				</style>
			</head>
			<body>
			<span>เรียน คุณปรัชญา สีทอง</span><br>
			<span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameHost.'</span><br>
			<br><br>
			<span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
			<table>
				<tr>
					<th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
					<td style="background-color:#d4d4d4;"><span>'.$labelM.' | '.$label.'</span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
					<td style="background-color:#e3e3e3;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatHost.')</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ช่วงเวลา :</span></td>
					<td style="background-color:#d4d4d4;"><span>'.$remark.'</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
					<td style="background-color:#e3e3e3;"><span>['.$codeHost.'] <b>'.$nameHost.'</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>สถานะ :</span></td>
					<td style="background-color:#ffff00;"><span><b>Pending</b></span></td>
				</tr>
			</table>
			<br><br><br>
			<span>This is an automated email, please don\'t reply.</span><br>
			<span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
			</body>
			</html>

			';

			$mail->send();
			header('location: ../index.php');
	} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}



}


if (isset($_POST['swapmenu3'])){
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$emailHost	=	($_POST['email']);
	$labelM    =  ($_POST['c_labelmain']);
	$remark 	=  ($_POST['c_remark']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);
	$codeVisit	=  ($_POST['c_code_visit']);
	$color = "#ffff00";

	$dateHost = $year.$month.$day;

	// function ดึงชื่อพนักงานมาใส่ field c_name_visit
	$selectNamevisit = "SELECT user_name, email FROM users WHERE username = '$codeVisit'";
	$qry = mysqli_query($db, $selectNamevisit);
	while ($qrydata = mysqli_fetch_array($qry)) {
		$nameVisit = $qrydata["user_name"];
		$emailVisit = $qrydata["email"];
	}

	// select seat + status host
	$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qrydata = mysqli_fetch_array($qry)) {
		$seatHost = $qrydata["w_type"];
		$statusHost = $qrydata["w_status"];
	}

	// select seat + status visit
	$selectSeatvisit = "SELECT w_type, w_status FROM work WHERE w_code='$codeVisit' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeatvisit);
	while ($qrydata = mysqli_fetch_array($qry)) {
		$seatVisit = $qrydata["w_type"];
		$statusVisit = $qrydata["w_status"];
	}

	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_code_visit, c_name_visit, c_date_visit, c_seat_visit, c_seat_stavisit, c_shift_visit, c_labelmain, c_remark)
	VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$codeVisit', '$nameVisit', '$dateHost', '$seatVisit', '$statusVisit', '$shiftHost', '$labelM', '$remark') ";
	mysqli_query($db, $insSQL);

	$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus);

	$updateStatus2 = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus2);


	$mail = new PHPMailer(true);

	try {
			$mail->CharSet = "utf-8";
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
			$mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
			$mail->Password   = 'darkhacked_123';                               // SMTP password
			$mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
			$mail->addAddress('panyaphol.s@jasmine.com');     // TO พี่ดิท
			$mail->addCC('pacharaporn.w@jasmine.com');          // CC พี่เจน
			$mail->addCC($emailHost);						// CC Host
			$mail->addCC($emailVisit);						// CC Visit
			$mail->addCC('nocchief@ji-net.com');

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = '[REQ] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
			$mail->Body    = '
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset=\'utf-8\'>
				<style>
					table {
							border-collapse: collapse;
							border: 1px solid black;
					}

					table, th, td {
							padding-right:5px;
							padding-left:5px;
					}
					span {
						font-size: 10.0pt;
						font-family: Tahoma;
					}
				</style>
			</head>
			<body>
			<span>เรียน คุณปรัชญา สีทอง</span><br>
			<span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameHost.', คุณ'.$nameVisit.'</span><br>
			<br><br>
			<span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
			<table>
				<tr>
					<th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
					<td style="background-color:#d4d4d4;"><span>'.$labelM.' ('.$remark.')</span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
					<td style="background-color:#e3e3e3;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatHost.')</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
					<td style="background-color:#d4d4d4;"><span>['.$codeHost.'] <b>'.$nameHost.'</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ผู้ปฏิบัติงาน :</span></td>
					<td style="background-color:#e3e3e3;"><span>['.$codeVisit.'] <b>'.$nameVisit.'</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
					<td style="background-color:#d4d4d4;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatVisit.')</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>สถานะ :</span></td>
					<td style="background-color:#ffff00;"><span><b>Pending</b></span></td>
				</tr>
			</table>
			<br><br><br>
			<span>This is an automated email, please don\'t reply.</span><br>
			<span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
			</body>
			</html>

			';

			$mail->send();
			header('location: ../index.php');
	} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}



}



if (isset($_POST['swapmenu4'])) {
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$emailHost =  ($_POST['email']);
	$labelM    =  ($_POST['c_labelmain']);
	$remark 	=  ($_POST['c_remark']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);

	$codeVisit  =  ($_POST['c_code_visit']);
	$day2			=  ($_POST['day_visit']);
	$month2			=  ($_POST['month_visit']);
	$year2 	=  ($_POST['year_visit']);
	$color = "#ffff00";


	$dateHost = $year.$month.$day;
	$dateVisit = $year2.$month2.$day2;

// select seat + status host
$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
$qry = mysqli_query($db, $selectSeathost);
while ($qrydata = mysqli_fetch_array($qry)) {
	$seatHost = $qrydata["w_type"];
	$statusHost = $qrydata["w_status"];
}

//select name+shift visit
$selectNamevisit = "SELECT user_name, shift, email FROM users WHERE username = '$codeVisit'";
$qry = mysqli_query($db, $selectNamevisit);
while ($qrydata = mysqli_fetch_array($qry)) {
	$nameVisit = $qrydata["user_name"];
	$shiftVisit = $qrydata["shift"];
	$emailVisit = $qrydata["email"];
}

// select seat + status visit
$selectSeatvisit = "SELECT w_type, w_status FROM work WHERE w_code='$codeVisit' AND w_date='$dateVisit'";
$qry = mysqli_query($db, $selectSeatvisit);
while ($qrydata = mysqli_fetch_array($qry)) {
	$seatVisit = $qrydata["w_type"];
	$statusVisit = $qrydata["w_status"];
}

//insert swap
$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_code_visit, c_name_visit, c_date_visit, c_seat_visit, c_seat_stavisit, c_shift_visit, c_labelmain, c_remark)
VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$codeVisit', '$nameVisit', '$dateVisit', '$seatVisit', '$statusVisit', '$shiftVisit', '$labelM', '$remark') ";
mysqli_query($db, $insSQL);

//update status
$updateStatus = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
mysqli_query($db, $updateStatus);

$updateStatus2 = "UPDATE work SET w_status ='$color' WHERE w_code = '$codeVisit' AND w_date ='$dateVisit'";
mysqli_query($db, $updateStatus2);


$mail = new PHPMailer(true);

try {
		$mail->CharSet = "utf-8";
		$mail->isSMTP();                                            // Send using SMTP
		$mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
		$mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
		$mail->Password   = 'darkhacked_123';                               // SMTP password
		$mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

		//Recipients
		$mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
		$mail->addAddress('panyaphol.s@jasmine.com');     // TO พี่ดิท
		$mail->addCC('pacharaporn.w@jasmine.com');          // CC พี่เจน
		$mail->addCC($emailHost);						// CC Host
		$mail->addCC($emailVisit);						// CC Visit
		$mail->addCC('nocchief@ji-net.com');

		// Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = '[REQ] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
		$mail->Body    = '
		<!DOCTYPE html>
		<html>
		<head>
			<meta charset=\'utf-8\'>
			<style>
				table {
						border-collapse: collapse;
						border: 1px solid black;
				}

				table, th, td {
						padding-right:5px;
						padding-left:5px;
				}
				span {
					font-size: 10.0pt;
					font-family: Tahoma;
				}
			</style>
		</head>
		<body>
		<span>เรียน คุณปรัชญา สีทอง</span><br>
		<span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameHost.', คุณ'.$nameVisit.'</span><br>
		<br><br>
		<span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
		<table>
			<tr>
				<th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
			</tr>
			<tr>
				<td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
				<td style="background-color:#d4d4d4;"><span>'.$labelM.' ('.$remark.')</span></td>
			</tr>
			<tr>
				<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
				<td style="background-color:#e3e3e3;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatHost.')</b></span></td>
			</tr>
			<tr>
				<td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
				<td style="background-color:#d4d4d4;"><span>['.$codeHost.'] <b>'.$nameHost.'</b></span></td>
			</tr>
			<tr>
				<td align="right" style="background-color:#bababa;"><span>ผู้ปฏิบัติงาน :</span></td>
				<td style="background-color:#e3e3e3;"><span>['.$codeVisit.'] <b>'.$nameVisit.'</b></span></td>
			</tr>
			<tr>
				<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
				<td style="background-color:#d4d4d4;"><span>'.$day2.'-'.$month2.'-'.$year2.' <b>('.$seatVisit.')</b></span></td>
			</tr>
			<tr>
				<td align="right" style="background-color:#bababa;"><span>สถานะ :</span></td>
				<td style="background-color:#ffff00;"><span><b>Pending</b></span></td>
			</tr>
		</table>
		<br><br><br>
		<span>This is an automated email, please don\'t reply.</span><br>
		<span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
		</body>
		</html>

		';

		$mail->send();
		header('location: ../index.php');
} catch (Exception $e) {
		echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}



}




if (isset($_POST['swapmenu5'])) {
	$codeHost    =  ($_POST['c_code_host']);
	$nameHost  =  ($_POST['c_name_host']);
	$shiftHost  =  ($_POST['c_shift_host']);
	$emailHost  =  ($_POST['email']);
	$labelM    =  ($_POST['c_labelmain']);
	$label    =  ($_POST['c_label']);
	$day			=  ($_POST['day_host']);
	$month			=  ($_POST['month_host']);
	$year 	=  ($_POST['year_host']);
	$codeVisit	=  ($_POST['c_code_visit']);
	$color = "#ffff00";

	$dateHost = $year.$month.$day;

	// function ดึงชื่อพนักงานแทน
	$selectNamevisit = "SELECT user_name, email FROM users WHERE username = '$codeVisit'";
	$qry = mysqli_query($db, $selectNamevisit);
	while ($qrydata = mysqli_fetch_array($qry)) {
		$nameVisit = $qrydata["user_name"];
		$emailVisit = $qrydata["email"];
	}

	// select seat + status host
	$selectSeathost = "SELECT w_type, w_status FROM work WHERE w_code='$codeHost' AND w_date='$dateHost'";
	$qry = mysqli_query($db, $selectSeathost);
	while ($qrydata = mysqli_fetch_array($qry)) {
		$seatHost = $qrydata["w_type"];
		$statusHost = $qrydata["w_status"];
	}


	$insSQL = "INSERT INTO swap (c_code_host, c_name_host, c_date_host, c_seat_host, c_seat_stahost, c_shift_host, c_labelmain, c_label, c_code_visit, c_name_visit, c_date_visit)
			VALUES('$codeHost', '$nameHost', '$dateHost', '$seatHost', '$statusHost', '$shiftHost', '$labelM', '$label', '$codeVisit', '$nameVisit', '$dateHost') ";
			mysqli_query($db, $insSQL);

	$updateStatus = "UPDATE work SET w_status='$color', w_status_temp='$statusHost' WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
	mysqli_query($db, $updateStatus);


	$mail = new PHPMailer(true);

	try {
			$mail->CharSet = "utf-8";
			$mail->isSMTP();                                            // Send using SMTP
			$mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
			$mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
			$mail->Password   = 'darkhacked_123';                               // SMTP password
			$mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

			//Recipients
			$mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
			$mail->addAddress('panyaphol.s@jasmine.com');     // TO พี่ดิท
			$mail->addCC('pacharaporn.w@jasmine.com');          // CC พี่เจน
			$mail->addCC($emailHost);						// CC Host
			$mail->addCC($emailVisit);						// CC Visit
			$mail->addCC('nocchief@ji-net.com');

			// Content
			$mail->isHTML(true);                                  // Set email format to HTML
			$mail->Subject = '[REQ] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
			$mail->Body    = '
			<!DOCTYPE html>
			<html>
			<head>
				<meta charset=\'utf-8\'>
				<style>
					table {
							border-collapse: collapse;
							border: 1px solid black;
					}

					table, th, td {
							padding-right:5px;
							padding-left:5px;
					}
					span {
						font-size: 10.0pt;
						font-family: Tahoma;
					}
				</style>
			</head>
			<body>
			<span>เรียน คุณปรัชญา สีทอง</span><br>
			<span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameHost.', คุณ'.$nameVisit.'</span><br>
			<br><br>
			<span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
			<table>
				<tr>
					<th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
					<td style="background-color:#d4d4d4;"><span>สลับ OT</span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
					<td style="background-color:#e3e3e3;"><span>'.$day.'-'.$month.'-'.$year.' <b>('.$seatHost.')</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
					<td style="background-color:#d4d4d4;"><span>['.$codeHost.'] <b>'.$nameHost.'</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>ผู้ปฏิบัติงานแทน :</span></td>
					<td style="background-color:#e3e3e3;"><span>['.$codeVisit.'] <b>'.$nameVisit.'</b></span></td>
				</tr>
				<tr>
					<td align="right" style="background-color:#bababa;"><span>สถานะ :</span></td>
					<td style="background-color:#ffff00;"><span><b>Pending</b></span></td>
				</tr>
			</table>
			<br><br><br>
			<span>This is an automated email, please don\'t reply.</span><br>
			<span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
			</body>
			</html>

			';

			$mail->send();
			header('location: ../index.php');
	} catch (Exception $e) {
			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}


}


?>
