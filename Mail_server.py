import smtplib
from email.MIMEMultipart import MIMEMultipart
from email.MIMEText import MIMEText
f=open("mail_log.txt","r")
while(1):
  server=smtplib.SMTP("localhost",8081)
	fromaddr="example@gmail.com"  # example mail id 
	k=f.readline()
	#print(k)
	if len(k)!=0:
		q=k.split('~')
		toaddr=q[0]
		msg=MIMEMultipart()
		msg['From']=fromaddr
		msg['To']=toaddr
		msg['Subject']=q[1]
		body=q[2]
		msg.attach(MIMEText(body,'plain'))
		text=msg.as_string()
		server.sendmail(fromaddr,toaddr,text)

