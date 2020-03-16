import smtplib
#from email.MIMEMultipart import MIMEMultipart
#from email.MIMEText import MIMEText

def mail(toaddr,subject,body):
	mail="example@abc.com"
	password="example_password"
	server=smtplib.SMTP("smtp.gmail.com",25)
	server.ehlo()
	server.starttls()
	server.ehlo()
	server.login(mail , password)   # inplace of mail you need to put your 'email' address and in place of 'password' you email password.
 	fromaddr=mail
	text=subject+"\n"+body
	server.sendmail(mail,toaddr,text)
	server.quit()
	return

