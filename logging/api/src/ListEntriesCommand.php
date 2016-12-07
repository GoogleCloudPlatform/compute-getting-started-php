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

namespace Google\Cloud\Samples\Logging;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ListEntriesCommand
 * @package Google\Cloud\Samples\Logging
 *
 * This command simply lists log messages.
 */
class ListEntriesCommand extends BaseCommand
{
    protected function configure()
    {
        $this
            ->setName('list-entries')
            ->setDescription('Lists log entries in the logger');
        $this->addCommonOptions();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $projectId = $input->getOption('project');
        $loggerName = $input->getOption('logger');
        $entries = list_entries($projectId, $loggerName);
        foreach ($entries as $entry) {
            /* @var $entry \Google\Cloud\Logging\Entry */
            printf(
                "%s : %s" . PHP_EOL,
                $entry->info()['timestamp'],
                $entry->info()['textPayload']
            );
        }
    }
}
