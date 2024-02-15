<?php
/**
 * Copyright 2016 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/monitoring/README.md
 */

namespace Google\Cloud\Samples\Monitoring;

// [START monitoring_uptime_check_create]
use Google\Api\MonitoredResource;
use Google\Cloud\Monitoring\V3\Client\UptimeCheckServiceClient;
use Google\Cloud\Monitoring\V3\CreateUptimeCheckConfigRequest;
use Google\Cloud\Monitoring\V3\UptimeCheckConfig;

/**
 * Example:
 * ```
 * create_uptime_check($projectId, 'myproject.appspot.com', 'Test Uptime Check!');
 * ```
 *
 * @param string $projectId Your project ID
 * @param string $hostName
 * @param string $displayName
 */
function create_uptime_check($projectId, $hostName = 'example.com', $displayName = 'New uptime check')
{
    $projectName = 'projects/' . $projectId;
    $uptimeCheckClient = new UptimeCheckServiceClient([
        'projectId' => $projectId,
    ]);

    $monitoredResource = new MonitoredResource();
    $monitoredResource->setType('uptime_url');
    $monitoredResource->setLabels(['host' => $hostName]);

    $uptimeCheckConfig = new UptimeCheckConfig();
    $uptimeCheckConfig->setDisplayName($displayName);
    $uptimeCheckConfig->setMonitoredResource($monitoredResource);
    $createUptimeCheckConfigRequest = (new CreateUptimeCheckConfigRequest())
        ->setParent($projectName)
        ->setUptimeCheckConfig($uptimeCheckConfig);

    $uptimeCheckConfig = $uptimeCheckClient->createUptimeCheckConfig($createUptimeCheckConfigRequest);

    printf('Created an uptime check: %s' . PHP_EOL, $uptimeCheckConfig->getName());
}
// [END monitoring_uptime_check_create]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
