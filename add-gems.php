<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$connect = connect_to_db($database);
$user = $_SESSION['user'];
$title = 'Добавление камней';

if ($user && ($user['role'] == 'dwarf' || 'master-dwarf')) {
    $gem_types = get_db_data($database, $gem_types_request);

    $page_content = renderTemplate('add-gems.tmp', [
        'gem_types' => $gem_types
    ]);
} else {
    header('Location: /index.php');
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title
]);

print($layout_content);