import getpass
import telnetlib

HOST = input("Enter Wan IP : ")
user = "noa"
password = ":jvogihonoa"

tn = telnetlib.Telnet(HOST)

tn.read_until(b"Login: ")
tn.write(user.encode('ascii') + b"\n")
if password:
    tn.read_until(b"Password: ")
    tn.write(password.encode('ascii') + b"\n")
tn.write(b"in p\n")
print(tn.read_all().decode('ascii'))
