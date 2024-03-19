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
        return $this->db->query("SELECT * FROM users WHERE username = ?", [$username])->fetch();
    }

    public function checkEmail($email): false|array
    {
        return $this->db->query('SELECT * FROM users WHERE email = ?', [$email])->fetchAll();
    }
    public function registration($data): array
    {
        if (count($this->getUser($data['username'])) !== 0) return CustomError::errorUsername($data['username']);
        else if (count($this->checkEmail($data['email'])) !== 0) return CustomError::errorEmail();
        $keyApp = require __DIR__ . "/../config/keyApp.php";
        $hash = password_hash($data['password'] . $keyApp, PASSWORD_BCRYPT);
        $answer = $this->db->queryAdd("INSERT INTO users (username, fullname, email, password) VALUES (?,?,?,?)", [$data['username'], $data['fullname'], $data['email'], $hash]);
        $_SESSION['login_login_username'] = $data['username'];
        session_regenerate_id();
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
            session_regenerate_id();
            return [
            'message' => 'Вы успешно вошли',
            'token' => $data['username']. '-'.session_id(),
            ...$this->getDataUser($user)
        ];
        }

        return CustomError::errorAuthorization();
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

}