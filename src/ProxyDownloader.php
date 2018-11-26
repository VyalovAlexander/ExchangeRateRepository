<?php

namespace VyalovAlexander\ExchangeRate;

use VyalovAlexander\ExchangeRate\Entities\ExchangeRateModel;
use VyalovAlexander\ExchangeRate\Storage\Storage;

/**
 * Class ProxyDownloader
 * @package VyalovAlexander\ExchangeRate
 */
class ProxyDownloader implements Downloader
{
    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Downloader
     */
    private $proxy;

    /**
     * ProxyDownloader constructor.
     * @param Storage $storage
     * @param Downloader|null $proxy
     */
    public function __construct(Storage $storage, Downloader $proxy = null)
    {
        $this->storage = $storage;
        $this->proxy= $proxy;
    }

    /**
     * @param ExchangeRateModel $model
     * @return ExchangeRateModel
     */
    public function currentExchangeRate(ExchangeRateModel $model): ExchangeRateModel
    {
        $storageModel = $this->storage->get($model);
        if ($storageModel->isNull() && !is_null($this->proxy)) {
            $repositoryModel = $this->proxy->currentExchangeRate($storageModel);
            if (!$repositoryModel->isNull()) {
                $this->storage->set($repositoryModel);
                return $repositoryModel;
            }
        }

        return $storageModel;
    }
}