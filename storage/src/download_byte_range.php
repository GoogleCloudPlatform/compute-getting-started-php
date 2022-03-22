<?php
/**
 * Copyright 2016 Google Inc.
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

# [START storage_download_byte_range]
use Google\Cloud\Storage\StorageClient;

/**
 * Download an object from Cloud Storage and save it as a local file.
 *
 * @param string $bucketName The name of your Cloud Storage bucket.
 * @param string $objectName The name of your Cloud Storage object.
 * @param string $start_byte The starting byte at which to begin the download.
 * @param string $end_byte The ending byte at which to end the download.
 * @param string $destination The local destination to save the object.
 */
function download_byte_range($bucketName, $objectName, $start_byte, $end_byte, $destination)
{
    // $bucketName = 'my-bucket';
    // $objectName = 'my-object';
    // $start_byte = 1;
    // $end_byte = 5;
    // $destination = '/path/to/your/file';

    $storage = new StorageClient();
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object($objectName);
    $object->downloadToFile($destination, [
        'restOptions' => [
            'headers' => [
                'Range' => "bytes=$start_byte-$end_byte",
            ],
        ],
    ]);
    printf(
        'Downloaded gs://%s/%s to %s' . PHP_EOL,
        $bucketName,
        $objectName,
        basename($destination)
    );
}
# [END storage_download_byte_range]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
