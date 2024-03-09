<?php
header('Access-Control-Allow-Origin: *');
include_once "classes/Db.php";
include_once "classes/Printer.php";





echo json_encode(main());

function main() {
    $method = $_POST['method'];
    $printer = new Printer(new Db);

    if ($method === 'getPrinters') {
         return $printer->getPrinters($_POST['search'] !== 'undefined' ? $_POST['search'] : '');
    }
    else if ($method === 'getPrinter') {
        return $printer->getPrinter($_POST['id']);
    }
    else {
        return "Error";
    }
}


