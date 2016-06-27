<?php
/**
 * Copyright 2015 Google Inc. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *   http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
class listObjectsTest extends PHPUnit_Framework_TestCase
{
    protected static $hasCredentials;

    public static function setUpBeforeClass()
    {
        $path = getenv('GOOGLE_APPLICATION_CREDENTIALS');
        self::$hasCredentials = $path && file_exists($path) &&
            filesize($path) > 0;
    }

    public function test()
    {
        if (!self::$hasCredentials) {
            $this->markTestSkipped('No application credentials were found.');
        }

        if (!$bucketName = getenv('GOOGLE_BUCKET_NAME')) {
            $this->markTestSkipped('GOOGLE_BUCKET_NAME must be set.');
        }

        if (!$objectName = getenv('GOOGLE_OBJECT_NAME')) {
            $this->markTestSkipped('GOOGLE_OBJECT_NAME must be set.');
        }

        // Invoke listBuckets.php, and fake first argument.
        global $argc, $argv;
        $argv[1] = getenv('GOOGLE_PROJECT_ID');
        $argv[2] = $bucketName;

        // Capture stdout.
        ob_start();
        include __DIR__ . '/../listObjects.php';
        $result = ob_get_contents();
        ob_end_clean();

        // Make sure it looks correct
        $this->assertContains($objectName, $result);
    }
}
