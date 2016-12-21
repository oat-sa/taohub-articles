<!--
author:
    - 'Somsack Sipasseuth'
created_at: '2016-09-21 14:53:47'
updated_at: '2016-11-02 10:42:37'
-->

PCI/PIC development
===================

How to refresh registered PCI/PIC assets during development
-----------------------------------------------------------

After this manipulation, you will be able to:

-   make a modification in the source PCI files
-   refresh the TAO QTI editor
-   see your modification!

Note: this is equivalent to the old ‘debug’ flag in the PCI creator manifest.

### 1. Register the asset reloader event

From the TAO instance root directory, run:

    php index.php '\oat\taoQtiItem\scripts\initEventCreatorLoad'

### 2. Register the PCI to reload

Create or open the file:

    /config/taoQtiItem/debug_portable_element.conf.php

and add a reference to the PCI whose assets are to be reloaded:

    return [
        'textReaderPCI' => 'pciSamples/views/js/pciCreator/dev/textReaderInteraction/'
    ];

### 3. Refresh the TAO editor

Tada!

Versionning
-----------

### Principle

Currently the portable element registry is able to register multiple versions of a single portable element. However on runtime, only the last version (with the highest version number) is automatically loaded. It means that registering any newer version with automatically impact all items that includes the updated portable element. The changes will reflect directly in preview, authoring and compiled delivery.<br/>

Similarly unregistering a portable element will also impact all existing items that is making use of it and therefore prevent its rendering completely. Since it is a dangerous action, it is no longer exposed to end users. The api in php is nevertheless available to developers.

Only one version can be used at once. Because javascript AMD dependencies reference fixed module names.<br/>

If we want multiple version to be supported at once, the other version PCI “customInteractionTypeIdentifier” should be renamed. We are assuming here that two versions may potentially have different behaviours.

### Versioning in PCI standard

The concept of version does not exist in PCI standard yet. We are planning to push this modification to improve the standard. Meanwhile TAO needs to support the import of PCI that has no defined version number. If the version is missing the arbitrary version number 0.0.0 is set.<br/>

PCI that support versioning will have the version set as the property “version”.

### Semantic versionning

PCI version number follow the semantic versionning: MAJOR.MINOR.PATCH\
MAJOR : incompatible change, both runtime libs and existing qti xml need to be updated (properties, response declaration, response processing). In this case, a separate update script is required to update the xml (items or/and deliveries) before the existing items can make use of the new major version.<br/>

MINOR : new features, libs are updated, qti xml does not need to be updated\
PATCH : bug fix, libs may be updated, qti xml does not need to be updated

### How to: update my PCI in TAO

If is a minor or a patch, the pci just need to be registered with the updated version number in the manifest. In practice, most of the portable elements being implemented for TAO are registered from their source directories, so you only need to:<br/>

increase the version\
re-register it in the update script\
make a regular PR\
This actual PR makes a patch to the text reader PCI and simply illustrates this process https://github.com/oat-sa/extension-pcisample/pull/12

If it is a major version, it requires updating the item xml with a php: changing the portable element markup, properties or the item level response declaration or response processing etc. In such a situation, the related updater.php needs to call an item update script like https://github.com/oat-sa/extension-pcisample/blob/master/scripts/tool/FixTextReaderDefaultValue.php to perform the changes : TBD.<br/>

Important notice: please keep in mind that the existing deliveries need to be recompiled as the old item data is no longer compatible with the new major version of the portable element and any old item package that includes the old major version will be rejected during import for the same reason. Those items need to be upgraded to the same major version before being able to be imported again.<br/>

How to: get two/multiple version of a PCI run at the same time ?<br/>

The only to do this, is to rename the second PCI type identifier to a new one.

Asset url resolution
--------------------

The new version of portable element also includes a new media file manifest in the portable element definition. (incl. example)

This allow declaration of extra assets to be resolved on runtime and that is not supposed to be in the markup. They could be images in css, fonts in css, other assets to be resolved on runtime (images, pdfs, audio, video etc).

Checklist for PR review
-----------------------

This is a suggestion of checklist for PCI and PIC related PR review:

-   pciCreator.json and pciCreator.js
-   type identifier matches in manifest json, creator and local lib in AMD dependencies
-   markup: properly scoped by a typeIdentifier class on root node
-   runtime: no tao core lib dependencies, no requires plugin usage (css![](resources/, tel), text! etc)
-   runtime: shared libs - check extension dependencies
-   runtime: response format compatible with the pci format and defined responseDeclaration baseType and cardinality
-   runtime: response processing types (correct, map, custom, custom operator ?)
-   runtime: allow multi instance of pci on a single item (no scope polluting)
-   creator: if any tao core libs are being used, check extension version dependencies
-   css: properly scoped in both runtime and creator
-   css: how the style is compatible with the existing client’s theme ? transparency, etc.
-   unit test: rendering, get/set response and serializedState
-   version: has any version upgrade, compliant with semantic versioning
-   test authoring, preview, delivery
-   use strict, header and licensing


