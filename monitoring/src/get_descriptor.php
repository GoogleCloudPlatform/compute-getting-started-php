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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/monitoring/README.md
 */

namespace Google\Cloud\Samples\Monitoring;

// [START monitoring_get_descriptor]
use Google\Cloud\Monitoring\V3\Client\MetricServiceClient;
use Google\Cloud\Monitoring\V3\GetMetricDescriptorRequest;

/**
 * Example:
 * ```
 * get_descriptor($projectId);
 * ```
 *
 * @param string $projectId Your project ID
 * @param string $metricId  The ID of the Metric Descriptor to get
 */
function get_descriptor($projectId, $metricId)
{
    $metrics = new MetricServiceClient([
        'projectId' => $projectId,
    ]);

    $metricName = $metrics->metricDescriptorName($projectId, $metricId);
    $getMetricDescriptorRequest = (new GetMetricDescriptorRequest())
        ->setName($metricName);
    $descriptor = $metrics->getMetricDescriptor($getMetricDescriptorRequest);

    printf('Name: ' . $descriptor->getDisplayName() . PHP_EOL);
    printf('Description: ' . $descriptor->getDescription() . PHP_EOL);
    printf('Type: ' . $descriptor->getType() . PHP_EOL);
    printf('Metric Kind: ' . $descriptor->getMetricKind() . PHP_EOL);
    printf('Value Type: ' . $descriptor->getValueType() . PHP_EOL);
    printf('Unit: ' . $descriptor->getUnit() . PHP_EOL);
    printf('Labels:' . PHP_EOL);
    foreach ($descriptor->getLabels() as $labels) {
        printf(
            '  %s (%s) - %s' . PHP_EOL,
            $labels->getKey(),
            $labels->getValueType(),
            $labels->getDescription()
        );
    }
}
// [END monitoring_get_descriptor]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
