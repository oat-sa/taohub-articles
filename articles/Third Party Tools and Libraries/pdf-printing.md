<!--
parent: articles
created_at: '2017-05-09 09:25:30'
updated_at: '2017-05-09 09:25:30'
authors:
    - 'Jean-Sébastien Conan'
tags:
    - 'Backend'
    - 'Tools'
    - 'taoBooklet'
    - 'PHP'
    - 'PDF'
    - 'wkhtmltopdf'
    - 'wkhtml'
    - 'Print'
    - 'Document'
-->

Install wkHTMLtoPDF
====================

![wkhtmltopdf logo](../resources/third-party/wkhtmltopdf.png) https://wkhtmltopdf.org/

> wkhtmltopdf is open source (LGPLv3) command line tool to render HTML into PDF using the Qt WebKit rendering engine.
> This run entirely "headless" and do not require a display or display service.

An extension for TAO allow to create test booklets: [taoBooklet](https://github.com/oat-sa/extension-tao-booklet).
However this extension needs a third-party tool to generate the PDF files.
So to be able to generate the booklet, you should install `wkhtmltopdf` on your server.

If you are using Ubuntu you can use these commands:

```
sudo apt-get update
sudo apt-get install wkhtmltopdf
```

However, depending of the version of your system, the installed version of `wkhtmltopdf` may not fully comply with the requirements, as there is some issues with QT when trying to render header and footers.
If you encounter errors when generating the document, you should install the tool using these commands:

```
sudo apt-get update
sudo apt-get install libxrender1 fontconfig xvfb
wget http://download.gna.org/wkhtmltopdf/0.12/0.12.4/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz -P /tmp/
cd /usr/share/
sudo tar xf /tmp/wkhtmltox-0.12.4_linux-generic-amd64.tar.xz
sudo ln -s /usr/share/wkhtmltox/bin/wkhtmltopdf /usr/bin/wkhtmltopdf
```
