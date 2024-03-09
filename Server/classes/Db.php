<?php

class Db
{
    private $host = 'localhost', $port = '3306', $dbname = 'demo2022', $charset = 'utf8', $user = 'root', $pass = '';

    private $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    public PDO $connection;
    private PDOStatement $stmt;

    public function __construct()  //метод подключения БД
    {
        try {
            $this->connection = new PDO('mysql:host=' . $this->host . ';
                            port=' . $this->port . ';  dbname=' . $this->dbname . ';  
                            charset=' . $this->charset, $this->user,
                $this->pass, $this->options);
        } catch (PDOException $exception) {
            echo 'Ошибка соединения: ' . $exception->getMessage();
        }
    }

    public function query($query, $params = []): PDOStatement
    {
        $this->stmt = $this->connection->prepare($query);
        $this->stmt->execute($params);
        return $this->stmt;
    }

    public function queryAdd($query, $params = []): bool
    {
        $this->stmt = $this->connection->prepare($query);
        return $this->stmt->execute($params);
    }
}