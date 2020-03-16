#!/usr/bin/env python
# coding: utf-8

# In[1]:


from PIL import Image                              # for image processing operations on the image.
from matplotlib import pyplot as plt               # for visualizing the image as an array.
from matplotlib import image                       # for importing image as an array of pixel intensities.
import mysql.connector as mysql                    # for database communute.
import Network_improved as ni                      # for cheque signature analysis. 
import os, sys, stat                                          # for folder level operations.
import mail                                        # for mailing custom messages to the clients based on process.


# In[2]:


def fetch_log(con):
    logger={"dot":[],"mode":[],"receiver":[],"sender":[],"amount":[],"ccn":[],"location":[],"tid":[],"status":[]}
    # this dictionary stores an instance of log file. 
    mycursor=con.cursor()
    mycursor.execute("SELECT * FROM `transaction` WHERE `Status`=0")
    result=mycursor.fetchall()
    for i in result:
        logger["dot"].append(i[6])
        logger["tid"].append(i[4])
        logger["mode"].append(i[3])
        logger["receiver"].append(i[0])
        logger["sender"].append(i[1])
        logger["amount"].append(i[2])
        logger["ccn"].append(i[5])
        logger["location"].append(i[7])
        logger["status"].append(i[8])
    return(logger)


# In[3]:


