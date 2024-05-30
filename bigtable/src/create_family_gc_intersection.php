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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/bigtable/README.md
 */

namespace Google\Cloud\Samples\Bigtable;

// [START bigtable_create_family_gc_intersection]
use Google\Cloud\Bigtable\Admin\V2\Client\BigtableTableAdminClient;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;
use Google\Cloud\Bigtable\Admin\V2\GcRule\Intersection as GcRuleIntersection;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest\Modification;
use Google\Protobuf\Duration;

/**
 * Create a new column family with an intersection GC rule
 *
 * @param string $projectId The Google Cloud project ID
 * @param string $instanceId The ID of the Bigtable instance where the table resides
 * @param string $tableId The ID of the table in which the rule needs to be created
 */
function create_family_gc_intersection(
    string $projectId,
    string $instanceId,
    string $tableId
): void {
    $tableAdminClient = new BigtableTableAdminClient();

    $tableName = $tableAdminClient->tableName($projectId, $instanceId, $tableId);

    print('Creating column family cf4 with Intersection GC rule...' . PHP_EOL);
    $columnFamily4 = new ColumnFamily();

    $intersectionRule = new GcRuleIntersection();
    $intersectionArray = [
        (new GcRule())->setMaxAge((new Duration())->setSeconds(3600 * 24 * 5)),
        (new GcRule())->setMaxNumVersions(2)
    ];
    $intersectionRule->setRules($intersectionArray);

    $intersection = new GcRule();
    $intersection->setIntersection($intersectionRule);

    $columnFamily4->setGCRule($intersection);

    $columnModification = new Modification();
    $columnModification->setId('cf4');
    $columnModification->setCreate($columnFamily4);
    $modifyColumnFamiliesRequest = (new ModifyColumnFamiliesRequest())
        ->setName($tableName)
        ->setModifications([$columnModification]);
    $tableAdminClient->modifyColumnFamilies($modifyColumnFamiliesRequest);

    print('Created column family cf4 with Union GC rule' . PHP_EOL);
}

// [END bigtable_create_family_gc_intersection]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
