import smtplib
import quickstart    # gmail API call
f=open("mail_log.txt","r")
sender="DigiDhan20@gmail.com"
while(1):
	k=f.readline()
	if len(k)!=0:
		q=k.split('~')
		to=q[0]
		subject=q[1]
		message_text=q[2]
		quickstart.driver(sender, to, subject, message_text)


