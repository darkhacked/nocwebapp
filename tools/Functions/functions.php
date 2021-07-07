<?php
error_reporting(E_ERROR | E_PARSE);

if (isset($_POST['submit_btn'])) {
  $config    =  $_POST['config'];
  $VPN       =  $_POST['user'];
  $PASS      =  $_POST['passvpn'];
  $SIM       =  $_POST['usersim'];
  $LAN       =  $_POST['lan'];
  $LAN2      =  $_POST['lan2'];
  $LAN3      =  $_POST['lan3'];

  $ConURL = "config/$config.php";

}


if (isset($_POST['submit_scb'])) {
  $config    =  $_POST['config'];
  $SO       =  $_POST['user'];
  $WAN       =  $_POST['wan'];
  $LAN       =  $_POST['lan'];

  $f0 = trim(preg_replace('/\s+/', '', $WAN));
  $f1 = strrchr($f0,"."); // ตัด ip 3 ชุดหน้าออก
  $f2 = substr($f1,1); // ตัด . เพื่อเอาเลขเพียวๆ
  $f3 = $f2 -2;
  $f4 = $f2 -1;

  $f5 = strrev($f0); // สลับหน้าหลังเพื่อตัดชุดสุดท้ายออก
  $f6 = strstr($f5,"."); // ตัดชุดแรกออก
  $f7 = strrev($f6); // สลับกลับ

  $NETWORK = $f7.$f3;
  $GATEWAY = $f7.$f4;

  $ConURL = "config/$config.php";

}

if (isset($_POST['submit_bbl'])) {
  $config    =  $_POST['config'];
  $SO        =  $_POST['user'];
  $WAN       =  $_POST['wan'];
  $LOOPBACK  =  $_POST['lb'];
  $VLAN      =  $_POST['vlan'];

  $f0 = trim(preg_replace('/\s+/', '', $WAN));
  $f1 = strrchr($f0,"."); // ตัด ip 3 ชุดหน้าออก
  $f2 = substr($f1,1); // ตัด . เพื่อเอาเลขเพียวๆ
  $f3 = $f2 -1;

  $f5 = strrev($f0); // สลับหน้าหลังเพื่อตัดชุดสุดท้ายออก
  $f6 = strstr($f5,"."); // ตัดชุดแรกออก
  $f7 = strrev($f6); // สลับกลับ

  $GATEWAY = $f7.$f3;

  $ConURL = "config/$config.php";

}
//echo "$config";
//echo "$VPN";
//echo "$SIM";
//echo "$LAN";
//echo "$LAN2";
//echo "$LAN3";

?>
