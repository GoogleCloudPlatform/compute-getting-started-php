<?php
/**
 * Copyright 2018 Google LLC
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


namespace Google\Cloud\Samples\Asset;

use Google\Cloud\Storage\StorageClient;
use Google\Cloud\TestUtils\TestTrait;
use Google\Cloud\TestUtils\ExecuteCommandTrait;
use Google\Cloud\Core\Exception\NotFoundException;
use Google\Cloud\Core\Exception\BadRequestException;
use PHPUnit\Framework\TestCase;

/**
 * Unit Tests for asset commands.
 */
class assetTest extends TestCase
{
    use TestTrait;
    use ExecuteCommandTrait;

    private static $commandFile = __DIR__ . '/../asset.php';
    private static $projectId;
    private static $storage;
    private static $bucketName;
    private static $bucket;

    public static function setUpBeforeClass()
    {
        self::checkProjectEnvVars();
        self::$projectId = self::requireEnv('GOOGLE_PROJECT_ID');
        self::$storage = new StorageClient();
        self::$bucketName = 'assets-bucket-' . time();
        self::$bucket = self::$storage->createBucket(self::$bucketName);
    }

    public static function tearDownAfterClass()
    {
        self::$bucket->delete();
    }

    public function testExportAssets()
    {
        $fileName = 'my-assets.txt';
        $dumpFilePath = 'gs://' . self::$bucketName . '/' . $fileName;
        $output = $this->runCommand('export', [
            'project' => self::$projectId,
            'filePath' => $dumpFilePath,
          ]);
        $assetFile = self::$bucket->object($fileName);
        $this->assertEquals($assetFile->name(), $fileName);
        $assetFile->delete();
    }

    public function testBatchGetAssetsHistory()
    {
        $assetName = '//storage.googleapis.com/' . self::$bucketName;
        $assetNames = array('//storage.googleapis.com/' . self::$bucketName);
        $output = $this->runCommand('batch-get-history', [
            'project' => self::$projectId,
            'assetNames' => $assetNames,
          ]);
        if ($output != '')
        {
            $this->assertContains($assetName, $output);
        }
    }

}
