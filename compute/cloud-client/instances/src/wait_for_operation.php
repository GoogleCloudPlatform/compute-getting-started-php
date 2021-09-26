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

# [START compute_instances_operation_check]
use Google\Cloud\Compute\V1\Operation;
use Google\Cloud\Compute\V1\ZoneOperationsClient;

/**
 * This method waits for an operation to be completed. Calling this function
 * will block until the operation is finished.
 *
 * @param Operation $operation The Operation object representing the operation you want to
wait on.
 * @param string $projectId Your Google Cloud project ID.
 * @param string $zone Zone where the instance you want to delete is (like "us-central1-a").
 *
 * @throws \Google\ApiCore\ApiException if the remote call fails.
 * @return Operation Finished Operation object.
 */
function wait_for_operation(
    Operation $operation,
    string $projectId,
    string $zone
): Operation {
    $operationClient = new ZoneOperationsClient();

    while ($operation->getStatus() != Operation\Status::DONE) {
        // Wait for the operation to complete.
        $operation = $operationClient->wait($operation->getName(), $projectId, $zone);

        if ($operation->hasError()) {
            printf('Operation failed with error(s): %s' . PHP_EOL, $operation->getError()->serializeToString());
            return $operation;
        }
    }

    print('Operation successful' . PHP_EOL);
    return $operation;
}
# [END compute_instances_operation_check]
