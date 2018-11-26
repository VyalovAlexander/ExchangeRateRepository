<?php

namespace VyalovAlexander\ExchangeRate\Entities;

/**
 * Базовая модель предметной области
 *
 * Class ExchangeRateModel
 * @package VyalovAlexander\ExchangeRate\Entities
 */
class ExchangeRateModel
{
    /**
     * базовая валюта (от которой считаем курс)
     *
     * @var string
     */
    protected $baseCurrency;

    /**
     * валюта для которой считаем курс
     *
     * @var string
     */
    protected $currentCurrency;

    /**
     * обменный курс
     *
     * @var float
     */
    protected $course;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * ExchangeRateModel constructor.
     * @param string $baseCurrency
     * @param string $currentCurrency
     * @param \DateTime $date
     * @param float $course
     */
    public function __construct(string $baseCurrency, string $currentCurrency, \DateTime $date, float $course)
    {
        $this->baseCurrency = $baseCurrency;
        $this->currentCurrency = $currentCurrency;
        $this->date = $date;
        $this->course = $course;
    }

    /**
     * @return bool
     */
    public function isNull(): bool
    {
        return false;
    }

    /**
     *
     * @return float
     */
    public function getCourse(): float
    {
        return $this->course;
    }

    /**
     *
     * @return string
     */
    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    /**
     *
     * @return string
     */
    public function getCurrentCurrency(): string
    {
        return $this->currentCurrency;
    }

    /**
     * @return \DateTime
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }

    /**
     * получение пустой модели
     *
     * @return NullExchangeRateModel
     */
    public function nullEntity(): NullExchangeRateModel
    {
        return new NullExchangeRateModel($this->baseCurrency, $this->currentCurrency, $this->date);
    }

    /**
     * получение заполненной модели
     *
     * @param float $course
     * @return ExchangeRateModel
     */
    public function filledEntity(float $course): ExchangeRateModel
    {
        return new ExchangeRateModel($this->baseCurrency, $this->currentCurrency, $this->date, $course);
    }

}