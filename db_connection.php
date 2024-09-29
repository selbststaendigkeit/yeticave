<?php

$db = require_once('./db_config.php');

$db_connection = mysqli_connect($db['host'], $db['username'], $db['password'], $db['db_name']);
if (!$db_connection) {
    print("Ошибка подключения к базе данных: " . mysqli_connect_error());
}
mysqli_set_charset($db_connection, 'utf8');