Views
=====

{{\>toc}}

User Interface: the views
-------------------------

### Templates

The views are separated into XHTML template using the PHP template syntax (using the short tags). The template files contain only limited PHP instructions:

-   ‘’<code><?=get_data("myVariable")?></code>’’ to display the content of a variable
-   ‘’<code><?=__("A string")?></code>’’ to display the content of a **translated** string
-   ‘’<code><?if($test == 1):?> … <?endif?></code>’’ a conditional instruction
-   ‘’<code><?foreach($array as $key => \$value):?\> … <?endforeach?></code>’’ an iterative instruction
-   helpers function are also available. For example, the ‘’\_url’’ function is used to format the hyper links URL

The communication between the template and the controller is made //via// the ‘’Module::setData’‘ method to bind a variable to the view (used inside an action) and the ’‘get\_data’’ helper function to retrieve the content from the bound variable.

### Javascript

We intensively use the javascript framework [jQuery](http://jquery.com/) and its plugin to create Rich Client Component such as:

-   Tabs, accordions, modal popups by [jQuery UI](http://jqueryui.com/)
-   Trees with [jsTree](http://jstree.com/)
-   Datagrid with [jqGrid](http://www.trirand.com/blog/)
-   Wysiwig editor [jWYSIWYG](http://plugins.jquery.com/project/jWYSIWYG)
-   Ajax uploader [uploadify](http://www.uploadify.com/)

So, we implemented and extended this library to create components easy to use.

We also gave priority to AJAX based navigation, using either HTML to render parts of the page or JSON to retrieve data from the server.\
The most part of the Javascript is set into separated ‘’.js’‘ files. Only the instantiations have been set in ’‘script’’ tag into the templates, to use model variables (from PHP) into the classes/functions parameters.

### CSS

We use the JQuery UI css selector for the common style and container themes and the usual CSS2 sheet for the layout.

![](http://forge.taotesting.com/attachments/download/215/returnTopArrow.JPG)[[Views|Return to Top]]

