<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// соединение с базой данных
require_once 'config/database.php';
// Подключаем объект RandomNumbers
require_once 'objects/random_numbers.php';
// Подключаем функцию вывода пользователю результата выполнения запроса
require_once 'objects/server_messenger.php';

if(!function_exists('http_response_code')){
    require_once 'functions_PHP5_3/http_response_code.php';
}


$database = new Database();
$db = $database->getConnection();

if(!$db){
    die('Не получилось установить соединение с базой данных.');
}

$num = new RandomNumbers($db);
// Принимаем присланные данные
$data_num = isset($_REQUEST['num']) ? $_REQUEST['num'] : '';
$to_do = isset($_REQUEST['to_do']) ? $_REQUEST['to_do'] : '';

if(isset($to_do) && (strlen($to_do) < 50)) {
    switch ($to_do) {
        case 'generate':
            include_once 'random_numbers/generate.php';
            break;
        case 'retrieve':
            include_once 'random_numbers/retrieve.php';
            break;
        default:
            http_response_code(400);
            die("Ошибка: выбран неверный запрос на сервер");
    }
}

