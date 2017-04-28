Users Management Model for TAO versions prior to 2.4
====================================================

{{\>toc}}

Back-office
-----------

### General information

TAO concerns various types of users for various types of features. One of the main feature we provide gives users the opportunity to build some tests and manage the whole test delivery. All these features are gathered in the Back-office of the TAO platform but they may be accessed in 2 different ways, either using the complete Back-office Interface or running a process monitored by the Workflow Engine providing access to available services from the platform.

### Manage Back-office Users

The *Tao Manager 1* User defined in figure 3 is the one created when installing the platform that lets you access all features of the TAO platform and should only be accessed by a User having the *TaoManager* Role which is an instance of the *BackOffice* Role that controls all access to Back-office’s Services.\
The *TaoManager* Role is also a sub-class of User Class in order to inherit specific properties of the User Class such as User’s *Login, Password, Last Name, First Name,* Languages.

![](http://forge.taotesting.com/attachments/277/role-whtoutInst.png)\
Fig .1

You can add a user thanks to the top bar from the Home, and add a new *TaoManager*.

![](http://forge.taotesting.com/attachments/281/CompleteInterface.png)\
![](http://forge.taotesting.com/attachments/282/AddUser2.png)\
Fig .2

*New TaoManager* is also an instance of Role *TaoManager*.

![](http://forge.taotesting.com/attachments/284/role-addingNewManager.png)\
Fig .3

Front-office
------------

The TAO platform also concerns Test Takers who will have to authenticate on the platform in order to take the tests dedicated to them. In order to do that, the *Test Taker* Class is a sub-class of the *TaoSubjectRole* which is an instance of the *FrontOffice* Role. Users having the *TaoSubjectRole* may access the delivery platform.

![](http://forge.taotesting.com/attachments/285/addTestTaker.png)\
Fig .4\
Adding a *Test Taker* in the Test Taker Extension will create an instance of the class *Test Taker*. (*Jane* and *John*)

![](http://forge.taotesting.com/attachments/286/role-addingNewTestTaker.png)\
Fig .5\
You can also obviously add sub-classes of *Test Takers* and add new properties to your own class in order to complete the description of your *Test Takers* who will then instantiate this class. (*1StGrade* is the class and *Nicolas* its instance)

![](http://forge.taotesting.com/attachments/287/role-addingNewTestTakerClass.png)\
Fig .6

Workflow Engine’s Users
-----------------------

As explained before, the TAO platform can be accessed through a workflow that will drive the different steps needed to build, manage, and validate the process of tests creation. The creation of such a process will be the focus of another [[The\_Processes\_extension|guide]]. Different steps of this process can be executed by actors having different roles. You can define these specific users and roles in the Process Extension.

![](http://forge.taotesting.com/attachments/288/addRole.png)\
Fig .7

The predefined *Role*, *Workflow* *User Role* allow Users having this Role to access the Worklow Engine. Adding a *User* in the Process Extension will add an instance of the *Workflow User Role*(*Chuck* and *Pedro* have been created as *Workflow User)*.

![](http://forge.taotesting.com/attachments/289/role-addingNewWfUser.png)\
Fig .8

Adding a *Role* will create an instance of *wfUser*.

![](http://forge.taotesting.com/attachments/290/role-addingNewRole.png)\
Fig .9

Then you can assign any created users to any created role (*Chuck* will remain\_ Workflow User Role\_ and *Perdo* will be both\_ Workflow User Role\_ and *User Defined Role 1* ).

![](http://forge.taotesting.com/attachments/291/role-assigningUserRole.png)\
Fig .9

You can also assign any users to any roles (*Tao Manager 1* will gain *User Defined Role 1*),

![](http://forge.taotesting.com/attachments/292/role-assigningManagerToRole.png)\
Fig .10

