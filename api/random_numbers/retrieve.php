<?php

// Если данные непустые
if(($data_num !== '') && (strlen($_REQUEST['num']) < 20) && (filter_var($data_num, FILTER_VALIDATE_INT) !== false)){

    // Устанавливаем значение для последующей записи его в базе данных
    $num->num = $data_num;

    // Создаем запись
    $value = $num->retrieve($data_num);

        if(isset($value['num'])){
            echo 'Для ID='.$value['ID'].' в базе данных содержится число '. $value['num'];
        } else {
            echo 'Для ID='.$value['ID'].' в базе данных числа нет. ';
        }

} elseif ($data_num === 'all'){
    $value = $num->retrieve($data_num);
        foreach ($value as $elem){
            echo $elem. ' ';
        }

} else { // Сообщаем пользователю о проблеме
    // ответ - 400 bad request
    http_response_code(400);
    echo "Запрос клиента содержит неверный ID.";
}
