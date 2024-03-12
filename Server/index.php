<?php

header('Access-Control-Allow-Origin: *');

require 'vendor/autoload.php';
require 'classes/Db.php';
require 'classes/User.php';
require 'classes/CustomError.php';
require 'classes/Printer.php';


echo isset($_POST['method']) ? json_encode(main()) : CustomError::errorMethodNotFound();

function main(): false|array|string|null
{
    $method = $_POST['method'];
    $printer = new Printer(new Db);
    $user = new User(new Db);

    if ($method === 'getPrinters') {
        $search = $_POST['search'] !== 'undefined' ? $_POST['search'] : '';
        $min = $_POST['min'];
        $max = $_POST['max'];
         return $printer->getPrinters($search, $min,$max);
    }
    else if ($method === 'getPrinter') {
        return $printer->getPrinter($_POST['id']);
    }
    else if ($method === 'registration') {
        if ($_POST['password'] !== $_POST['password_confirm']) return CustomError::errorPasswordConfirm();
        return CustomError::errorValidation($_POST) ??  $user->registration($_POST);
    }
    else {
        return ;
    }
}


