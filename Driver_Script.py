#!/usr/bin/env python
# coding: utf-8

# In[1]:


from PIL import Image                              # for image processing operations on the image.
import numpy as np
from matplotlib import image                       # for importing image as an array of pixel intensities.
import mysql.connector as mysql                    # for database communute.
import BackpropNN as bpn                      # for cheque signature analysis. 
import os                                          # for folder level operations.
import time
from datetime import date
from skimage.util import random_noise
from skimage.transform import rotate              # image transformation for data augmentation
from sklearn.utils import shuffle

# In[2]:


class augmentation:
    def __init__(self,theta_range=360,thetaProgression=1):
        self.theta_range=theta_range
        self.thetaProgression=thetaProgression
    def rotateImg(self,origImg,theta):
        return rotate(origImg,theta)
    def flip(self,origImg,mode='horizontal'):
        if mode=='horizontal':
            return origImg[:, ::-1]
        else:
            return origImg[::-1, :]
    def induceNoise(self,origImg):
        return random_noise(origImg) 
    def augment(self,img):
        augmented=[]
        for i in range(0,self.theta_range,self.thetaProgression):
            augmented.append(self.rotateImg(img,i))
        augmented.append(self.flip(img,mode='vertical'))
        augmented.append(self.flip(img))
        augmented.append(self.induceNoise(img))
        return augmented
        


# In[3]:


def mail(toaddr,subject,body):
    mailing_log=open("mail_log.txt","a")
    mailing_log.write(str(toaddr)+"~"+str(subject)+"~"+str(body)+"\n")
    mailing_log.close()
    return


# In[4]:


def fetch_log(con):
    logger={"dot":[],"mode":[],"receiver":[],"sender":[],"amount":[],"ccn":[],"location":[],"tid":[],"status":[]}
    # this dictionary stores an instance of log file. 
    mycursor=con.cursor()
    mycursor.execute("SELECT * FROM `transaction` WHERE `Status`=0 AND `Date_Of_Transaction`='"+str(date.today())+"'")
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


# In[5]:


