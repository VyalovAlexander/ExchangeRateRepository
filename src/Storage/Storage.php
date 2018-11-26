<?php

namespace VyalovAlexander\ExchangeRate\Storage;

use VyalovAlexander\ExchangeRate\Entities\ExchangeRateModel;

/**
 * Interface Storage
 * @package VyalovAlexander\ExchangeRate\Storage
 */
interface Storage
{
    /**
     * @param ExchangeRateModel $model
     * @return ExchangeRateModel
     */
    public function get(ExchangeRateModel $model) : ExchangeRateModel;

    /**
     * @param ExchangeRateModel $model
     * @return mixed
     */
    public function set(ExchangeRateModel $model);
}