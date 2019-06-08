<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] = 'GET') {
    $user = $_SESSION['user'];
    $errors = [];

    if ($user['role'] == 'master-dwarf') {

    }
} else {
    header('Location: /index.php');
}