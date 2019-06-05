<?php

require_once 'data.php';

$connect = mysqli_connect (
    $database['host'],
    $database['user'],
    $database['password'],
    $database['name'],
    $database['port']
);

if (!$connect) {
    print ('Ошибка соединения: ' . mysqli_connect_error());
}