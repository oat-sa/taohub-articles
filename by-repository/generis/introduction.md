# Introduction

When it is time to introduce a new feature in a TAO Current Gen Extension, it is very important to understand and implement all the necessary components to make it a success. This Best Practice document is designed to help TAO Current Gen developers to understand all the essential steps to introduce a new feature.

In this Best Practice document, the reader will learn how to introduce a new feature by creating a Dummy TAO Service in the _[taoOutcomeRds](https://github.com/oat-sa/extension-tao-outcomerds)_ extension, in addition with all the components required to make it installed properly on a new TAO Platform Instance (_Installation Process_), but also integrable on a long-running TAO Platform Instance (_Update Process_) using Migrations to properly update configuration and database schema.

# Core Feature Components

In our Dummy Feature example, we will introduce a new `DummyFeatureManager` Service  that relies on an upgraded database schema. It requires that we have a `dummytable` table in the database on which we will rely on. The core feature component is then a simple `oat\oatbox\service\ConfigurableService` as described below.

```php
<?php
// taoOutcomeRds/model/DummyFeatureManager.php

declare(strict_types=1);

namespace oat\taoOutcomeRds\model;

use common_persistence_SqlPersistence;
use oat\generis\persistence\PersistenceManager;
use oat\oatbox\service\ConfigurableService;
use Doctrine\DBAL\DBALException;

/**
 * Class DummyFeatureManager.
 *
 * This is the implementation of my DummyFeatureManager Service.
 *
 * @package oat\taoOutcomeRds\model
 */
class DummyFeatureManager extends ConfigurableService
{
    /** @var string The DummyFeatureManager Service ID ('extensionName/className'). */
    public const SERVICE_ID = 'taoOutcomeRds/DummyFeatureManager';

    /** @var string It is a good practice to make the persistence configurable. */
    public const OPTION_PERSISTENCE = 'persistence';

    /** @var string The 'dummy_option' key. */
    public const OPTION_DUMMY_OPTION = 'dummy';

    /** @var string The name of the new database table required by the DummyFeatureManager. */
    protected const DUMMY_TABLE_NAME = 'dummytable';

    /** @var common_persistence_SqlPersistence */
    protected $persistence;

    /**r
     * DummyFeatueManager constructor.
     *
     * A ConfigurableService always receive an array of options at
     * instantiation time.
     *
     * @param array $options An array of Service options.
     */
    public function __construct(array $options = [])
    {
        parent::__construct($options);
    }

    /**
     * Get Persistence.
     *
     * Retrieve the appropriate persistence depending on the self::OPTION_PERSISTENCE
     * option. If no value is set for option self::OPTION_PERSISTENCE, the 'default'
     * persistence will be retrieve to access the database.
     *
     * @return common_persistence_SqlPersistence
     */
    public function getPersistence(): common_persistence_SqlPersistence
    {
        $persistenceId = $this->hasOption(self::OPTION_PERSISTENCE) ? $this->getOption(self::OPTION_PERSISTENCE) : 'default';
        $this->persistence = $this->getServiceLocator()
                                  ->get(PersistenceManager::SERVICE_ID)
                                  ->getPersistenceById($persistenceId);

        return $this->persistence;
    }

    /**
     * Do Something.
     *
     * Do something in the scope of the DummyFeatureManager Service.
     */
    public function doSomething(): void
    {
        // Let us do some database stuff.
        $persistence = $this->getPersistence();
        $dummyOption = $this->getOption(self::OPTION_DUMMY_OPTION);
        if ($dummyOption === 'dummy') {
            // Do something dummy...
        } else {
            // Do something else...
        }
    }

    /**
     * Upgrade Database.
     *
     * Implementation of the database upgrade consisting of creating
     * a new 'dummytable' with a sinble 'dummycolumn' varchar(255) column.
     *
     * @throws DBALException
     */
    public function upgradeDatabase(): void
    {
        // Get the current schema and clone it.
        $persistence = $this->getPersistence();
        $schema = $persistence->getSchemaManager()->createSchema();
        $fromSchema = clone $schema;

        // Perform changes.
        $table = $schema->createTable(self::DUMMY_TABLE_NAME);
        $table->addColumn('dummycolumn', 'string', ['length' => 255]);

        // Execute schema transformation.
        $persistence->getPlatForm()->migrateSchema($fromSchema, $schema);
        $this->getLogger()->debug('Migration Schema upgrade done.');
    }

    /**
     * Downgrade Database.
     *
     * Implementation of the database downgrade consisting of dropping
     * the 'dummytable'.
     *
     * @throws DBALException
     */
    public function downgradeDatabase(): void
    {
        // Get the current schema and clone it.
        $persistence = $this->getPersistence();
        $schema = $persistence->getSchemaManager()->createSchema();
        $fromSchema = clone $schema;

        $schema->dropTable(self::DUMMY_TABLE_NAME);

        // Execute schema transformation.
        $persistence->getPlatForm()->migrateSchema($fromSchema, $schema);
        $this->getLogger()->debug('Migration Schema downgrade done.');
    }
}
```

This is beautiful, but we now have to integrate this within the TAO ecosystem. To do so, we will have to wire everything together to make our `DummyFeatureManager` Service available after a successful _Installation Process_ or _Update Process_.

# Installation Process

In order to make sure that our `DummyFeatureManager` Service is registered and our database schema gets updated during a fresh TAO _Installation Process_, we need proceed with two things. First of all, we have to provide a default _Instantiation Pattern_ to our Service. Secondly, we have to make sure that the database schema will be updated by creating an _Installation Action_.

## Service Instantiation

During a TAO Extension _Installation Process_, the `config/default` directory of the Extension will be scanned to find default _Service Instantiation Patterns_ for implemented Services. The file name must correspond to the **second part of the Service ID** + .`conf.php`. As our `DummyFeatureManager` Service has the `"taoOutcomeRds/DummyFeatureManager"` Service ID, we will create our _Service Instantiation Pattern_ as below.

```php
<?php
// taoOutcomeRds/config/default/DummyFeatureManager.conf.php
declare(strict_types=1);

use oat\taoOutcomeRds\model\DummyFeatureManager;

/*
 * Instructions to be executed to properly instantiate the DummyFeatureManager
 * Service when it is retrieved for the first time by the TAO ServiceManager.
 */
return new DummyFeatureManager([
    DummyFeatureManager::OPTION_DUMMY_OPTION => 'dummy'
]);
```

By doing this, we are sure that at the _[taoOutcomeRds](https://github.com/oat-sa/extension-tao-outcomerds)_ Extension installation time, this file will be copied in `config/taoOutcomeRds/DummyFeatureManager.conf.php`. The service will be then automatically registered and then available via the TAO Service Locator for further usage.

## Installation Action

We can now take care of the _Installation Action_ containing the code to be executed to properly activate our new  feature. It is easy to implement it as an `__invokable()` action by extending the `oat\oatbox\extension\AbstractAction` class.

```php
<?php
// taoOutcomeRds/scripts/install/CreateDummyFeatureTables.php
declare(strict_types=1);

namespace oat\taoOutcomeRds\scripts\install;

use Doctrine\DBAL\DBALException;
use oat\oatbox\extension\AbstractAction;
use oat\taoOutcomeRds\model\DummyFeatureManager;

/**
 * Class CreateDummyFeatureTables.
 *
 * An invokable Action that is triggered at installation time to setup
 * database for our dummy feature.
 *
 * @package oat\taoOutcomeRds\scripts\install
 */
class CreateDummyFeatureTables extends AbstractAction
{
    /**
     * @param array $params
     * @throws DBALException
     */
    public function __invoke($params): void
    {
        /*
         * At installation time, the DummyFeatureManager Service is already registered thanks
         * to its config/default configuration file.
         */
        /** @var DummyFeatureManager $dummyFeatureManager */
        $dummyFeatureManager = $this->getServiceLocator()->get(DummyFeatureManager::SERVICE_ID);
        $dummyFeatureManager->upgradeDatabase();

        $this->getLogger()->debug('Installation Schema upgrade done.');
    }
}
```

The only thing we have to do to make this action being triggered during the _Installation Process_ is to reference it into the manifest.php file of the extension. As we are introducing a new feature, take also the opportunity to update the version from 7.2.0 to 7.3.0.

```php
<?php

return [
    'name' => 'taoOutcomeRds',
    'label' => 'extension-tao-outcomerds',
    'description' => 'extension that allows a storage in relational database',
    'license' => 'GPL-2.0',
    // Update version from 7.2.0 to 7.3.0.
    'version' => '7.3.0',
    'author' => 'Open Assessment Technologies SA',
    'requires' => [
        'taoResultServer' => '>=11.0.0',
        'generis' => '>=12.15.0'
    ],
    // ..
    'install' => [
        // ...
        'php' => [
            // ...
            // Reference the __invokable() CreateDummyFeatureTables class.
            \oat\taoOutcomeRds\scripts\install\CreateDummyFeatureTables::class
        ]
    ],
    // ...
];
```

# Update Process

For the _Update Process_, the only thing to do is to create a new _Migration_. Execute the following command in your terminal to create a new _Migration Class Skeleton_ for the taoOutcomeRds extension.

```
cd ~/root/installation/directory
php index.php "oat\tao\scripts\tools\Migrations" -c generate -e taoOutcomeRds
```

This will generate a _Migration Class Skeleton_ in the `taoOutcomeRds/migrations` directory. In our specific case, the generated file is named `Version202006101217421904_taoOutcomeRds.php` and looks like the following.

The version number in your own generated file will differ.

**It is extremely important to always generate the _Migration Class Skeleton_ with the command described above.** This is required for the _Update Process_ to determine the order of execution and properly scan/register migrations.

```php
<?php
// taoOutcomeRds/migrations/Version202006101217421904_taoOutcomeRds.php
declare(strict_types=1);

namespace oat\taoOutcomeRds\migrations;

use Doctrine\DBAL\Schema\Schema;
use oat\tao\scripts\tools\migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version202006101217421904_taoOutcomeRds extends AbstractMigration
{

    public function getDescription(): string
    {
        return '';
    }

    /**
     * The $schema parameter will be most of the time not be used. Indeed,
     * it will be by default a Schema object referencing the 'default' TAO
     * Persistence. As we recommend that TAO Configurable Services use 
     * configurable persistences, this $schema variable will be ignored most
     * of the time.
     *
     * See the next Migration implementation below to see how to proceed.  
     *
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
```

As you can see, there are 3 methods to be implemented:

* `getDescription(): string` which provides a basic description of the _Migration_.
* `up(Schema $schema): void` containing the implementation of the _Migration Upgrade_.
* `down(Schema $schema): void` containing the implementation of the _Migration Downgrade_ in case of rollback.

The `down()` method is optional. However, **if you consider to ship your _Migration_ without any way to rollback, you MUST call** `$this->throwIrreversibleMigrationException();` as the implementation of the down() method.

Let us now customize this _Migration Class Skeleton_ to meet our requirements:

* register the `taoOutcomeRds/DummyFeatureManager` Service to make it available through  the TAO Service Locator.
* update the database schema.

```php
<?php
// taoOutcomeRds/migrations/Version202006101217421904_taoOutcomeRds.php
declare(strict_types=1);

namespace oat\taoOutcomeRds\migrations;

use common_Exception;
use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\Schema\Schema;
use oat\tao\scripts\tools\migrations\AbstractMigration;
use oat\taoOutcomeRds\model\DummyFeatureManager;

/**
 * Class Version202006101217421904_taoOutcomeRds.
 *
 * The Migration Class implementing the necessary changes to introduce/remove
 * a Dummy Feature in extension taoOutcomeRds.
 *
 * @package oat\taoOutcomeRds\migrations
 */
final class Version202006101217421904_taoOutcomeRds extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'New Dummy Feature for extension taoOutcomeRds.';
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     * @throws common_Exception
     */
    public function up(Schema $schema): void
    {
        $dummyFeatureManager = new DummyFeatureManager([
            DummyFeatureManager::OPTION_DUMMY_OPTION => 'dummy'
        ]);

        /*
         * This might throw a common_Exception. This is why it is reported
         * in the PhpDoc above. We will let the Migration Manager taking care
         * of it in case of error.
         */
        $this->getServiceLocator()->register(
            DummyFeatureManager::SERVICE_ID,
            $dummyFeatureManager
        );

        // Apply database upgrade.
        $dummyFeatureManager->upgradeDatabase();
    }

    /**
     * @param Schema $schema
     * @throws DBALException
     */
    public function down(Schema $schema): void
    {
        /** @var DummyFeatureManager $dummyFeatureManager */
        $dummyFeatureManager = $this->getServiceLocator()->get(DummyFeatureManager::SERVICE_ID);
        $dummyFeatureManager->downgradeDatabase();

        // Unregister DummyFeatureManager service.
        $this->getServiceLocator()->unregister(DummyFeatureManager::SERVICE_ID);
    }
}
```

# Testing the Solution

The final touch is to make sure that what we provide for the _Update Process_ and _Installation Process_ works. If you implemented the `down()` method of your _Migration Class_, you must also test the Rollback Process.

## Update Process Testing

Let us get back to the original source code state by retrieving all `develop` by using `composer update`. Install the platform. Now, switch to the appropriate branch of your feature in the `composer.json` file and perform `composer update` again to get your new feature code.

We can now test what happens by launching the _Update Process_.

```
cd ~/root/installation/directory
php tao/scripts/taoUpdate.php
```

You must see the following as the output of the `taoUpdate.php` script.

```
Running extension update
  generis already up to date
  tao already up to date
  taoResultServer already up to date
  taoOutcomeRds requires update from 7.2.1 to 7.3.0
    Successfully updated taoOutcomeRds to 7.3.0
  taoDelivery already up to date
  taoBackOffice already up to date
  taoTestTaker already up to date
  taoGroups already up to date
  taoItems already up to date
  taoTests already up to date
  taoQtiItem already up to date
  taoQtiTest already up to date
  taoDeliveryRdf already up to date
  taoOutcomeUi already up to date
  taoQtiTestPreviewer already up to date
  qtiItemPci already up to date
  funcAcl already up to date
  taoCe already up to date
  [notice] Migrating up to oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds
[warning] Migration oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds was executed but did not result in any SQL statements.
[notice] finished in 71.6ms, used 4M memory, 1 migrations executed, 0 sql queries


  Successfully updated 39 client translation bundles
  Update ID : 5eeb650a5f536
Update completed
```

There are 4 checkpoints. **1st checkpoint**, the taoOutcomeRds extension indeed updated from version `7.2.0` to `7.3.0`. 

```
taoOutcomeRds requires update from 7.2.0 to 7.3.0
    Successfully updated taoOutcomeRds to 7.3.0
```

For the **2nd checkpoint**, we can see that the Migration itself was properly executed.

The `[warning]` message below is absolutely normal. Indeed, we did not use the provided `$schema` variable provided to the `up()` method. Doctrine Migrations then considers no SQL queries were performed. However, the necessary SQL queries to update the schema have been performed separately, in the implementation of our `DummyFeatureService`.

The reason why we do not use the $schema variable provided by Doctrine Migrations is because we wanted the TAO Persistence to remain configurable. By default, Doctrine Migrations provides a `$schema` variable representing the schema of the `'default'` TAO Persistence. In our case, we wanted to make sure the schema changes will occur on the currently configured TAO Persistence, not the `'default'` one.

```
[notice] Migrating up to oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds
[warning] Migration oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds was executed but did not result in any SQL statements.
[notice] finished in 71.6ms, used 4M memory, 1 migrations executed, 0 sql queries
```

We can also check that everything went well for the migration by calling the following command.

```
cd ~/root/installation/directory
php index.php "\oat\tao\scripts\tools\Migrations" -c status
```

As we can see in the output below, everything is good. It is a good practice to check that everything is fine in the Versions and Migrations sections of the output are correct.

This Migration was executed on a platform instance having only migrated once at version `Version202005081221002234_tao`. 

After our update, the previous version becomes `Version202005081221002234_tao`, and the latest version `becomesVersion202006101217421904_taoOutcomeRds`.

```
+----------------------+------------------------------+-----------------------------------------------------------------------+
| Configuration                                                                                                               |
+----------------------+------------------------------+-----------------------------------------------------------------------+
| Storage              | Type                         |                                                                       |
|-----------------------------------------------------------------------------------------------------------------------------|
| Database             | Driver                       | Doctrine\DBAL\Driver\PDOMySql\Driver                                  |
|                      | Name                         | tao-community                                                         |
|-----------------------------------------------------------------------------------------------------------------------------|
| Versions             | Previous                     | oat\tao\migrations\Version202005081221002234_tao                      |
|                      | Current                      | oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds  |
|                      | Next                         | Already at latest version                                             |
|                      | Latest                       | oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds  |
|-----------------------------------------------------------------------------------------------------------------------------|
| Migrations           | Executed                     | 2                                                                     |
|                      | Executed Unavailable         | 0                                                                     |
|                      | Available                    | 2                                                                     |
|                      | New                          | 0                                                                     |
|-----------------------------------------------------------------------------------------------------------------------------|
| Migration Namespaces | oat\tao\migrations           | /var/www/html/tao/migrations                                          |
|                      | oat\taoOutcomeRds\migrations | /var/www/html/taoOutcomeRds/migrations                                |
+----------------------+------------------------------+-----------------------------------------------------------------------+
```

The **3rd checkpoint** is about checking that our `DummyFeatureManager` Service has been indeed properly registered by calling . In other words, our `taoOutcomeRds/config/default/DummyFeatureManager.conf.php` _Service Instantiation Pattern_ must have been copied at `~/root/installation/director/config/taoOutcomeRds/DummyFeatureManager.conf.php` and its content should be relevant.

Finally, the **4th checkpoint** is about checking we have all we need in the database. Here is an example for MySQL/MariaDB.

```
MariaDB [tao-community]> DESCRIBE dummytable;
+-------------+--------------+------+-----+---------+-------+
| Field       | Type         | Null | Key | Default | Extra |
+-------------+--------------+------+-----+---------+-------+
| dummycolumn | varchar(255) | NO   |     | NULL    |       |
+-------------+--------------+------+-----+---------+-------+
1 row in set (0.002 sec)
```

### Single Migration Testing

Please execute/rollback migrations manually only for debugging or testing purposes. 

You can also test your migrations “outside” of the full _Update Process_. This is very convenient while you are developing your new Migration, and want to have some testing.

You can run the following commands in order to test your Migrations as a single unit of work.

Run `php index.php "oat\tao\scripts\tools\Migrations" -c execute -v <version>` to apply single migration, where `<version>` is a Fully Qualified Class Name (FQCN) e.g. `oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds.`

Run `php index.php "oat\tao\scripts\tools\Migrations" -c rollback -v <version>` to rollback single migration, where `<version>` is fully qualified class name.____

## Installation Process Testing

Now that we have the appropriate new code source in our local environment, we also have to check that the _Installation Process_ is working well. Reinstall the platform and validate the 4 following checkpoints.

The **1st checkpoint** is about checking that our `DummyFeatureManager` Service is indeed registered. In other words, a `config/taoOutcomeRds/DummyFeatureManager.conf.php` _Service Instantiation Pattern_ has been generated in the platform root installation directory, by calling the `ServiceLocator::register()` method in our Migration Class. The content of the file must be relevant.

The **2nd checkpoint** is to check that our Installation Script located in `taoOutcomeRds/scripts/install/CreateDummyFeatureTables.php` was executed. Make sure that the dummytable database table is present. 

Finally, the **3rd checkpoint** is to make sure that your Migration has been registered by the _Installation Process_, but not executed. This mechanism ensures that the Migration will not be taken into account in further Update Processes, because its related feature is already installed. You can check this by calling the following command.

```
cd ~/root/installation/directory
php index.php "oat\tao\scripts\tools\Migrations" -c status
```

The output must be exactly the same as the one you received while checking the _Update Process_ at the **2nd checkpoint**.

# Additional Concepts

There are other concepts to be taken into account while creating a new feature. It is critical they are well understood.

## Long Migrations

**It is absolutely critical to respect the following rules as it could affect deployment in production.**

As soon as you consider that a Migration might take more than 1 minute in production, it is absolutely mandatory to put the code that is taking a long time to execute in a separate script. Indeed, we currently have technical limitations at deployment time: it cannot exceed 5 minutes due to our way to proceed with AWS Code Deploy.

Long Migrations examples:

* Adding an index on an existing table column.
* Transforming data already stored in database.
* Processing massive amount of files.

Externalize long running processes from a Migration is a **2 step process**.

The **1st step** to externalize some long running code to a script, you must create an `invokable` class extending `oat\oatbox\extension\AbstractAction` as in the following example.

```php
<?php
// taoOutcomeRds/scripts/update/DummyExternalProcessing.php
declare(strict_types=1);

namespace oat\taoOutcomeRds\scripts\update;

use oat\oatbox\extension\AbstractAction;

class DummyExternalProcessing extends AbstractAction
{
    /**
     * @param array $params
     */
    public function __invoke($params)
    {
        // ...
        // Perform some long running operations...
        // ...
    
        return \common_report_Report::createSuccess('Meaningful success message.');
    }
}
```

The **2nd step** is about making sure that a person (e.g. Operations, Software Engineering) in charge of updating a TAO Platform Instance will be aware that an additional script must be run for a long time. This will be done in your Migration class by leveraging the `AbstractMigration::addReport() method.

```php
<?php
// taoOutcomeRds/migrations/Version202006191726251904_taoOutcomeRds.php
declare(strict_types=1);

namespace oat\taoOutcomeRds\migrations;

use Doctrine\DBAL\Schema\Schema;
use oat\tao\scripts\tools\migrations\AbstractMigration;
use common_report_Report as Report;

final class Version202006191726251904_taoOutcomeRds extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Report Example';
    }

    public function up(Schema $schema): void
    {
        $this->addReport(
            new Report(
                Report::TYPE_WARNING,
                'Run `\oat\taoOutcomeRds\scripts\update\DummyExternalProcessing` script to do something very long.'
            )
        );
    }

    public function down(Schema $schema): void
    {
        // ...
    }
}
```

As a result, the output of the `tao/scripts/taoUpdate.php` script will look like this.

```
Running extension update
  generis already up to date
  tao already up to date
  taoResultServer already up to date
  taoOutcomeRds requires update from 7.2.1 to 7.3.0
    Successfully updated taoOutcomeRds to 7.3.0
  taoDelivery already up to date
  taoBackOffice already up to date
  taoTestTaker already up to date
  taoGroups already up to date
  taoItems already up to date
  taoTests already up to date
  taoQtiItem already up to date
  taoQtiTest already up to date
  taoDeliveryRdf already up to date
  taoOutcomeUi already up to date
  taoQtiTestPreviewer already up to date
  qtiItemPci already up to date
  funcAcl already up to date
  taoCe already up to date
  [notice] Migrating up to oat\taoOutcomeRds\migrations\Version202006191726251904_taoOutcomeRds
