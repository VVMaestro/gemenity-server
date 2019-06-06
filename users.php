<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Добавить камни';

if ($user) {
    $connect = connect_to_db($database);

    $elf_result = mysqli_query($connect, $elf_request);
    error_check($connect, $elf_result);

    $dwarf_result = mysqli_query($connect, $dwarf_request);
    error_check($connect, $dwarf_result);

    $preference_result = mysqli_query($connect, $preference_request);
    error_check($connect, $preference_result);

    $elves = mysqli_fetch_all($elf_result, MYSQLI_ASSOC);
    $dwarfs = mysqli_fetch_all($dwarf_result, MYSQLI_ASSOC);
    $preferences = mysqli_fetch_all($preference_result, MYSQLI_ASSOC);

    $page_content = renderTemplate('users.tmp', [
        'elves' => $elves,
        'dwarfs' => $dwarfs,
        'prefs' => $preferences
    ]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);