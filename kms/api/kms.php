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
require __DIR__ . '/vendor/autoload.php';

use Google\Cloud\Samples\Kms\EncryptionCommand;
use Google\Cloud\Samples\Kms\IamCommand;
use Google\Cloud\Samples\Kms\KeyCommand;
use Google\Cloud\Samples\Kms\KeyRingCommand;
use Google\Cloud\Samples\Kms\VersionCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new EncryptionCommand());
$application->add(new IamCommand());
$application->add(new KeyCommand());
$application->add(new KeyRingCommand());
$application->add(new VersionCommand());
$application->run();
