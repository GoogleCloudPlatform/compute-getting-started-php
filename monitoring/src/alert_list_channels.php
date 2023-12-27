<?php
/**
 * Copyright 2018 Google Inc.
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

// [START monitoring_alert_list_channels]
use Google\Cloud\Monitoring\V3\Client\NotificationChannelServiceClient;
use Google\Cloud\Monitoring\V3\ListNotificationChannelsRequest;

/**
 * @param string $projectId Your project ID
 */
function alert_list_channels($projectId)
{
    $channelClient = new NotificationChannelServiceClient([
        'projectId' => $projectId,
    ]);
    $listNotificationChannelsRequest = (new ListNotificationChannelsRequest())
        ->setName($channelClient->projectName($projectId));

    $channels = $channelClient->listNotificationChannels($listNotificationChannelsRequest);
    foreach ($channels->iterateAllElements() as $channel) {
        printf('Name: %s (%s)' . PHP_EOL, $channel->getDisplayName(), $channel->getName());
    }
}
// [END monitoring_alert_list_channels]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
