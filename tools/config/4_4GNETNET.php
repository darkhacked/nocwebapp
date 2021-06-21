<?php
	include('Functions/functions.php');
  $config    =  $_POST['config'];
  $VPN       =  $_POST['user'];
  $PASS      =  $_POST['passvpn'];
  $LAN       =  $_POST['lan'];
  $LAN2      =  $_POST['lan2'];
  $LAN3      =  $_POST['lan3'];

  $LabelLAN2  = "# Lan2      : $LAN2";
  $LabelLAN3  = "# Lan3      : $LAN3";
  $AddLAN2  = "ip address add address=$LAN2 interface=Lan comment=Lan-Cus2";
  $AddLAN3  = "ip address add address=$LAN3 interface=Lan comment=Lan-Cus3";

?><div class="col bg" font style="color:lightgreen"><pre id="showconfig"><h6>#############################
# UserVPN   : <?php echo "$VPN\n"; ?>
# PassVPN   : <?php echo "$PASS\n"; ?>
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
#
system identity set name=<?php echo "$VPN\n"; ?>
#
user add name=noa password=:jvogihonoa group=full disabled=no
user remove 0
user add name=kcs password=kcssck group=write disabled=no
#
# Disable Wifi
interface disable numbers=5
interface bridge add name=bridge
interface lte set [find] name=AirCard
interface wireless cap set enabled=no
#
interface bridge set name=Lan numbers=0
interface ethernet set numbers=0 name=ether1-Wan
interface ethernet set numbers=1 name=ether2-Lan
interface ethernet set numbers=2 name=ether3-Lan
interface ethernet set numbers=3 name=ether4-Lan
interface ethernet set numbers=4 name=ether5-Lan
#
interface ppp-client add add-default-route=no apn=internet disabled=no name=SIM-Internet port=usb1 use-peer-dns=no
interface enable 6
interface ppp-client remove 1
#
interface l2tp-client add add-default-route=yes connect-to=203.147.8.133 disabled=no max-mru=1400 max-mtu=1400 \
mrru=1550 name=Wan password=<?php echo "$PASS"; ?> user=<?php echo "$VPN\n"; ?>
#
ip address add address=<?php echo "$LAN"; ?> interface=Lan comment=Lan-Cus
<?php
if ($LAN2 == "") {
  echo "";
}else {
  echo "$AddLAN2\n";
}

if ($LAN3 == "") {
  echo "ip address add address=192.168.88.1/24 interface=Lan comment=Lan-Default\n";
}else {
  echo "$AddLAN3\n";
}
?>
ip address add address=192.168.1.2 netmask=255.255.255.252 interface=ether1-Wan comment=C2RNW192
ip address add address=10.10.254.2 netmask=255.255.255.252 interface=ether1-Wan comment=C2RNW10
#
ip route add check-gateway=ping dst-address=203.147.8.133/32 gateway=192.168.1.1 distance=5 comment=L2TP-Connect-192
ip route add check-gateway=ping dst-address=203.147.8.133/32 gateway=10.10.254.1 distance=10 comment=L2TP-Connect-10
ip route add check-gateway=ping dst-address=203.147.8.133/32 gateway=SIM-Internet distance=15 comment=L2TP-Connect-E303
ip route add check-gateway=ping dst-address=203.147.8.133/32 gateway=192.168.8.1 distance=20 comment=L2TP-Connect-E3372
#
ip dhcp-client remove 0
ip pool remove 0
ip dhcp-server network remove 0
ip dhcp-server disable 0
ip dhcp-server remove 0
#
ipv6 settings set forward=no
ipv6 address remove numbers=0
ipv6 address remove numbers=1
ipv6 address remove numbers=2
ipv6 settings set accept-redirects=no
ipv6 settings set accept-router-advertisements=no
#
#
system ntp client set enabled=yes primary-ntp=203.147.0.3 secondary-ntp=203.147.0.2
system clock set time-zone-name=Asia/Bangkok
ip dns set allow-remote-requests=yes servers=203.147.0.3,8.8.8.8
#
ip dhcp-client add add-default-route=no disabled=no interface=AirCard comment="DHCP From AirCard"
#
queue simple add max-limit=1024k/10240k name="Rate limit" target=Lan disabled=yes
#
snmp set enabled=yes trap-target=0.0.0.0
snmp community set [ find default=yes ] addresses=10.0.0.0/8,172.16.0.0/12,192.168.0.0/16,203.147.0.10/32,203.147.1.224/32 name=jinet
#
system scheduler add disabled=yes interval=1d name="Reboot 1 Day" on-event=\
    "log warning \"######## Schedue reboot ########\" ; delay 15; :execute {/system reboot;}" policy=\
    ftp,reboot,read,write,policy,test,password,sniff,sensitive,romon start-time=06:00:00
