#!/usr/bin/env python
# coding: utf-8

# In[1]:


import numpy as np
import math
Activation=[]                                   #activations of all the neurons of all layers
Derivative_Activation=[]                        #derivatives of activations of all neurons of all layers
LR=0.01                                         #learning rate


# In[2]:


class Network:
    """
    Class represents the neural network wireframe.
    """
    def __init__(self,N_Input_Nodes,N_Hidden_Nodes,N_Output_Nodes):
        """
        constructor method to initialize the neural network parameters.
        """
        print("\n Neural network Initializing........\n")
        self.N_Input_Nodes=N_Input_Nodes
        self.N_Output_Nodes=N_Output_Nodes
        self.N_Hidden_Nodes=N_Hidden_Nodes
        i=0
        self.Hidden_Layers=len(self.N_Hidden_Nodes)
        self.Weight_Input_Hidden=Random_Matrix(self.N_Input_Nodes,self.N_Hidden_Nodes[0])
        self.Weight_Hidden_Hidden=[]
        self.max_iteration=10
        while(i<(self.Hidden_Layers-1)):
            temp=Random_Matrix(self.N_Hidden_Nodes[i],self.N_Hidden_Nodes[i+1])
            self.Weight_Hidden_Hidden.append(temp)
            i=i+1 
        self.Weight_Hidden_Output=Random_Matrix(self.N_Hidden_Nodes[self.Hidden_Layers-1],self.N_Output_Nodes)
        i=0
        self.bias_Hidden=[]
        while(i<self.Hidden_Layers):
            temp=Random_Matrix(self.N_Hidden_Nodes[i],1)
            self.bias_Hidden.append(temp)
            i=i+1 
        self.bias_Output=Random_Matrix(self.N_Output_Nodes,1)
#        Show("Weight_Input_Hidden",Weight_Input_Hidden)
 #       Show("Weight_Hidden_Hidden",Weight_Hidden_Hidden)
  #      Show("Weight_Hidden_Output",Weight_Hidden_Output)
   #     Show("bias_Hidden",bias_Hidden)
    #    Show("bias_Output",bias_Output)
        print("\n Neural network Initialized........ \n")
        
        


# In[3]:


def Activation_Function(z):
    """
    Function returns the sigmoid value matrix of the matrix passed in as paramter.
    F([M(m x n)])=[F(M(m x n))]
    """
    #print("\n __________Activating_________ \n")
    i=0
    col=len(z[0])
    row=len(z)
    activation=Random_Matrix(row,col)
    while(i<row):
        j=0
        while(j<col):
            if(z[i][j]>=0):
                activation[i][j]=(1/(1+math.exp(-1*z[i][j])))
            else:
                activation[i][j]=1-(1/(1+math.exp(1*z[i][j])))
            j=j+1
        i=i+1
    #print("\n __________Activated_________ \n")
    return activation


# In[4]:


def Feedforward(Inputs,Weight,Bias,flag):
    """
    Function implements the feed forward procedure of propagating inputs into hidden layers which are activated 
    and feed to the output layer inturn obtaining the activation/firing status of output neurons.
    """
    #print("\n __________Feeding Forward_________ \n")
    if(flag==0):
        #print(len(Weight))
        Transposed_Weight=Transpose(Weight)
        Weighted_Sum=Matrix_Multiply(Transposed_Weight,Inputs)
        Weighted_Sum=Matrix_Sum(Weighted_Sum,Bias)
        Activation.append(Activation_Function(Weighted_Sum))
        Derivative_Activation.append(Activation_Function_Prime(Weighted_Sum))
        #print("\n __________Feedforward Accomplished_________ \n")
        return(Activation_Function(Weighted_Sum))
    else:
        for i in range(len(Weight)):
            Transposed_Weight=Transpose(Weight[i])
            Weighted_Sum=Matrix_Multiply(Transposed_Weight,Inputs)
            Weighted_Sum=Matrix_Sum(Weighted_Sum,Bias[i+1])
            Activation.append(Activation_Function(Weighted_Sum))
            Derivative_Activation.append(Activation_Function_Prime(Weighted_Sum))
        #print("\n __________Feedforward Accomplished_________ \n")
        return(Activation_Function(Weighted_Sum))


# In[5]:


def Matrix_Sum(matrix1,matrix2):
    """
    Function returns the summation of two matrices passed as parameters to it.
    """
    row1=len(matrix1)
    row2=len(matrix2)
    col1=len(matrix1[0])
    col2=len(matrix2[0])
    i=0
    j=0
    if((row1==row2) and (col1==col2)):
        matrix=Random_Matrix(row1,col1)
        while(i<row1):
            while(j<col1):
                matrix[i][j]=matrix1[i][j]+matrix2[i][j]
                j=j+1
            i=i+1
        return(matrix)
    else:
        print("\nMatrices incompatible for summation operation!\n")


