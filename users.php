<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Пользователи';
$messages = [];

if (isset($user)) {
    $connect = connect_to_db($database);

    $all_users_result = mysqli_query($connect, $all_users_request);
    error_check($connect, $all_users_result);

    $elf_result = mysqli_query($connect, $elf_request);
    error_check($connect, $elf_result);

    $dwarf_result = mysqli_query($connect, $dwarf_request);
    error_check($connect, $dwarf_result);

    $preference_result = mysqli_query($connect, $preference_request);
    error_check($connect, $preference_result);

    $all_users = mysqli_fetch_all($all_users_result, MYSQLI_ASSOC);
    $elves = mysqli_fetch_all($elf_result, MYSQLI_ASSOC);
    $dwarfs = mysqli_fetch_all($dwarf_result, MYSQLI_ASSOC);
    $preferences = mysqli_fetch_all($preference_result, MYSQLI_ASSOC);

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