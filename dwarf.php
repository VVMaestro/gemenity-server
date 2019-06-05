<?php

require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Страница гнома';

if ($user && $user['role'] == 'dwarf') {
    $page_content = renderTemplate('dwarf-profile', [
        'login' => $user['login'],
        'NAME' => $user['NAME'],
        'status' => $user['status'],
        'registration_date' => $user['registration_date'],
        'deleted_date' => $user['deleted_date']
    ]);
    $title = $user['NAME'];
} elseif ($user['role'] == 'elf') {
    header('Location: /elf.php');
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);