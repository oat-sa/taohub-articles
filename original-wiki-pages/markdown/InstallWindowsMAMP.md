TAO on Windows with Apache2 & MySQL using MAMP
==============================================

{{\>toc}}

This installation guide focuses on installing the TAO platform on a Microsoft Windows environment using Apache2, PHP & MySQL. We will use a ready to use AMP (Apache2 MySQL PHP) stack named MAMP. The tested MAMP version is 3.1.0 (64-bit).

1. Installation & Setup of MAMP
-------------------------------

### 1.1. Installation

MAMP is the Windows port of a famous and widely used AMP stack for Mac OS X. It comes with an installer that takes care of everything to set up your web server and has MySQL and PHP built-in.

The first step is to download the latest [MAMP Windows package](https://www.mamp.info/en/downloads/) on the [official website](https://www.mamp.info/en/). Click on the Windows button (default page shows to Mac OS X version) to get the required package. Unless your system is older, download the 64-bit package. Follow the instructions on the screen and launch MAMP.

{{thumbnail(MAMP installation.png,size=800,title=MAMP installation)}}

### 1.2. Setup

### 1.2.1. PHP Setup

The TAO platform requires a few PHP extensions to be loaded to run correctly on your web server. However, the MAMP default configuration already complies with those requirements. The same goes for PHP configuration, the default one is already good for the job.

### 1.2.2. (Optional) MySQL Setup

In practice, you may need to create a local MySQL user with all privileges (except the ‘grant’ privilege) on a TAO specific database name such as ‘tao’. You may skip this step if you only go for a quick TAO trial and use later in the TAO installer the Autoconfiguration option at the database configuration step.

If you need more information about database privileges and databases, please visit [[DatabaseUserPrivileges|this page]].

{{thumbnail(MAMP MySQL create tao user 3.png,size=800,title=Create a TAO specific MySQL account)}}

### 1.2.3. Apache2 Setup

The **Apache2 rewrite module** must be enabled to install TAO. With MAMP, this module is already enabled.

You are now ready to deploy the TAO platform.

2. TAO Platform Deployment
--------------------------

### 2.1. Download the Latest Version of TAO

We will now download the latest version of the TAO source code and deploy it on the web server. Go to the official TAO [download page](http://taotesting.com/get-tao/official-tao-packages/) and download the latest manual install release. You may also download the latest nightly build.

Create a folder named **tao** in the root directory of your web server. Depending on your installation settings, it should be located at **C:\\MAMP\\htdocs\\tao\\**. You can now unzip the TAO source code previously downloaded in the **tao** folder.

{{thumbnail(Extract TAO to htdocs folder.png,size=800,title=Extract TAO package)}}

You should now have the following folders:

-   tao (full path: C:\\MAMP\\htdocs\\tao\\tao\\)
-   taoItems (full path: C:\\MAMP\\htdocs\\tao\\taoItems\\)
-   taoDelivery (full path: C:\\MAMP\\htdocs\\tao\\taoDelivery\\)
-   etc.

### 2.2. (Optional) Creation of a Virtual Host for TAO

The TAO platform may be run using an Apache2 virtual host instead of a subfolder installation. We will create a new **virtual host** named **taoplatform** by editing the virtual host configuration file of Apache2. Depending on your installation settings, it should be located at **C:\\MAMP\\bin\\apache\\conf\\extra\\**. Create a new configuration file httpd-taoplatform.conf with your favorite text editor (we recommend Notepad++) and edit it accordingly:


        ServerAdmin webmaster@taoplatform
        ServerName taoplatform

        DocumentRoot C:\MAMP\htdocs\tao

        
            Options -Indexes +FollowSymLinks +MultiViews
            AllowOverride All
            Order allow,deny
            allow from all
        

        ErrorLog C:\MAMP\logs\tao-error.log
        CustomLog C:\MAMP\logs\tao-access.log combined

Open the main Apache2 configuration file located at **C:\\MAMP\\bin\\apache\\conf\\httpd.conf** and add the following line below the commented one:

    # Various default settings
    #Include conf/extra/httpd-default.conf

    # add this line -->
    Include conf/extra/httpd-taoplatform.conf

This will integrate your virtual host configuration in the main Apache2 configuration file.

Do not forget to make the hostname reachable by editing your system **hosts** file. Open Notepad++ in **administrator mode** and open your hosts file located at **C:\\Windows\\System32\\drivers\\etc\\hosts**. Add the following instructions at the end of the file:

    127.0.0.1   taoplatform

{{thumbnail(add TAO host 2.png,size=800,title=Add a TAO specific host)}}

You can now restart your web server (click on ‘Stop Servers’ then ‘Start Servers’) to take into account the new configuration settings.

### 2.3. TAO Installation Wizard

For this last step of the installation process, open up your favourite web browser. If you followed step 2.2, then you will reach TAO at this URL: http://taoplatform/. If you didn’t, use the default URL: http://localhost/tao/. The installation wizard will appear.

{{thumbnail(Install TAO with vhost.png,size=800,title=TAO installer)}}

Follow the instructions to finalize your TAO installation.

### 3. (Optional) Fine tuning

To improve performance, you are strongly advised to enable in MAMP a PHP opcode caching such as OPCache:\
{{thumbnail(PHP opcode cache.png,size=800,title=OPCache)}}

