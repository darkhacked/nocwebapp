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


//echo "$config";
//echo "$VPN";
//echo "$SIM";
//echo "$LAN";
//echo "$LAN2";
//echo "$LAN3";

?>
