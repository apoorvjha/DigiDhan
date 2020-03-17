++++++++++++++++++++++++++++++++++++++++++++++++++ DEPENDENCIES +++++++++++++++++++++++++++++++++++++++++++++++++++

$ PYTHON3.x ; x>=5.
$ PILLOW library(PYTHON).
$ numpy library(PYTHON).
$ matplotlib library(PYTHON).
$ mysql.connector library(PYTHON).
$ smtplib library(PYTHON).
$ XAMPP server version>=5.6 .
$ Best viewed on google Chromium browser.
$ RAM > 2GB.
$ Screen resolution of 1366 X 768 pixels.

++++++++++++++++++++++++++++++++++++++++++++++++++++ End of DEPENDENCIES ++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++++++++ Modules ++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$ Home page
$ Login
$ User Registration
$ Services 
	->Cheque issue (virtual cheque is created in which user need to upload his/her signature along with other cheque related data in the 			form.)
	->Cheque deposit (Physical cheque is uploaded along with issuer's details assuming that issuer is DigiDhan client.)
	->Card request (user can request for credit/debit cards for their accounts without visiting their bank's branch .)
	->Transaction History(users can track their transaction history and status.)
	->Change credentials(Name, password and email registered on the website can be changed using this service.)
$ Careers (any visitor can submit their resume to be considered for future employment purposes.)
$ Ventures(visitors can look into the list of banks that share business relationship with us.)
$ Admin pannel (apart from visitors and users, we have admins who have previledge to activate and deactivate users. Super user is the one 	who is responsible for admin activities as well as adding and deleting ventures as well. )
$ Machine learning(this is responsible to analyse various signatures of user and train a neural network such that the signatures uploaded as transaction credentials are when fed into that model, it should output wheather the signature is authentic or not based on which status of transaction is changed in real time.)
$ Contact (users and admins can talk to the super user to rectify their queries and doubts about the system.) 

++++++++++++++++++++++++++++++++++++++++++++ End of module listing ++++++++++++++++++++++++++++++++++++++++++++++++

++++++++++++++++++++++++++++++++++++++++++++ Functioning of the code ++++++++++++++++++++++++++++++++++++++++++++++
# create a database with name as "DigiDhan" in your XAMPP/WAMPP admin pannel. 
# user of this database should be "root" and password for it should be null.

@ if you want to do otherwise then corresponding changes need to be done inside the connectivity code of PHP-MYSQL 
and PYTHON-MYSQL.

# "index.php" is home page of our web site. 
# For activating a new registered users you need to login as admin/super user and then activate the correspondig user from admin pannel.
# For deactivating users we have same procedure as for activating users.
# As users/admin you can chat with super user using inbuilt chat application.
# The super user you will get a pannel of listing all users who texted you and you can choose either to read the chat or delete the chats from that user.
# You can issue and deposit cheque through our services without worrying about physical visit to bank's branch.
# You need to start execution of "driver.py" python script before you move on to the web site as it will run as single threaded server that processes the cheque issue or deposit requests. 
# As part of processing the cheque(signature) and indivisual signatures go through authentication on a trained deep learning
signature recognition model which is essentially a custom made backpropagation neural network. Which automatically changes the status of the transaction based on the label it predicts for the cheque(signature) or indivisual signature in real time using AJAX framework.
# Most of Fetch in the project is AJAX implementation to provide seamless experience to users.
 
+++++++++++++++++++++++++++++++++++++++++ End of functioning details +++++++++++++++++++++++++++++++++++++++++++++

+++++++++++++++++++++++++++++++++++++++++ Problems that need to be addressed +++++++++++++++++++++++++++++++++++++
! Backpropagation neural network is slow in comparison to convolution neural network. Speed is crucial in domain we are dealing with as a typical bank can have ~ 1million users (atleast) and for each user we store 10 images that means we need
to train our model on ~10 million images which will take more time to process requests in comparison to traditional system.

! We are not using any hashing or encryption and decryption scheme for passwords so users accounts are vulnerable to
account hijacking if database is compromised.

! Alot of redundant peice of code is present on each code page which need to segmented so that overall size of the project can be reduced.

