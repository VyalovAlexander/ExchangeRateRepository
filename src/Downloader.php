<?php

namespace VyalovAlexander\ExchangeRate;

use VyalovAlexander\ExchangeRate\Entities\ExchangeRateModel;

/**
 * Interface Downloader
 * @package VyalovAlexander\ExchangeRate
 */
interface Downloader
{

    /**
     * @param ExchangeRateModel $model
     * @return ExchangeRateModel
     */
    public function currentExchangeRate(ExchangeRateModel $model): ExchangeRateModel;

}