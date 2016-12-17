---
tags: Forge
---

Extension update guide
======================

1. Composer basics
------------------

Excerpts from the documentation (https://getcomposer.org/doc/):

### composer install

    The install command checks if a lock file is present, and if it is, it downloads the versions specified there (regardless of what composer.json says).
    If no composer.lock file exists, Composer will read the dependencies and versions from composer.json and create the lock file after executing the update or the install command.

    Note: Composer will display a Warning when executing an install command if composer.lock and composer.json are not synchronized.

### composer update

    The update command will fetch the latest matching versions (according to your composer.json file) and also update the lock file with the new version.

### versions references in composer.json

tilde (\~):

    The ~ operator is best explained by example: ~1.2 is equivalent to >=1.2 <2.0.0, while ~1.2.3 is equivalent to >=1.2.3 <1.3.0

2. Create a local branch
------------------------

Your modifications should be contained within a branch, with the following naming convention:

**modification\_type / jira\_ref - short-description**

Exemples:

-   bug/TAO-1756-ipassage-content-height
-   hotfix/TAO-2323-mathjax-comments
-   feature/TAO-2324-css-tweaks

3. Version update
-----------------

As an example, we will update an extension from 1.1.0 to 1.2.0.

Start by updating the version number in manifest.php, following semver principles (http://semver.org/). ex:

    'version' => '1.2.0'

**Create an install script**

If the new version needs to run a script (registering a hook, a theme, etc.):

\* put it in scripts/install in its own file. ex:

    AddHook.php
    SetThemeConfig.php

\* use this template for the code:

\* reference the script in the manifest of the extension:

    'install' => array(
        ...
        'php' => array(
            ...
            'oat\\taoQtiItem\\install\\scripts\\SetThemeConfig'

\* test the installer:

    php tao/scripts/installExtension.php taoQtiItem

\* if you need to run the installer multiple times, delete the extension entry in config/generis/installation.conf

    ‘ext’ => array(
       'installed' => '1.2.0',
       'enabled' => true
    )

**Create an update script** (if needed)

\* mirror the script in scripts/update/Updater.php by putting it at the end of the existing update scripts

    import oat\taoQtiItem\install\scripts\SetThemeConfig
    ...

    if($this->isVersion('1.1.0')){

       $setThemeConfig = new SetThemeConfig();
       $setThemeConfig([]);

       $this->setVersion('1.2.0');
    }

\* check that the update script works:

    php tao/scripts/taoUpdate.php

    should output...

    [ext] requires update from 1.1.0 to 1.2.0
        Successfully updated ext to 1.2.0

-   if you need to run the updater again, lower the version number in installation.conf (see above)

If the release doesn’t need to run a script, you still need to update the version number in scripts/update/Updater.php

\* the new way (depends on a recent version of generis):

    $this->skip('1.1.0', '1.2.0');

\* or the old way (safer):

    if($this->isVersion('1.1.0')){

       /* NOTHING HERE, AND THAT’S FINE */

       $this->setVersion('1.2.0');
    }

**Javascript / CSS**

Finally, **make sure you compile any javascript/css if needed.**