#
tool netwatch add comment="Ping for Log" down-script="log warning \"Netwatch 10.0.1.33 Down\"" host=10.0.1.33 timeout=2s \
    up-script="log warning \"Netwatch 10.0.1.33 Up\""
tool netwatch add comment="Ping For Reboot" disabled=yes down-script="log warning \"netwatch Reboot 10.0.1.33 \
	Down\"; :if ([/ping 10.0.1.33 interval=5s count=180] =0) do={\r\nlog warning \"Netwatch Reboot 10.0.1.33 Reboot\" ; delay 15 ; \
	:execute {/system reboot;}\r}" host=10.0.1.33 timeout=2s up-script="log warning \"Netwatch Reboot 10.0.1.33 Up\""
#
system logging disable [find default]
system logging action add name=Syslog remote=203.130.150.130 target=remote
system logging action set 0 memory-lines=100
system logging add topics=account
system logging add topics=async
system logging add topics=critical
system logging add topics=interface
system logging add topics=system
system logging add topics=vrrp
system logging add topics=warning
system logging add action=Syslog topics=account
system logging add action=Syslog topics=async
system logging add action=Syslog topics=critical
system logging add action=Syslog topics=interface
system logging add action=Syslog topics=system
system logging add action=Syslog topics=vrrp
system logging add action=Syslog topics=warning
#
ip service set ftp disabled=yes
ip service set api disabled=yes
ip service set ssh disabled=yes
ip service set api-ssl disabled=yes
ip service set www address=10.0.0.0/8,172.16.0.0/12,192.168.0.0/16,203.147.0.10/32
ip service set telnet address=10.0.0.0/8,172.16.0.0/12,192.168.0.0/16,203.147.0.10/32
ip service set winbox address=10.0.0.0/8,172.16.0.0/12,192.168.0.0/16,203.147.0.10/32
#
ip firewall service-port disable numbers=0
ip firewall service-port disable numbers=1
ip firewall service-port disable numbers=2
ip firewall service-port disable numbers=3
ip firewall service-port disable numbers=4
ip firewall service-port disable numbers=5
ip firewall service-port disable numbers=6
ip firewall service-port disable numbers=7
ip firewall service-port disable numbers=8
ip firewall service-port disable numbers=9
#
ip firewall nat remove 0
#
ip firewall mangle remove 0
ip firewall mangle remove 1
ip firewall mangle remove 2
ip firewall mangle remove 3
#
ip firewall filter remove 0
ip firewall filter remove 1
ip firewall filter remove 2
ip firewall filter remove 3
ip firewall filter remove 4
ip firewall filter remove 5
ip firewall filter remove 7
#
ip firewall nat add action=masquerade chain=srcnat out-interface=Wan
ip firewall filter add action=log chain=forward comment=Syslog out-interface=Wan
#
system note set note="\
    \n\
    \n#############################################################################\
    \n#\
    \n# Authorised Access Only\
    \n# Disconnected IMMEDIATELY if you are not the authorized user\
    \n#\
    \n# This system is the property of Jasmine Internet Co., Ltd.\
    \n# Tel : 02-1021199 (24 Hr.)\
    \n# \
    \n# Solution : L2TP Over VPN\
    \n# Date : 2019-08-16 15:00\
    \n# Router Model : Mikrotik_951Ui-2nD\
    \n# \
    \n# ETH 1 : NET\
    \n# ETH 2 : Lan\
    \n# ETH 3 : Lan\
    \n# ETH 4 : Lan\
    \n# ETH 5 : Lan\
    \n#\
    \n#############################################################################\
    \n"
#
interface bridge port add interface=ether2-Lan bridge=Lan
interface bridge port add interface=ether3-Lan bridge=Lan
interface bridge port add interface=ether4-Lan bridge=Lan
interface bridge port add interface=ether5-Lan bridge=Lan
#
system reboot
y</h6></pre></div>
