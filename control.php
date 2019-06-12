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
        if (isUserMaster($user)) {
            $connection = connect_to_db($database);
            $del_user = $_GET['login'];
            delete_user($del_user, $connection);
        } else {
            $_SESSION['messages']['denied'] = 'Только мастер-гном может удалять пользователей';
        }
        header('Location: /users.php');
        break;

    case 'change-login' :
        $connection = connect_to_db($database);
        $changed_user = find_user($_POST['changed_user'], $connection);

        if (isUserElf($changed_user)) {
            $page = 'elf';
        } else $page = 'dwarf';

        if (isUserMaster($user) || $user['login'] == $changed_user['login']) {
            $new_login = trim($_POST['login']);
            $users_logins = get_db_data($connection, 'SELECT login FROM users');

            if ($new_login == $changed_user['login']) {
                $_SESSION['messages']['change'] = 'Новый логин идентичен старому';
                header('Location: /' . $page . '.php');
                break;
            }

            if (in_array($new_login, $users_logins)) {
                $_SESSION['messages']['change'] = 'Этот логин занят';
                header('Location: /' . $page. '.php');
                break;
            }

            $change_login_request = 'UPDATE users
                                        SET login = "'.$new_login.'"
                                        WHERE id = "'.$changed_user['id'].'"';
            change_db_data($connection, $change_login_request);
            $_SESSION['user'] = find_user($new_login, $connection);
            $_SESSION['messages']['change'] = 'Логин изменён';
            header('Location: /' . $page. '.php');
            break;
        } else {
            $_SESSION['messages']['change'] = 'У вас нет прав для этого';
            header('Location: /' . $page . '.php');
            break;
        }
        break;

    case 'change-password':
        $connection = connect_to_db($database);
        $changed_user = find_user($_POST['changed_user'], $connection);

        if (isUserElf($changed_user)) {
            $page = 'elf';
        } else $page = 'dwarf';

        if (isUserMaster($user) || $user['login'] == $changed_user['login']) {
            if ($_POST['password-new'] == $_POST['password-repeat']) {
                $new_password = $_POST['password-new'];
            } else {
                $_SESSION['messages']['change'] = 'Пароли не совпадают';
                header('Location: /' . $page . '.php');
                break;
            }

            $hashed_pass = hash('md5', $new_password);
            $change_pass_request = 'UPDATE users
                                    SET password = "'.$hashed_pass.'"
                                    WHERE id ="'.$changed_user['id'].'"';
            change_db_data($connection, $change_pass_request);

            $_SESSION['messages']['change'] = 'Пароль изменён';
            header('Location: /' . $page. '.php');
            break;
        } else {
            $_SESSION['messages']['change'] = 'У вас нет прав для этого';
            header('Location: /' . $page . '.php');
            break;
        }
        break;
    case 'change-name':
        $connection = connect_to_db($database);
        $changed_user = find_user($_POST['changed_user'], $connection);

        if (isUserElf($changed_user)) {
            $page = 'elf';
        } else $page = 'dwarf';

        if (isUserMaster($user) || $user['login'] == $changed_user['login']) {
            $new_name = $_POST['name'];
            $change_name_request = 'UPDATE users
                                    SET name = "' . $new_name . '"
                                    WHERE id ="' . $changed_user['id'] . '"';
            change_db_data($connection, $change_name_request);

            $_SESSION['user'] = find_user($changed_user['login'], $connection);
            $_SESSION['messages']['change'] = 'Имя изменёно';
            header('Location: /' . $page. '.php');
            break;
        } else {
            $_SESSION['messages']['change'] = 'У вас нет прав для этого';
            header('Location: /' . $page . '.php');
            break;
        }
}
