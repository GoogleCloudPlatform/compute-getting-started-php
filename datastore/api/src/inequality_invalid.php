<?php
/**
 * Copyright 2023 Google Inc.
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

namespace Google\Cloud\Samples\Datastore;

use DateTime;
use Google\Cloud\Datastore\DatastoreClient;
use Google\Cloud\Datastore\EntityInterface;
use Google\Cloud\Datastore\EntityIterator;
use Google\Cloud\Datastore\Key;
use Google\Cloud\Datastore\Query\GqlQuery;
use Google\Cloud\Datastore\Query\Query;

/**
 * Create an invalid query with inequality filters on multiple properties.
 *
 * @param DatastoreClient $datastore
 * @return Query
 */
function inequality_invalid(DatastoreClient $datastore)
{
    // [START datastore_inequality_invalid]
    $query = $datastore->query()
        ->kind('Task')
        ->filter('priority', '>', 3)
        ->filter('created', '>', new DateTime('1990-01-01T00:00:00z'));
    // [END datastore_inequality_invalid]
    print_r($query);

    $result = $datastore->runQuery($query);
    $found = false;
    foreach ($result as $e) {
        $found = true;
    }

    if(!$found) {
        print("No records found.\n");
    }
}

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
