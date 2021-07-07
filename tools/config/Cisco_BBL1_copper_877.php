<?php
	include('Functions/functions.php');

  echo "<div class=\"col bg\" font style=\"color:lightgreen\"><pre><h6>";
  echo "Type : Config BBL Copper + CISCO877\n";
  echo "Service Order = " . trim(preg_replace('/\s+/', '', $SO)) . "\n";
  echo "IP WAN = " . trim(preg_replace('/\s+/', '', $WAN)) . "\n";
  echo "IP Gateway = " . $GATEWAY . "\n";
  echo "Loopback = " . trim(preg_replace('/\s+/', '', $LOOPBACK)) . "\n";
  echo "VLAN1 = " . trim(preg_replace('/\s+/', '', $VLAN)) . "\n";
  echo "</h6></pre>";
  echo "<hr>";

?><pre id="showconfig"><h6>version 12.4
no service pad
service timestamps debug datetime msec
service timestamps log datetime msec
service password-encryption
!
hostname <?php echo trim(preg_replace('/\s+/', '', $SO)) . "\n";?>
!
boot-start-marker
boot-end-marker
!
logging buffered 4096
!
no aaa new-model
!
dot11 syslog
ip cef
!
no ip domain lookup
ip domain name bbl.co.th
!
multilink bundle-name authenticated
!
username tttbb privilege 15 secret 5 $1$RsTr$6AHGzOTR5S.vpMtA1clcL0
username bbl privilege 15 secret 5 $1$ZjSb$/DgmrOuNaejAZH4PUwaPz0
!
archive
 log config
  hidekeys
!
ip tftp source-interface loopback 0
ip ssh version 2
!
interface Loopback0
 ip address <?php echo trim(preg_replace('/\s+/', '', $LOOPBACK));?> 255.255.255.255
!
interface ATM0
 no ip address
 no atm ilmi-keepalive
 dsl operating-mode adsl2+
 no shutdown
!
interface ATM0.101 point-to-point
 ip address <?php echo trim(preg_replace('/\s+/', '', $WAN));?> 255.255.255.252
 no ip redirects
 no ip proxy-arp
 atm route-bridged ip
 pvc 0/34
  encapsulation aal5snap
!
interface FastEthernet0
 no shutdown
!
interface FastEthernet1
!
interface FastEthernet2
!
interface FastEthernet3
!
interface Vlan1
 ip address <?php echo trim(preg_replace('/\s+/', '', $VLAN));?> 255.255.255.248
 no shutdown
!
ip forward-protocol nd
ip route 0.0.0.0 0.0.0.0 <?php echo trim(preg_replace('/\s+/', '', $GATEWAY)) . "\n";?>
ip route 10.2.0.0 255.255.0.0 <?php echo trim(preg_replace('/\s+/', '', $GATEWAY));?> name MONITOR-WAN-3BB
ip route 10.255.254.0 255.255.255.0 <?php echo trim(preg_replace('/\s+/', '', $GATEWAY));?> name MONITOR-SERVER-3BB
!
no ip http server
no ip http secure-server
!
control-plane
!
line con 0
 no modem enable
line aux 0
line vty 0 4
 exec-timeout 0 0
 login local
 transport input all
!
scheduler max-task-time 5000
end</h6></pre></div>
