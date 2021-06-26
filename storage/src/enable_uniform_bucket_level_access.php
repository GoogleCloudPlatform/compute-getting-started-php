<?php
/**
 * Copyright 2019 Google Inc.
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/storage/README.md
 */

namespace Google\Cloud\Samples\Storage;

# [START storage_enable_uniform_bucket_level_access]
use Google\Cloud\Storage\StorageClient;

/**
 * Enable uniform bucket-level access.
 *
 * @param string $bucketName Name of your Google Cloud Storage bucket.
 *
 * @return void
 */
function enable_uniform_bucket_level_access($bucketName)
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);
    $bucket->update([
        'iamConfiguration' => [
            'uniformBucketLevelAccess' => [
                'enabled' => true
            ],
        ]
    ]);
    printf('Uniform bucket-level access was enabled for %s' . PHP_EOL, $bucketName);
}
# [END storage_enable_uniform_bucket_level_access]
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
