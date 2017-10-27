<!--
created_at: '2017-05-09 09:25:30'
updated_at: '2017-05-11 08:30:00'
authors:
    - 'Jean-Sébastien Conan'
tags:
    - 'Backend'
    - 'Tools'
    - 'taoBooklet'
-->

# Install wkHTMLtoPDF

> wkhtmltopdf is open source (LGPLv3) command line tool to render HTML into PDF using the Qt WebKit rendering engine.
> This run entirely "headless" and do not require a display or display service.

![wkHTMLtoPDF logo](../resources/third-party/wkhtmltopdf.png) 

[wkHTMLtoPDF Website](https://wkhtmltopdf.org/)

An extension for TAO allow to create test booklets: [taoBooklet](https://github.com/oat-sa/extension-tao-booklet). However this extension needs a third-party tool to generate the PDF files. To be able to generate a booklet, you need to install `wkhtmltopdf` on your server.

All three major OS brands are supported, and you should find the right binaries in the [download page of the official wkhtmltopdf website](https://wkhtmltopdf.org/downloads.html). You can also directly compile the source code and build your own platform binaries.

Note: We successfully tested `wkhtmltopdf` on MacOS, Linux and Windows 10 machines but won't guarantee that it runs on your system.

If you are using Ubuntu you can use these commands:

```bash
sudo apt-get update
sudo apt-get install wkhtmltopdf
```

However, depending on the version of your system, the installed version of `wkhtmltopdf` may not fully comply with the requirements, as there is some issues with QT when trying to render header and footers. If you encounter errors when generating the document, you should install the tool using these commands:

```bash
sudo apt-get update
sudo apt-get install libxrender1 fontconfig xvfb
wget http://download.gna.org/wkhtmltopdf/0.12/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz -P /tmp/
cd /usr/share/
sudo tar xf /tmp/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz
sudo ln -s /usr/share/wkhtmltox/bin/wkhtmltopdf /usr/bin/wkhtmltopdf
```
