<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$connect = connect_to_db($database);
$user = $_SESSION['user'];

if (isset($user)) {
    $gems = get_db_data($connect, $gems_request);

    $page_content = renderTemplate('gems.tmp', [
        'gems' => $gems
    ]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', ['page_content' => $page_content]);
print($layout_content);