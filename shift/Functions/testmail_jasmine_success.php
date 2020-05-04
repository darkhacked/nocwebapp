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

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->CharSet = "utf-8";
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.jasmine.com';                    // Set the SMTP server to send through
    //$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'anaphat.r@jasmine.com';                     // SMTP username
    $mail->Password   = 'darkhacked_123';                               // SMTP password
    //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 25;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

    //Recipients
    $mail->setFrom('testmailname@jasmine.com', 'NO-REPLY NOCJI WEBAPP');   // ชื่อที่จะให้โชว์ตั้งเองได้
    $mail->addAddress('godofwarpp@gmail.com', 'PLAK');     // Add a recipient
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    // Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    // Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = 'TESTTTT ทดสอบการส่งแบบ HTML';
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
    <span>สำเนาเรียน คุณพัชราพร วัฒนสุวรรณโชติ, คุณอนพัทย์ รำไพวริน, คุณนัฐพล ยิ้มสำเนียง</span><br>
    <br><br>
    <span>แจ้งรายการขออนุมัติดังนี้</span><br><br>
    <table>
      <tr>
        <th colspan="2" style="background-color:#02b875;"><span>รายการขออนุมัติ</span></th>
      </tr>
      <tr>
        <td align="right" style="background-color:#bababa;"><span>ประเภท :</span></td>
        <td style="background-color:#d4d4d4;"><span>Smith</span></td>
      </tr>
      <tr>
        <td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติงาน :</span></td>
        <td style="background-color:#e3e3e3;"><span>Lastname</span></td>
      </tr>
      <tr>
        <td align="right" style="background-color:#bababa;"><span>ผู้ขออนุมัติ :</span></td>
        <td style="background-color:#d4d4d4;"><span>Smith</span></td>
      </tr>
      <tr>
        <td align="right" style="background-color:#bababa;"><span>วันที่ปฏิบัติ OD/ON :</span></td>
        <td style="background-color:#e3e3e3;"><span>Lastname</span></td>
      </tr>
      <tr>
        <td align="right" style="background-color:#bababa;"><span>ผู้ถูกขอปฏิบัติ OD/ON :</span></td>
        <td style="background-color:#d4d4d4;"><span>Smith</span></td>
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
    //$mail->AltBody = 'ทดสอบการส่ง หัวข้อรอง This is the body in plain text for non-HTML mail clients';

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