# In[6]:


def Matrix_Multiply(matrix1,matrix2):
    """
    Function returns the matrix multiplication of two matrices passed as parameters of it.
    """
    row1=len(matrix1)
    row2=len(matrix2)
    col1=len(matrix1[0])
    col2=len(matrix2[0])
    i=0
    j=0
    k=0
    sum=0
    matrix=Random_Matrix(row1,col2)
    if(col1==row2):
        while(i<row1):
            while(j<col2):
                while(k<col1):
                    sum=sum+matrix1[i][k]*matrix2[k][j]
                    k=k+1
                matrix[i][j]=sum
                sum=0
                j=j+1
            i=i+1
        return(matrix)
    else:
        print("\nMatrices incompatible for matrix multiplication operation!\n") 


# In[7]:


def Hadamard_Product(matrix1,matrix2):
    """
    Function returns the elementwise product of two matrices.
    say, we have two Matrices as [M(m x n)] and [N(m x n)]
    then Hadamarad_product(M,N)=[M(i,j)*N(i,j)].
    Both [M(m x n)] and [N(m x n)] should be of same shape.
    """
    row1=len(matrix1)
    row2=len(matrix2)
    col1=len(matrix1[0])
    col2=len(matrix2[0])
    i=0
    matrix=Random_Matrix(row1,col1)
    if((col1==col2)and(row1==row2)):
        while(i<row1):
            j=0
            while(j<col1):
                matrix[i][j]=matrix1[i][j]*matrix2[i][j]
                j=j+1
            i=i+1
        return(matrix)
    else:
        print("\nMatrices incompatible for Hadamard matrix multiplication operation!\n")


# In[8]:


def Random_Matrix(row,col):
    """
    Function returns the matrix with random values, of size specified in the prameter list.
    """
    matrix=[]
    i=0
    while(i<row):
        matrix.append([np.random.uniform(-10,10) for w in range(col)])
        i=i+1
    return(matrix)


# In[9]:


def Transpose(matrix1):
    """
    Function implements simple matrix transpose operation and returns the resulting matrix.
    Transpose([M(n x m)])=[N(m x n)]-----> with rows interchanged with corresponding columns.
    """
    row=len(matrix1)
    col=len(matrix1[0])
    matrix=Random_Matrix(col,row)
    i=0
    while(i<row):
        j=0
        while(j<col):
            matrix[j][i]=matrix1[i][j]
            j=j+1
        i=i+1
    return(matrix)


# In[10]:


def Train(brain,Inputs,Label,Weight_Input_Hidden,Weight_Hidden_Hidden,Weight_Hidden_Output,bias_Hidden,bias_Output,Hidden_Layers):
    #print("\n __________Training Started_________ \n")
    """
    Function to initiate training process for the neural network and check for halting condition
    to save the parameters and produce a deployable/testable model.
    """
    Output_Input_Hidden=Feedforward(Inputs,Weight_Input_Hidden,bias_Hidden[0],0)
    Output_Hidden_Hidden=Feedforward(Output_Input_Hidden,Weight_Hidden_Hidden,bias_Hidden,1)
    Output_Hidden_Output=Feedforward(Output_Hidden_Hidden,Weight_Hidden_Output,bias_Output,0)
    #print(len(Weight_Hidden_Output),len(Weight_Hidden_Output[0]))
    if(dist(Transpose(Output_Hidden_Output)[0],Label[0][0])>0.0016 or brain.max_iteration>0):      #there can be more than one dependent attribute in case of multiclass classification  
        brain.max_iteration-=1
        Gradient_Descent(brain,Label,Hidden_Layers,Inputs,Weight_Input_Hidden,Weight_Hidden_Hidden,Weight_Hidden_Output,bias_Hidden,bias_Output)
    else:
        #print("\n __________Training Complete_________ \n")
        k=open("Train.txt",'w')                                                     #Train.txt contains values of paramers
        k.write("Weight_Input_Hidden: "+str(Weight_Input_Hidden)+"\n")              #for future references.
        k.write("Weight_Hidden_Hidden: "+str(Weight_Hidden_Hidden)+"\n")
        k.write("Weight_Hidden_Output: "+str(Weight_Hidden_Output)+"\n")
        k.write("bias_Hidden: "+str(bias_Hidden)+"\n")
        k.write("bias_Output: "+str(bias_Output)+"\n")
        brain.Weight_Input_Hidden=Weight_Input_Hidden
        brain.Weight_Hidden_Hidden=Weight_Hidden_Hidden
        brain.Weight_Hidden_Output=Weight_Hidden_Output
        brain.bias_Hidden=bias_Hidden
        brain.bias_Output=bias_Output
        k.close()