[warning] Migration oat\taoOutcomeRds\migrations\Version202006101217421904_taoOutcomeRds was executed but did not result in any SQL statements.
[warning] Migration oat\taoOutcomeRds\migrations\Version202006191134551904_taoOutcomeRds was executed but did not result in any SQL statements.
[notice] Run `\oat\taoOutcomeRds\scripts\update\DummyExternalProcessing` script to do something very long.

[warning] Migration oat\taoOutcomeRds\migrations\Version202006191726251904_taoOutcomeRds was executed but did not result in any SQL statements.
[notice] finished in 83.3ms, used 6M memory, 3 migrations executed, 0 sql queries


  Successfully updated 39 client translation bundles
  Update ID : 5eecf6faef7ee
Update completed
```

As a result, the person in charge of the update in production will read the output, and proceed to the execution of the `DummyExternalProcessing` script by calling the following command manually to finalize the deployment.

```
cd ~/root/installation/directory
php index.php "oat\taoOutcomeRds\scripts\update\DummyExternalProcessing"
```

## No Migration

In case of your new feature or bugfix does not contain any code aiming at updating the platform (database schema, configuration, …) there is no need to create a _Migration Class_. The only thing you have to do is to update the version in the `manifest.php` file. As an example, in case of a bugfix on the _[taoOutcomeRds](https://github.com/oat-sa/extension-tao-outcomerds)_ extension, you would perform the following change.

```php
<?php
// taoOutcomeRds/manifest.php

