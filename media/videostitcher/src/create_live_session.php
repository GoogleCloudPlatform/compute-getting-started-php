<?php

/**
 * Copyright 2022 Google LLC.
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
 * For instructions on how to run the samples:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/master/media/videostitcher/README.md
 */

namespace Google\Cloud\Samples\Media\Stitcher;

// [START videostitcher_create_live_session]
use Google\Cloud\Video\Stitcher\V1\Client\VideoStitcherServiceClient;
use Google\Cloud\Video\Stitcher\V1\CreateLiveSessionRequest;
use Google\Cloud\Video\Stitcher\V1\LiveSession;

/**
 * Creates a live session. Live sessions are ephemeral resources that expire
 * after a few minutes.
 *
 * @param string $callingProjectId     The project ID to run the API call under
 * @param string $location             The location of the session
 * @param string $liveConfigId         The live config ID to use to create the
 *                                     live session
 */
function create_live_session(
    string $callingProjectId,
    string $location,
    string $liveConfigId
): void {
    // Instantiate a client.
    $stitcherClient = new VideoStitcherServiceClient();

    $parent = $stitcherClient->locationName($callingProjectId, $location);
    $liveConfig = $stitcherClient->liveConfigName($callingProjectId, $location, $liveConfigId);
    $liveSession = new LiveSession();
    $liveSession->setLiveConfig($liveConfig);

    // Run live session creation request
    $request = (new CreateLiveSessionRequest())
        ->setParent($parent)
        ->setLiveSession($liveSession);
    $response = $stitcherClient->createLiveSession($request);

    // Print results
    printf('Live session: %s' . PHP_EOL, $response->getName());
}
// [END videostitcher_create_live_session]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
