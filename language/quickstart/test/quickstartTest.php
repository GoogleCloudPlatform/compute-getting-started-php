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
class quickstartTest extends PHPUnit_Framework_TestCase
{
    public function testQuickstart()
    {
        if (!$projectId = getenv('GOOGLE_PROJECT_ID')) {
            $this->markTestSkipped('GOOGLE_PROJECT_ID must be set.');
        }

        $file = sys_get_temp_dir() . '/language_quickstart.php';
        $contents = file_get_contents(__DIR__ . '/../quickstart.php');
        $contents = str_replace(
            ['YOUR_PROJECT_ID', '__DIR__'],
            [$projectId, sprintf('"%s/.."', __DIR__)],
            $contents
        );
        file_put_contents($file, $contents);

        // Invoke quickstart.php
        $sentiment = include $file;

        // Make sure it looks correct
        $this->assertTrue(is_array($sentiment));
        $this->assertArrayHasKey('polarity', $sentiment);
        $this->assertArrayHasKey('magnitude', $sentiment);
        $this->assertEquals(1, $sentiment['polarity']);
        $this->assertEquals(.6, $sentiment['magnitude']);

        $expectedOutput = <<<EOF
Text: Hello, world!
Sentiment: 1, 0.6
EOF;

        $this->expectOutputString($expectedOutput);
    }
}
