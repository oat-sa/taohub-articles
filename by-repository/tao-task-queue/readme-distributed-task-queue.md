# Readme: Distributed Task Queue

> This article describes the functioning of an ASYNC Task Queue.

## Install

You can add the Task Queue as a standard TAO extension to your current TAO instance.

```bash
 $ composer require oat-sa/extension-tao-task-queue
```

### Queue component{#queue-component}

Queue can work with different types of queue brokers, here two types are to accomplish ASYNC mechanism:
- **RdsQueueBroker** which stores tasks in RDS.
- **SqsQueueBroker** which is for using AWS SQS.

_Note_: 
> When SqsQueueBroker is used, please make sure that "**oat-sa/lib-generis-aws**" is included in the main composer.json and you have 
> generis/awsClient.conf.php properly configured.

#### Weight{#weight}

A Queue can have a weight. If multiple Queues are in use, this weight will be used for randomly select a Queue to be consumed. 
For example, if QueueA has weight of 1 and QueueB has weight of 2, then QueueB has about a 66% chance of being selected.

### Worker component{#worker-component}

Here we have a so called `LongRunningWorker` which can run unlimited time.
It has built-in signal handling for the following actions:
 - Shutting down the worker gracefully: SIGTERM/SIGINT/SIGQUIT
 - Pausing task processing: SIGUSR2
 - Resuming task processing: SIGCONT

_Note_: 
> Multiple workers can be run at the same time.
 
After processing the given task, the worker saves the generated report for the task through the Task Log.


## Service setup examples{#service-setup-examples}

## Multiple Queues settings

In this case we have 3 Queues registered: one of them is using SQS broker, the other two RDS. 
Every Queue has its own weight (like 90, 30, 10) which will be used at selecting the next queue to be consumed.

And we have two tasks linked to different queues, furthermore the default queue is specified ('background')
what will be used for every other tasks not defined in OPTION_TASK_TO_QUEUE_ASSOCIATIONS.

```php
use oat\tao\model\taskQueue\QueueDispatcher;
use oat\tao\model\taskQueue\Queue;
use oat\taoTaskQueue\model\QueueBroker\RdsQueueBroker;
use oat\taoTaskQueue\model\QueueBroker\SqsQueueBroker;
use oat\tao\model\taskQueue\TaskLogInterface;
use oat\tao\model\taskQueue\QueueDispatcherInterface;

$queueService = new QueueDispatcher(array(
    QueueDispatcherInterface::OPTION_QUEUES => [
        new Queue('priority', new SqsQueueBroker('default', \common_cache_Cache::SERVICE_ID, 10), 90),
        new Queue('standard', new RdsQueueBroker('default', 5), 30),
        new Queue('background', new RdsQueueBroker('default', 5), 10)
    ],
    QueueDispatcherInterface::OPTION_TASK_LOG     => TaskLogInterface::SERVICE_ID,
    QueueDispatcherInterface::OPTION_TASK_TO_QUEUE_ASSOCIATIONS => [
        SomeImportantAction::class => 'priority',
        SomeLessImportantTask::class => 'standard'
    ]
));

$queueService->setOption(QueueDispatcherInterface::OPTION_DEFAULT_QUEUE, 'background');

$this->getServiceManager()->register(QueueDispatcherInterface::SERVICE_ID, $queueService);
```

If the queue has not been initialized, meaning the required queue container has not been created yet:
```php
try {
    $queueService->initialize();
} catch (\Exception $e) {
    return \oat\oatbox\reporting\Report::createError('Initializing queues failed');
}
```

### Initializing the queues and the task log container{#initializing-the-queues-and-the-task-log-container}

You can run this script if you want to be sure that the required queues and the task log container are created.

```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\InitializeQueue'
```

_Note_:
> This script also can be used to change the current queues to use a different queue broker.

- Changing every existing queue to use InMemoryQueueBroker. (Sync Queue)
```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\InitializeQueue' --broker=memory
```

- Changing every existing queue to use RdsQueueBroker. 
Option "persistence" is required, "receive" (Maximum amount of tasks that can be received when polling the queue) is optional.
```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\InitializeQueue' --broker=rds --persistence=default --receive=10
```

- Changing every existing queue to use SqsQueueBroker. Option "aws-profile" is required, "receive" is optional.
```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\InitializeQueue' --broker=sqs --aws-profile=default --receive=10
```

- If you want to apply the settings above for a specific queue, you can add `--queue=...` option to the command. In the following case, only `myQueue` will be modified.
```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\InitializeQueue' --queue=myQueue --broker=rds --persistence=default --receive=10
```


- Setting a task selector strategy.
```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\InitializeQueue' --strategy="\oat\taoTaskQueue\model\TaskSelector\StrictPriorityStrategy"
```

### Running a worker{#running-a-worker}

To run a worker, use the following command. It will start a worker for running infinitely and iterating over every registered Queues based in their weights.

```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\RunWorker'
```

If you want the worker running for a dedicated Queue, pass the name of the queue to the command like this:

```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\RunWorker' --queue=priority
```

You can limit the iteration of the worker. It can be used only on a dedicated queue.

```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\RunWorker' --queue=standard --limit=5
```

If you want to associate specyfic task to new queue you can use this command:
```bash
 $ sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\ManageAssociationMap' \
      -t  '{ you fully qualified task class name }' -q queue-name
```
Next time when defined task will be created, it will be assign to specified queue. 

### Summarize stuck tasks{#summarize-stuck-tasks}

Execute this command if you want to summarize stuck tasks. Example: 

```shell
sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\StuckTaskSummary' \
--queue indexation_queue \
--age 300 \
--whitelist "oat\tao\model\search\tasks\UpdateResourceInIndex,oat\tao\model\search\tasks\UpdateClassInIndex"
```

### Restart stuck tasks{#restart-stuck-tasks}

Execute this command if you want to restart stuck tasks. Example: 

```shell
sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\StuckTaskRestart' \
--queue indexation_queue \
--age 300 \
--whitelist "oat\tao\model\search\tasks\UpdateResourceInIndex,oat\tao\model\search\tasks\UpdateClassInIndex"
```

## Rest API{#rest-api}

The task log reports can be viewed/consume using the Application Programming Interface (API).
In order to use it please check the swagger file in (doc/taskApi.yml).

## Command Line Utility{#command-line-utility}

Besides using the API to check reports of tasks, another way it's using the command line. 
```bash
sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\TaskLogUtility' --help
```
This command will show you all the possibilities action the the utility can have.

```text
Examples
 1. Stats
	 Description: 	 Return stats about the tasks logs statuses
	 Example: 	 sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\TaskLogUtility' --stats
 2. List Task Logs
	 Description: 	 List All the tasks that are not archived will be retrived, default limit is 20
	 Example: 	 sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\TaskLogUtility' --available --limit[optional]=20 --offset[optional]=10
 3. Get Task Log
	 Description: 	 Get an specific task log by id
	 Example: 	 sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\TaskLogUtility' --get-task=[taskdId]
 4. Archive a Task Log
	 Description: 	 Archive a task log
	 Example: 	 sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\TaskLogUtility' --archive=[taskdId] --force[optional]
 5. Cancel a Task Log
	 Description: 	 Cancel a task log
	 Example: 	 sudo -u www-data php index.php 'oat\taoTaskQueue\scripts\tools\TaskLogUtility' --cancel=[taskdId] --force[optional]
```