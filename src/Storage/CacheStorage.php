<?php

namespace VyalovAlexander\ExchangeRate\Storage;

use Predis\Client;
use VyalovAlexander\ExchangeRate\Entities\ExchangeRateModel;

/**
 * Class CacheStorage
 * @package VyalovAlexander\ExchangeRate\Storage
 */
class CacheStorage implements Storage
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * CacheStorage constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param ExchangeRateModel $model
     * @return ExchangeRateModel
     */
    public function get(ExchangeRateModel $model): ExchangeRateModel
    {
        $value = $this->client->get($this->key($model));
        if (!is_null($value))
            $model->filledEntity($this->client->get($value));
        return $model;
    }

    /**
     * @param ExchangeRateModel $model
     */
    public function set(ExchangeRateModel $model)
    {
        $this->client->set($this->key($model), $model->getCourse(), 'EX', getenv('REDIS_EXCHANGE_RATE_EX_TTL'));
    }

    /**
     * @param ExchangeRateModel $model
     * @return string
     */
    private function key(ExchangeRateModel $model): string
    {
        return $model->getBaseCurrency() . $model->getCurrentCurrency() . $model->getDate()->format('Y-m-d');
    }


}