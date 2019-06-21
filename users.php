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

    if(isset($_GET['sortby'])) {
        switch ($_GET['sortby']) {
            case 'status':
                usort($all_users, function ($left, $right) {
                    if ($left['status'] == 'active' && $right['status'] == 'deleted') return -1;
                    if ($left['status'] == 'deleted' && $right['status'] == 'active') return 1;
                    if ($left['status'] == $right['status']) return 0;
                });
                break;
            case 'name':
                usort($all_users, function ($left, $right) {
                    if ($left['NAME'] == $right['NAME']) return 0;
                    if ($left['NAME'] < $right['NAME']) return -1;
                    if ($left['NAME'] > $right['NAME']) return 1;
                });
                break;
        }
    }

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
    'title' => $title,
    'user' => $user
]);

print($layout_content);