return [
    'name' => 'taoOutcomeRds',
    'label' => 'extension-tao-outcomerds',
    'description' => 'extension that allows a storage in relational database',
    'license' => 'GPL-2.0',
    // Update version from 7.2.0 to 7.2.1.
    'version' => '7.2.1',
    // ...
];
```

## Irreversible Migrations

Sometimes, implementing the `AbstractMigration::down()` is very difficult or close to impossible. Reverting complex data changes can take too much time to implement, or simply to execute. In such a case, an agreement must occur between the developer and the reviewer. In case of a Migration is Irreversible, the implementation of the `AbstractMigration::down()` must throw a `Doctrine\Migrations\Exception\IrreversibleMigration` exception as in the following example

```php
<?php
// taoOutcomeRds/migrations/Version202006191726251904_taoOutcomeRds.php
declare(strict_types=1);

namespace oat\taoOutcomeRds\migrations;

use Doctrine\DBAL\Schema\Schema;
use oat\tao\scripts\tools\migrations\AbstractMigration;

final class Version202006191726251904_taoOutcomeRds extends AbstractMigration
{

    public function getDescription(): string
    {
        return 'Irreversible Exception Example';
    }

    public function up(Schema $schema): void
    {
        // Do something...
    }

    public function down(Schema $schema): void
    {
        // This Migration is "Irreversible".
        $this->throwIrreversibleMigrationException();
    }
}
```

# Conclusion

In this Best Practice document, the reader could learn how to implement a new feature from end to end for a TAO Current Gen Extension. He knows how to create a new _TAO Service_ and configure it for installation using _Service Instantiation Patterns_ and _Installation Scripts_. In addition he could learn how to properly update the database and configuration using _Migrations_.