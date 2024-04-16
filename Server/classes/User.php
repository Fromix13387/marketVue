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

    function changeProfile($data, $username): array
    {
        $err = CustomError::errorValidation($_POST);
        if ($err && $err['error_message'] != 'null') return $err;
        if (!empty($data['password'])) {
            if ($data['password'] !== $data['password_confirm']) return CustomError::errorPasswordConfirm();
            else $this->changePassword($data['password'], $username);
        }
        $path = 'NULL';
        if (isset($file['image'])) {
            $file = $file['image'];
            $path = $file['name'];
            move_uploaded_file($file['tmp_name'], 'Sever/src/imageUser/'.$path);
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

}