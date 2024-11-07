# Pre-requisites

Before running the integration tests, ensure that the Momento API Key is available in your environment. If you don't
have one, you can get it from the  [Momento Console](https://console.gomomento.com). Add the following environment variables:

```bash
export MOMENTO_API_KEY=<YOUR_API_KEY> # Momento API Key
export TEST_REDIS=true # false if you would like to use momento
export REDIS_HOST=<REDIS_HOST> # Redis host, default is "127.0.0.1"
export REDIS_PORT=<REDIS_PORT> # Redis port, default is 6379
export TEST_CACHE_NAME="test-cache" # Cache name
```

# Setup

There are two ways to set up your development environment:

## Option 1: Build Docker Image
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
composer test-momento # for momento
composer test-redis # for redis
```

## Option 2: Running a Dev Container in IntelliJ IDEA
- In IntelliJ IDEA, open the .devcontainer/devcontainer.json file located in the root of this repository.
- In the left gutter, click and select Create Dev Container and Mount Sources.
- This will set up and launch a development container with all necessary dependencies pre-installed.

### Running Integration Tests
Once inside the container, you can run the integration tests in two ways:

**1. Using the Terminal:**
Run the following commands in the terminal to install dependencies and execute tests:

```bash
composer install
composer test-momento # for momento
composer test-redis # for redis
```

**2. Using IntelliJ IDEA UI:**
Alternatively, you can run the tests directly within IntelliJ IDEA. To do this, edit the test configuration and set the necessary environment variables:

- **_For Momento:_**
    - `MOMENTO_API_KEY` - Your Momento API Key
    - `TEST_REDIS` - Set to `false`

- **_For Redis:_**
    - `MOMENTO_API_KEY` - Your Momento API Key
    - `REDIS_HOST` - Redis host (default: `redis`)
    - `REDIS_PORT` - Redis port (default: `6379`)
    - `TEST_REDIS` - Set to `true`

## Option 2: Running a Dev Container in Visual Studio Code
- In Visual Studio Code, open the `.devcontainer/devcontainer.json` file located in the root of this repository.
- Click on the Reopen in Container button in the bottom right corner.
- This will create and launch a development container with all necessary dependencies pre-installed.

### Running Integration Tests
Once inside the container, you can run the integration tests in two ways:

**1. Using the Terminal:**
Run the following commands in the terminal to install dependencies and execute tests:

```bash
composer install
composer test-momento # for momento
composer test-redis # for redis
```

**2. Using Visual Studio Code UI**
Alternatively, you can run the tests directly within Visual Studio Code. To do this, edit the test configuration and set the necessary environment variables:

- **_For Momento:_**
    - `MOMENTO_API_KEY` - Your Momento API Key
    - `TEST_REDIS` - Set to `false`

- **_For Redis:_**
    - `MOMENTO_API_KEY` - Your Momento API Key
    - `REDIS_HOST` - Redis host (default: `redis`)
    - `REDIS_PORT` - Redis port (default: `6379`)
    - `TEST_REDIS` - Set to `true`

