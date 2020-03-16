import smtplib
#from email.MIMEMultipart import MIMEMultipart
#from email.MIMEText import MIMEText

def mail(toaddr,subject,body):
	server=smtplib.SMTP("smtp.gmail.com",25)
	server.ehlo()
	server.starttls()
	server.ehlo()
	server.login("otbsinfra@gmail.com","OTBS@otbs123")
	fromaddr="otbsinfra@gmail.com"
	text=subject+"\n"+body
	server.sendmail("otbsinfra@gmail.com",toaddr,text)
	server.quit()
	return

