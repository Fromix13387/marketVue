<?php

class User
{
    private Db $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getUser($username): false|array
    {
        return $this->db->query("SELECT *,  users.id as id FROM users WHERE username = ?", [$username])->fetch();
    }
    public function deleteUser($id): bool
    {
        return $this->db->queryAdd("DELETE FROM users WHERE id = ?", [$id]);
    }
    public function editUser($data, $file): bool
    {
        if (isset($file['image'])) {
            $file = $file['image'];
            $path = $file['name'];
            move_uploaded_file($file['tmp_name'], 'src/imageUser/' . $path);
            return $this->db->queryAdd('UPDATE users SET fullname = ? ,email = ?, role = ?, image = ? WHERE id = ?', [$data['fullname'], $data['email'], $data['role'], $path, $data['id']]);
        }
        return $this->db->queryAdd('UPDATE users SET fullname = ? ,email = ?, role = ?, image = image WHERE id = ?', [$data['fullname'], $data['email'], $data['role'], $data['id']]);
    }
    public function getUsers(): false|array
    {
        return $this->db->query("SELECT *, users.id as id FROM users JOIN roles ON roles.id = users.role")->fetchAll();
    }


    public function checkEmail($email): false|array
    {
        return $this->db->query('SELECT * FROM users WHERE email = ?', [$email])->fetchAll();
    }
    public function registration($data): array
    {
        if ($this->getUser($data['username'])) return CustomError::errorUsername($data['username']);
        else if (count($this->checkEmail($data['email'])) !== 0) return CustomError::errorEmail();
        $keyApp = require __DIR__ . "/../config/keyApp.php";
        $hash = password_hash($data['password'] . $keyApp, PASSWORD_BCRYPT);
        $answer = $this->db->queryAdd("INSERT INTO users (username, fullname, email, password) VALUES (?,?,?,?)", [$data['username'], $data['fullname'], $data['email'], $hash]);
        $_SESSION['login_login_username'] = $data['username'];

        return $answer ? [
            ...$this->getDataUser($data),
            'message' => 'Вы успешно зарегестрировались',
            'token' => $data['username']. '-'.session_id(),
            'role' => 1
            ]
            : CustomError::errorUnknown();
    }
    public function authorization($data): array
    {
        $user = $this->getUser($data['username']);
        $keyApp = require __DIR__."/../config/keyApp.php";
        if ($user && password_verify($data['password'].$keyApp, $user['password'] ?? ''))
        {
            $_SESSION['login_username'] = $user['username'];
            session_regenerate_id(true);
            return [
            'message' => 'Вы успешно вошли',
            'token' => $data['username']. '-'.session_id(),
            ...$this->getDataUser($user)
        ];
        }

        return CustomError::errorAuthorization();
    }

    function changeProfile($data, $file,$username): array
    {
        $err = CustomError::errorValidation($_POST);
        if ($err && $err['error_message'] != 'null') return $err;
        if (!empty($data['password'])) {
            if ($data['password'] !== $data['password_confirm']) return CustomError::errorPasswordConfirm();
            else $this->changePassword($data['password'], $username);
        }
        $path = null;
        if (isset($file['image'])) {
            $file = $file['image'];
            $path = $file['name'];
            move_uploaded_file($file['tmp_name'], 'src/imageUser/'.$path);
        }

        $answer = $this->db->queryAdd('UPDATE users SET username = ?, fullname = ?,image = ?, email = ? WHERE username = ?', [$data['username'], $data['fullname'], $path, $data['email'], $username]);

        $user = $this->getUser($data['username']);
        $_SESSION['login_username'] = $data['username'];

        return $answer ? [
            ...$this->getDataUser($user),
            'message' => 'Вы успешно изменили данные',
            'token' => $data['username'] . '-' . session_id(),
        ] : CustomError::errorUnknown();
    }

    function changePassword($newPassword, $username): bool
    {
        $keyApp = require __DIR__ . '/../config/keyApp.php';
        $hash = password_hash($newPassword . $keyApp, PASSWORD_BCRYPT);
        return $this->db->queryAdd('UPDATE users SET password = ? WHERE username = ?', [$hash, $username]);
    }
    function getDataUser($data): array
    {
        return [
            'username' => $data['username'] ?? null,
            'fullname' => $data['fullname'] ?? null,
            'email' => $data['email'] ?? null,
            'image' => $data['image'] ?? null,
            'role' => $data['role'] ?? null
        ];
    }

    function saveOrder($username, $product_id, $count): bool
    {
        return $this->db->queryAdd("INSERT INTO orders (count, user_id, product_id) VALUES (?, (SELECT id FROM users WHERE username = ?), ?)", [$count, $username, $product_id]);
    }
    function sendReviews($username, $title, $value): bool
    {
        return $this->db->queryAdd("INSERT INTO reviews (title, value, user_id) VALUES (?, ?, (SELECT id FROM users WHERE username = ?))", [$title, $value, $username]);
    }
    function getReviews(): false|array
    {
        return $this->db->query("SELECT reviews.title, reviews.value, reviews.date, users.username, users.image FROM reviews JOIN users ON users.id = reviews.user_id ORDER BY date DESC ")->fetchAll();
    }
    function getOrderHistory($username): false|array
    {
        return $this->db->query("SELECT statuses.nameStatus as status, products.nameProduct as product, products.description, products.image , orders.created_at, orders.count, products.price FROM orders 
            JOIN statuses ON orders.status_id = statuses.id
            JOIN users ON users.id = orders.user_id
            JOIN products ON products.id = orders.product_id
            WHERE users.username = ?
            ", [$username])->fetchAll();
    }

}