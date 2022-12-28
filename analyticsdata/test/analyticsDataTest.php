<?php
/**
 * Copyright 2022 Google Inc.
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

namespace Google\Cloud\Samples\Analytics\Data\Tests;

use Google\ApiCore\ValidationException;
use Google\Cloud\TestUtils\TestTrait;
use PHPUnit\Framework\TestCase;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

class analyticsDataTest extends TestCase
{
    use TestTrait;

    public function testRunReport()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testClientFromJsonCredentials()
    {
        $jsonCredentials = self::requireEnv('GOOGLE_APPLICATION_CREDENTIALS');
        $this->runFunctionSnippet('client_from_json_credentials', [$jsonCredentials]);

        $client = $this->getLastReturnedSnippetValue();

        $this->assertInstanceOf(BetaAnalyticsDataClient::class, $client);

        try {
            $this->runFunctionSnippet('client_from_json_credentials', ['does-not-exist.json']);
            $this->fail('Non-existant json credentials should throw exception');
        } catch (ValidationException $ex) {
            $this->assertStringContainsString('does-not-exist.json', $ex->getMessage());
        }
    }

    public function testRunReportWithDimensionAndMetricFilters()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_dimension_and_metric_filters', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithDimensionFilter()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_dimension_filter', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithMultipleDimensionFilters()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_multiple_dimension_filters', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithMultipleMetrics()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_multiple_metrics', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithNamedDateRanges()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_named_date_ranges', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithMultipleDimensions()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_multiple_dimensions', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithDateRanges()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_date_ranges', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithCohorts()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_cohorts', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }

    public function testRunReportWithAggregations()
    {
        $propertyId = self::requireEnv('GA_TEST_PROPERTY_ID');
        $output = $this->runFunctionSnippet('run_report_with_aggregations', [$propertyId]);

        $this->assertStringContainsString('Report result', $output);
    }
}
