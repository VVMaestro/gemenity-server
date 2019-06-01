<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user']; 

if ($user) {
    $page_content = renderTemplate('elf-profile', [
        'login' => $user['login'],
        'name' => $user['name']
    ]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'title' => $title,
    'page_content' => $page_content
]);

print($layout_content);