# In[11]:


def Matrix_Difference(matrix1,matrix2):
    """
    Function is to calculate the difference of two matrices and return the resulting matrix.
    """
    row1=len(matrix1)
    row2=len(matrix2)
    col1=len(matrix1[0])
    col2=len(matrix2[0])
    i=0
    j=0
    if((row1==row2) and (col1==col2)):
        matrix=Random_Matrix(row1,col1)
        while(i<row1):
            while(j<col1):
                matrix[i][j]=matrix1[i][j]-matrix2[i][j]
                j=j+1
            i=i+1
        return(matrix)
    else:
        print("\nMatrices incompatible for Difference operation!\n")


# In[12]:


def Gradient_Descent(brain,Label,Hidden_Layers,Inputs,Weight_Input_Hidden,Weight_Hidden_Hidden,Weight_Hidden_Output,bias_Hidden,bias_Output):
    """
    Function to Train the network such that total quadratic cost is minimum by changing parameter values in the direction of 
    negative gradient.
    """
    Layer=Hidden_Layers
    error=Matrix_Difference(Activation[Layer],Transpose(Label[0]))
    Backpropagation(brain,error,Layer,Inputs,Weight_Input_Hidden,Weight_Hidden_Hidden,Weight_Hidden_Output,bias_Hidden,bias_Output,Label)
    return    
    


# In[13]:


def Backpropagation(brain,error,Layer,Inputs,Weight_Input_Hidden,Weight_Hidden_Hidden,Weight_Hidden_Output,bias_Hidden,bias_Output,Label):
    """
    Function to propagate error occuring at output layer to the hidden nodes and updating the parameters in interim.
    """
    Hidden_Layers=Layer
    delta_weight_hidden_output=Hadamard_Product(Derivative_Activation[Layer],error)
    delta_bias_output=delta_weight_hidden_output
    temp=Activation[Layer-1]
    #print(delta_weight_hidden_output,Activation[Layer-1])
    delta_weight_hidden_output=Matrix_Multiply(temp,Transpose(delta_weight_hidden_output))
    for i in range(len(delta_weight_hidden_output)):
        for j in range(len(delta_weight_hidden_output[0])):
            delta_weight_hidden_output[i][j]=delta_weight_hidden_output[i][j]*2*LR
    for i in range(len(delta_bias_output)):
        for j in range(len(delta_bias_output[0])):
            delta_bias_output[i][j]=delta_bias_output[i][j]*2*LR
    Layer-=1
    error=Matrix_Multiply(Weight_Hidden_Output,error)
    #print(len(Weight_Hidden_Output),len(Weight_Hidden_Output[0]))
    #print(len(delta_weight_hidden_output),len(delta_weight_hidden_output[0]))
    Weight_Hidden_Output=Matrix_Difference(Weight_Hidden_Output,delta_weight_hidden_output)
    #print(len(Weight_Hidden_Output),len(Weight_Hidden_Output[0]))
    bias_Output=Matrix_Difference(bias_Output,delta_bias_output)
    while(Layer>0):
        delta_weight=Hadamard_Product(error,Derivative_Activation[Layer])    #checkpoint......
        delta_bias=delta_weight
        delta_weight=Matrix_Multiply(Activation[Layer-1],Transpose(delta_weight))
        for i in range(len(delta_weight)):
            for j in range(len(delta_weight[0])):
                delta_weight[i][j]=delta_weight[i][j]*2*LR
        for i in range(len(delta_bias)):
            for j in range(len(delta_bias[0])):
                delta_bias[i][j]=delta_bias[i][j]*2*LR
        error=Matrix_Multiply(Weight_Hidden_Hidden[Layer-1],error)
        bias_Hidden[Layer]=Matrix_Difference(bias_Hidden[Layer],delta_bias)
        Weight_Hidden_Hidden[Layer-1]=Matrix_Difference(Weight_Hidden_Hidden[Layer-1],delta_weight)
        Layer-=1
    delta_weight=Hadamard_Product(error,Derivative_Activation[Layer])
    delta_bias=delta_weight
    delta_weight=Matrix_Multiply(Inputs,Transpose(delta_weight))
    for i in range(len(delta_weight)):
        for j in range(len(delta_weight[0])):
            delta_weight[i][j]=delta_weight[i][j]*2*LR
    for i in range(len(delta_bias)):
        for j in range(len(delta_bias[0])):
            delta_bias[i][j]=delta_bias[i][j]*2*LR
    bias_Hidden[Layer]=Matrix_Difference(bias_Hidden[Layer],delta_bias)
    Weight_Input_Hidden=Matrix_Difference(Weight_Input_Hidden,delta_weight)
    Train(brain,Inputs,Label,Weight_Input_Hidden,Weight_Hidden_Hidden,Weight_Hidden_Output,bias_Hidden,bias_Output,Hidden_Layers)
    

    
    


