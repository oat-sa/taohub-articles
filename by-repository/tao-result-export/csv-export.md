# CSV export

> We are providing specific exports. The Wiki page explains how to deal with it.

## Authoring Export Commands

We are running two different flavours of exports while running activities.

1. **Daily Exports**: contain Test-Taker, Delivery Execution information and `response` variables only.
2. **Full Exports**: contain Test-Taker, Delivery Execution information, `response` and `outcome` variables.

The **Daily Exports** are run once a night and provided to the customer on a Monday/Wednesday/Friday basis. On the other and, **Full Exports** are run once at Delivery Campaign end. **Daily Exports** will be performed using CRON scheduled tasks. **Full Exports** will be performed manually by a DevOps at the end of the Delivery Campaign.

In order to make sure that DevOps can configure the Daily and Full exports, we have to provide them with the commands to execute. To do so, please follow the following pattern.

### Daily Export Commands

```shell
sudo -u www-data php index.php "oat\taoResultExports\scripts\tools\GenerateCsvFile" -d ${DELIVERY_URIS} -s label --policy response -b numAttempts,duration --prefix MyPrefix
```

In the command pattern above, the `${DELIVERY_URIs}` must be replaced with a commas (`,`) separated list of URIs corresponding to the Deliveries that will be taken by Test-Takers (**NOT the QA Deliveries!**). These URIs can be found in the `ingestion.json` file of the [Ingestion Package](https://github.com/oat-sa/extension-tao-operations/wiki/Ingestion-Packages#basic-structure-of-an-ingestion-package) dedicated to the customer activity.

### Full Export Commands

```shell
sudo -u www-data php index.php "oat\taoInvalsi\scripts\tools\GenerateCsvFile" -d ${DELIVERY_URIS} -s label --policy all -b MAXSCORE --prefix fullExport
```

In the command pattern above, the `${DELIVERY_URIs}` must be replaced with a commas (`,`) separated list of URIs corresponding to the Deliveries that will be taken by Test-Takers (**NOT the QA Deliveries!**). These URIs can be found in the `ingestion.json` file of the [Ingestion Package](https://github.com/oat-sa/extension-tao-operations/wiki/Ingestion-Packages#basic-structure-of-an-ingestion-package) dedicated to the customer activity.

## Early Header Exports

Right after proceeding to the creation of an Ingestion Package following the [standard procedure](https://github.com/oat-sa/extension-tao-operations/wiki/Ingestion-Packages#customer-ingestion-package-creation-process), we have to provide our customer with a an "empty" sample export that we call **Early Header Exports**.

By "empty", we mean that no results must be involved. The export will contain only the header of the file. This header contain the final names of the variables we will provide to the customer. This **Early Header Export** must be provided to the customer as soon as possible in order to allow them to check everything is correctly in place for final delivery. If possible, deliver the **Daily** and **Full** Header Exports to your Project Manager as soon as the Ingestion Package you created can be successfully ingested without error on your local environment.

You can find the instruction about how to create export in the [Authoring Export Commands](#authoring-export-commands) of this document.

Please note that the Early Header Export files to be provided to your Project Manager must be respectively named `${ACTIVITY_CODE}-DAILY.csv` and `${ACTIVITY_CODE}-FULL.csv`. An Excel version (`.xlsx`) is also required by the customer for these two files.

To generate the Excel version of these files, you can use the [Sheet converter](https://github.com/oat-sa/sheet-converter)