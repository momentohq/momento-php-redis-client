<img src="https://docs.momentohq.com/img/momento-logo-forest.svg" alt="logo" width="400"/>

[![project status](https://momentohq.github.io/standards-and-practices/badges/project-status-official.svg)](https://github.com/momentohq/standards-and-practices/blob/main/docs/momento-on-github.md)
[![project stability](https://momentohq.github.io/standards-and-practices/badges/project-stability-beta.svg)](https://github.com/momentohq/standards-and-practices/blob/main/docs/momento-on-github.md)


# PhpRedis用Momento Drop-inクライアント

[PhpRedis](https://github.com/phpredis/phpredis)用Momento Drop-inクライアントへようこそ! このパッケージはMomento cacheインテグレーションを行なったPhpRedisエクステンションに対するラッパーです。このパッケージをPhpRedisの代替えとして直接使用することができ、またさらにMomento cacheのメリットも受けることができます。

## 使用方法

```php
<?php
declare(strict_types=1);

use Momento\Auth\CredentialProvider;
use Momento\Cache\CacheClient;
use Momento\Cache\MomentoCacheClient;
use Momento\Config\Configurations\Laptop;
use Momento\Logging\StderrLoggerFactory;

require "vendor/autoload.php";

$CACHE_NAME = uniqid("php-example-");
$ITEM_DEFAULT_TTL_SECONDS = 60;
$KEY = uniqid("myKey-");
$VALUE = uniqid("myValue-");

// Momento cacheクライアントを作成
$authProvider = CredentialProvider::fromEnvironmentVariable("MOMENTO_API_KEY");
$configuration = Laptop::latest(new StderrLoggerFactory());
$client = new CacheClient($configuration, $authProvider, $ITEM_DEFAULT_TTL_SECONDS);
$logger = $configuration->getLoggerFactory()->getLogger("ex:");

// Momento cacheに対応したRedisクライアントを作成
$momentoCacheClient = new MomentoCacheClient($client, $CACHE_NAME);

// 重要事項: このサンプルではすでにcache($CACHE_NAME)が作成されていることを想定しています。
// cacheを作成するにはMomento Console (https://console.gomomento.com/)もしくはSDKのメソッドをコールしてください。
// 詳細はこちらのドキュメント (https://docs.momentohq.com/ja/platform/sdks/php/cache)参照してください。

// 通常のRedisクライアントを使用しているかのようにMomentoを使用できます。
$setResult = $momentoCacheClient->set($KEY, $VALUE);
$logger->info("Set result: " . $setResult . "\n");

$getResult = $momentoCacheClient->get($KEY);
$logger->info("Get result: " . $getResult . "\n");

```

## 開始方法とドキュメント

Drop-inクライアントを使用するにはMomento API Keyが必要です。
[Momento Console](https://console.gomomento.com)より取得できます。

## インストール

[Phpredis](https://github.com/phpredis/phpredis)用Momento Drop-inクライアントはpackagist.org: [momento-php-redis](https://packagist.org/packages/momentohq/momento-php-redis-client)にてインストール可能です。

## コードサンプル

[examples directory](./examples/)にて全てのコードサンプルを参照いただけます。

## 開発

こちらのSDKへのコントリビューションに興味のある方は[CONTRIBUTING](./CONTRIBUTING.md)のドキュメントをご覧ください。

## Attributions

このプロジェクトはPHPソフトウェアを含みます。<http://www.php.net/software/>より無料で提供されています。

----------------------------------------------------------------------------------------
詳細は[https://gomomento.com](https://gomomento.com)をご覧ください！