# In[14]:


def Show(item_name,item):
    """
    Helper Function to resolve and debug the code, it prints out the parameter name and its value 
    in an understandable format.
    """
    print("\n\n")
    print(item_name)
    print(item)
    print("\n\n")


# In[15]:


def Activation_Function_Prime(z):
    """
    Function to calculate the derivative of the activation function on Z i.e. F'(Z)
    and return it to the caller function.
    """
    F_X=Activation_Function(z)
    row=len(z)
    col=len(z[0])
    i=0
    unitary_negative=Random_Matrix(row,col)
    while(i<row):
        j=0
        while(j<col):
            unitary_negative[i][j]=-1
            j=j+1
        i=i+1
    F_Minus_X=Hadamard_Product(F_X,unitary_negative)
    derivative=Hadamard_Product(F_X,F_Minus_X)
    return(derivative)


# In[16]:


def dist(a,b):
    """
    Function returns the Euclidean distance between two vectors.
    """
    if(len(a)==len(b)):
        dist_sum=0
        for i in range(len(a)):
            dist_sum+=(a[i]-b[i])**2
        return(dist_sum)
    else:
        return(99999999)                        #if shape of two vectors are not same then they are infinitely distinct.


# In[17]:


def Train_Network(Inputs_raw,Label_raw,N_Input_Nodes,N_Hidden_Nodes,N_Output_Nodes):#Train function to define object of Network class
                                                                            #and carry out trainning. 
    """
    n ------->number of dependent atrributes. 
    m ------->number of Labels we are using for trainig of the network.
    input format is: 
    [[[X1],[X2],[X3],......,[Xn]],[[X1],[X2],[X3],......,[Xn]],[[X1],[X2],[X3],......,[Xn]],....(m times)..,[[X1],[X2],[X3],......,[Xn]]]
    where X1,X2,X3,....,Xn are neumerical entities(attributes for classification).
    
    Label format is:
    [[L1],[L2],[L3],.....,[Lm]]
    where L1,L2,L3,......,Lm are binary entities(label associated with each [[X1],[X2],[X3],......,[Xn]] attribute pair)
    """
    Inputs=input_vector_formatter(Inputs_raw)
    Label=label_vector_formatter(Label_raw)
    for i in range(len(Inputs)):
        print("...........Data vector[{}] training started.......".format(i+1))
        inputs=Inputs[i]
        label=[]
        label.append(Label[i])
        if(i==0):
            brain=Network(N_Input_Nodes,N_Hidden_Nodes,N_Output_Nodes)
        #epoch=0    #controlling the loops of recursive training to a certain number
        Train(brain,inputs,label,brain.Weight_Input_Hidden,brain.Weight_Hidden_Hidden,brain.Weight_Hidden_Output,brain.bias_Hidden,brain.bias_Output,brain.Hidden_Layers)
        print("...........Data vector[{}] training completed.......".format(i+1))
    parameter={"N_Input_Nodes":N_Input_Nodes,"N_Hidden_Nodes":N_Hidden_Nodes,"N_Output_Nodes":N_Output_Nodes,"Weight_Input_Hidden":brain.Weight_Input_Hidden,"Weight_Hidden_Hidden":brain.Weight_Hidden_Hidden,"Weight_Hidden_Output":brain.Weight_Hidden_Output,"bias_Hidden":brain.bias_Hidden,"bias_Output":brain.bias_Output,"Hidden_Layers":brain.Hidden_Layers}
    return(parameter)        
    
    


# In[18]:


