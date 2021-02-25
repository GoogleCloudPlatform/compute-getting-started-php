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

namespace Google\Cloud\Samples\Functions\FirebaseRemoteConfig\Test;

use Google\Auth\ApplicationDefaultCredentials;
use Google\Auth\CredentialsLoader;
use Google\Cloud\Logging\LoggingClient;
use Google\Cloud\TestUtils\CloudFunctionDeploymentTrait;
use Google\Cloud\TestUtils\EventuallyConsistentTestTrait;
use Google\Cloud\TestUtils\GcloudWrapper\CloudFunction;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\ExpectationFailedException;

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
    use EventuallyConsistentTestTrait;

    /** @var string */
    private static $entryPoint = 'firebaseRemoteConfig';

    /** @var string */
    private static $functionSignatureType = 'cloudevent';

    /** @var LoggingClient */
    private static $loggingClient;

    /** @var \GuzzleHttp\Client */
    private static $apiHttpClient;

    /**
     * Deploy the Cloud Function, called from DeploymentTrait::deployApp().
     *
     * Overrides CloudFunctionDeploymentTrait::doDeploy().
     */
    private static function doDeploy()
    {
        $project = self::requireEnv(
            'GOOGLE_PROJECT_ID'
        );

        $event = 'google.firebase.remoteconfig.update';

        return self::$fn->deploy([
            '--trigger-event' => $event
        ], '');
    }

    public function dataProvider()
    {
        $value = uniqid();
        return [
            [
                'label' => 'Shows update type',
                'key' => 'php_test',
                'value' => $value,
                'expected' => 'Update type: FORCED_UPDATE',
            ],
            [
                'label' => 'Shows update origin',
                'key' => 'php_test',
                'value' => $value,
                'expected' => 'Origin: REST_API',
            ],
        ];
    }

    /**
     * @dataProvider dataProvider
     */
    public function testFirebaseRemoteConfig(
        string $label,
        string $key,
        string $value,
        string $expected
    ): void {
        // Trigger config update.
        $objectUri = $this->updateRemoteConfig(
            $key,
            $value
        );

        // Give event and log systems a head start.
        // If log retrieval fails to find logs for our function within retry limit, increase sleep time.
        sleep(5);

        $fiveMinAgo = date(\DateTime::RFC3339, strtotime('-5 minutes'));
        $this->processFunctionLogs(self::$fn, $fiveMinAgo, function (\Iterator $logs) use ($expected, $label) {
            // Concatenate all relevant log messages.
            $actual = '';
            foreach ($logs as $log) {
                $info = $log->info();
                if (isset($info['textPayload'])) {
                    $actual .= $info['textPayload'];
                }
            }

            // Only testing one property to decrease odds the expected logs are
            // split between log requests.
            $this->assertStringContainsString($expected, $actual, $label);
        });
    }

    /**
     * Retrieve and process logs for the defined function.
     *
     * @param CloudFunction $fn function whose logs should be checked.
     * @param string $startTime RFC3339 timestamp marking start of time range to retrieve.
     * @param callable $process callback function to run on the logs.
     */
    private function processFunctionLogs(CloudFunction $fn, string $startTime, callable $process)
    {
        $projectId = self::requireEnv('GOOGLE_PROJECT_ID');

        if (empty(self::$loggingClient)) {
            self::$loggingClient = new LoggingClient([
                'projectId' => $projectId
            ]);
        }

        // Define the log search criteria.
        $logFullName = 'projects/' . $projectId . '/logs/cloudfunctions.googleapis.com%2Fcloud-functions';
        $filter = sprintf(
            'logName="%s" resource.labels.function_name="%s" timestamp>="%s"',
            $logFullName,
            $fn->getFunctionName(),
            $startTime
        );

        echo "\nRetrieving logs [$filter]...\n";

        // Check for new logs for the function.
        $attempt = 1;
        $this->runEventuallyConsistentTest(function () use ($filter, $process, &$attempt) {
            $entries = self::$loggingClient->entries(['filter' => $filter]);

            // If no logs came in try again.
            if (empty($entries->current())) {
                echo 'Logs not found, attempting retry #' . $attempt++ . PHP_EOL;
                throw new ExpectationFailedException('Log Entries not available');
            }
            echo 'Processing logs...' . PHP_EOL;

            $process($entries);
        }, $retries = 10);
    }

    /**
     * Update a value in Firebase Remote Config.
     *
     * @param string $key The key to update.
     * @param string $value The value to set the key to.
     *
     * @throws \RuntimeException
     */
    private function updateRemoteConfig(
        string $key,
        string $value
    ): void {
        $projectId = self::requireEnv('GOOGLE_PROJECT_ID');

        if (empty(self::$apiHttpClient)) {
            $credentials = ApplicationDefaultCredentials::getCredentials('https://www.googleapis.com/auth/cloud-platform');
            self::$apiHttpClient = CredentialsLoader::makeHttpClient($credentials, [
                'base_uri' => 'https://firebaseremoteconfig.googleapis.com/v1/projects/' . $projectId . '/remoteConfig'
            ]);
        }

        $json = [
            'parameters' => [
                $key => [
                    'defaultValue' => [
                        'value' => $value
                    ]
                ]
            ]
        ];
        $response = self::$apiHttpClient->put('', [
            'headers' => ['If-Match' => '*'],
            'json' => $json
        ]);
    }
}
