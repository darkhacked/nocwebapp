<?php

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


$c_id = mysqli_real_escape_string($db,$_GET['c_id']);


$sql = "SELECT * FROM swap WHERE c_id='$c_id' ";
$qry = mysqli_query($db, $sql);
while ($qrydata = mysqli_fetch_array($qry)) {
  $codeHost = $qrydata["c_code_host"];
  $dateHost = $qrydata["c_date_host"];
  $seatHost = $qrydata["c_seat_host"];
  $labelM   = $qrydata["c_labelmain"];
  $label    = $qrydata["c_label"];
  $codeVisit = $qrydata["c_code_visit"];
  $dateVisit = $qrydata["c_date_visit"];
  $seatVisit = $qrydata["c_seat_visit"];

  $color = "#00ff00";

  $selectemailHost = "SELECT user_name, email FROM users WHERE username='$codeHost'";
  $qry = mysqli_query($db, $selectemailHost);
  while ($qrydata = mysqli_fetch_array($qry)) {
    $nameHost = $qrydata["user_name"];
		$emailHost = $qrydata["email"];
	}

  $selectemailVisit = "SELECT user_name, email FROM users WHERE username='$codeVisit'";
  $qry = mysqli_query($db, $selectemailVisit);
  while ($qrydata = mysqli_fetch_array($qry)) {
    $nameVisit = $qrydata["user_name"];
		$emailVisit = $qrydata["email"];
	}

  $updatewdayVisit = "INSERT INTO work (w_code, w_date, w_type, w_status) VALUES ('$codeVisit', '$dateHost', '$seatHost', '$color')";
  mysqli_query($db, $updatewdayVisit);

  $updatewdayHost = "DELETE FROM work WHERE w_code = '$codeHost' AND w_date ='$dateHost'";
  mysqli_query($db, $updatewdayHost);

  $updateSwap = "UPDATE swap SET c_status ='Approve', c_badge='success' WHERE c_id='$c_id' ";
  mysqli_query($db, $updateSwap);



  // Instantiation and passing `true` enables exceptions
  $mail = new PHPMailer(true);

  try {
      //Server settings
      //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
      $mail->CharSet = "utf-8";
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
      //$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
      $mail->Password   = 'darkhacked_123';                               // SMTP password
      //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom('webapp@ji-net.com', 'NOC-JINET WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
      $mail->addAddress($emailHost);     // TO host
      $mail->addCC('spanyaphol@ji-net.com');
      $mail->addCC('wpacharaporn@ji-net.com');          // CC พี่เจน
      $mail->addCC($emailVisit);						// CC Visit
      $mail->addCC('nocchief@ji-net.com');

      // Content
      $mail->isHTML(true);                                  // Set email format to HTML
      $mail->Subject = '[APV] คำขออนุมัติของ'.$nameHost.' ('.$codeHost.')';
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
      <span>เรียน คุณ'.$nameHost.'</span><br>
      <span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณ'.$nameVisit.'</span><br>
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
          <td style="background-color:#e3e3e3;"><span>'.$dateHost.' <b>('.$seatHost.')</b></span></td>
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
          <td style="background-color:#00ff00;"><span><b>Approve</b></span></td>
        </tr>
      </table>
      <br><br><br>
      <span>This is an automated email, please dont\'t reply.</span><br>
      <span>Sent by NOC-JINET WORK SCHEDULE WEBAPP.</span>
      </body>
      </html>

      ';
      //$mail->AltBody = 'ทดสอบการส่ง หัวข้อรอง This is the body in plain text for non-HTML mail clients';

      $mail->send();
      header('location: ../moderator/home.php');
  } catch (Exception $e) {
      echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }



}


 ?>
