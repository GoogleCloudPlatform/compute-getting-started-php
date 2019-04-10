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
namespace Google\Cloud\Samples\VideoIntelligence;

use PHPUnit\Framework\TestCase;
use Google\Cloud\TestUtils\TestTrait;
use Google\Cloud\TestUtils\ExecuteCommandTrait;

/**
 * Unit Tests for video commands.
 */
class videoTest extends TestCase
{
    use TestTrait;
    use ExecuteCommandTrait;

    private static $commandFile = __DIR__ . '/../video.php';

    public function setUp()
    {
        $this->useResourceExhaustedBackoff();
    }

    public function testAnalyzeLabels()
    {
        $output = $this->runCommand('labels', [
            'uri' => $this->gcsUri(),
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('cat', $output);
        $this->assertContains('Video label description', $output);
        $this->assertContains('Shot label description', $output);
        $this->assertContains('Category', $output);
        $this->assertContains('Segment', $output);
        $this->assertContains('Shot', $output);
        $this->assertContains('Confidence', $output);
    }

    public function testAnalyzeLabelsInFile()
    {
        $output = $this->runCommand('labels-in-file', [
            'file' => __DIR__ . '/data/cat_shortened.mp4',
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('cat', $output);
        $this->assertContains('Video label description:', $output);
        $this->assertContains('Shot label description:', $output);
        $this->assertContains('Category:', $output);
        $this->assertContains('Segment:', $output);
        $this->assertContains('Shot:', $output);
        $this->assertContains('Confidence:', $output);
    }

    public function testAnalyzeExplicitContent()
    {
        $output = $this->runCommand('explicit-content', [
            'uri' => $this->gcsUri(),
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('pornography:', $output);
    }

    public function testAnalyzeShots()
    {
        $output = $this->runCommand('shots', [
            'uri' => $this->gcsUri(),
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('Shot:', $output);
        $this->assertContains(' to ', $output);
    }

    public function testTranscription()
    {
        $output = $this->runCommand('transcription', [
            'uri' => $this->gcsUriTwo(),
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('Transcript:', $output);
        $this->assertContains('Paris', $output);
        $this->assertContains('France', $output);
    }

    public function testAnalyzeText()
    {
        $output = $this->runCommand('text-detection', [
            'uri' => $this->gcsUriTwo(),
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('GOOGLE', $output);
        $this->assertContains('Video text description:', $output);
        $this->assertContains('Segment:', $output);
        $this->assertContains('Confidence:', $output);
    }

    public function testAnalyzeTextInFile()
    {
        $output = $this->runCommand('text-detection-file', [
            'file' => __DIR__ . '/data/googlework_short.mp4',
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('GOOGLE', $output);
        $this->assertContains('Video text description:', $output);
        $this->assertContains('Segment:', $output);
        $this->assertContains('Confidence:', $output);
    }

    public function testObjectTracking()
    {
        $output = $this->runCommand('object-tracking', [
            'uri' => $this->gcsUriTwo(),
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('/m/01g317', $output);
        $this->assertContains('person', $output);
    }

    public function testObjectTrackingFile()
    {
        $output = $this->runCommand('object-tracking-file', [
            'file' => __DIR__ . '/data/googlework_short.mp4',
            '--polling-interval-seconds' => 10,
        ]);
        $this->assertContains('/m/01g317', $output);
        $this->assertContains('person', $output);
    }

    private function gcsUri()
    {
        return sprintf(
            'gs://%s/video/cat_shortened.mp4',
            $this->requireEnv('GOOGLE_STORAGE_BUCKET')
        );
    }

    private function gcsUriTwo()
    {
        return sprintf(
            'gs://%s/video/googlework_short.mp4',
            $this->requireEnv('GOOGLE_STORAGE_BUCKET')
        );
    }
}
