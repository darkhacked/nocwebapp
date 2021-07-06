<?php
	include('Functions/functions.php');

  $LabelLAN2  = "# Lan2      : " . trim(preg_replace('/\s+/', '', $LAN2));
  $LabelLAN3  = "# Lan3      : " . trim(preg_replace('/\s+/', '', $LAN3));
  $AddLAN2  = "ip address " . trim(preg_replace('/\s+/', '', $LAN2)) . " label br0:2";
  $AddLAN3  = "ip address " . trim(preg_replace('/\s+/', '', $LAN3)) . " label br0:3";

?><div class="col bg" font style="color:lightgreen"><pre id="showconfig"><h6>########################################
# Type   : Config Hongdian + 4G INTERNET
# UserVPN   : <?php echo trim(preg_replace('/\s+/', '', $VPN)) . "\n";?>
# Lan       : <?php echo trim(preg_replace('/\s+/', '', $LAN)) . "\n";?>
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
########################################
!
hostname <?php echo trim(preg_replace('/\s+/', '', $VPN)) . "\n";?>
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
ip address <?php echo trim(preg_replace('/\s+/', '', $LAN)) . "\n";
if ($LAN2 == "") {
  echo "";
}else {
  echo "$AddLAN2\n";
}

if ($LAN3 == "") {
  echo "ip address 192.168.8.1/24 label br0:3\n";
}else {
  echo "$AddLAN3\n";
}
?>
!
interface ppp100
!
interface modem
!
interface ppp110
!
interface vpdnL2Sim1
!
ip route 0.0.0.0/0 vpdnL2Sim1
ip route 10.0.0.0/8 vpdnL2Sim1
ip route 172.16.0.0/12 vpdnL2Sim1
ip route 172.29.4.0/24 modem
ip route 172.30.234.0/24 modem
ip route 192.168.0.0/16 vpdnL2Sim1
ip route 203.147.0.10/32 modem
ip route 203.147.63.147/32 modem
!
line vty
!
interface modem Sim1
svc-code *99***1#
access-point-name www.dtac.co.th
username internet password internet
simcard 1
network-type auto
ppp advance authernication refuse-chap refuse-mschap refuse-mschap-v2 refuse-eap
ppp advance compress novj novjccomp nopcomp noaccomp noccp
ppp advance debug
ppp advance usepeerdns
ppp advance lcp interval 30 retry 5
ppp advance mtu 1300
!
!
!
!
service wakeup
shutdown
phone number 021003000 action reboot
phone number 66865463200 action reboot
!
!
service snmp
snmp port 161
community kcs
!
service syslog
file size 80
destination 10.0.1.33
server port 514
!
service ntp
update interval 360
primary destination 203.147.0.4
secondary destination 10.0.1.33
time zone bangkok/hanoi/jakarta
!
!
interface vpdn L2Sim1
username <?php echo trim(preg_replace('/\s+/', '', $VPN));?>@jivpn password 123456
destination 203.147.63.147
protocol l2tp
ppp advance authernication refuse-chap refuse-mschap refuse-mschap-v2 refuse-eap
ppp advance compress novj novjccomp nopcomp noaccomp noccp
ppp advance debug
ppp advance usepeerdns
ppp advance lcp interval 30 retry 5
ppp advance mtu 1400
!
!
!
!
service dhcp
set ip pool 192.14.186.254 192.168.8.254
lease time 3600
set dns 203.147.0.3 203.147.0.2
shutdown
!
!
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