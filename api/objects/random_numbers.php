<?php

class RandomNumbers{

    // для соединения с базой данных и имя таблицы
    private $conn;
    private $table_name = "REST_randoms_test";

    // свойства объекта (только 2 поля)
    public $id;
    public $num;

    // конструктор с $db как соединение с базой данных
    public function __construct($db){
        $this->conn = $db;
    }

    // Создаем запись в базе данных
    public function generate(){

        // Делаем запрос для вставки числа, полученного от клиента
        $query = "INSERT INTO $this->table_name  SET num=:num";
//        $query = "INSERT INTO $this->table_name(num) VALUES (:num)";  // Или так - тоже можно

        // Подготовляем запрос
        $stmt = $this->conn->prepare($query);

        // Преобразуем опасные символы в безопасные последовательности
        $this->name=htmlspecialchars(strip_tags($this->num));

        // bind values
        $stmt->bindParam(":num", $this->num);

        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;

    }

    // Создаем запись в базе данных
    public function retrieve($ID){

        if($ID !== 'all'){
        // Делаем запрос для вывода числа по id записи
            $query = "SELECT * FROM `$this->table_name` WHERE `ID` = :ID";

        } else {
            $query = "SELECT * FROM `$this->table_name`";
        }


        // Подготовляем запрос
        $stmt = $this->conn->prepare($query);

        if($ID !== 'all'){

        // execute query
            if($stmt->execute(array('ID' => $ID))){
                $value = $stmt->fetch(PDO::FETCH_LAZY);
            }
        } else {

            // execute query
            if($stmt->execute()){
                $value = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
            }
        }

        if(empty($value)){
            $value = array('ID' => $ID);
        }

        return $value;
    }

}
