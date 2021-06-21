<?php
	include('Functions/functions.php');
  $config    =  $_POST['config'];
  $VPN       =  $_POST['user'];
  $SIM       =  $_POST['usersim'];
  $LAN       =  $_POST['lan'];
  $LAN2      =  $_POST['lan2'];
  $LAN3      =  $_POST['lan3'];

  $LabelLAN2  = "# Lan2      : $LAN2";
  $LabelLAN3  = "# Lan3      : $LAN3";
  $AddLAN2  = "ip address $LAN2 label br0:2";
  $AddLAN3  = "ip address $LAN3 label br0:3";

?><div class="col bg" font style="color:lightgreen"><pre id="showconfig"><h6>#############################
# UserVPN   : <?php echo "$VPN\n"; ?>
# UserDTAC  : <?php echo "$SIM\n"; ?>
# Lan       : <?php echo "$LAN\n"; ?>
<?php
if ($LAN2 == "") {
  echo "";
}else {
  echo "$LabelLAN2\n";
}

if ($LAN3 == "") {
  echo "";
}else {
  echo "$LabelLAN3\n";
}
?>
#############################
!
hostname <?php echo "$VPN\n"; ?>
password admin
!
interface lo
!
interface eth0
!
interface tunl0
!
interface gre0
!
interface vlan0
!
interface br0
ip address <?php echo "$LAN\n"; ?>
<?php
if ($LAN2 == "") {
  echo "";
}else {
  echo "$AddLAN2\n";
}

if ($LAN3 == "") {
  echo "ip address 192.168.8.1/24 label br0:2\n";
}else {
  echo "$AddLAN3\n";
}
?>
!
interface modem
!
interfacevpdnL2Sim1
!
ip route 0.0.0.0/0 vpdnL2Sim1
ip route 10.0.0.0/8 vpdnL2Sim1
ip route 172.16.0.0/12 vpdnL2Sim1
ip route 172.29.4.0/24 modem
ip route 172.30.234.0/24 modem
ip route 192.168.0.0/16 vpdnL2Sim1
ip route 203.147.0.10/32 modem
ip route 203.147.63.131/32 modem
!
line vty
!
interface modem Sim1
 svc-code *99***1#
 access-point-name corp.jivpn
 username <?php echo "$SIM"; ?>@jivpn password 123456
 simcard 1
 network-type auto
 ppp advance authernication refuse-chap refuse-mschap refuse-mschap-v2 refuse-eap
 ppp advance compress novj novjccomp nopcomp noaccomp noccp
 ppp advance debug
 ppp advance usepeerdns
 ppp advance lcp interval 30 retry 5
 ppp advance mtu 1300
!
service wakeup
 shutdown
 phone number 66865463200 action reboot
 phone number 021003000 action reboot
!
service snmp
 snmp port 161
 community kcs
!
service syslog
 file size 80
 destination 192.168.8.123
 shutdown
!
service ntp
 update interval 360
 primary destination 172.30.234.25
 secondary destination 10.0.1.33
 time zone bangkok/hanoi/jakarta
!
interface vpdn L2Sim1
 username <?php echo "$VPN"; ?>@jivpn password 123456
 destination 172.30.234.15
 protocol l2tp
 ppp advance authernication refuse-chap refuse-mschap refuse-mschap-v2 refuse-eap
 ppp advance compress novj novjccomp nopcomp noaccomp noccp
 ppp advance debug
 ppp advance usepeerdns
 ppp advance lcp interval 30 retry 5
!
service dhcp
 set ip pool 10.162.103.130 10.162.103.140
 lease time 3600
 set gateway 10.162.103.129
 set dns 10.162.34.3 10.162.34.4
 shutdown
!
ip dns server modem
!
parameter select rule 0
 select interface modem Sim1 check state
 select interface vpdn L2Sim1 check state
 check interval 40 retry 5
!
service webadmin
 admin username admin password admin
 guest username guest password guest
!</h6></pre></div>
