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

// [START vision_crop_hint_detection_gcs]
namespace Google\Cloud\Samples\Vision;

use Google\Cloud\Vision\VisionClient;

// $path = 'gs://path/to/your/image.jpg'

function detect_crop_hints_gcs($path)
{
    $vision = new VisionClient();
    # annotate the image
    $image = $vision->image($path, ['CROP_HINTS']);
    $annotations = $vision->annotate($image);
    # print the crop hints from the annotation
    if ($annotations) {
        print("Crop hints:" . PHP_EOL);
        foreach ($annotations->cropHints() as $key => $hint) {
            # get bounds
            $vertices = $hint->boundingPoly()['vertices'];
            $bounds = [];
            foreach ($vertices as $vertex) {
                # get (x, y) coordinates if available.
                $bounds[] = sprintf('(%d,%d)',
                    isset($vertex['x']) ? $vertex['x'] : 0,
                    isset($vertex['y']) ? $vertex['y'] : 0
                );
            }
            print('Bounds: ' . join(', ', $bounds) . PHP_EOL);
        }
    } else {
        print('No crop hints' . PHP_EOL);
    }
}
// [END vision_crop_hint_detection_gcs]