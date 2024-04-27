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
    public function getCountries(): bool|array
    {
        return $this->query('SELECT * FROM countries')->fetchAll();
    }
    public function getRoles(): bool|array
    {
        return $this->query('SELECT * FROM roles')->fetchAll();
    }
    public function getCategories(): bool|array
    {
        return $this->query('SELECT * FROM categories')->fetchAll();
    }
    public function getCountry($id): bool|array
    {
        return $this->query('SELECT * FROM countries WHERE id = ?', [$id])->fetchAll();
    }
    public function getCategory($id): bool|array
    {
        return $this->query('SELECT * FROM categories WHERE id = ?', [$id])->fetchAll();
    }
    public function getStatuses(): bool|array
    {
        return $this->query('SELECT * FROM statuses')->fetchAll();
    }
    public function getOrders(): bool|array
    {
        return $this->query('SELECT *, orders.id as order_id,orders.count as count  FROM orders JOIN statuses s on s.id = orders.status_id JOIN users u on u.id = orders.user_id JOIN products p on p.id = orders.product_id')->fetchAll();
    }
    public function changeStatus($id_status, $id_user, $id_order): bool|array
    {
        return $this->query('UPDATE orders SET status_id = ? WHERE user_id = ? and id = ?', [$id_status, $id_user, $id_order])->fetchAll();
    }
    public function deleteOrder($id): bool|array
    {
        return $this->queryAdd('DELETE FROM orders WHERE id = ?', [$id]);
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