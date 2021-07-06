#!/bin/bash
# Copyright 2016 Google Inc.
#
# Licensed under the Apache License, Version 2.0 (the "License");
# you may not use this file except in compliance with the License.
# You may obtain a copy of the License at
#
#     http://www.apache.org/licenses/LICENSE-2.0
#
# Unless required by applicable law or agreed to in writing, software
# distributed under the License is distributed on an "AS IS" BASIS,
# WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
# See the License for the specific language governing permissions and
# limitations under the License.

set -ex

# install local version of php-cs-fixer 3.0 from composer.json
if [ -f "composer.json" ]; then
    # install composer dependencies
    composer -q install
fi

# run php-cs-fixer
PHP_CS_FIXER="php-cs-fixer"
if [ -f "vendor/bin/php-cs-fixer" ]; then
    PHP_CS_FIXER="vendor/bin/php-cs-fixer"
elif [ -f "./php-cs-fixer" ]; then
    PHP_CS_FIXER="./php-cs-fixer"
fi

PROJECT_ROOT="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/.."
DIR="${1:-$PROJECT_ROOT}"

$PHP_CS_FIXER fix --dry-run --diff --config="${PROJECT_ROOT}/.php_cs.dist" --path-mode=intersection $DIR
