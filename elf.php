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
    $elf_prefs_request = 'SELECT gem_type.id, name, rating FROM gem_type
                          LEFT JOIN 
                          (SELECT * FROM preferences WHERE USER = ' . $page_owner['id'] . ') AS elf_prefs
                          ON gem_type.id = gem_type
                          WHERE gem_type.condition != "deleted"';
    $elf_assigned_request = 'SELECT gems.id AS gem_id, NAME FROM gems
                             JOIN gem_type ON TYPE = gem_type.id
                             WHERE assign_elf = '. $page_owner['id'] .' AND STATUS = "assigned"';

    $elf_prefs = get_db_data($connection, $elf_prefs_request);

    if($page_owner['id'] == $user['id']) {
        $assigned_gems = get_db_data($connection, $elf_assigned_request);
    }

    $page_content = renderTemplate('elf-profile', [
        'login' => $page_owner['login'],
        'NAME' => $page_owner['NAME'],
        'status' => $page_owner['status'],
        'registration_date' => $page_owner['registration_date'],
        'last_auth' => $page_owner['last_auth'],
        'delete_date' => $page_owner['delete_date'],
        'elf_prefs' => $elf_prefs,
        'messages' => $messages,
        'assigned_gems' => $assigned_gems
    ]);
    $title = $page_owner['NAME'];
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'title' => $title,
    'page_content' => $page_content,
    'user' => $user
]);

print($layout_content);