def process_requests(log,con):
    res=[]
    for i in range(len(log["sender"])):
        if log["mode"][i]=='ONLINE':
            # sender isssued a virtual cheque which constitute a signature.
            ## at first send mail to sender and receiver to make them know the deposited cheque is starting to be reviewed. 
            subject="Virtual Cheque Deposited in DigiDhan"
            mycursor=con.cursor()
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["sender"][i]))
            result=mycursor.fetchone()
            body1="""Dear """+str(result[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account
            for clearance of """ + str(log["amount"][i])+""" rupees. \nIf you were not the one who initiated this transaction then report this to your\n
            nearest bank branch."""
            #mail.mail(result[1],subject,body1)
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["receiver"][i]))
            result=mycursor.fetchone()
            body2="""Dear """+str(result[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account
            for clearance of """ + str(log["amount"][i])+""" rupees. \n"""
            #mail.mail(result[1],subject,body2)

            img=[]                                   # array of preprocessed images
            signature=Image.open(log["location"][i]).convert('L')
            new_size=(50,50)
            signature=signature.resize(new_size)  # converts uploaded colour signature image into greyscale 50 pixls long X 50 pixels wide.
            signature.save(log["location"][i])
            img.append(image.imread(log["location"][i]))
            linearized_img=[]
            for k in range(len(img)):
                temp=[]
                for l in range(img[k].shape[0]):
                    for m in range(img[k].shape[1]):
                        temp.append(img[k][l][m])
                linearized_img.append(temp)
            # linearized_img contains preprocessed images for all processing requests.
            X=[]           # Training signature sample.
            Y=[]           # Label for training sample.
            mycursor.execute("SELECT * FROM `Signature_Dataset`")
            result=mycursor.fetchall()
            for j in result:
                signature=Image.open(j[1]).convert('L')
                new_size=(50,50)
                signature=signature.resize(new_size)
                signature.save(j[1])
                X.append(image.imread(j[1]))
                temp1=[]
                if(j[0]==log["sender"][i]):
                    temp1.append(1)
                    Y.append(temp1)
                else:
                    temp1.append(0)
                    Y.append(temp1)

            linearized_X=[]
            for k in range(len(X)):
                temp=[]
                for l in range(X[k].shape[0]):
                    for m in range(X[k].shape[1]):
                        temp.append(X[k][l][m])
                linearized_X.append(temp)
            train=ni.Train_Network(linearized_X,Y,len(linearized_X[0]),[10,8],1)
            res.append(ni.Model(linearized_img,train))
        else:
            # sender issued a physical cheque whose image is uploaded into portal for processing.
            ## send status mail to both sender and receiver. 
            ### here preprocessing start with segmentation of whole cheque to obtain portion which contains signature.
            #### the segmented signature image then goes through same preprocessing steps as in 'if' case.
             
            subject="Cheque Deposited in DigiDhan"
            mycursor=con.cursor()
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["sender"][i]))
            result=mycursor.fetchone()
            body1="""Dear """+str(result[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account
            for clearance of """ +str(log["amount"][i])+""" rupees. \nIf you were not the one who initiated this transaction then report this to your\n
            nearest bank branch."""
            #mail.mail(result[1],subject,body1)
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["receiver"][i]))
            result=mycursor.fetchone()
            body2="""Dear """+str(result[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account
            for clearance of """ + str(log["amount"][i])+""" rupees. \n"""
            #mail.mail(result[1],subject,body2)
            img=[]                                   # array of preprocessed images
            signature=Image.open(log["location"][i]).convert('L')
            height,width=signature.size
            area=(int(height/2)-10,int(width/2)+10,height,width-60)
            signature=signature.crop(area)
            new_size=(50,50)
            signature=signature.resize(new_size)  # converts uploaded colour signature image into greyscale 50 pixls long X 50 pixels wide.
            signature.save(log["location"][i])
            img.append(image.imread(log["location"][i]))
            linearized_img=[]
            for k in range(len(img)):
                temp=[]
                for l in range(img[k].shape[0]):
                    for m in range(img[k].shape[1]):
                        temp.append(img[k][l][m])
                linearized_img.append(temp)
            # linearized_img contains preprocessed images for all processing requests.
            X=[]           # Training signature sample.
            Y=[]           # Label for training sample.
            mycursor.execute("SELECT * FROM `Signature_Dataset`")
            result=mycursor.fetchall()
            for j in result:
                signature=Image.open(j[1]).convert('L')
                new_size=(50,50)
                signature=signature.resize(new_size)
                signature.save(j[1])
                X.append(image.imread(j[1]))
                if(j[0]==log["sender"][i]):
                    temp1.append(1)
                    Y.append(temp1)
                else:
                    temp1.append(0)
                    Y.append(temp1)

            linearized_X=[]
            for k in range(len(X)):
                temp=[]
                for l in range(X[k].shape[0]):
                    for m in range(X[k].shape[1]):
                        temp.append(X[k][l][m])
                linearized_X.append(temp)
            train=ni.Train_Network(linearized_X,Y,len(linearized_X[0]),[10,8],1)
            res.append(ni.Model(linearized_img,train))
    return(res)


# In[4]:


def driver():
    while(1):
        con=mysql.connect(host="127.0.0.1",user="root",password="",database="DigiDhan") # connection setup with our database.
        log=fetch_log(con)
        mycursor=con.cursor()
        mycursor.execute("SELECT * FROM `transaction` WHERE `Status`=0")
        result=mycursor.fetchall()
        if(len(result)!=0):
            res=process_requests(log,con)
            for i in range(len(res[0])):
                mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["sender"][i]))
                result1=mycursor.fetchone() 
                mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["receiver"][i]))
                result2=mycursor.fetchone()
                if(res[0][i][0]<=0.5):
                    status=2   # cheque has been cancelled due inappropriate signature.
                    subject="Cheque cancelled for furthur processing in DigiDhan"
                    body1="""Dear """+str(result1[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account
            for clearance of """ +str(log["amount"][i])+""" rupees has been cancelled due to inappropriate signature. \nIf you were not the one who initiated this transaction then report this to your\n
            nearest bank branch."""
                    #mail.mail(result1[1],subject,body1)
                    body2="""Dear """+str(result2[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account
            for clearance of """ + str(log["amount"][i])+""" rupees has been cancelled due to inappropriate signature. \n"""
                    #mail.mail(result2[1],subject,body2)

                else:
                    status=1   # cheque has been successfully accepted.
                    subject="Cheque cancelled for furthur processing in DigiDhan"
                    body1="""Dear """+str(result1[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account
            for clearance of """ +str(log["amount"][i])+""" rupees has been cancelled due to inappropriate signature. \nIf you were not the one who initiated this transaction then report this to your\n
            nearest bank branch."""
                    #mail.mail(result1[1],subject,body1)
                    body2="""Dear """+str(result2[0])+""" \nThis is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account
            for clearance of """ + str(log["amount"][i])+""" rupees has been cancelled due to inappropriate signature. \n"""
                    #mail.mail(result2[1],subject,body2)

                mycursor.execute("UPDATE `transaction` SET `Status`="+str(status)+" WHERE `Transaction_Id`="+str(log["tid"][i]))
                con.commit()


# In[5]:


if __name__=='__main__':
    con=mysql.connect(host="127.0.0.1",user="root",password="",database="DigiDhan") # connection setup with our database.
    # initially we need to alter permissions for uploaded signature/cheque images in the directories so that our script can manipulate it.
    mycursor=con.cursor()
    mycursor.execute("SELECT `Signature` FROM `transaction`")
    result=mycursor.fetchall()
    '''
    os.system('echo %s | sudo -S'%("apoorv@123"))
    for i in result:
        os.chmod(i[0],stat.S_IRWXU)
        os.chmod(i[0],stat.S_IRWXG)
        os.chmod(i[0],stat.S_IRWXO)
    mycursor.execute("SELECT `Location` FROM `Signature_Dataset`")
    result=mycursor.fetchall()
    for i in result:
        os.chmod(i[0],stat.S_IRWXU)
        os.chmod(i[0],stat.S_IRWXG)
        os.chmod(i[0],stat.S_IRWXO)
    '''
    driver()
        


# In[ ]:





# In[ ]:




