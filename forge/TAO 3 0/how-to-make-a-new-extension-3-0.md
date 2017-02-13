<!--
parent: 'TAO 3 0'
created_at: '2014-09-17 10:33:59'
updated_at: '2016-06-17 14:30:08'
authors:
    - 'Christophe Garcia'
tags:
    - 'Legacy Versions:TAO 3.0'
-->



How to make a new extension 3 0
===============================

Preparation
-----------

1.  Install TAO (3.0) with the development tools (https://github.com/oat-sa/extension-tao-devtools)
2.  Make sure the extension taoDevTools has been installed.

Create the extension
--------------------

1.  Log into Tao Back Office with your TaoManager account
2.  Go to “Settings”(upper right corner) -<br/>
> “Extensions Manager”
3.  Click on “create new” to create your new extension
4.  Fill out the form and call your new extension “taoDocs” ( you can select some *Samples* to generate extra structure, according to your choice )
5.  Return to the extension manager, select taoDocs, and install it

Simple Examples
---------------

### Hello World

\* Create the `TestController.php` in the `controller` folder

\* Create the `sayHello()` method

         public function sayHello()
         {
              echo 'Hello World';
         }

-   To run the action visit *ROOT_URL/taoDocs/TestController/sayHello* (if your TAO Home is http://localhost/myinstall/tao/Main/index this would translate to http://localhost/myinstall/taoDocs/TestController/sayHello). If you get an “Access Denied” instead of the expected Hello world message, make sure you properly set up the extension in tao as described in the preparation step of this tutorial here above. Make sure, www-data may fully access the files on the file system of your extension.

### Hello Template

\* Create the `hello.tpl` file in views/templates

         Hello <?=get_data('name')?>

\* Update the `sayHello()` method to define the template and the parameter *<span class="URL:/taoDocs/TestController/sayHello"></span>*

         public function sayHello()
         {
              $this->setData('name', 'bertrand');
              $this->setView('hello.tpl');
         }

-   To test this action visit *<span class="URL:/taoDocs/TestController/sayHello"></span>*

### Hello Parameter

\* Update the `sayHello()` method to use the GET parameter “name”

         public function sayHello()
         {
            if ($this->hasRequestParameter('name')) {
                $name = $this->getRequestParameter('name');
            } else {
                $name = 'everybody';
            }
            $this->setData('name', $name);
            $this->setView('hello.tpl');
         }

-   Pass the parameter “name” in the url to test it *<span class="URL:/taoDocs/TestController/sayHello?name=bertrand"></span>*

Integration with TAO
--------------------

### Adding a structure

\* Open the `controller/structures.xml` ( see more at Tao_30_structuresxml_format| guide about structures.xml  )

\* Add a new structure with a section

**** In the `structures.xml` add the tag











-   Since Tao 2.6 the structures are cached, so you will need to empty your cache (by default situated in *data/generis/cache*. Also you can use taoDevTools scripts)
-   When refreshing the TAO home screen, the new extension should be visible

### Adding a tree

\* Add the tag into `trees` in the `structures.xml` file ( How_to_add_a_new_items_type|How to add a new items type )






NOTE: You should clear cache after each change of structures.xml.

### Adding a Controller

\* Now you can reload page and see error. It’s because you should create controller for our tree of documents. Example of Browser controller is attached ( [Browser.php](../resources/Browser.php) ). Download and place this file to `controller` folder.

\* Browser controller need two dependent classes: **DocsService** ( [DocsService.php](../resources/DocsService.php) ) and **FileUtils** ( [FileUtils.php](../resources/FileUtils.php) ). This files should be downloaded and placed to `model` and `helpers` folders respectively. You need create this folders if it not exists.

\* Now we see error about undefined `DOCS_PATH` constant. Constants in extension usually stored in `includes/constants.php`. Create folder and file and insert into code from section below.

    $todefine = [
        'DOCS_PATH' => ROOT_PATH . 'taoDocs/views/docs/'
    ];

Our documents will be placed on `taoDocs/views/docs/` folder. Also you need create this folder and place to there or create some files.

-   If you placed some files to created folder, the extension taoDocs now should shows a list of the files in it.

### Adding an action

\* Add the tag into `actions` in the `structures.xml` file





Attribute **id** link this actions with tree. So for Delete button we need define id as “delete”, as in tree.<br/>

Attribute **name** define text on button.<br/>

Attribute **url** define path to controller action.<br/>

Attribute **group** tell where action (button) should be placed. In our case it will be places in tree, below list of files.<br/>

Attribute **binding** define handler for this action in front-side application (javascript). How should be organised frontend application see here: [Front js](../documentation-for-core-components/front-js.md)

\* Add the following code to the controller `Browser.php`

    public function delete()
    {
        $filepath = DOCS_PATH . $this->getRequestParameter('uri');
        $deleted = FileUtils::deleteFile($filepath);
        if ($deleted) {
            //remove the current selection from the session
            $this->removeSessionAttribute('uri');

            echo json_encode(['deleted' => 1]);
        }
    }

-   After refreshing the page, when you select file in tree, you will see a delete button at the bottom of the Tree. Now you can delete selected file.



-   If you wish you can now try to add your own actions, like duplicating a file, or creating an form to upload new files


