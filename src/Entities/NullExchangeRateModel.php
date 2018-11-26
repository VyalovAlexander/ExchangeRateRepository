<?php

namespace VyalovAlexander\ExchangeRate\Entities;

/**
 * Null object for ExchangeRateModel
 *
 * Class NullExchangeRateModel
 * @package VyalovAlexander\ExchangeRate\Entities
 */
class NullExchangeRateModel extends ExchangeRateModel
{
    /**
     * NullExchangeRateModel constructor.
     * @param string $baseCurrency
     * @param string $currentCurrency
     * @param \DateTime $date
     */
    public function __construct(string $baseCurrency, string $currentCurrency, \DateTime $date)
    {
        $this->baseCurrency = $baseCurrency;
        $this->currentCurrency = $currentCurrency;
        $this->date = $date;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return true;
    }

}