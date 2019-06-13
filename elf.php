<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$connection = connect_to_db($database);

$user = $_SESSION['user'];

//проверка запроса
if (isset($_GET['page_owner'])) {
    $page_owner = find_user($_GET['page_owner'], $connection);
    if (isUserDwarf($page_owner) || isUserMaster($page_owner)) {
        header('Location: ' . get_user_page($page_owner));
    }
} else {
    header('Location: ' . get_user_page($user));
    exit();
}

$title = 'Страница эльфа';

if (isset($_SESSION['messages'])) {
    $messages = $_SESSION['messages'];
    $_SESSION['messages'] = null;
}

if ($user) {
    $gem_types = get_db_data($connection, $gem_types_request);

    $page_content = renderTemplate('elf-profile', [
        'login' => $page_owner['login'],
        'NAME' => $page_owner['NAME'],
        'status' => $page_owner['status'],
        'registration_date' => $page_owner['registration_date'],
        'delete_date' => $page_owner['delete_date'],
        'gem_types' => $gem_types,
        'messages' => $messages
    ]);
    $title = $page_owner['NAME'];
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'title' => $title,
    'page_content' => $page_content
]);

print($layout_content);