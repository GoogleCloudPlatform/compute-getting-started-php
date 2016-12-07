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

// Install composer dependencies with "composer install"
// @see http://getcomposer.org for more information.
require __DIR__ . '/vendor/autoload.php';

$app = require __DIR__ . '/app.php';

$app['sendgrid.sender'] = getenv('SENDGRID_SENDER');
$app['sendgrid.api_key'] = getenv('SENDGRID_API_KEY');

// Run the app!
// use "gcloud app deploy" or run "php -S localhost:8000"
$app['debug'] = true;
$app->run();