def Test_Network(Inputs_raw,Label_raw,Parameter):
    """
    n ------->number of dependent atrributes. 
    m ------->number of Labels we are using for testing of the network.
    input format is: 
    [[[X1],[X2],[X3],......,[Xn]],[[X1],[X2],[X3],......,[Xn]],[[X1],[X2],[X3],......,[Xn]],....(m times)..,[[X1],[X2],[X3],......,[Xn]]]
    where X1,X2,X3,....,Xn are neumerical entities(attributes for classification).
    
    Label format is:
    [[L1],[L2],[L3],.....,[Lm]]
    where L1,L2,L3,......,Lm are binary entities(label associated with each [[X1],[X2],[X3],......,[Xn]] attribute pair)
    """
    Cost=0
    Inputs=input_vector_formatter(Inputs_raw)
    Label=label_vector_formatter(Label_raw)
    for i in range(len(Inputs)):
        print("...........Data vector[{}] testing started.......".format(i+1))
        inputs=Inputs[i]
        label=[]
        label.append(Label[i])
        if(i==0):
            brain=Network(Parameter["N_Input_Nodes"],Parameter["N_Hidden_Nodes"],Parameter["N_Output_Nodes"])
            brain.Weight_Input_Hidden=Parameter["Weight_Input_Hidden"]
            brain.Weight_Hidden_Hidden=Parameter["Weight_Hidden_Hidden"]
            brain.Weight_Hidden_Output=Parameter["Weight_Hidden_Output"]
            brain.bias_Hidden=Parameter["bias_Hidden"]
            brain.bias_Output=Parameter["bias_Output"]
        Input_to_Hidden=Feedforward(inputs,Parameter["Weight_Input_Hidden"],Parameter["bias_Hidden"][0],0)
        Hidden_to_Hidden=Feedforward(Input_to_Hidden,Parameter["Weight_Hidden_Hidden"],Parameter["bias_Hidden"],1)
        Hidden_to_Output=Feedforward(Hidden_to_Hidden,Parameter["Weight_Hidden_Output"],Parameter["bias_Output"],0)
        #print(Transpose(Hidden_to_Output)[0])
        Cost+=dist(Transpose(Hidden_to_Output)[0],Label[0][0])
        print("...........Data vector[{}] testing completed.......".format(i+1))
    return(Cost)


# In[19]:


def Model(Inputs_raw,Parameter):
    """
    n ------->number of dependent atrributes. 
    input format is: 
    [[[X1],[X2],[X3],......,[Xn]],[[X1],[X2],[X3],......,[Xn]],[[X1],[X2],[X3],......,[Xn]],....(m times)..,[[X1],[X2],[X3],......,[Xn]]]
    where X1,X2,X3,....,Xn are neumerical entities(attributes for classification).
    It returns the vector of predicted outputs for unlabelled inputs. 
    """
    Output=[]
    Inputs=input_vector_formatter(Inputs_raw)
    for i in range(len(Inputs)):
        print("...........Data vector[{}] feed started.......".format(i+1))
        inputs=Inputs[i]
        if(i==0):
            brain=Network(Parameter["N_Input_Nodes"],Parameter["N_Hidden_Nodes"],Parameter["N_Output_Nodes"])
            brain.Weight_Input_Hidden=Parameter["Weight_Input_Hidden"]
            brain.Weight_Hidden_Hidden=Parameter["Weight_Hidden_Hidden"]
            brain.Weight_Hidden_Output=Parameter["Weight_Hidden_Output"]
            brain.bias_Hidden=Parameter["bias_Hidden"]
            brain.bias_Output=Parameter["bias_Output"]
        Input_to_Hidden=Feedforward(inputs,Parameter["Weight_Input_Hidden"],Parameter["bias_Hidden"][0],0)
        Hidden_to_Hidden=Feedforward(Input_to_Hidden,Parameter["Weight_Hidden_Hidden"],Parameter["bias_Hidden"],1)
        Hidden_to_Output=Feedforward(Hidden_to_Hidden,Parameter["Weight_Hidden_Output"],Parameter["bias_Output"],0)
        Show("Prediction: ",Hidden_to_Output[0])
        Output.append(Hidden_to_Output[0])
        print("...........Data vector[{}] feed completed.......".format(i+1))
    return(Output)


# In[20]:


def input_vector_formatter(inputs):
    """
    Function used to convert row vector inputs into column vector format which is required by
    throughout this library.
    """
    temp=[]
    for i in range(len(inputs)):
        temp_input=[]
        for j in range(len(inputs[0])):
            temp_data=[]
            temp_data.append(inputs[i][j])
            temp_input.append(temp_data)
        temp.append(temp_input)
    return(temp)


# In[21]:


def label_vector_formatter(label):
    """
    Function to convert the row vector format into column vector format to bridge 
    the notations of other libraries and this library.
    """
    labels=[]
    labels.append(label)
    temp=input_vector_formatter(labels)
    return(temp[0])


# In[22]:


#k=Train_Network([[1,2,3,4],[6,7,4,8]],[1,0],4,[3,2],1)    #sample call for Training method 
#c=Test_Network([[1,2,3,4],[6,7,4,8]],[1,0],k)             #sample call for testing method
#Out=Model([[5,6,7,8]],k)                                              #sample call for deployment

