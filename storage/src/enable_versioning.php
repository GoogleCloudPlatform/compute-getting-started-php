<?php
/**
 * Copyright 2021 Google LLC
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

# [START storage_enable_versioning]
use Google\Cloud\Storage\StorageClient;

/**
 * @param string $bucketName the name of your Cloud Storage bucket.
 */
function enable_versioning($bucketName)
{
    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);
    $bucket->update([
        'versioning' => [
            'enabled' => true,
        ]
    ]);

    printf('Versioning is now enabled for bucket %s', $bucketName);
}
# [END storage_enable_versioning]

require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
