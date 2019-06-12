<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$user = $_SESSION['user'];
$title = 'Страница эльфа';

if (isset($_SESSION['messages'])) {
    $messages = $_SESSION['messages'];
    $_SESSION['messages'] = null;
}

if ($user && $user['role'] == 'elf') {
    $connection = connect_to_db($database);
    $gem_types = get_db_data($connection, $gem_types_request);

    $page_content = renderTemplate('elf-profile', [
        'login' => $user['login'],
        'NAME' => $user['NAME'],
        'status' => $user['status'],
        'registration_date' => $user['registration_date'],
        'delete_date' => $user['delete_date'],
        'gem_types' => $gem_types,
        'messages' => $messages
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