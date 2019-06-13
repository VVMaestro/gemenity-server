<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Пользователи';
$messages = [];

if (isset($user)) {
    $connect = connect_to_db($database);

    $all_users = get_db_data($connect, $all_users_request);
    $elves = get_db_data($connect, $elf_request);
    $dwarfs = get_db_data($connect, $dwarf_request);
    $preferences = get_db_data($connect, $preference_request);

    if (isset($_SESSION['messages'])) {
        $messages = $_SESSION['messages'];
        $_SESSION['messages'] = null;
    }

    $page_content = renderTemplate('users.tmp', [
        'all_users' => $all_users,
        'elves' => $elves,
        'dwarfs' => $dwarfs,
        'prefs' => $preferences,
        'messages' => $messages
    ]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);