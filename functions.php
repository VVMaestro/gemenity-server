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

function error_check ($con, $result) {
    if(!$result) {
        $error = 'Ошибка запроса: ' . mysqli_error($con);
        print ($error);
    }
}

function createUser($login, $password, $name, $role, $con) {
    $sql_request = 'INSERT INTO users (login, password, name, role, status, registration_date)
                    VALUES ('. $login . ',' . $password . ',' . $name . ',' . $role . ',' . '"active", CURDATE())';
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