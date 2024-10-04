# Welcome to Momento php-redis drop-in replacement

Welcome to the Momento PHP-Redis Drop-in Replacement package! This package is a wrapper around the PHP-Redis extension that allows integration with Momento's caching service. You can use this as a direct replacement for PHP-Redis, while leveraging the benefits of Momento's serverless cache.

## Pre-requisites

Before running the integration tests, ensure that the Momento API Key is available in your environment. If you don't have one, you can get it from the  [Momento Console](https://console.gomomento.com).
Additionally, create a .env file at the root of the project with the following contents:

```bash
TEST_REDIS=true # false if you would like to use momento
REDIS_HOST="127.0.0.1" # Redis host
REDIS_PORT=6379 # Redis port
TEST_CACHE_NAME="test-cache" # Cache name
```

## Installation

To set up the integration tests, you'll need two Docker containers: one for running Redis and the other for running the integration tests.

### Step 1: Set Up Redis Docker Container

- Run the following command to start a Redis container:

```bash
docker run -it --name my-redis -d -p 6379:6379 redis
```

- Retrieve the IP address of the Redis container:

```bash
docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' my-redis
```

- Update the `REDIS_HOST` field in your `.env` file with the Redis container's IP address.

### Step 2: Build and Run the Integration Test Docker Container

- Build the Docker image for running the integration tests using the provided script:

```bash
./dev-docker-build.sh
```

- Run the Docker container for integration tests:

```bash
docker run -it -v $(pwd):/app -w /app momento-php-dev /bin/bash
```

- Inside the Docker container, execute the integration tests:
    
```bash
./vendor/bin/phpunit tests/MomentoRedisClientTest.php
```
