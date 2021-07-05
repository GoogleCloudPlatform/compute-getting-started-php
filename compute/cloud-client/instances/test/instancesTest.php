<?php
/**
 * Copyright 2021 Google LLC
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

namespace Google\Cloud\Samples\Compute;

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\TestUtils\TestTrait;
use PHPUnit\Framework\TestCase;

class instancesTest extends TestCase
{
    use TestTrait;

    private static $instanceName;
    private static $bucketName;
    private static $bucket;

    private const DEFAULT_ZONE = 'us-central1-a';

    public static function setUpBeforeClass(): void
    {
        self::$instanceName = sprintf('test-compute-instance-%s', rand());

        // Generate bucket name
        self::$bucketName = sprintf('test-compute-usage-export-bucket-%s', rand());

        // Setup new bucket for UsageReports
        $storage = new StorageClient([
            'projectId' => self::$projectId
        ]);

        self::$bucket = $storage->createBucket(self::$bucketName);
    }

    public static function tearDownAfterClass(): void
    {
        // Remove the bucket
        self::$bucket->delete();
    }

    public function testCreateInstance()
    {
        $output = $this->runFunctionSnippet('create_instance', [
            'projectId' => self::$projectId,
            'zone' => self::DEFAULT_ZONE,
            'instanceName' => self::$instanceName
        ]);
        $this->assertStringContainsString('Created instance ' . self::$instanceName, $output);
    }

    /**
     * @depends testCreateInstance
     */
    public function testListInstances()
    {
        $output = $this->runFunctionSnippet('list_instances', [
            'projectId' => self::$projectId,
            'zone' => self::DEFAULT_ZONE,
        ]);
        $this->assertStringContainsString(self::$instanceName, $output);
    }

    /**
     * @depends testCreateInstance
     */
    public function testListAllInstances()
    {
        $output = $this->runFunctionSnippet('list_all_instances', [
            'projectId' => self::$projectId
        ]);
        $this->assertStringContainsString(self::$instanceName, $output);
        $this->assertStringContainsString(self::DEFAULT_ZONE, $output);
    }

    /**
     * @depends testCreateInstance
     */
    public function testDeleteInstance()
    {
        $output = $this->runFunctionSnippet('delete_instance', [
            'projectId' => self::$projectId,
            'zone' => self::DEFAULT_ZONE,
            'instanceName' => self::$instanceName,
        ]);
        $this->assertStringContainsString('Deleted instance ' . self::$instanceName, $output);
    }

    public function testSetUsageExportBucketDefaultPrefix()
    {
        // Check default value behaviour for setter
        $output = $this->runFunctionSnippet('set_usage_export_bucket', [
            'projectId' => self::$projectId,
            'bucketName' => self::$bucketName
        ]);

        $this->assertStringContainsString('default value of `usage_gce`', $output);
        $this->assertStringContainsString('project `' . self::$projectId . '`', $output);
        $this->assertStringContainsString('bucket_name = `' . self::$bucketName . '`', $output);
        $this->assertStringContainsString('report_name_prefix = `usage_gce`', $output);

        // Check default value behaviour for getter
        $output = $this->runFunctionSnippet('get_usage_export_bucket', [
            'projectId' => self::$projectId
        ]);
        $this->assertStringContainsString('default value of `usage_gce`', $output);
        $this->assertStringContainsString('project `' . self::$projectId . '`', $output);
        $this->assertStringContainsString('bucket_name = `' . self::$bucketName . '`', $output);
        $this->assertStringContainsString('report_name_prefix = `usage_gce`', $output);

        // Disable usage exports
        $output = $this->runFunctionSnippet('disable_usage_export_bucket', [
            'projectId' => self::$projectId,
        ]);
        $this->assertStringContainsString('project `' . self::$projectId . '` disabled', $output);

        $output = $this->runFunctionSnippet('get_usage_export_bucket', [
            'projectId' => self::$projectId,
        ]);
        $this->assertStringContainsString('project `' . self::$projectId . '` is disabled', $output);
    }

    public function testSetUsageExportBucketCustomPrefix()
    {
        // Set custom prefix
        $customPrefix = "my-custom-prefix";

        // Check user value behaviour for setter
        $output = $this->runFunctionSnippet('set_usage_export_bucket', [
            'projectId' => self::$projectId,
            'bucketName' => self::$bucketName,
            'reportNamePrefix' => $customPrefix
        ]);

        $this->assertStringNotContainsString('default value of `usage_gce`', $output);
        $this->assertStringContainsString('project `' . self::$projectId . '`', $output);
        $this->assertStringContainsString('bucket_name = `' . self::$bucketName . '`', $output);
        $this->assertStringContainsString('report_name_prefix = `' . $customPrefix . '`', $output);

        // Check user value behaviour for getter
        $output = $this->runFunctionSnippet('get_usage_export_bucket', [
            'projectId' => self::$projectId,
        ]);
        $this->assertStringNotContainsString('default value of `usage_gce`', $output);
        $this->assertStringContainsString('project `' . self::$projectId . '`', $output);
        $this->assertStringContainsString('bucket_name = `' . self::$bucketName . '`', $output);
        $this->assertStringContainsString('report_name_prefix = `' . $customPrefix . '`', $output);

        // Disable usage exports
        $output = $this->runFunctionSnippet('disable_usage_export_bucket', [
            'projectId' => self::$projectId,
        ]);
        $this->assertStringContainsString('project `' . self::$projectId . '` disabled', $output);

        $output = $this->runFunctionSnippet('get_usage_export_bucket', [
            'projectId' => self::$projectId,
        ]);
        $this->assertStringContainsString('project `' . self::$projectId . '` is disabled', $output);
    }
}
