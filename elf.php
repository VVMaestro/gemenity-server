<?php

require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Страница эльфа';

var_dump($user);

if ($user) {
    $page_content = renderTemplate('elf-profile', [
        'login' => $user['login'],
        'NAME' => $user['name'],
        'status' => $user['status'],
        'delete_date' => $user['delete_date']
    ]);
    $title = $user['name'];
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'title' => $title,
    'page_content' => $page_content
]);

print($layout_content);