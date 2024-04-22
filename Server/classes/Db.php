<?php

class Db
{
    private array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    public PDO $connection;
    private PDOStatement $stmt;

    public function __construct()  //метод подключения БД
    {
        $data = require __DIR__."/../config/configDb.php";
        try {
            $this->connection = new PDO("mysql:host={$data['host']};port={$data['port']};dbname={$data['dbname']};charset={$data['charset']}", $data['user'],
                $data['pass'], $this->options);
        } catch (PDOException $exception) {
            echo 'Ошибка соединения: ' . $exception->getMessage();
        }
    }
    public function getRole(): bool|array
    {
        return $this->query('SELECT * FROM roles')->fetchAll();
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