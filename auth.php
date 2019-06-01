<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$post_data = $_POST;
$auth_user = array();
$error_message = '';

foreach ($users as $user) {
    if ($user['login'] == $post_data['login']) {
        $auth_user = $user;
        break;
    } else {
        $error_message = 'Пользователь не найден.';
        header('Location: /index.php');
    }
}

if ($post_data['password'] == $auth_user['password']) {
    $page_content = renderTemplate('elf-profile', [
        'login' => $auth_user['login'],
        'name' => $auth_user['name'],
        'status' => $auth_user['status']
        ]);
    $layout_content = renderTemplate('layout', [
        'page_content' => $page_content,
        'title' => $auth_user['name']
        ]);
    print ($layout_content);
} else {
    $error_message = 'Неверный пароль.';
    header('Location: /index.php');
}