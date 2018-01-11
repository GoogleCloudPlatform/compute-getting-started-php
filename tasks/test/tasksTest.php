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

namespace Google\Cloud\Samples\Tasks\Tests;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use PHPUnit\Framework\TestCase;

/**
 * Unit Tests for tasks commands.
 */
class tasksTest extends TestCase
{
    protected static $hasCredentials;
    protected static $project;
    protected static $queue;
    protected static $location;


    public static function setUpBeforeClass()
    {
        $path = getenv('GOOGLE_APPLICATION_CREDENTIALS');
        self::$hasCredentials = $path && file_exists($path) &&
            filesize($path) > 0;
        self::$project = getenv('GOOGLE_CLOUD_PROJECT');
        self::$queue = getenv('CLOUD_TASKS_PULL_QUEUE');
        self::$location = getenv('CLOUD_TASKS_LOCATION');
    }

    public function setUp()
    {
        if (!self::$hasCredentials) {
            $this->markTestSkipped('No application credentials were found. Please set the GOOGLE_APPLICATION_CREDENTIALS environment variable.');
        } elseif (!self::$project) {
            $this->markTestSkipped('No project ID was found. Please set the GOOGLE_CLOUD_PROJECT environment variable.');
        } elseif (!self::$queue) {
            $this->markTestSkipped('No Pull Queue was found. Please set the CLOUD_TASKS_PULL_QUEUE environment variable.');
        } elseif (!self::$location) {
            $this->markTestSkipped('No location was found. Please set the CLOUD_TASKS_LOCATION environment variable.');
        }
    }

    public function testCreateTask()
    {
        $output = $this->runCommand('create-task', [
            'project' => self::$project,
            'queue' => self::$queue,
            'location' => self::$location
        ]);
        $taskNamePrefix = sprintf('projects/%s/locations/%s/queues/%s/tasks/',
            self::$project,
            self::$location,
            self::$queue
        );
        $expectedOutput = sprintf('Created task %s', $taskNamePrefix);
        $this->assertContains($expectedOutput, $output);
    }

    public function testPullAndAcknowledgeTask()
    {
        $output = $this->runCommand('pull-and-acknowledge-task', [
            'project' => self::$project,
            'queue' => self::$queue,
            'location' => self::$location
        ]);

        $taskNamePrefix = sprintf('projects/%s/locations/%s/queues/%s/tasks/',
            self::$project,
            self::$location,
            self::$queue
        );
        $expectedPullTaskOutput = sprintf('Pulled task %s', $taskNamePrefix);
        $this->assertContains($expectedPullTaskOutput, $output);
        $expectedAcknowledgeTaskOutput = sprintf('Acknowledged task %s', $taskNamePrefix);
        $this->assertContains($expectedAcknowledgeTaskOutput, $output);
    }

    private function runCommand($commandName, $args)
    {
        $application = require __DIR__ . '/../tasks.php';
        $command = $application->get($commandName);
        $commandTester = new CommandTester($command);

        ob_start();
        $commandTester->execute(
            $args,
            ['interactive' => false]);
        return ob_get_clean();
    }
}
