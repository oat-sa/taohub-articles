<!--
parent: Tutorials
created_at: '2012-08-17 10:03:07'
updated_at: '2013-03-13 12:48:21'
authors:
    - 'Jérôme Bogaerts'
tags:
    - Tutorials
-->



**Page under construction**

How to add a new items type
===========================

Models
------

First you need to add in the ontology your own items type, some example are available in taoItems/models/ontology such as the Surveyitems.






        http://qat
        Electronic version of paper based Question's
        SurveyItem
        itemGroup.xml



Here a second sample from paperbased.rdf








        Paper-based Items model
        Paper-based Item


        data



If you look in the quoted samples below the RDF description will gather all additional content we may need to edit,preview and run the new type of Items.

Here some details about some specific property :

-   ItemModelStatus describe the maturity of the Items Type, we currently handle Stable, Experimental, Deprecated
-   ModelTarget will be use to handle different behavior for OnlineTarget or OfflineTarget mainly for Paperbased items.
-   ItemRuntime was used with legacy items to describe item’s runtime link
-   ItemAuthoring is used to describe item’s authoring link

Then to add your rdf file in tao just used the following script


    php tao/scripts/taoRDFImport.php -u taoManagerLogin -p taoManagerPassword -i taoItems/models/ontology/surveyItem.rdf

You may also add your file in the extension manifest to add this new Items type directly during TAO Installation, edit manifest.php, in install, rdf, you may add your own rdf file that will add your Item type during installation.


     'taoItems',
        'description' => 'the TAO Items extension provides the item creation, authoring and management',
        'additional' => array(
        'version' => '2.3',
        'author' => 'CRP Henri Tudor',
        'extends' => 'tao',
        'dependences' => array('tao'),
        'models' => array(
            'http://www.tao.lu/Ontologies/TAOItem.rdf',
            'http://www.tao.lu/Ontologies/taoFuncACL.rdf'
        ),
        'install' => array(
            'rdf' => array(
                dirname(__FILE__). '/models/ontology/taoitem.rdf'
            ),
        'classLoaderPackages' => array(
            dirname(__FILE__).'/actions/',
            dirname(__FILE__).'/helpers/'
        )
    );

ItemsService
------------

### TAO 2.3 or earlier

Once your type is added into TAO you may customize the deploy method of taoItems/class.ItemsService.php to add your specific behavior for your new type. For now this service handle those type of Items.


    $deployableItems = array(
        TAO_ITEM_MODEL_KOHS,
        TAO_ITEM_MODEL_CTEST,
        TAO_ITEM_MODEL_HAWAI,
        TAO_ITEM_MODEL_QTI,
        TAO_ITEM_MODEL_XHTML,
        TAO_ITEM_MODEL_SURVEY,
        TAO_ITEM_MODEL_PAPERBASED
    );

In most of the case, the ItemsService just call a specific renderer to retrieve the content of the items to display. For instance the ItemsSurvey just rely on those line in the deploy method


    else if($this->hasItemModel($item, array(TAO_ITEM_MODEL_SURVEY))) {
        $output = taoItems_models_classes_Survey_Item::renderItem($item);
    }

### TAO 2.4

Create a new class for your item type that implements the interface **taoItems_models_classes_itemModel**. Optionally it can also implement the interface **taoItems_models_classes_evaluatableItemModel**

Add the following property to the <rdf:Description> block of the item type.


        YOUREXTENSION_models_classes_YOURCLASS


