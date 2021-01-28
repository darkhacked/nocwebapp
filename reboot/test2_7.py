import getpass
import sys
import telnetlib

HOST = raw_input(" ")
#HOST = "10.50.237.15"
user = "noa"
password = ":jvogihonoa"

tn = telnetlib.Telnet(HOST)

tn.read_until("Login: ")
tn.write(user + "\n")
if password:
    tn.read_until("Password: ")
    tn.write(password + "\n")
    tn.read_until(">")
    tn.write("in p\n")
    data = ''
    #print tn.read_until('>')
    while data.find('>') == -1:
        data += tn.read_very_eager()
    print data
