<?php
/**
 * Copyright 2019 Google LLC.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/firestore/README.md
 */

namespace Google\Cloud\Samples\Firestore;

use Google\Cloud\Firestore\FirestoreClient;

/**
 * Returns a total count across all shards of distributed counter.
 * ```
 * get_distributed_counter_value('your-project-id');
 * ```
 */
function get_distributed_counter_value($projectId)
{
    // Create the Cloud Firestore client
    $db = new FirestoreClient([
        'projectId' => $projectId,
    ]);
    # [START firestore_solution_sharded_counter_get]
    $result = 0;
    $docCollection = $db->collection('samples/php/distributedCounters')->documents();
    foreach ($docCollection as $doc) {
        $result += $doc->data()['Cnt'];
    }
    # [END firestore_solution_sharded_counter_get]
    printf('The current value of the distributed counter: %d' . PHP_EOL, $result);
}

require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
