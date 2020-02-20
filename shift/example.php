    <?php
    //เปิดการเชื่อมต่อฐานข้อมูล sunzandesign
    //mysql_connect("localhost","root","abcd1234");  //ข้อมูลนี้ได้มาจากตอนติดตั้งเว็บเซิร์ฟเวอร์
    $conn = mysqli_connect('localhost', 'root', 'toor', 'test');  //ข้อมูลนี้ได้มาจากตอนติดตั้งเว็บเซิร์ฟเวอร์
    mysqli_set_charset($conn, "utf8");//ส่วนนี้คือการตั้งค่า encoding แบบสากล ถ้าฐานข้อมูลเป็น tis-620 ก็ต้องเปลี่ยนด้วย
    ?>
    <html>
    <head>
    <title>SunZan-Desgin.Com</title>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <style>
    .number{ text-align : right;}
    .number div{
     background: #91F7A4;
     color : #ff0000;
    }
    #test_report th{ background-color : #21BBD6; color : #ffffff;}
    #test_report{
     border-right : 1px solid #eeeeee;
     border-bottom : 1px solid #eeeeee;
    }
    #test_report td,#test_report th{
     border-top : 1px solid #eeeeee;
     border-left : 1px solid #eeeeee;
     padding : 2px;
    }
    #txt_year{ width : 70px;}
    .fail{ color : red;}
    </style>
    </head>
    <body>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
     <table>
      <tr>
       <td>ระบุเดือน-ปี : </td>
       <td>
        <select name="txt_month">
         <option value="">--------------</option>
         <?php
         $month = array('01' => 'มกราคม', '02' => 'กุมภาพันธ์', '03' => 'มีนาคม', '04' => 'เมษายน',
             '05' => 'พฤษภาคม', '06' => 'มิถุนายน', '07' => 'กรกฎาคม', '08' => 'สิงหาคม',
             '09' => 'กันยายน ', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
         $txtMonth = isset($_POST['txt_month']) && $_POST['txt_month'] != '' ? $_POST['txt_month'] : date('m');
         foreach($month as $i=>$mName) {
          $selected = '';
          if($txtMonth == $i) $selected = 'selected="selected"';
          echo '<option value="'.$i.'" '.$selected.'>'. $mName .'</option>'."\n";
         }
         ?>
        </select>
       </td>
       <td>
        <select name="txt_year">
         <option value="">--------------</option>
         <?php
         $txtYear = (isset($_POST['txt_year']) && $_POST['txt_year'] != '') ? $_POST['txt_year'] : date('Y');
         $yearStart = date('Y');
         $yearEnd = $txtYear-5;
         for($year=$yearStart;$year > $yearEnd;$year--){
          $selected = '';
          if($txtYear == $year) $selected = 'selected="selected"';
          echo '<option value="'.$year.'" '.$selected.'>'. ($year+543) .'</option>'."\n";
         }
         ?>
        </select>
       </td>
       <td><input type="submit" value="ค้นหา" /></td>
      </tr>
     </table>
    </form>
    <?php
    //รับค่าตัวแปรที่ส่งมาจากแบบฟอร์ม HTML
    $year = isset($_POST['txt_year']) ? mysqli_real_escape_string($conn, $_POST['txt_year']) : '';
    $month = isset($_POST['txt_month']) ? mysqli_real_escape_string($conn, $_POST['txt_month']) : '';
    if($year == '' || $month == '') exit('<p class="fail">กรุณาระบุ "เดือน-ปี" ที่ต้องการเรียกรายงาน</p>');


    //ดึงข้อมูลพนักงานทั้งหมด
    //ในส่วนนี้จะเก็บข้อมูลโดยใช้คีย์ เป็นรหัสพนักงาน และ value คือชื่อพนักงาน
    $allEmpData = array();
    $strSQL = "SELECT user_code,user_fullname FROM `tb_user` ";
    $qry = mysqli_query($conn, $strSQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
    while($row = mysqli_fetch_assoc($qry)){
     $allEmpData[$row['user_code']] = $row['user_fullname'];
    }

    echo "<pre>";
    print_r($year);
    print_r($month);
    print_r($allEmpData);
    echo "</pre>";

    //เรียกข้อมูลการจองของเดือนที่ต้องการ
    $allReportData = array();
    $strSQL = "SELECT bk_user_code, DAY(`bk_date`) AS bk_day, COUNT(*) AS numBook FROM `tb_report_booking`
    WHERE `bk_date` LIKE '$year-$month%'
    GROUP by bk_user_code,DAY(`bk_date`)";
    $qry = mysqli_query($conn, $strSQL) or die('ไม่สามารถเชื่อมต่อฐานข้อมูลได้ Error : '. mysqli_error());
    while($row = mysqli_fetch_assoc($qry)){
     $allReportData[$row['bk_user_code']][$row['bk_day']] = $row['numBook'];
    }
    echo "<table border='0' id='test_report' cellpadding='0' cellspacing='0'>";
    echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
    echo '<th>รหัสพนังงาน</th>';
    echo '<th>รายชื่อพนักงาน</th>';
    //วันที่สุดท้ายของเดือน
    $timeDate = strtotime($year.'-'.$month."-01");  //เปลี่ยนวันที่เป็น timestamp
    $lastDay = date("t", $timeDate);       //จำนวนวันของเดือน
    echo "$timeDate";
    //สร้างหัวตารางตั้งแต่วันที่ 1 ถึงวันที่สุดท้ายของดือน
    for($day=1;$day<=$lastDay;$day++){
     echo '<th>' . substr("0".$day, -2) . '</th>';
    }
    echo "</tr>";
    //วนลูปเพื่อสร้างตารางตามจำนวนรายชื่อพนักงานใน Array
    foreach($allEmpData as $empCode=>$empName){
     echo '<tr>';//เปิดแถวใหม่ ตาราง HTML
     echo '<td>'. $empCode .'</td>';
     echo '<td>'. $empName .'</td>';
      //เรียกข้อมูลการจองของพนักงานแต่ละคน ในเดือนนี้
     for($j=1;$j<=$lastDay;$j++){
      //ตรวจสอบว่าวันที่แต่ละวัน $j ของ พนักงานแต่ละรหัส  $empCode มีข้อมูลใน  $allReportData หรือไม่ ถ้ามีให้แสดงจำนวนในอาร์เรย์ออกมา ถ้าไม่มีให้เป็น 0
      $numBook = isset($allReportData[$empCode][$j]) ? '<div>'.$allReportData[$empCode][$j].'</div>' : 0;
      echo "<td class='number'>", $numBook, "</td>";
     }
      echo '</tr>';//ปิดแถวตาราง HTML
    }
    echo "</table>";

    echo "<pre>";
    print_r($numBook);
    echo "<br>";
    echo "allreport data";
    echo "<br>";
    print_r($allReportData);
    echo "</pre>";

    mysqli_close($conn);//ปิดการเชื่อมต่อฐานข้อมูล
    ?>
