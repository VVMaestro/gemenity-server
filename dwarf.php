<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$user = $_SESSION['user'];
$title = 'Страница гнома';

if (isset($_SESSION['messages'])) {
    $messages = $_SESSION['messages'];
    $_SESSION['messages'] = null;
}

if ($user && (isUserDwarf($user) || isUserMaster($user))) {
    $connection = connect_to_db($database);
    $dwarf_gems_request = 'SELECT gem_type.NAME AS name, COUNT(*) AS num FROM gems
                            JOIN users ON users.id = gems.mine_dwarf
                            JOIN gem_type ON gem_type.id = gems.TYPE
                            WHERE login = "'.$user['login'].'"
                            GROUP BY NAME';
    $dwarf_gems = get_db_data($connection, $dwarf_gems_request);

    $page_content = renderTemplate('dwarf-profile', [
        'login' => $user['login'],
        'NAME' => $user['NAME'],
        'status' => $user['status'],
        'role' => $user['role'],
        'registration_date' => $user['registration_date'],
        'deleted_date' => $user['deleted_date'],
        'dwarf_gems' => $dwarf_gems,
        'messages' => $messages
    ]);
    $title = $user['NAME'];
} elseif (isUserElf($user)) {
    header('Location: /elf.php');
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);