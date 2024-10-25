## Pre-requisites

Before running the integration tests, ensure that the Momento API Key is available in your environment. If you don't
have one, you can get it from the  [Momento Console](https://console.gomomento.com). Add the following environment variables:

```bash
export MOMENTO_API_KEY=<YOUR_API_KEY> # Momento API Key
export TEST_REDIS=true # false if you would like to use momento
export REDIS_HOST=<REDIS_HOST> # Redis host, default is "127.0.0.1"
export REDIS_PORT=<REDIS_PORT> # Redis port, default is 6379
export TEST_CACHE_NAME="test-cache" # Cache name
```

## Installation

To set up the integration tests, you'll need two Docker containers: one for running Redis and the other for running the integration tests.

### Step 1: Set Up a Redis Docker Container

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
docker run -it -v $(pwd):/app -w /app momento-php-redis-dev /bin/bash
```

- Inside the Docker container, execute the integration tests:

```bash
composer install
composer test
```
