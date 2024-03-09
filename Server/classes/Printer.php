<?php
class Printer
{
    private Db $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPrinters($search): false|array
    {
        return $this->db->query('SELECT *, products.id FROM products JOIN countries c on c.id = products.country_id JOIN categories c2 on c2.id = products.category_id WHERE products.nameProduct LIKE ?', [$search."%"])->fetchAll();
    }
    public function getPrinter($id): false|array
    {
        return $this->db->query('SELECT *, c.nameCountry, c2.nameCategory FROM products JOIN countries c on c.id = products.country_id JOIN categories c2 on c2.id = products.category_id WHERE products.id = ?', [$id])->fetch();
    }

}