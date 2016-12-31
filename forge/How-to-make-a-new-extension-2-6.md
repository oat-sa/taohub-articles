<!--
created_at: '2014-01-08 18:09:49'
updated_at: '2014-11-05 11:23:34'
authors:
    - 'Joel Bout'
tags:
    - '"Legacy Versions:TAO 2.6"'
-->



Make a new extension
====================

Preparation
-----------

1.  Install TAO (2.6)
2.  Download [taoDocs_26_tutorial.zip](resources/taoDocs_26_tutorial.zip)
3.  Unzip it in your tao root folder
4.  Make sure your webserver has read/write access to taoDocs

### Install the extension

1.  Log into Tao Back Office with your TaoManager account
2.  Go to “Settings”(upper right corner) -<br/>
> “Extensions Manager”
3.  Select taoDocs, and install it

Simple Examples
---------------

### Hello World

\* Create the `TestController.php` in the actions folder

\* Create the `sayHello()` method

         public function sayHello() {
              echo 'Hello World';
         }

-   Before you can test it, you will need to run the script **funcAcl/scripts/taoPreparePublicActions.php** (in a shell using php). This will grant you access to the newly created action.<br/>

     For example:<pre>sudo -u www-data php funcAcl/scripts/taoPreparePublicActions.php</pre>



-   To run the action visit *ROOT_URL/taoDocs/TestController/sayHello* (if your TAO Home is http://localhost/myinstall/tao/Main/index this would translate to http://localhost/myinstall/taoDocs/TestController/sayHello). If you get an “Access Denied” instead of the expected Hello world message, make sure you properly set up the extension in tao as described in the preparation step of this tutorial here above. Make sure, www-data may fully access the files on the file system of your extension.

### Hello Template

\* Create the `hello.tpl` file in views/templates

         Hello <?=get_data('name')?>

\* Update the `sayHello()` method to define the template and the parameter *<span class="URL:/taoDocs/TestController/sayHello"></span>*

         public function sayHello() {
              $this->setData('name', 'bertrand');
              $this->setView('hello.tpl');
         }

-   To test this action visit *<span class="URL:/taoDocs/TestController/sayHello"></span>*

### Hello Parameter

\* Update the `sayHello()` method to use the GET parameter “name”

         public function sayHello() {
              if($this->hasRequestParameter('name')){
                   $name = $this->getRequestParameter('name');
              }
              else{
                   $name = 'everybody';
              }
              $this->setData('name', $name);
              $this->setView('hello.tpl');
         }

-   Pass the parameter “name” in the url to test it *<span class="URL:/taoDocs/TestController/sayHello?name=bertrand"></span>*

Integration with TAO
--------------------

### Adding a structure

\* Open the `actions/structures.xml`

\* Add the following structure into `structures` in the `structures.xml` file


      An example extension.









-   Since Tao 2.6 the structures are cached, so you will need to empty your cache (by default situated in generis/data/generis/cache)
-   When refreshing the TAO home screen, the new extension should be visible

### Adding a tree

\* Add the tag into `trees` in the `structures.xml` file, and empty the cache once more.

-   The extension taoDocs now shows a list of the files in it

### Adding an action

\* Add the tag into `actions` in the `structures.xml` file, and empty the cache once more.

\* Add the following code to the `Browser.php` in `actions`

    public function delete(){
        $filepath = DOCS_PATH.$this->getRequestParameter('uri');
        $deleted = \taoDocs_helpers_FileUtils::deleteFile($filepath);
        if ($deleted) {
            $this->setView('confirmDel.tpl');
            //remove the current selection from the session
            $this->removeSessionAttribute('uri');
        }
    }

-   After refreshing the page, you will see a disabled delete button at the bottom of the Tree. Selecting a file will activate it, and allow you to delete the file.



-   If you wish you can now try to add your own actions, like duplicating a file, or creating a form to upload new files


