<?php

require 'bootstrap.php';

use VyalovAlexander\ExchangeRate\Entities\NullExchangeRateModel;
use VyalovAlexander\ExchangeRate\Storage\APIStorage;
use VyalovAlexander\ExchangeRate\Storage\CacheStorage;
use VyalovAlexander\ExchangeRate\Storage\DatabaseStorage;
use VyalovAlexander\ExchangeRate\ProxyDownloader;

$exchangeRate =
    (new ProxyDownloader(
        new CacheStorage($cacheClient),
        new ProxyDownloader(
            new DatabaseStorage($dbConn),
            new ProxyDownloader(new APIStorage())
        )))->currentExchangeRate(
        new NullExchangeRateModel(
            getenv('RUBLE_NAME'),
            getenv('DOLLAR_NAME'),
            new DateTime('now')
        ));

print_r("Курс: {$exchangeRate->getBaseCurrency()} к {$exchangeRate->getCurrentCurrency()} - {$exchangeRate->getCourse()}");

// close connections
$dbConn = null;
$cacheClient = null;