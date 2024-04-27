<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Authorization');
header('Access-Control-Allow-Credentials: true');
require 'vendor/autoload.php';
require 'classes/Db.php';
require 'classes/User.php';
require 'classes/CustomError.php';
require 'classes/Printer.php';

$auth = false;
$headers = getallheaders();

if (isset($headers['Authorization'])) {
    [$username, $id] = explode('-', $headers['Authorization']) + [1 => null];
    $session_id = session_id($id);
    session_start(['cookie_lifetime' => 86400]);
    if (isset($_SESSION['login_username']) && $_SESSION['login_username'] === $username) $auth = true;
}
else session_start(['cookie_lifetime' => 86400]);


echo json_encode(isset($_POST['method']) ? main() : CustomError::errorMethodNotFound() );

function main(): false|array|string|null
{
    global $auth, $username;
    $method = $_POST['method'];
    $db = new Db;
    $printer = new Printer($db);
    $user = new User($db);

    if ($method === 'getPrinters') {
        $search = isset($_POST['search'] ) && $_POST['search'] !== 'undefined' ? $_POST['search'] : '';
        $min = $_POST['min'] ?? 0;
        $max = $_POST['max'] ?? 999999;
         return $printer->getPrinters($search, $min,$max);
    }
    else if ($method === 'getPrinter') {
        return $printer->getPrinter($_POST['id']);
    }
    else if ($method === 'getCountries') {
        return $db->getCountries();
    }
    else if ($method === 'getCategories') {
        return $db->getCategories();
    }
    else if ($method === 'saveOrder' && $auth) {
        return $user->saveOrder($username,$_POST['id_product'], $_POST['count']);
    }
    else if ($method === 'getOrderHistory' && $auth) {
        return $user->getOrderHistory($username);
    }
    else if ($method === 'getStatuses' && $auth) {
        return $db->getStatuses();
    }
    else if ($method === 'getRoles' && $auth) {
        return $db->getRoles();
    }
    else if ($method === 'sendReviews' && $auth) return $user->sendReviews($username,$_POST['title'], $_POST['value']);
    else if ($method === 'getReviews' && $auth) return $user->getReviews();
    else if ($method === 'registration') {
        if ($_POST['password'] !== $_POST['password_confirm']) return CustomError::errorPasswordConfirm();
        return CustomError::errorValidation($_POST) ??  $user->registration($_POST);
    }
    else if ($method === 'authorization') {
        return $user->authorization($_POST);
    }
    else if ($method === 'changeProfile' && $auth) {
        return $user->changeProfile($_POST, $_FILES,$username);
    }
    else if ($method === 'checkAuth' && $auth) {
        $data = $user->getUser($_SESSION['login_username']);
        session_regenerate_id(true);
        return [...$user->getDataUser($data), 'token' => $data['username'].'-'.session_id()];
    }
    else if ($method === 'checkPassword' && $auth) {
        $password = $_POST['password'] ?? '';
        $data = $user->getUser($_SESSION['login_username']);
        $keyApp = require __DIR__ . '/config/keyApp.php';
        return ['password' => $data && password_verify($password.$keyApp, $data['password'] ?? '')];
    }
    else if ($method === 'exit') {
        if (!$auth) return CustomError::errorExit();
        return ['answer' => session_destroy()];
    }
    else if ((
            $method === 'getUsers' ||
            $method === 'deleteUser' ||
            $method === 'editUser' ||
            $method === 'addPrinter' ||
            $method === 'deletePrinter' ||
            $method === 'editPrinter' ||
            $method === 'getOrders' ||
            $method === 'deleteOrder' ||
            $method === 'changeStatus'
        ) && $auth) {
        $userData = $user->getUser($username);
        if ($userData['role'] <= 1) return CustomError::errorAdmin();
        return match ($method) {
            'getUsers' => $user->getUsers(),
            'deleteUser' => $user->deleteUser($_POST['id']),
            'editUser' => $user->editUser($_POST, $_FILES),
            'addPrinter' => $printer->addPrinter($_POST, $_FILES),
            'deletePrinter' => $printer->deletePrinter($_POST['id']),
            'editPrinter' => $printer->editPrinter($_POST, $_FILES),
            'getOrders' => $db->getOrders(),
            'deleteOrder' => $db->deleteOrder($_POST['id']),
            'changeStatus' => $db->changeStatus($_POST['status_id'],$_POST['user_id'], $_POST['order_id']),
            default => CustomError::errorUnknown(),
        };
    }
    else {
        return CustomError::errorUnknown();
    }
}

