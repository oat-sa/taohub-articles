# Readme: Tao task scheduler

[RRULE](https://tools.ietf.org/html/rfc5545) standard is used to configure time and recurrence rule of each job.

## Install

```bash
$ composer require oat-sa/extension-tao-scheduler
```

## Usage

## attach a job:

```
use oat\taoScheduler\model\scheduler\SchedulerServiceInterface;
$schedulerService = $this->getServiceManager()->get(SchedulerServiceInterface::SERVICE_ID);
$schedulerService->attach(
    'FREQ=MONTHLY;COUNT=5',                     //Reccurrence rule (repeat monthly, 5 times)  
    new \DateTime('2017-12-12 20:00:00'),       //Start date (time of first execution) 
    ['taoExtension/ServiceName', 'methodName']  //Callback to be called.
);
```

Also cron notation may be used:
```
$schedulerService->attach(
    '* * * * *',                                //Reccurrence rule (repeat minutely)  
    new \DateTime('2017-12-12 20:00:00'),       //Start date (time of first execution) 
    ['taoExtension/ServiceName', 'methodName']  //Callback to be called.
);
```

_Note_: 
> You can use any instance of callable type as callback except functions. In case if object is used ([$object, 'method']) make sure that object is instance of `PhpSerializable`.  
> Class name of `oat\oatbox\action\Action` instance may be used as a callback

### detach a job:

```
use oat\taoScheduler\model\scheduler\SchedulerServiceInterface;
$schedulerService = $this->getServiceManager()->get(SchedulerServiceInterface::SERVICE_ID);
$schedulerService->detach(
    'FREQ=MONTHLY;COUNT=5',                     //Reccurrence rule (repeat monthly, 5 times)  
    new \DateTime('2017-12-12 20:00:00'),       //Start date (time of first execution) 
    ['taoExtension/ServiceName', 'methodName']  //Callback to be called.
);
```

All given parameters to `detach` function should be the same as in existing job.

### Run JobRunner

```
sudo -u www-data php index.php '\oat\taoScheduler\scripts\JobRunner' 1518006301 PT10S
```

- First parameter is a timestamp from which scheduler should start to look up scheduled tasks. 
All the tasks scheduled before this time will be ignored.

_Note_: 
> Scheduled tasks may be executed even if their start date is later than timestamp given to job runner because they may be recurred and their start date is just a time of the first occurrence      

If this parameter is omitted or less than 0 then start time will be taken from the storage (time of last seeking of scheduled job or time of last job runner iteration).  
If there is no last iteration time in the storage current timestamp will be used.

- Second parameter is time between Job Runner iterations. Default value is 60 seconds. This time may be longer than configured because execution of tasks found during current iteration may take some time. 

### Discover tasks to be run

```
sudo -u www-data php index.php '\oat\taoScheduler\scripts\tools\SchedulerHelper' show 1518097355 1518100955 
```

### Remove expired jobs from job storage (jobs which will not be executed anymore after given date):

```
sudo php index.php '\oat\taoScheduler\scripts\tools\SchedulerHelper' removeExpiredJobs false 1519890884 
```

- First parameter is dryrun mode. `false` by default. 
- Second parameter is time since which helper will try to find expired jobs (including given time). If parameter was not given then the last launch time of job runner will be used.

#### To run tasks through the task queue you may use `\oat\taoTaskQueue\scripts\tools\AddTaskToQueue` action.

_Note_: 
> taoScheduler does not require taoTaskQueue extension. Make sure that task queue is installed.
 
```php
use oat\taoTaskQueue\scripts\tools\AddTaskToQueue;
$schedulerService->attach(
    '*/5 * * * *',
    new DateTime('now', new \DateTimeZone('utc')),
    AddTaskToQueue::class,
    [ActionClassToBeRun::class, 'param 1', 'param2']
);
```

### Warnings

1. Configure JobRunner service with common rds storage in case if scheduler is going to be run on multiserver environment.
2. Please do not schedule tasks which execution of which requires a lot of resource or take long time. All the time/resources consuming tasks should create appropriate tasks in the task queue. Ideally scheduled tasks should do nothing except adding tasks to the task queue.
3. Use cron syntax in case if number of occurrences is not limited.
4. iCalendar syntax is more flexible but in case of large or unlimited number of repeats there may be performance issues. By default limit of repeats is 732. More information: https://github.com/simshaun/recurr