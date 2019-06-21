<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$connect = connect_to_db($database);
$user = $_SESSION['user'];
$title = 'Добавление камней';

if ($user && (isUserDwarf($user) || isUserMaster($user))) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        foreach ($_POST as $gem_type => $gem_amount) {
            for ($i = 0; $i < $gem_amount; $i++) {
                $sql_request = 'INSERT INTO gems (TYPE, mine_dwarf, mine_date, STATUS)
                VALUES (' . $gem_type . ', ' . $user['id'] . ', CURDATE(), "not_assigned")';
                change_db_data($connect, $sql_request);
            }
        }
    }

    $gem_types = get_db_data($connect, $gem_types_request);

    $page_content = renderTemplate('add-gems.tmp', [
        'gem_types' => $gem_types
    ]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title,
    'user' => $user
]);

print($layout_content);