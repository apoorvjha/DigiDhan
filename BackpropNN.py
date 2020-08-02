#!/usr/bin/env python
# coding: utf-8

# In[1]:


import numpy as np
import time
import json


# In[2]:


class NumpyArrayEncoder(json.JSONEncoder):
    # helper class to tranform numpy array objects into proper json objects. 
    def default(self, obj):
        if isinstance(obj, np.integer):
            return int(obj)
        elif isinstance(obj, np.floating):
            return float(obj)
        elif isinstance(obj, np.longdouble):
            return float(obj)
        elif isinstance(obj, np.ndarray):
            return obj.tolist()
        else:
            return super(NumpyArrayEncoder, self).default(obj)


# In[3]:


class Network:
    def __init__(self,filename="model",splitRatio=1,architecture=[],epoch=10,learningRate=0.1,momentumFactor=0.1):
        if len(architecture)==0:
            # in absence of any parameter, the program will look for 'model.json' file
            # which contains all the initialization of parametrs of the class variables
            ## this condition makes it compatible for transfer learning.
            self.loadModel(filename)
            inputNeurons=self.architecture[0]
            hiddenNeurons=self.architecture[1]
            outputNeurons=self.architecture[2]
            self.activated={}
            self.weightedSum={}
            self.deltaWeight={}
            self.deltaBias={}
            self.splitRatio=splitRatio
            for i in range(len(hiddenNeurons)):
                self.deltaWeight[str(i+1)]=np.zeros((inputNeurons,hiddenNeurons[i]))
                self.deltaBias[str(i+1)]=np.zeros((1,hiddenNeurons[i]))
                inputNeurons=hiddenNeurons[i]
            self.deltaWeight[str(len(hiddenNeurons) + 1)]=np.zeros((inputNeurons,outputNeurons))
            self.deltaBias[str(len(hiddenNeurons) + 1)]=np.zeros((1,outputNeurons))

        else:
            # initialization for the case of manual architecture definition.
            self.architecture=architecture
            self.epoch=epoch
            self.learningRate=learningRate
            self.momentumFactor=momentumFactor
            self.weight={}
            self.bias={}
            self.activated={}
            self.weightedSum={}
            self.deltaWeight={}
            self.deltaBias={}
            self.splitRatio=splitRatio
            inputNeurons=self.architecture[0]
            hiddenNeurons=self.architecture[1]
            outputNeurons=self.architecture[2]
            for i in range(len(hiddenNeurons)):
                self.weight[str(i+1)]=np.random.rand(inputNeurons,hiddenNeurons[i])
                self.bias[str(i+1)]=np.random.rand(1,hiddenNeurons[i])
                self.deltaWeight[str(i+1)]=np.zeros((inputNeurons,hiddenNeurons[i]))
                self.deltaBias[str(i+1)]=np.zeros((1,hiddenNeurons[i]))
                inputNeurons=hiddenNeurons[i]
            self.weight[str(len(hiddenNeurons) + 1)]=np.random.rand(inputNeurons,outputNeurons)
            self.bias[str(len(hiddenNeurons) + 1)]=np.random.rand(1,outputNeurons)
            self.deltaWeight[str(len(hiddenNeurons) + 1)]=np.zeros((inputNeurons,outputNeurons))
            self.deltaBias[str(len(hiddenNeurons) + 1)]=np.zeros((1,outputNeurons))
        print("Input Neurons   : ",self.architecture[0])
        if len(hiddenNeurons)!=0:
            print("Hidden Layers  : ",len(self.architecture[1]))
            print("Hidden Neurons : ",[n for n in self.architecture[1]])
        print("Output Neurons  : ",self.architecture[2])
        print("Learning Rate   : ",self.learningRate)
        print("Epochs          : ",self.epoch)
        print("Momentum Factor : ",self.momentumFactor)
        return
    
    def feedforward(self,inputData):
        # feeds the single data point forward through the network.
        self.activated[str(0)]=inputData
        for i in range(len(self.architecture[1])):
            self.weightedSum[str(i+1)]=self.multiplyMatrix(inputData,self.weight[str(i+1)])+self.bias[str(i+1)]
            inputData=self.activate(self.weightedSum[str(i+1)],activation='leaky_relu')
            self.activated[str(i+1)]=inputData
        self.weightedSum[str(len(self.architecture[1])+1)]=self.multiplyMatrix(inputData,self.weight[str(len(self.architecture[1])+1)])+self.bias[str(len(self.architecture[1])+1)]
        self.activated[str(len(self.architecture[1])+1)]=self.activate(self.weightedSum[str(len(self.architecture[1])+1)],activation='softmax')
        return self.activated[str(len(self.architecture[1])+1)]
    
    def activate(self,inputData,activation):
        # activation function 
        if activation=='leaky_relu':
            for i in range(inputData.shape[0]):
                for j in range(inputData.shape[1]):
                    if inputData[i][j]<0:
                        inputData[i][j]=0.1 * inputData[i][j]
        elif activation=='relu':
            for i in range(inputData.shape[0]):
                for j in range(inputData.shape[1]):
                    if inputData[i][j]<0:
                        inputData[i][j]=0
        elif activation=='softmax':
            inputData=np.exp(inputData-np.max(inputData))
            inputData=inputData/np.sum(inputData)
        else:
            print("Error : No Such activation function exists!")
        return inputData
    
    def multiplyMatrix(self,x,y):
        #output=np.dot(x,y)
        assert x.shape[1]==y.shape[0] , "Error : Matrices are incompatible for multiplication operation!"
        output=np.zeros((x.shape[0],y.shape[1]),dtype=np.longdouble)
        modu=np.max(np.array([np.max(x),np.max(y)]))
        for i in range(x.shape[0]):
            for j in range(y.shape[1]):
                temp=0
                for k in range(x.shape[1]):
                    temp+=(x[i][k] % modu) * (y[k][j] % modu)
                output[i][j]=temp
        return output
    
    def loss(self,label):
        # RSME loss function
        activated=self.activated[str(len(self.architecture[1])+1)]
        n=activated.shape[-1]
        return np.sum(((activated - label)**2)/(2*n))
    
    def transpose(self,x):
        output=np.zeros((x.shape[1],x.shape[0]))
        for i in range(x.shape[1]):
            for j in range(x.shape[0]):
                output[i][j]=x[j][i]
        return output
        
    def activatePrime(self,x,activation):
        # derivative of activation function.
        if activation=='leaky_relu':
            for i in range(x.shape[0]):
                for j in range(x.shape[1]):
                    if x[i][j]<=0:
                        x[i][j]=0.1
                    else:
                        x[i][j]=1
            return x
        elif activation=='relu':
            for i in range(x.shape[0]):
                for j in range(x.shape[1]):
                    if x[i][j]<=0:
                        x[i][j]=0
                    else:
                        x[i][j]=1
            return x
        elif activation=='softmax':
            jacobian=np.empty((x.shape[-1],x.shape[-1]),dtype=np.longdouble)
            for i in range(jacobian.shape[0]):
                for j in range(jacobian.shape[1]):
                    if i==j:
                        jacobian[i][j]=x[0][i] * (1 - x[0][j])
                    else:
                        jacobian[i][j]=x[0][i] * (0 - x[0][j])
            return jacobian
        else:
            print("Error : No Such activation function exists!")
            
    def train(self,label):
        # gradient descent optimizer that makes use of backpropagation to update weights 
        # and calculate the error at each layer.
        # dl_dw is gradient of loss with respect to weights of that layer.
        # dl_db is gradient of loss with respect to bias of that layer.
        # error is the gradient of loss with respect to the inputs of that layer.
        activated=self.activated[str(len(self.architecture[1])+1)]
        n=activated.shape[-1]
        error=(activated-label)/n
        dl_dw=self.multiplyMatrix(error,self.activatePrime(self.weightedSum[str(len(self.architecture[1])+1)],activation='softmax'))
        dl_db=dl_dw
        error=self.multiplyMatrix(dl_dw,self.transpose(self.weight[str(len(self.architecture[1])+1)])) 
        dl_dw=self.multiplyMatrix(self.transpose(self.activated[str(len(self.architecture[1]))]),dl_dw)
        self.deltaWeight[str(len(self.architecture[1])+1)]=(dl_dw * self.learningRate) + (self.deltaWeight[str(len(self.architecture[1])+1)] * self.momentumFactor)
        self.deltaBias[str(len(self.architecture[1])+1)]=(dl_db * self.learningRate) + (self.deltaBias[str(len(self.architecture[1])+1)] * self.momentumFactor)
        self.weight[str(len(self.architecture[1])+1)]+=self.deltaWeight[str(len(self.architecture[1])+1)]
        self.bias[str(len(self.architecture[1])+1)]+=self.deltaBias[str(len(self.architecture[1])+1)]
        for i in range(len(self.architecture[1]),0,-1):
            dl_dw=error * self.activatePrime(self.weightedSum[str(i)],activation='leaky_relu')
            dl_db=dl_dw
            error=self.multiplyMatrix(dl_dw,self.transpose(self.weight[str(i)]))
            dl_dw=self.multiplyMatrix(self.transpose(self.activated[str(i-1)]),dl_dw)
            self.deltaWeight[str(i)]=(dl_dw * self.learningRate) + (self.deltaWeight[str(i)] * self.momentumFactor)
            self.deltaBias[str(i)]=(dl_db * self.learningRate) + (self.deltaBias[str(i)] * self.momentumFactor)
            self.weight[str(i)]+=self.deltaWeight[str(i)]
            self.bias[str(i)]+=self.deltaBias[str(i)]
        return error 
    
    def fit(self,inputData,label):
        # manages the data feed and training 
        loss=[]
        trainningSize=int(self.splitRatio * inputData.shape[0])
        print("Training Size : ",trainningSize)
        print("Testing Size  :",inputData.shape[0] - trainningSize)
        for i in range(trainningSize):
            startTime=time.time()
            print("Data : ",i+1,end="       ")
            activated=self.feedforward(inputData[i])
            loss.append(self.loss(label[i]))
            for j in range(1,self.epoch):
                self.train(label[i])
                activated=self.feedforward(inputData[i])
                loss.append(self.loss(label[i]))
            endTime=time.time()
            for j in range(int(np.log10(i+1))):
                print(end="\b")
            print("       Time Taken per epoch (seconds): ",(endTime-startTime)/self.epoch,end="\n")
        prediction=self.predict(inputData[trainningSize:])
        acc=self.accuracy(prediction,label[trainningSize:])
        return np.array(loss),acc
    
    def accuracy(self,x,y):
        count=0
        for i in range(x.shape[0]):
            if np.argmax(x[i])==np.argmax(y[i]):
                count+=1
        return((count * 100)/x.shape[0]) 

    def predict(self,inputData):
        # makes prediction on the provided data.
        output=[]
        for i in range(inputData.shape[0]):
            startTime=time.time()
            print("Data : ",i+1,end="       ")
            activated=self.feedforward(inputData[i])
            output.append(activated)
            endTime=time.time()
            for j in range(int(np.log10(i+1))):
                print(end="\b")
            print("       Time Taken (seconds): ",(endTime-startTime),end="\n")
        return np.array(output)
    def saveModel(self,filename):
        # saves the model in form of json
        parameterDict={}
        parameterDict["Architecture"]=self.architecture
        parameterDict["Bias"]=self.bias
        parameterDict["Weight"]=self.weight
        parameterDict["Epoch"]=self.epoch
        parameterDict["Learning Rate"]=self.learningRate
        parameterDict["Momentum Factor"]=self.momentumFactor
        with open(filename+".json","w") as modelFile:
            json.dump(parameterDict,modelFile,cls=NumpyArrayEncoder)
        return
    
    def loadModel(self,filename):
        # loads the model from a json file.
        with open(filename+".json","r") as modelFile:
            parameterDict=json.load(modelFile)
        self.architecture=parameterDict["Architecture"]
        self.bias=parameterDict["Bias"]
        for i in self.bias.keys():
            self.bias[i]=np.array(self.bias[i])
        self.weight=parameterDict["Weight"]
        for i in self.weight.keys():
            self.weight[i]=np.array(self.weight[i])
        self.epoch=parameterDict["Epoch"]
        self.learningRate=parameterDict["Learning Rate"]
        self.momentumFactor=parameterDict["Momentum Factor"]
        return

    def plotLoss(self,loss,fname):
        # visualization of variation of loss function as trainning progresses.
        import matplotlib.pyplot as plt
        plt.xlabel('Time Step')
        plt.ylabel('Loss')
        plt.title('Variation of Loss')
        plt.plot(np.array([i for i in range(loss.shape[0])]),loss)
        plt.savefig(fname+'.jpg')
        return


          
            
