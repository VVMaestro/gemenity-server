<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
} else {
    $action = $_GET['action'];
}

switch ($action) {
    case 'create_user' :
        if (isUserMaster($user)) {
            $connection = connect_to_db($database);

            if (!find_user($_POST['login'], $connection)) {
                create_user(
                    $_POST['login'],
                    $_POST['password'],
                    $_POST['name'],
                    $_POST['role'],
                    $connection
                );
                $_SESSION['messages']['created'] = 'Приветствуем новичка. Добро пожаловать ' . $_POST['name'];
            } else {
                $_SESSION['messages']['exist'] = 'Пользователь с таким логином уже существует.';
            }
        } else {
            $_SESSION['messages']['denied'] = 'Только мастер-гном может добавлять пользователей';
        }
        header('Location: /users.php');
        break;
    case 'delete_user' :
        header('Location: /users.php');
        break;
}
