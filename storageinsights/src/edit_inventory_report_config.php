<?php
/**
 * Copyright 2024 Google Inc.
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

namespace Google\Cloud\Samples\StorageInsights;

# [START storageinsights_edit_inventory_report_config]
use Google\Cloud\StorageInsights\V1\StorageInsightsClient;
use Google\Protobuf\FieldMask;

/**
 * Update an existing inventory report config.
 * Example:
 * ```
 * edit_inventory_report_config($projectId, $bucketLocation, $inventoryReportConfigUuid);
 * ```
 *
 * @param string $projectId Your Google Cloud Project ID
 * @param string $bucketLocation The location of your bucket
 * @param string $inventoryReportConfigUuid The UUID of the inventory report config to edit
 */
function edit_inventory_report_config(
    string $projectId,
    string $bucketLocation,
    string $inventoryReportConfigUuid
): void {
    $storageInsightsClient = new StorageInsightsClient();

    $reportConfigName = $storageInsightsClient->reportConfigName($projectId, $bucketLocation, $inventoryReportConfigUuid);
    $reportConfig = $storageInsightsClient->getReportConfig($reportConfigName);

    // Set any other fields you want to update here
    $updatedReportConfig = $reportConfig->setDisplayName('Updated Display Name');
    $updateMask = new FieldMask([
        'paths' => ['display_name']
    ]);

    $storageInsightsClient->updateReportConfig($updateMask, $updatedReportConfig);

    printf('Edited inventory report config with name %s' . PHP_EOL, $reportConfigName);
}
# [END storageinsights_edit_inventory_report_config]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
