<?php

require_once 'data.php';

function renderTemplate($template, $data = array()) {
    if (file_exists('templates/' . $template . '.php')) {
        ob_start();
        extract($data);
        require 'templates/' . $template . '.php';
        return ob_get_clean();
    }
}

function connect_to_db ($db) {
    $connect = mysqli_connect (
        $db['host'],
        $db['user'],
        $db['password'],
        $db['name'],
        $db['port']
    );

    if (!$connect) {
        print ('Ошибка соединения: ' . mysqli_connect_error());
    }

    return $connect;
}

function error_check ($con, $result) {
    if(!$result) {
        $error = 'Ошибка запроса: ' . mysqli_error($con);
        print ($error);
    }
}

function get_db_data($con, $request) {
    $result = mysqli_query($con, $request);
    error_check($con, $result);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function change_db_data($con, $request) {
    $result = mysqli_query($con, $request);
    error_check($con, $result);
}

function isUserElf ($user) {
    if ($user['role'] == 'elf') return true;
    else return false;
}

function isUserDwarf ($user) {
    if ($user['role'] == 'dwarf') return true;
    else return false;
}

function isUserMaster ($user) {
    if ($user['role'] == 'master-dwarf') return true;
    else return false;
}

function create_user($login, $password, $name, $role, $con) {

    $hashed_pass = hash('md5', $password);
    $sql_request = 'INSERT INTO users (login, password, name, role, status, registration_date)
                    VALUES ("'. $login . '","' . $hashed_pass . '","' . $name . '","' . $role . '",' . '"active", CURDATE())';
    $result = mysqli_query($con, $sql_request);

    error_check($con, $result);
}

function delete_user($login, $con) {
    $sql_request = 'UPDATE users
        SET STATUS = "deleted"
        WHERE login = "' . $login . '"';
    $result = mysqli_query($con, $sql_request);

    error_check($con, $result);
}

function find_user ($login, $con) {
    $sql_request = 'SELECT * FROM users
                    WHERE login = "' . $login . '"';

    $result = mysqli_query($con, $sql_request);
    error_check($con, $result);
    $number_of_rows = mysqli_num_rows($result);

    if ($number_of_rows == 0) {
        return false;
    } else {
        $user = mysqli_fetch_assoc($result);
        return $user;
    }
}

function get_elf_prefs ($login, $prefs) {
    $elf_prefs = [];
    foreach ($prefs as $pref) {
        if ($pref['login'] == $login) {
            array_push($elf_prefs, $pref);
        }
    }
    return $elf_prefs;
}

function sort_prefs ($prefs) {
    usort($prefs, function ($a, $b) {
        if ($a['rating'] < $b['rating']) return -1;
        elseif ($a['rating'] > $b['rating']) return 1;
        else return 0;
    });
}

function get_user_page ($user) {
    if ($user['role'] == 'elf') {
        $page = 'elf';
    } else {
        $page = 'dwarf';
    }

    return $page . '.php?page_owner=' . $user['login'];
}