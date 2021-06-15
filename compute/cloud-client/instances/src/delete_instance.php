<?php
/**
 * Copyright 2021 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/compute/cloud-client/README.md
 */

namespace Google\Cloud\Samples\Compute;

# [START compute_instances_delete]
use Google\Cloud\Compute\V1\InstancesClient;
# [START compute_instances_operation_check]
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\ZoneOperationsClient;

# [END compute_instances_operation_check]

/**
 * Delete an instance.
 * Example:
 * ```
 * delete_instance($projectId, $zone, $instanceName);
 * ```
 *
 * @param string $projectId Your Google Cloud project ID.
 * @param string $zone Zone where the instance you want to delete is (like "us-central1-a").
 * @param string $instanceName Unique name for the Compute instance to delete.
 *
 * @throws \Google\ApiCore\ApiException if the remote call fails.
 */
function delete_instance(
    string $projectId,
    string $zone,
    string $instanceName
) {
    // Delete the Compute Engine instance using InstancesClient.
    $instancesClient = new InstancesClient();
    $operation = $instancesClient->delete($instanceName, $projectId, $zone);

    # [START compute_instances_operation_check]
    if ($operation->getStatus() === Operation\Status::RUNNING) {
        // Wait for the operation to complete.
        $operationClient = new ZoneOperationsClient();

        // Default timeout of 60 s is not always enough for operation to finish,
        // to avoid an exception we set timeout to 180000 ms = 180 s = 3 minutes
        $optionalArgs = ['timeoutMillis' => 180000];
        $operationClient->wait($operation->getName(), $projectId, $zone, $optionalArgs);
    }
    # [END compute_instances_operation_check]

    printf('Deleted instance %s' . PHP_EOL, $instanceName);
}
# [END compute_instances_delete]

require_once __DIR__ . '/../../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
