<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$connection = connect_to_db($database);

$user = $_SESSION['user'];

//проверка запроса
if (isset($_GET['page_owner'])) {
    $page_owner = find_user($_GET['page_owner'], $connection);
    if (isUserElf($page_owner)) {
        header('Location: ' . get_user_page($page_owner));
    }
} else {
    header('Location: ' . get_user_page($user));
    exit();
}

$title = 'Страница гнома';

if (isset($_SESSION['messages'])) {
    $messages = $_SESSION['messages'];
    $_SESSION['messages'] = null;
}

if ($user) {
    $dwarf_gems_request = 'SELECT gem_type.NAME AS name, COUNT(*) AS num FROM gems
                            JOIN users ON users.id = gems.mine_dwarf
                            JOIN gem_type ON gem_type.id = gems.TYPE
                            WHERE login = "'.$page_owner['login'].'" AND gem_type.condition != "deleted"
                            GROUP BY NAME';
    $dwarf_gems = get_db_data($connection, $dwarf_gems_request);

    $page_content = renderTemplate('dwarf-profile', [
        'login' => $page_owner['login'],
        'NAME' => $page_owner['NAME'],
        'status' => $page_owner['status'],
        'role' => $page_owner['role'],
        'registration_date' => $page_owner['registration_date'],
        'last_auth' => $page_owner['last_auth'],
        'deleted_date' => $page_owner['deleted_date'],
        'dwarf_gems' => $dwarf_gems,
        'messages' => $messages
    ]);
    $title = $page_owner['NAME'];
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);