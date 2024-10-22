# Momento phpredis drop-in client examples

## Requirements

- A Momento API key is required, you can generate one using the [Momento Console](https://console.gomomento.com/)

### Running via local PHP

You will need:

- At least PHP 8.0
- The gRPC PHP extension. See the [gRPC docs](https://github.com/grpc/grpc/blob/master/src/php/README.md) section on installing the extension.
- The protobuf C extension. See the [protobuf C extension docs](https://developers.google.com/google-ads/api/docs/client-libs/php/protobuf#c_implementation) for installation instructions.
- [Composer](https://getcomposer.org/doc/00-intro.md)

Run `composer update` to install the prerequisites.

### Running Examples with Docker

The Docker way:

Make sure you have run the dev-docker-build.sh script in the parent directory, to build the Momento PHP development image.
Run the ./dev-php-docker-shell.sh script to get a bash shell in a docker container that has all of the PHP dependencies necessary to run the examples. You may then run any of the commands below inside of the shell.

## Running the examples
You can run various examples to explore Momento functionality:

Set required environment variables:

```bash
export MOMENTO_API_KEY=<YOUR_API_KEY>
```

Run the examples:

- basic Example:

```bash
php examples/basic.php
```

- Sorted Set Example:

```bash
php examples/sorted_set.php
```

## Using the SDK in your project
To include the Momento PHP Redis Client SDK in your project, add the following to your `composer.json` file:

## TODO: Update the version number to the latest release version
```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/momentohq/momento-php-redis-client"
    }
  ],
    "require": {
        "momento/momento-php-redis-client": "dev-main"
    },
    "minimum-stability": "dev"
}
```

Then run `composer update` to install the SDK.
