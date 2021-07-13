<?php
	include('Functions/functions.php');

  echo "<div class=\"col bg\" font style=\"color:lightgreen\"><pre><h6>";
	echo "Service Order = " . trim(preg_replace('/\s+/', '', $SO)) . "\n";
  echo "IP WAN = " . trim(preg_replace('/\s+/', '', $WAN)) . "\n";
  echo "IP Network = " . $NETWORK . "\n";
  echo "IP Gateway = " . $GATEWAY . "\n";
  echo "IP LAN = " . trim(preg_replace('/\s+/', '', $LAN)) . "\n";
  echo "</h6></pre>";
  echo "<hr>";

?><pre id="showconfig"><h6>service timestamps debug datetime msec
service timestamps log datetime localtime
service password-encryption
service sequence-numbers
!
hostname <?php echo trim(preg_replace('/\s+/', '', $SO)) . "\n";?>
!
enable secret <?php echo trim(preg_replace('/\s+/', '', $SO)) . "\n";?>
!
aaa new-model
!
aaa group server radius Corp3BB
 server-private 10.255.254.216 auth-port 1812 acct-port 1813 timeout 1 retransmit 0 key 7 0528571C221C6E3D2D313530
 server-private 10.255.254.217 auth-port 1812 acct-port 1813 timeout 1 retransmit 0 key 7 13264601085C241E1F100A11
!
aaa authentication login authenloc local
aaa authentication login authenrad group Corp3BB local
aaa authorization console
aaa authorization exec authorized1 group Corp3BB local if-authenticated
aaa authorization exec authorized2 local if-authenticated
aaa accounting exec accounting1 start-stop group Corp3BB
aaa accounting connection Corp3BB start-stop broadcast group Corp3BB
!
aaa session-id common
clock timezone Bangkok 7 0
!
no ip domain lookup
no ipv6 cef
!
archive
 log config
  logging enable
  notify syslog contenttype plaintext
  hidekeys
file privilege 6
username adminnoa privilege 15 secret 5 $1$lNKP$uguGDn0fQImUqOiFx8/HS0
username noctttbb privilege 15 secret 5 $1$qLyT$viRU7uJdEM0byii1GOWtG1
!
controller VDSL 0
 operating mode adsl2+
!
no cdp advertise-v2
!
vlan 100
!
ip access-list extended deny-icmp
 permit icmp host 10.3.22.249 any
 permit icmp host 10.255.254.12 any
 permit icmp host 10.255.254.211 any
 permit icmp host 10.255.254.216 any
 permit icmp 10.0.53.0 0.0.0.255 any
 permit icmp 10.1.13.0 0.0.0.255 any
 permit icmp 10.2.0.0 0.0.0.255 any
 permit icmp 10.2.1.0 0.0.0.255 any
 permit icmp 10.2.2.0 0.0.0.255 any
 permit icmp 10.2.7.0 0.0.0.255 any
 permit icmp 10.2.9.0 0.0.0.255 any
 permit icmp 10.2.15.0 0.0.0.255 any
 permit icmp 10.2.101.0 0.0.0.255 any
 permit icmp 10.2.156.0 0.0.0.255 any
 permit icmp 10.6.1.0 0.0.0.255 any
 permit icmp 10.6.7.0 0.0.0.255 any
 permit icmp 10.21.15.0 0.0.0.255 any
 permit icmp 10.254.0.0 0.0.255.255 any
 deny   icmp any any
 permit ip any any
!
interface ATM0
 no ip address
 no atm ilmi-keepalive
 no shutdown
!
interface ATM0.101 point-to-point
 ip address <?php echo trim(preg_replace('/\s+/', '', $WAN));?> 255.255.255.252
 ip access-group deny-icmp in
 no ip redirects
 no ip proxy-arp
 atm route-bridged ip
 pvc 0/34
  encapsulation aal5snap
 !
!
interface FastEthernet0
 switchport access vlan 100
 no ip address
!
interface FastEthernet1
 no ip address
 shutdown
!
interface FastEthernet2
 no ip address
 shutdown
!
interface FastEthernet3
 no ip address
 shutdown
!
interface Vlan1
 no ip address
 shutdown
!
interface Vlan100
 ip address <?php echo trim(preg_replace('/\s+/', '', $LAN));?> 255.255.255.248
 no autostate
 no shutdown
!
ip route 0.0.0.0 0.0.0.0 <?php echo trim(preg_replace('/\s+/', '', $GATEWAY)) . "\n";?>
!
ip access-list standard Management3BB
 permit 10.255.254.12
 permit 10.255.254.216
 permit <?php echo trim(preg_replace('/\s+/', '', $GATEWAY)) . "\n";?>
!
logging host 10.255.254.216
logging host 10.255.254.217
!
snmp-server community SCB@3BB RO
!
privilege exec level 2 traceroute
privilege exec level 2 ping ip
privilege exec level 2 ping
privilege exec level 6 reload
privilege exec level 2 show ip route
privilege exec level 2 show ip interface brief
privilege exec level 2 show ip interface
privilege exec level 2 show ip
privilege exec level 2 show version
privilege exec all level 6 show running-config
privilege exec level 2 show logging
privilege exec level 2 show
privilege exec level 2 clear ip arp
privilege exec level 2 clear ip
privilege exec level 2 clear counters
privilege exec level 2 clear
!
line con 0
 authorization exec authorized2
 accounting exec accounting1
 logging synchronous
 login authentication authenloc
 no modem enable
line aux 0
line vty 0 4
 access-class Management3BB in
 authorization exec authorized1
 accounting exec accounting1
 logging synchronous
 login authentication authenrad
 transport input telnet ssh
!
ntp update-calendar
ntp server 10.255.254.12
!
end</h6></pre></div><script type="text/javascript" src="http://10.11.61.54/app/tools/functions/create_config.php?page=logcreate"></script>
