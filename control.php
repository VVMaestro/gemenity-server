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

$connection = connect_to_db($database);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $changed_user = find_user($_POST['changed_user'], $connection);
} else {
    $changed_user = find_user($_GET['changed_user'], $connection);
}


switch ($action) {
    case 'create_user' :
        if (isUserMaster($user)) {

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
            $del_user = $_GET['login'];
            delete_user($del_user, $connection);
        } else {
            $_SESSION['messages']['denied'] = 'Только мастер-гном может удалять пользователей';
        }
        header('Location: /users.php');
        break;

    case 'change-login' :
        if (isUserMaster($user) || $user['login'] == $changed_user['login']) {
            $new_login = trim($_POST['login']);
            $users_logins = get_db_data($connection, 'SELECT login FROM users');

            if ($new_login == $changed_user['login']) {
                $_SESSION['messages']['change'] = 'Новый логин идентичен старому';
                header('Location: /' . get_user_page($changed_user));
                break;
            }

            if (in_array($new_login, $users_logins)) {
                $_SESSION['messages']['change'] = 'Этот логин занят';
                header('Location: /' . get_user_page($changed_user));
                break;
            }

            $change_login_request = 'UPDATE users
                                        SET login = "'.$new_login.'"
                                        WHERE id = "'.$changed_user['id'].'"';
            change_db_data($connection, $change_login_request);
            $_SESSION['messages']['change'] = 'Логин изменён';
            header('Location: /' . get_user_page($changed_user));
            break;
        } else {
            $_SESSION['messages']['change'] = 'У вас нет прав для этого';
            header('Location: /' . get_user_page($changed_user));
            break;
        }
        break;

    case 'change-password':
        if (isUserMaster($user) || $user['login'] == $changed_user['login']) {
            if ($_POST['password-new'] == $_POST['password-repeat']) {
                $new_password = $_POST['password-new'];
            } else {
                $_SESSION['messages']['change'] = 'Пароли не совпадают';
                header('Location: /' . get_user_page($changed_user));
                break;
            }

            $hashed_pass = hash('md5', $new_password);
            $change_pass_request = 'UPDATE users
                                    SET password = "'.$hashed_pass.'"
                                    WHERE id ="'.$changed_user['id'].'"';
            change_db_data($connection, $change_pass_request);

            $_SESSION['messages']['change'] = 'Пароль изменён';
            header('Location: /' . get_user_page($changed_user));
            break;
        } else {
            $_SESSION['messages']['change'] = 'У вас нет прав для этого';
            header('Location: /' . get_user_page($changed_user));
            break;
        }
        break;

    case 'change-name':
        if (isUserMaster($user) || $user['login'] == $changed_user['login']) {
            $new_name = $_POST['name'];
            $change_name_request = 'UPDATE users
                                    SET name = "' . $new_name . '"
                                    WHERE id ="' . $changed_user['id'] . '"';
            change_db_data($connection, $change_name_request);

            $_SESSION['messages']['change'] = 'Имя изменёно';
            header('Location: /' . get_user_page($changed_user));
            break;
        } else {
            $_SESSION['messages']['change'] = 'У вас нет прав для этого';
            header('Location: /' . get_user_page($changed_user));
            break;
        }
        break;

    case 'update-prefs':
        $new_prefs = [];
        foreach ($_POST as $key => $item) {
            if ($key != 'changed_user' || $key != 'action') {
                $new_prefs[$key] = floatval($item);
            }
        }

        $rating_sum = array_reduce($new_prefs, function ($sum, $item, $initial = 0) {
            $sum += $item;
            return $sum;
        });

        if ($rating_sum > 1) {
            $_SESSION['messages']['denied'] = 'Сумма предпочтений не может быть больше единицы';
            header('Location: ' . get_user_page($changed_user));
            exit();
        }

        $elf_prefs_request = 'SELECT gem_type.id, name, rating FROM gem_type
                            LEFT JOIN 
                            (SELECT * FROM preferences WHERE USER = "' . $changed_user['id'] . '") AS elf_prefs
                            ON gem_type.id = gem_type';
        $elf_prefs = get_db_data($connection, $elf_prefs_request);

        foreach ($elf_prefs as $pref) {
            if ($pref['rating'] == null) {
                $pref_request = 'INSERT INTO preferences (gem_type, user, rating)
                                        VALUES ("'. $pref['id'] . '","'. $changed_user['id'] . '","'. $new_prefs[$pref['id']] . '")';
            } else {
                $pref_request = 'UPDATE preferences
                                 SET rating = "' . $new_prefs[$pref['id']] . '"
                                 WHERE gem_type = "' . $pref['id'] . '" AND user = "' . $changed_user['id'] . '"';
            }

            change_db_data($connection, $pref_request);
        }
        $_SESSION['messages']['success'] = 'Предпочтения обновлены';
        header('Location: ' . get_user_page($changed_user));
        exit();
        break;

    case 'confirm_gem':
        if ($changed_user['login'] == $user['login']) {
            $gem_id = $_GET['gem_id'];
            $confirm_gem_request = 'UPDATE gems
                                    SET STATUS = "confirmed"
                                    WHERE id = ' . $gem_id;
            change_db_data($connection, $confirm_gem_request);

            $_SESSION['messages']['success'] = 'Получение камня подтверждено';
            header('Location: ' . get_user_page($changed_user));
            break;
        } else {
            $_SESSION['messages']['denied'] = 'Только сами пользователи могут подтверждать полученные камни';
            header('Location: ' . get_user_page($changed_user));
            exit();
            break;
        }

    case 'update-signific':

        if (isUserMaster($user)) {
            $signifigs = array_filter($_POST, function ($value, $key) {
                if ($key == 'action') return false;
                else return true;
            }, ARRAY_FILTER_USE_BOTH);

            $sign_sum = array_reduce($signifigs, function ($carry, $value) {
                return $carry + $value;
            });

            if ($sign_sum > 1) {
                $_SESSION['messages']['denied'] = 'Значимость не должна быть больше единицы!';
                header('Location: /settings.php');
                exit();
            }

            foreach ($signifigs as $key => $sign) {
                $update_sign_request = 'UPDATE settings
                                        SET value = ' . $sign . ' 
                                        WHERE setting = "assign_' . $key . '"';
                change_db_data($connection, $update_sign_request);
            }
            header('Location: /settings.php');
            exit();
        } else {
            header('Location: /index.php');
            exit();
        }
        break;

    case 'delete-type':
        if (isUserMaster($user)) {
            $type_for_delete = $_GET['type-id'];
            $delete_type_request = 'UPDATE gem_type
                                  SET gem_type.condition = "deleted"
                                  WHERE id = ' . $type_for_delete;
            change_db_data($connection, $delete_type_request);
            header('Location: /settings.php');
        } else {
            header('Location: /index.php');
            exit();
        }
        break;
    case 'add-type':
        if (isUserMaster($user)) {
            $new_type = $_POST['type-name'];
            $new_type_request = 'INSERT INTO gem_type (gem_type.condition, name)
                                 VALUES ("active", "' . $new_type . '")';
            change_db_data($connection, $new_type_request);
            header('Location: /settings.php');
        } else {
            header('Location: /index.php');
            exit();
        }
        break;
}
