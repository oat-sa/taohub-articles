# Readme: TAO _taoAdvancedSearch_ extension

![TAO Logo](https://github.com/oat-sa/taohub-developer-guide/raw/master/resources/tao-logo.png)

![GitHub](https://img.shields.io/github/license/oat-sa/extension-tao-advanced-search.svg)
![GitHub release](https://img.shields.io/github/release/oat-sa/extension-tao-advanced-search.svg)
![GitHub commit activity](https://img.shields.io/github/commit-activity/y/oat-sa/extension-tao-advanced-search.svg)

> Extension required to advanced search integration with TAO platform `oat-sa/extension-tao-advanced-search`

## Installation instructions

## Worker configuration
Event processing related to the indexing isolated within separate taskQueue named `indexation_queue`. 
It must be configured to work though RDS broker according to [this instruction](https://github.com/oat-sa/extension-tao-task-queue/blob/master/README)

## Create an Indexer

## 1) Create a new Migration Indexing Task

Here we need to specify 3 required classes and create them:

- **Normalizer**: Convert search result support format of AdvancedSearch.
- **Result Searcher**: Execute the search for a paginated index execution.
- **Result Filter Factory**: The filter used to segregate the index within many workers. 

```php
<?php
namespace oat\taoAdvancedSearch\model\DeliveryResult\Service;

use oat\taoAdvancedSearch\model\DeliveryResult\Factory\DeliveryResultFilterFactory;
use oat\taoAdvancedSearch\model\DeliveryResult\Normalizer\DeliveryResultNormalizer;
use oat\taoAdvancedSearch\model\Index\Service\AbstractIndexMigrationTask;

class DeliveryResultMigrationTask extends AbstractIndexMigrationTask
{
    protected function getConfig(): array
    {
        return [
            self::OPTION_NORMALIZER => DeliveryResultNormalizer::class,
            self::OPTION_RESULT_SEARCHER => DeliveryResultSearcher::class,
            self::OPTION_RESULT_FILTER_FACTORY => DeliveryResultFilterFactory::class,
        ];
    }
}
``` 

### 2) Populate the indexes

### To warmup cache

This is necessary to optimize indexation:

```shell
./taoAdvancedSearch/scripts/tools/CacheWarmup.sh --help
```

#### To populate ALL indexes, execute:

```shell script
./taoAdvancedSearch/scripts/tools/IndexPopulator.sh --help
```

#### To populate only resources indexes (Items, tests, etc), execute:

```shell script
./taoAdvancedSearch/scripts/tools/IndexResources.sh --help
```

#### To populate only resources from one class, execute:

```shell script
./taoAdvancedSearch/scripts/tools/IndexClassResources.sh --help
```

#### To populate only class metadata indexes, execute:

```shell script
./taoAdvancedSearch/scripts/tools/IndexClassMetatada.sh --help
```

#### To populate only delivery results, execute:

```shell script
./taoAdvancedSearch/scripts/tools/IndexDeliveryResults.sh --help
```

## Garbage collection

To clean old documents in the indexes:

````shell
./taoAdvancedSearch/scripts/tools/GarbageCollector.sh --help
````

## Getting statistics

Execute following command:
```shell
php index.php '\oat\taoAdvancedSearch\scripts\tools\IndexSummary'
```

Output example:
```shell
Index vs Storage
  Item (http://www.tao.lu/Ontologies/TAOItem.rdf#Item)
    Total in DB: 14
    Total indexed "items": 14
    Percentage indexed: 100%
    Missing items: 0
  Test (http://www.tao.lu/Ontologies/TAOTest.rdf#Test)
    Total in DB: 10
    Total indexed "tests": 10
    Percentage indexed: 100%
    Missing items: 0
  Test-taker (http://www.tao.lu/Ontologies/TAOSubject.rdf#Subject)
    Total in DB: 6
    Total indexed "test-takers": 6
    Percentage indexed: 100%
    Missing items: 0
  Group (http://www.tao.lu/Ontologies/TAOGroup.rdf#Group)
    Total in DB: 5
    Total indexed "groups": 5
    Percentage indexed: 100%
    Missing items: 0
  Assembled Delivery (http://www.tao.lu/Ontologies/TAODelivery.rdf#AssembledDelivery)
    Total in DB: 0
    Total indexed "deliveries": 0
    Percentage indexed: 0%
    Missing items: 0
  Assets (http://www.tao.lu/Ontologies/TAOMedia.rdf#Media)
    Total in DB: 4
    Total indexed "assets": 4
    Percentage indexed: 100%
    Missing items: 0
  Metadata
    Total in DB: 23
    Total indexed "property-list": 2
    Percentage indexed: 8.7%
    Missing items: 21
```