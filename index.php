<?php

require_once 'data.php';
require_once 'init.php';
require_once 'functions.php';

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
    //Проверка, есть ли такой пользователь в системе
    $auth_user = find_user($post_data['login'], $connect);
    if (!count($errors) && $auth_user) {
        //Проверка совпадения пароля
        $hashed_pass = hash('md5', $post_data['password']);
        if (hash_equals($hashed_pass, $auth_user['password']) || $post_data['password'] == $auth_user['password']) {
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
        $date_request = 'UPDATE users
                        SET last_auth = CURDATE()
                        WHERE id = ' . $auth_user['id'];
        change_db_data($connect, $date_request);
        if (isUserDwarf($auth_user)) {
            header('Location: /add-gems.php');
            exit();
        } else if (isUserElf($auth_user)) {
            header('Location: /elf.php');
            exit();
        } else if (isUserMaster($auth_user)) {
            header('Location: /users.php');
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