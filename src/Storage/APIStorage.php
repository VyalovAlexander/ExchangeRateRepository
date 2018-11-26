<?php

namespace VyalovAlexander\ExchangeRate\Storage;


use VyalovAlexander\ExchangeRate\Entities\ExchangeRateModel;

/**
 * Class APIStorage
 * @package VyalovAlexander\ExchangeRate\Storage
 */
class APIStorage implements Storage
{
    /**
     * @param ExchangeRateModel $model
     * @return ExchangeRateModel
     */
    public function get(ExchangeRateModel $model): ExchangeRateModel
    {
        $url = getenv('EXCHANGE_RATE_URL') . $model->getBaseCurrency();
        $rates = json_decode(file_get_contents($url));
        $rate = $rates->rates->{$model->getCurrentCurrency()};

        if (!is_null($rate))
            return $model->filledEntity($rate);

        return $model->nullEntity();
    }

    /**
     * @param ExchangeRateModel $model
     */
    public function set(ExchangeRateModel $model) {}

}