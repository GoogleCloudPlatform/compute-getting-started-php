<?php
/**
 * Copyright 2024 Google LLC
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
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/blob/main/pubsub/api/README.md
 */

namespace Google\Cloud\Samples\PubSub;

# [START pubsub_create_topic_with_schema_revisions]
use Google\Cloud\PubSub\PubSubClient;
use Google\Cloud\PubSub\Schema;

/**
 * Create a topic with schema revisions.
 *
 * @param string $projectId Your Google Cloud Project ID.
 * @param string $topicId Topic ID for the new topic.
 * @param string $schemaId Existing schema id
 * @param string $firstRevisionId Minimum revision Id
 * @param string $lastRevisionId Maximum revision Id
 * @param string $encoding Either BINARY or JSON
 */
function create_topic_with_schema_revisions(
    string $projectId,
    string $topicId,
    string $schemaId,
    string $firstRevisionId,
    string $lastRevisionId,
    string $encoding
) {
    $pubsub = new PubSubClient([
        'projectId' => $projectId,
    ]);

    $schema = $pubsub->schema($schemaId);

    $topic = $pubsub->createTopic($topicId, [
        'schemaSettings' => [
            'schema' => $schema,
            'encoding' => $encoding,
            'firstRevisionId' => $firstRevisionId,
            'lastRevisionId' => $lastRevisionId,
        ]
    ]);

    printf('Topic %s created', $topic->name());
}
# [END pubsub_create_topic_with_schema_revisions]
require_once __DIR__ . '/../../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
