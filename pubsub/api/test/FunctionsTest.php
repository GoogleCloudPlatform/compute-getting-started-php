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

namespace Google\Cloud\Samples\PubSub;

use Google\Cloud\PubSub\PubSubClient;
use PHPUnit\Framework\TestCase;

/**
 * Unit Tests for BrowseTableCommand.
 */
class FunctionsTest extends TestCase
{
    public function testPubSubClient()
    {
        if (!$projectId = getenv('GOOGLE_PROJECT_ID')) {
            $this->markTestSkipped('No project ID');
        }

        $pubsub = require __DIR__ . '/../src/pubsub_client.php';

        $this->assertInstanceOf(PubSubClient::class, $pubsub);
    }
}
