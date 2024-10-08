#!/usr/bin/env bash

set -e
set -x
set -o pipefail

docker build --tag momento-php-redis-dev .
