<?php
/**
 * Copyright 2020 Google LLC.
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

// Include Google Cloud dependendencies using Composer
require_once __DIR__ . '/../vendor/autoload.php';
if (count($argv) < 1) {
    return printf("Usage: php %s PROJECT_ID STRING\n", __FILE__);
}
list($_, $organizationId, $notificationConfigId) = $argv;

// [START scc_delete_notification_config]

use \Google\Cloud\SecurityCenter\V1\SecurityCenterClient;

/** Uncomment and populate these variables in your code */
// $organizationId = "{your-org-id}";
// $notificationConfigId = {"your-unique-id"};

$securityCenterClient = new SecurityCenterClient();
$organizationName = "organizations/" . $organizationId;
$notificationConfigName = $organizationName . "/notificationConfigs/" . $notificationConfigId;

try {
    $response = $securityCenterClient->deleteNotificationConfig($notificationConfigName);
    printf("Notification config was deleted");

} finally {
    $securityCenterClient->close();
}

// [END scc_delete_notification_config]