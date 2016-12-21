<!--
parent:
    title: Tutorials
author:
    - 'Jérôme Bogaerts'
created_at: '2011-09-13 11:20:33'
updated_at: '2013-03-13 12:47:04'
tags:
    - Tutorials
-->

{{\>toc}}

Massive Import of Test Takers using CSV
=======================================

In this tutorial, we will focus on the Import Feature of TAO to learn how to insert a large set of Test Takers in the TAO database in a single operation.

1. Introduction
---------------

The TAO Platform provides everything you need to insert Test Takers into the database. By using specific forms in the [[The Test Takers Extension|Test Takers extension]] you can create Test Takers once at a time. Despite this ease of use, it is sometime useful to import a large set of Test Takers in a single operation and/or reuse an existing CSV data file.

2. Prepare your CSV file
------------------------

TAO supports the import of multiple formats CSV (Comma Separated Values) and RDF-XML (Resource Description Framework XML). In this tutorial, we will use the CSV format because it is widely adopted and can be easily edited with popular softwares such as Microsoft Exell or LibreOffice.

We will now use a sample CSV file to analyse how the Test Takers data must be formatted to be recognized by the platform and finally inserted in the database. Before continuing the tutorial, please download and open the following CSV file with your favorite spreadsheet software.

-   attachment:users1-header.csv: a file containing generic Test Takers data.

Now that you can see the data, let us review it together.

###2.1. Targeted properties{#21-targeted-properties}

The first line of the file is dedicated to the labels of the properties defining your Test Takers. In the TAO ontology, Test Takers are defined by the following properties:

-   (string) **label**: a label describing quickly the Test Taker
-   (string) **First Name**: the first name of the Test Taker
-   (string) **Last Name**: the last name of the Test Taker
-   (string) **Login**: the series of characters the Test Taker will have to provide for authentication at test delivery time
-   (string) **Mail**: the email address of the Test Taker
-   (string) **password**: the series of characters the Test Taker will have to provide to be authenticated at delivery time in addition to its Login
-   (Resource) **UserUILg**: The language of the GUI (Graphical User Interface) the Test Taker will see at delivery time e.g. button labels, links, items, …

You can of course use existing CSV data files of your organization that have more than these properties as a basis. The mapping between your properties and the properties of the Test Taker class in the TAO ontology will be done at import time later on.

You probably noticed in the TAO properties’ descriptions that the type of **UserUILg** is Resource. This means that you have to provide a value corresponding to a URI (Universal Resource Identifier) that identifies a resource in the database. In TAO every resource is identified with a URI. Because languages are instances of the language class, they are considered as resources. In this example, the language resource in use for both properties is the English one, identified by the *http://www.tao.lu/Ontologies/TAO.rdf\#LangEN* URI. Other language resources exists in TAO such *as http://www.tao.lu/Ontologies/TAO.rdf\{#langen-uri-other-language-resources-exists-in-tao-such-as-httpwwwtaoluontologiestaordf}

LangFR* where *FR* is the ISO code for the French language.

###2.2. Rows of data{#22-rows-of-data}

Each row of the file is related to a Test Taker to import in the database. Each cell of the row is a value to be set for a particular property.

3. Import the file in TAO
-------------------------

Open up your favorite web browser and go to the TAO backoffice at http://www.mydomain.com/tao. www.mydomain.com is of course the domain name addressing the web server where your TAO instance is deployed.

1\. Click on the Test Takers extension link at the top of the screen.

2\. Click on the Test Taker class in the Test Takers Library panel.

3\. Click on the Import icon in the Actions panel.

4\. A form appears on your screen.

-   Tick the CSV option in the Supported formats to Import section. New options appear on the screen.
-   Do not change the options in the CSV Options section unless you modified the default export values in your favorite spreadsheet software.
-   Click on the Browse button in the Upload CSV file section of the form. Select the file that has to be imported.
-   Click on the Next button at the bottom of the form.

5\. A second form appears on your screen. It is time to map your properties with the ones of the TAO Ontology.

-   Map your properties to TAO ones by using the lists in the Map the properties to the CSV columns section of the form. Values on the left are properties of TAO. Values on the right, in the lists, are the columns of your CSV file.
-   Click on the Import button at the bottom of the form.

**Congratulations, you successfuly imported your first set of Test Takers using the CSV Import feature of TAO!**

