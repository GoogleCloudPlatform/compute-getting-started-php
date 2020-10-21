<?php
/**
 * Copyright 2020 Google LLC.
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

declare(strict_types=1);

namespace Google\Cloud\Samples\Functions\HelloworldHttp\Test;

use Google\Cloud\TestUtils\CloudFunctionDeploymentTrait;
use GuzzleHttp\Exception\ClientException;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/TestCasesTrait.php';

/**
 * Class DeployTest.
 *
 * This test is not run by the CI system.
 *
 * To skip deployment of a new function, run with "GOOGLE_SKIP_DEPLOYMENT=true".
 * To skip deletion of the tested function, run with "GOOGLE_KEEP_DEPLOYMENT=true".
 */
class DeployTest extends TestCase
{
    use CloudFunctionDeploymentTrait;
    use TestCasesTrait;

    private static $name = 'uploadFile';

    public function testFunction(): void
    {
        foreach (self::cases() as $test) {
            $method = $test['method'];
            $resp = $this->client->$method('', [
                'multipart' => $test['multipart'],
            ]);
            $this->assertEquals($test['code'], $resp->getStatusCode(), $test['label'] . ' code:');
            $actual = trim((string) $resp->getBody());
            $this->assertContains($test['expected'], $actual, $test['label'] . ':');
        }
    }

    public function testErrorCases(): void
    {
        $actual = $actualCode = null;
        foreach (self::errorCases() as $test) {
            try {
                $method = $test['method'];
                $resp = $this->client->$method('', [
                    'multipart' => $test['multipart'],
                ]);

                $actual = $resp->getBody()->getContents();
                $actualCode = $resp->getStatusCode();
            } catch (ClientException $e) {
                // Expected exception, nothing to do here.
                $actual = $actualCode = $e->getMessage();
            } finally {
                print $actual . $actualCode;
                $this->assertContains($test['code'], $actualCode, $test['label'] . ' code:');
                $this->assertContains($test['expected'], $actual, $test['label'] . ':');
            }
        }
    }
}
