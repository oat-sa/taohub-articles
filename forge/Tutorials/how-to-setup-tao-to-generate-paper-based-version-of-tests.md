<!--
parent: Tutorials
created_at: '2015-04-14 10:36:40'
updated_at: '2016-10-21 14:53:41'
authors:
    - 'Stephan Holtmeier'
tags:
    - Tutorials
-->

How to setup TAO to generate paper based version of tests
=========================================================

1\. Install [wkhtmltopdf](http://wkhtmltopdf.org/downloads.html) (please use the stable version 0.12.2.1) on your server.

2\. Using composer :

Edit the file composer.json and add the following entries in the `require` list :

        "oat-sa/extension-tao-qtiprint" : "dev-master",
        "oat-sa/extension-tao-booklet": "dev-master"

And run `composer update`

3\. Change the permissions according to your web server

4\. Log in as an administrator, go to the “Extension Manager” and install the extension “taoBooklet”

Now the taoBooklet extension enables you to create paper version of your tests.

**Please note that only choices, text entries and extended text interactions are supported for now.**


