<?php
/**
 * Copyright 2017 Google Inc.
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

# [START vision_web_detection_gcs]
namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\VisionClient;
use Google\Cloud\Storage\StorageClient;

// $projectId = 'YOUR_PROJECT_ID';
// $bucketName = 'your-bucket-name'
// $objectName = 'your-object-name'

function detect_web_gcs($projectId, $bucketName, $objectName)
{
    $vision = new VisionClient([
        'projectId' => $projectId,
    ]);
    $storage = new StorageClient([
        'projectId' => $projectId,
    ]);

    # Fetch the storage object and annotate the image
    $object = $storage->bucket($bucketName)->object($objectName);
    $image = $vision->image($object, ['WEB_DETECTION']);
    $annotation = $vision->annotate($image);
    $web = $annotation->web();

    if ($web->pages()) {
        printf('%d Pages with matching images found:' . PHP_EOL, count($web->pages()));
        foreach ($web->pages() as $page) {
            printf('URL: %s' . PHP_EOL, $page->url());
        }
        print(PHP_EOL);
    }

    if ($web->matchingImages()) {
        printf('%d Full Matching Images found:' . PHP_EOL, count($web->matchingImages()));
        foreach ($web->matchingImages() as $matchingImage) {
            printf('URL: %s' . PHP_EOL, $matchingImage->url());
        }
        print(PHP_EOL);
    }

    if ($web->partialMatchingImages()) {
        printf('%d Partial Matching Images found:' . PHP_EOL, count($web->partialMatchingImages()));
        foreach ($web->partialMatchingImages() as $partialMatchingImage) {
            printf('URL: %s' . PHP_EOL, $partialMatchingImage->url());
        }
        print(PHP_EOL);
    }

    if ($web->entities()) {
        printf('%d Web Entities found:' . PHP_EOL, count($web->entities()));
        foreach ($web->entities() as $entity) {
            printf('Score: %f' . PHP_EOL, $entity->score());
            if (isset($entity->info()['description'])) {
                printf('Description: %s' . PHP_EOL, $entity->description());
            }
            printf(PHP_EOL);
        }
    }
}
# [END vision_web_detection_gcs]
