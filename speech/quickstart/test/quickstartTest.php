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
class quickstartTest extends PHPUnit_Framework_TestCase
{
    public function testQuickstart()
    {
        if (!$projectId = getenv('GOOGLE_PROJECT_ID')) {
            $this->markTestSkipped('GOOGLE_PROJECT_ID must be set.');
        }

        $file = sys_get_temp_dir() . '/speech_quickstart.php';
        $contents = file_get_contents(__DIR__ . '/../quickstart.php');
        $contents = str_replace(
            ['YOUR_PROJECT_ID', '__DIR__'],
            [$projectId, sprintf('"%s/.."', __DIR__)],
            $contents
        );
        file_put_contents($file, $contents);

        // Invoke quickstart.php
        $results = include $file;

        // Make sure it looks correct
        $this->assertTrue(is_array($results));
        $this->assertEquals(1, count($results));
        $this->assertArrayHasKey('transcript', $results[0]);
        $this->assertArrayHasKey('confidence', $results[0]);
        $this->assertEquals('how old is the Brooklyn Bridge', $results[0]['transcript']);
        $this->assertTrue($results[0]['confidence'] > .9);

        $expectedOutput = <<<EOF
Transcription: how old is the Brooklyn Bridge
EOF;

        $this->expectOutputString($expectedOutput);
    }
}
