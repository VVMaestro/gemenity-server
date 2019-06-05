<?php

require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Страница эльфа';

if ($user && $user['role'] == 'elf') {
    $page_content = renderTemplate('elf-profile', [
        'login' => $user['login'],
        'NAME' => $user['NAME'],
        'status' => $user['status'],
        'registration_date' => $user['registration_date'],
        'delete_date' => $user['delete_date']
    ]);
    $title = $user['name'];
} elseif ($user['role'] == 'dwarf') {
    header('Location: /dwarf.php');
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'title' => $title,
    'page_content' => $page_content
]);

print($layout_content);