<?php

if(!function_exists('http_response_code')){
    require_once 'functions_PHP5_3/http_response_code.php';
}

$servername = "localhost";
$database = "REST_test";
$username = "root";
$password = ""; // В учебных целях пароль не задан

$database_table = "REST_randoms_test";

// ********  Актуально при первом запуске, когда еще нет базы данных  **********************
// Создание соединения
$conn = new mysqli($servername, $username, $password);
// Проверка соединения
    if ($conn->connect_error) {
        die("Ошибка подключения: " . $conn->connect_error);
    }

// Создание базы данных, если ее еще нет
$sql = "CREATE DATABASE IF NOT EXISTS $database";
    if ($conn->query($sql) !== TRUE) {
        die("Ошибка создания базы данных: " . $conn->error);
    }
$conn->close();

// Создание нового соединения - для созданной базы данных со случайными числами
$conn_t = new mysqli($servername, $username, $password, $database);
// Создание таблицы в базе данных
$sql = "CREATE TABLE IF NOT EXISTS $database_table (ID INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, num INT (50) NOT NULL)";

$mes = '';
    if(!mysqli_query($conn_t, $sql)){
        $mes = "ERROR: Не удалось выполнить $sql. " . mysqli_error($conn_t);
    }
// Закрыть подключение
$conn_t->close();

    if($mes !== ''){
        die($mes);
    }

include_once 'objects/main.php';
