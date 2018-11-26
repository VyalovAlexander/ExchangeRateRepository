<?php

namespace VyalovAlexander\ExchangeRate\Storage;

use VyalovAlexander\ExchangeRate\Entities\ExchangeRateModel;

/**
 * Class DatabaseStorage
 * @package VyalovAlexander\ExchangeRate\Storage
 */
class DatabaseStorage implements Storage
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * DatabaseStorage constructor.
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param ExchangeRateModel $model
     * @return ExchangeRateModel
     */
    public function get(ExchangeRateModel $model): ExchangeRateModel
    {
        $statement  = $this->connection->prepare("SELECT * FROM rates WHERE basecurrancy = ? AND currentcurrency = ? and date = ?");
        $statement->execute(array(
            $model->getBaseCurrency(),
            $model->getCurrentCurrency(),
            $model->getDate()->format('Y-m-d')
        ));

        $data = $statement->fetchAll();
        if (count($data) > 0) {
            return $model->filledEntity($data[0]['course']);
        }
        return $model;
    }

    /**
     * @param ExchangeRateModel $model
     */
    public function set(ExchangeRateModel $model)
    {
        $statement = $this->connection->prepare("INSERT INTO rates(basecurrancy, currentcurrency, course, date)
          VALUES(:basecurrency, :currentcurrency, :course, :date)");
        $statement->bindParam('basecurrency', $model->getBaseCurrency());
        $statement->bindParam('currentcurrency', $model->getCurrentCurrency());
        $statement->bindParam('course', $model->getCourse());
        $statement->bindParam('date', $model->getDate()->format('Y-m-d'));
        $statement->execute();
    }

}