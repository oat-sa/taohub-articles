# Readme: TAO Aggregated statistics

This extension contains services for creating and maintaining aggregated statistics.

## Usages:{#usages}

Using `MonitoringPlugService` you can configure which statistics will be logged.

```php
<?php
/**
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; under version 2
 * of the License (non-upgradable).
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * Copyright (c) 2017 (original work) Open Assessment Technologies SA (under the project TAO-PRODUCT);
 *
 */

namespace oat\tao\scripts\install;


use oat\oatbox\extension\InstallAction;
use oat\taoMonitoring\model\InstantActionQueueLog\InstantActionQueueLogService;
use oat\taoMonitoring\model\MonitoringPlugService;

/**
 * Install Action to register instant action log.
 */
class RegisterMonitoringPlugService extends InstallAction
{
    /**
     * @param $params
     * @return \common_report_Report
     * @throws \common_Exception
     * @throws \oat\oatbox\service\exception\InvalidServiceManagerException
     */
    public function __invoke($params)
    {
        $service = $this->getServiceManager()->get(MonitoringPlugService::SERVICE_ID);
        $service->setOption('services', [
            InstantActionQueueLogService::SERVICE_ID,
        ]);
        $this->getServiceManager()->register(MonitoringPlugService::SERVICE_ID, $service);

        return \common_report_Report::createSuccess('Monitoring plug service registered.');
    }
}
```