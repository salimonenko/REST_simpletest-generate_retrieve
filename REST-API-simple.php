<?php

header('Content-Type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>REST_test: публичные вызовы generate() и retrieve(id)</title>

<style>
    .save_number, .show_number{display: inline-block}
    .info{border: solid 1px; height: 20px; display: inline-block; min-width: 350px; margin: 10px; width: auto}
    .show_number{margin-top: 10px}
</style>

</head>

<body>

<div class="save_number">
    <button onclick="random_number(<?php require_once 'api/config/parameters.php'; echo $max_number; ?>)">Взять случайное число <br/>и отправить его на сервер</button>
</div>

<div class="show_number">
    <button onclick="show_number()">Показать случайное число, сохраненное на сервере с  <br/>выбранным <span style="font-weight: bold">id</span></button>
<input type="text" placeholder="Введите id..." id="number_id"/>
</div>

<div class="show_number">
    <button onclick="show_all_numbers()">Показать случайные числа для всех <span style="font-weight: bold">id</span></button>
</div>

<br/>
<div id="xhr_message" class="info"></div>

<script>
    
    function show_all_numbers() {
        var num = 'all';
        sender(num, 'retrieve');
    }
    
    function show_number() {
        var num = document.getElementById('number_id').value;
        sender(num, 'retrieve');
    }
    
    function random_number(max_level) { // max_level задается в api/config/parameters.php в качестве параметра
         var num = parseInt(Math.random()*max_level);
         sender(num, 'generate');
    }

    function sender(num, to_do) { // Функция отправляет сообщение на сервер  и ждет того или иного ответа, выводя потом его в alert
        var xhr = new XMLHttpRequest();
        // Готовим тело сообщения для отправки     // в encodeURIComponent преобразует в формат, который может принять сервер
        var body = 'num='+encodeURIComponent(num)+'&to_do='+to_do;
        xhr.open("POST", 'api/create_database.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function xhr_state() {
            if (xhr.readyState != 4) return;
            if  (xhr.status == 201) {
                // После подтверждения получения сообщения сервером выдаем оповещение
                alert('Случайное число успешно отправлено и сохранено на сервере.');
            } else {
//                alert('xhr error '+xhr.statusText); // Сообщение об ошибке на транспортном (IP/ТСР) уровне. Обычно вызвано проблемами  с доступом к сети или неправильной работой РНР на сервере, т.п.
            }

            document.getElementById('xhr_message').innerHTML = xhr.responseText;
        };
        xhr.send(body);
        return false;
    }

</script>

</body>
</html>