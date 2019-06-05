<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Добавить камни';

if ($user) {
    $connect = connect_to_db($database);
    $sql_request = 'SELECT * FROM users';
    $result = mysqli_query($connect, $sql_request);
    error_check($connect, $result);

    $all_users = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $page_content = renderTemplate('users.tmp', ['all_users' => $all_users]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);