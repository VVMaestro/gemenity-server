<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$user = $_SESSION['user'];
$title = 'Страница эльфа';

if ($user && $user['role'] == 'elf') {
    $gem_types = get_db_data($database, $gem_types_request);

    $page_content = renderTemplate('elf-profile', [
        'login' => $user['login'],
        'NAME' => $user['NAME'],
        'status' => $user['status'],
        'registration_date' => $user['registration_date'],
        'delete_date' => $user['delete_date'],
        'gem_types' => $gem_types
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