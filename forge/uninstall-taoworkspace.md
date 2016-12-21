<!--
author:
    - 'Joel Bout'
created_at: '2016-08-22 14:28:12'
updated_at: '2016-08-22 14:51:37'
-->

Uninstall taoWorkspace
======================

Preparing the uninstall
-----------------------

-   Before attempting an uninstall, please backup your database, as well as the directories data and config.
-   **Warning** All work in progress that users have not checked in will be lost.

Unregister the extension
------------------------

-   In **config/generis/installation.conf.php** remove the entry *’workspace’* :

<!-- -->

        'taoWorkspace' => array(
            'installed' => '0.3.1',
            'enabled' => true
        )

Restoring the configuration
---------------------------

-   Please replace the content of **config/taoRevision/repository.conf.php** with the content of **config/taoWorkspace/innerRevision.conf.php** and delete the directory **config/taoWorkspace/** afterwards.

\* Replace the content of **config/tao/lock.conf.php** with:

-   Edit the content of **config/generis/ontology.conf.php** by taking the configuration of the *’inner’* block and use it as basis of the main config. This means that the *’class’* will become ‘core\_kernel\_persistence\_smoothsql\_SmoothModel’, and for *’config’* we will use the parameters that the inner *new core\_kernel\_persistence\_smoothsql\_SmoothModel()* was called with.

For example:

    return array(
        'class' => 'oat\\taoWorkspace\\model\\generis\\WrapperModel',
        'config' => array(
            'inner' => new core_kernel_persistence_smoothsql_SmoothModel(array(
                'persistence' => 'default',
                'readable' => array(
                    '1'....'17'
                ),
                'writeable' => array(
                    '1'
                ),
                'addTo' => '1'
            )),
            'workspace' => new core_kernel_persistence_smoothsql_SmoothModel(array(
                'persistence' => 'default',
                'readable' => array(
                    666
                ),
                'writeable' => array(
                    666
                ),
                'addTo' => 666
            ))
        )
    );

would become:

    return array(
        'class' => 'core_kernel_persistence_smoothsql_SmoothModel',
        'config' => array(
            'persistence' => 'default',
            'readable' => array(
                '1'....'17'
            ),
            'writeable' => array(
                '1'
            ),
            'addTo' => '1'
        )
    );

Cleaning up the database
------------------------

-   The table ‘workspace’ can now safely be dropped.

