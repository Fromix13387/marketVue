<?php
class Printer
{
    private Db $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getPrinters($search, $min, $max): false|array
    {
        return $this->db->query('SELECT *, products.id  FROM products JOIN countries c on c.id = products.country_id JOIN categories c2 on c2.id = products.category_id WHERE price >= ? and price <= ? and products.nameProduct LIKE ?', [$min, $max, $search . '%'])->fetchAll();
    }
    public function getPrinter($id): false|array
    {
        return $this->db->query('SELECT *, c.nameCountry, c2.nameCategory, products.id FROM products JOIN countries c on c.id = products.country_id JOIN categories c2 on c2.id = products.category_id WHERE products.id = ?', [$id])->fetch();
    }

    public function addPrinter($data, $file): array|bool
    {
        if (!$this->db->getCountry($data['country_id']) ) return CustomError::errorCountry();
        if (!$this->db->getCategory($data['category_id']) ) return CustomError::errorCategory();

        $path = '1.png';
        if (isset($file['image'])) {
            $file = $file['image'];
            $path = $file['name'];
            move_uploaded_file($file['tmp_name'], 'src/product/' . $path);
        }
        return $this->db->queryAdd('INSERT INTO products (nameProduct, price, description, country_id, releaseYear, model, category_id, image, count) VALUES (?,?,?, ?,?,?,?,?,?)', [$data['nameProduct'], $data['price'], $data['description'], $data['country_id'], $data['releaseYear'], $data['model'], $data['category_id'], $path, $data['count']]);
    }
    public function editPrinter($data, $file): array|bool
    {
        if (!$this->db->getCountry($data['country_id']) ) return CustomError::errorCountry();
        if (!$this->db->getCategory($data['category_id']) ) return CustomError::errorCategory();
        if (isset($file['image'])) {
            $file = $file['image'];
            $path = $file['name'];
            move_uploaded_file($file['tmp_name'], 'src/product/' . $path);
            return $this->db->queryAdd('Update products  SET nameProduct =? , price =?, description = ?, country_id =?, releaseYear = ?, model=?, category_id =?, image =?, count =? WHERE id = ?', [$data['nameProduct'], $data['price'], $data['description'], $data['country_id'], $data['releaseYear'], $data['model'], $data['category_id'], $path, $data['count'], $data['id']]);
        }
        return $this->db->queryAdd('Update products  SET nameProduct =? , price =?, description = ?, country_id =?, releaseYear = ?, model=?, category_id =?, image = image, count =? WHERE id = ?', [$data['nameProduct'], $data['price'], $data['description'], $data['country_id'], $data['releaseYear'], $data['model'], $data['category_id'], $data['count'], $data['id']]);
    }

    public function deletePrinter($id): bool
    {
        return $this->db->queryAdd('DELETE FROM products WHERE id = ?', [$id]);
    }

}