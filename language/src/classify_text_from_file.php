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

/**
 * For instructions on how to run the full sample:
 *
 * @see https://github.com/GoogleCloudPlatform/php-docs-samples/tree/main/language/README.md
 */

namespace Google\Cloud\Samples\Language;

# [START language_classify_gcs]
use Google\Cloud\Language\V1\ClassifyTextRequest;
use Google\Cloud\Language\V1\Client\LanguageServiceClient;
use Google\Cloud\Language\V1\Document;
use Google\Cloud\Language\V1\Document\Type;

/**
 * @param string $uri The cloud storage object to analyze (gs://your-bucket-name/your-object-name)
 */
function classify_text_from_file(string $uri): void
{
    $languageServiceClient = new LanguageServiceClient();

    // Create a new Document, pass GCS URI and set type to PLAIN_TEXT
    $document = (new Document())
        ->setGcsContentUri($uri)
        ->setType(Type::PLAIN_TEXT);

    // Call the analyzeSentiment function
    $request = (new ClassifyTextRequest())
        ->setDocument($document);
    $response = $languageServiceClient->classifyText($request);
    $categories = $response->getCategories();
    // Print document information
    foreach ($categories as $category) {
        printf('Category Name: %s' . PHP_EOL, $category->getName());
        printf('Confidence: %s' . PHP_EOL, $category->getConfidence());
        print(PHP_EOL);
    }
}
# [END language_classify_gcs]

// The following 2 lines are only needed to run the samples
require_once __DIR__ . '/../../testing/sample_helpers.php';
\Google\Cloud\Samples\execute_sample(__FILE__, __NAMESPACE__, $argv);
