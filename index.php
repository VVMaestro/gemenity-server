<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

//если запрос из формы
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_data = $_POST;

    $errors = [];
    $required = ['login', 'password'];

    //Проверка незаполненных полей
    foreach ($required as $field) {
        if (empty($post_data[$field])) {
            $errors[$field] = 'Поле нужно заполнить';
        }
    }

    //Вынести в функцию------
    $auth_user = null;
    foreach ($users as $user) {
        if ($user['login'] == $post_data['login']) {
            $auth_user = $user;
            break;
        } else {
            $auth_user = false;
        }
    }
    //---------------------
    
    //Проверка, есть ли такой пользователь в системе
    if (!count($errors) && $auth_user) {
        //Проверка совпадения пароля
        $isPasswordVerified = $auth_user['password'] == $post_data['password'];
        if ($isPasswordVerified) {
            $_SESSION['user'] = $auth_user;
        } else {
            $errors['password'] = 'Неверный пароль';
        }
    } else {
        $errors['login'] = 'Такой пользователь не найден';
    }

    //Если есть ошибки снова показываем форму аутентификации с ошибками
    if (count($errors)) {
        $page_content = renderTemplate('auth-tpl', ['form' => $post_data, 'errors' => $errors]);
    }
    //Если ошибок нет - направляем пользователя на соответстующую страницу 
    else {
        if ($auth_user['race'] == 'dwarf') {
            header('Location: /add-gems.php');
            exit();
        } else if ($auth_user['race'] == 'elf') {
            header('Location: /elf.php');
            exit();
        }
    }
} else {
    $page_content = renderTemplate('auth-tpl', []);
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' =>'Авторизация'
]);

print($layout_content);