def process_requests(log,con):
    start=time.time()
    res=[]
    imageAugmenter=augmentation(theta_range=360,thetaProgression=4)
    for i in range(len(log["sender"])):
        modelFileName='MODELS/'+str(log["sender"][i])
        lossImgName='LOSS/'+str(log["sender"][i])
        if log["mode"][i]=='ONLINE':
            # sender isssued a virtual cheque which constitute a signature.
            ## at first send mail to sender and receiver to make them know the deposited cheque is starting to be reviewed. 
            subject="Virtual Cheque Deposited in DigiDhan"
            mycursor=con.cursor()
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["sender"][i]))
            result=mycursor.fetchone()
            body1="""Dear """+str(result[0])+""" This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account for clearance of """ + str(log["amount"][i])+""" rupees. If you were not the one who initiated this transaction then report this to your nearest bank branch."""
            mail(result[1],subject,body1)
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["receiver"][i]))
            result=mycursor.fetchone()
            body2="""Dear """+str(result[0])+""" This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account for clearance of """ + str(log["amount"][i])+""" rupees. """
            mail(result[1],subject,body2)
            file_name=log["location"][i].split('/')[1]
            img=[]   # array of preprocessed images
            signature=Image.open(log["location"][i]).convert('L')
            new_size=(25,25)
            signature=signature.resize(new_size)  # converts uploaded colour signature image into greyscale 50 pixls long X 50 pixels wide.
            signature.save('TEMP_TRANS_PIC/'+file_name)
            img.append(image.imread('TEMP_TRANS_PIC/'+file_name))
            img=np.array(img)
            img=img.reshape(img.shape[0],1,img.shape[1]*img.shape[2])
            # normalization
            img=img/(255*255*255)
            # linearized_img contains preprocessed images for all processing requests.
            X=[]           # Training signature sample.
            Y=[]           # Label for training sample.
            mycursor.execute("SELECT * FROM `Signature_Dataset`")
            result=mycursor.fetchall()
            for j in result:
                file_name1=j[1].split('/')[1]
                signature=Image.open(j[1]).convert('L')
                new_size=(25,25)
                signature=signature.resize(new_size)
                signature.save('TEMP_SIG_PIC/'+file_name1)
                X.append(image.imread('TEMP_SIG_PIC/'+file_name1))
                augmentedImages=imageAugmenter.augment(image.imread('TEMP_SIG_PIC/'+file_name1))
                    
                if(j[0]==log["sender"][i]):
                    Y.append(np.array([[1,0]]))   # real
                else:
                    Y.append(np.array([[0,1]]))   # fake
                for augmented in augmentedImages:
                    X.append(augmented)
                    if(j[0]==log["sender"][i]):
                        Y.append(np.array([[1,0]]))   # real
                    else:
                        Y.append(np.array([[0,1]]))   # fake
                
            X=np.array(X)
            Y=np.array(Y)
            X=X.reshape(X.shape[0],1,X.shape[1]*X.shape[2])
            flatSize=X.shape[1]*X.shape[2]
            X,Y=shuffle(X,Y)
            # normalization
            X=X/(255*255*255)
            if os.path.exists(modelFileName+'.json'):
                model=bpn.Network(filename=modelFileName,splitRatio=0.35)
            else:
                model=bpn.Network(filename=modelFileName,splitRatio=0.35,architecture=[flatSize,[16,8,16],2],epoch=10,learningRate=0.0001,momentumFactor=0.9)
            loss,acc=model.fit(X,Y)
            print("Accuracy : ",acc)
            model.plotLoss(loss,lossImgName)
            model.saveModel(modelFileName)
            res.append(model.predict(img))
            
        else:
            # sender issued a physical cheque whose image is uploaded into portal for processing.
            ## send status mail to both sender and receiver. 
            ### here preprocessing start with segmentation of whole cheque to obtain portion which contains signature.
            #### the segmented signature image then goes through same preprocessing steps as in 'if' case.
             
            subject="Cheque Deposited in DigiDhan"
            mycursor=con.cursor()
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["sender"][i]))
            result=mycursor.fetchone()
            body1="""Dear """+str(result[0])+""" This is to inform you that Cheque Nummber """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account for clearance of """ +str(log["amount"][i])+""" rupees. If you were not the one who initiated this transaction then report this to your nearest bank branch."""
            mail(result[1],subject,body1)
            mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["receiver"][i]))
            result=mycursor.fetchone()
            body2="""Dear """+str(result[0])+""" This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account for clearance of """ + str(log["amount"][i])+""" rupees. """
            mail(result[1],subject,body2)
            img=[]                                   # array of preprocessed images
            file_name=log["location"][i].split('/')[1]
            signature=Image.open(log["location"][i]).convert('L')
            height,width=signature.size
            area=(int(height/2)-10,int(width/2)+10,height,width-60)
            signature=signature.crop(area)
            new_size=(25,25)
            signature=signature.resize(new_size)  # converts uploaded colour signature image into greyscale 50 pixls long X 50 pixels wide.
            signature.save('TEMP_TRANS_PIC/'+file_name)
            img.append(image.imread('TEMP_TRANS_PIC/'+file_name))
            img=np.array(img)
            img=img.reshape(img.shape[0],1,img.shape[1]*img.shape[2])
            # normalization
            img=img/(255*255*255)

            # linearized_img contains preprocessed images for all processing requests.
            X=[]           # Training signature sample.
            Y=[]           # Label for training sample.
            mycursor.execute("SELECT * FROM `Signature_Dataset`")
            result=mycursor.fetchall()
            for j in result:
                file_name1=j[1].split('/')[1]
                signature=Image.open(j[1]).convert('L')
                new_size=(25,25)
                signature=signature.resize(new_size)
                signature.save('TEMP_SIG_PIC/'+file_name1)
                X.append(image.imread('TEMP_SIG_PIC/'+file_name1))
                augmentedImages=imageAugmenter.augment(image.imread('TEMP_SIG_PIC/'+file_name1))
                    
                if(j[0]==log["sender"][i]):
                    Y.append(np.array([[1,0]]))   # real
                else:
                    Y.append(np.array([[0,1]]))   # fake
                for augmented in augmentedImages:
                    X.append(augmented)
                    if(j[0]==log["sender"][i]):
                        Y.append(np.array([[1,0]]))   # real
                    else:
                        Y.append(np.array([[0,1]]))   # fake

            X=np.array(X)
            Y=np.array(Y)
            X=X.reshape(X.shape[0],1,X.shape[1]*X.shape[2])
            flatSize=X.shape[1]*X.shape[2]
            X,Y=shuffle(X,Y)
            # normalization
            X=X/(255*255*255)
            if os.path.exists(modelFileName+'.json'):
                model=bpn.Network(filename=modelFileName,splitRatio=0.35)
            else:
                model=bpn.Network(filename=modelFileName,splitRatio=0.35,architecture=[flatSize,[16,8,16],2],epoch=10,learningRate=0.0001,momentumFactor=0.9)
            loss,acc=model.fit(X,Y)
            print("Accuracy : ",acc)
            model.plotLoss(loss,lossImgName)
            model.saveModel(modelFileName)
            res.append(model.predict(img))
    end=time.time()
    print("Time Taken :"+str(end-start)+"seconds")
    return(np.array(res))


# In[6]:


def driver():
    while(1):
        activation_mail()
        con=mysql.connect(host="127.0.0.1",user="root",password="",database="DigiDhan") # connection setup with our database.
        log=fetch_log(con)
        mycursor=con.cursor()
        mycursor.execute("SELECT * FROM `transaction` WHERE `Status`=0 AND `Date_Of_Transaction`='"+str(date.today())+"'")
        result=mycursor.fetchall()
        time.sleep(3)    # time span to let the system upload the file.
        if(len(result)!=0):
            os.popen("sudo -S %s"%('chmod -R 777 TRANSACTION_PIC'),'w').write('apoorv@123/n')
            res=process_requests(log,con)
            for i in range(res.shape[0]):
                mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["sender"][i]))
                result1=mycursor.fetchone() 
                mycursor.execute("SELECT `User_Name`,`User_mail` FROM `user` WHERE `Bank_Account_Number`="+str(log["receiver"][i]))
                result2=mycursor.fetchone()
                if(np.argmax(res[i])==1):
                    status=2   # cheque has been cancelled due inappropriate signature.
                    subject="Cheque cancelled for furthur processing in DigiDhan"
                    body1="""Dear """+str(result1[0])+"""  This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account for clearance of """ +str(log["amount"][i])+""" rupees has been cancelled due to inappropriate signature. If you were not the one who initiated this transaction then report this to your nearest bank branch."""
                    mail(result1[1],subject,body1)
                    body2="""Dear """+str(result2[0])+""" This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account for clearance of """ + str(log["amount"][i])+""" rupees has been cancelled due to inappropriate signature. """
                    mail(result2[1],subject,body2)

                else:
                    status=1   # cheque has been successfully accepted.
                    subject="Cheque cancelled for furthur processing in DigiDhan"
                    body1="""Dear """+str(result1[0])+""" This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from your DigiDhan account for clearance of """ +str(log["amount"][i])+""" rupees has been accepted succesfully. If you were not the one who initiated this transaction then report this to your nearest bank branch."""
                    mail(result1[1],subject,body1)
                    body2="""Dear """+str(result2[0])+""" This is to inform you that Cheque Number """+str(log["ccn"][i])+""" has been submitted from """+str(log["sender"][i])+""" 's DigiDhan account for clearance of """ + str(log["amount"][i])+""" rupees has been rupees has been accepted succesfully."""
                    mail(result2[1],subject,body2)

                mycursor.execute("UPDATE `transaction` SET `Status`="+str(status)+" WHERE `Transaction_Id`="+str(log["tid"][i]))
                con.commit()


# In[7]:


def activation_mail():
    # function constatantly checks for activation requests and send the activation links to 
    # corresponding bank contact person.
    con=mysql.connect(host="127.0.0.1",user="root",password="",database="DigiDhan") # connection setup with our database.
    mycursor=con.cursor()
    mycursor.execute("SELECT `User_Mail`,`Bank_Account_Number`,`Bank_Name` FROM `user` WHERE `User_Mail` IN (SELECT `User_Mail` FROM `activation` WHERE `Response`=0)")
    res=mycursor.fetchall()
    if(len(res)!=0):
        for i in res:
            body="Dear "+str(i[1])+" of "+str(i[2])+",  Following is activation link which can be used to activate and in interim verify your account. Link : http://localhost:8080/signature/activation.php?mail="+str(i[0])+"&acc="+str(i[1])
            mail(i[0],"Activation Link from DigiDhan",body)
            mycursor.execute("UPDATE `activation` SET `Response`=1 WHERE `User_Mail`='"+str(i[0])+"'")
            con.commit()
    return
        
    


# In[8]:


if __name__=='__main__':
    driver()
    
    
        


# In[ ]:





# In[ ]:





# In[ ]:





# In[ ]:




