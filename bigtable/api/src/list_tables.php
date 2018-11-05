<?php

/**
 * Copyright 2018 Google LLC.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/bigtable/api/README.md
 */

// Include Google Cloud dependendencies using Composer
require_once __DIR__ . '/../vendor/autoload.php';

if (count($argv) != 3) {
    return printf("Usage: php %s PROJECT_ID INSTANCE_ID" . PHP_EOL, __FILE__);
}
list($_, $project_id, $instance_id, $table_id) = $argv;
$location_id = isset($argv[4]) ? $argv[4] : 'us-east1-b';

// [START bigtable_list_tables]
use Google\Cloud\Bigtable\Admin\V2\BigtableInstanceAdminClient;
use Google\Cloud\Bigtable\Admin\V2\BigtableTableAdminClient;

use Google\Cloud\Bigtable\Admin\V2\Table;
use Google\Cloud\Bigtable\Admin\V2\ColumnFamily;
use Google\Cloud\Bigtable\Admin\V2\GcRule;
use Google\Cloud\Bigtable\Admin\V2\GcRule\Union as GcRuleUnion;
use Google\Cloud\Bigtable\Admin\V2\GcRule\Intersection as GcRuleIntersection;
use Google\Cloud\Bigtable\Admin\V2\ModifyColumnFamiliesRequest\Modification;

use Google\Cloud\Bigtable\Admin\V2\Table\View;
use Google\ApiCore\ApiException;
use Google\Protobuf\Duration;


/** Uncomment and populate these variables in your code */
// $project_id = 'The Google project ID';
// $instance_id = 'The Bigtable instance ID';
// $table_id = 'The Bigtable table ID';
// $location_id = 'The Bigtable region ID';

$instanceAdminClient = new BigtableInstanceAdminClient();
$tableAdminClient = new BigtableTableAdminClient();

$instanceName = $instanceAdminClient->instanceName($project_id, $instance_id);

printf("Listing Tables:" . PHP_EOL);
$tables = iterator_to_array($tableAdminClient->listTables($instanceName)->iterateAllElements());
if ($tables != []) {
    foreach ($tables as $table) {
        print($table->getName() . PHP_EOL);
    }
} else {
    print('No table exists in current project...' . PHP_EOL);
}
// [END bigtable_list_tables]