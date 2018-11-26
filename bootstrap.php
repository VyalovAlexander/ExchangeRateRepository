<?php

    include 'vendor/autoload.php';

    $dotenv = new Dotenv\Dotenv(__DIR__);
    $dotenv->load();

    $host = getenv('DB_HOST');
    $port = getenv('DB_PORT');
    $dbName = getenv('DB_NAME');
    $dbDriver = getenv('DB_DRIVER');
    $dsn = "{$dbDriver}:host={$host};port={$port};dbname={$dbName}";
    $username = getenv('DB_USER');
    $password = getenv('DB_PASSWORD');
    $dbConn = new PDO($dsn, $username, $password);

    try
    {
        $rows = $dbConn->exec("CREATE TABLE IF NOT EXISTS rates 
                ( 
                    Id SERIAL PRIMARY KEY,
                    baseCurrancy VARCHAR(3),
                    currentCurrency VARCHAR(3),
                    course NUMERIC (20, 10),
                    date date
                );");
    }
    catch(PDOException $e)
    {
        die("Error: ".$e->getMessage());
    }

$cacheClient = new Predis\Client([
        'scheme' => 'tcp',
        'host'   => getenv('REDIS_HOST'),
        'port'   => getenv('REDIS_PORT'),
    ]);

