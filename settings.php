<?php

require_once 'functions.php';
require_once 'data.php';

session_start();

$connect = connect_to_db($database);
$user = $_SESSION['user'];
$title = 'Настройки системы';
$messages = [];

if (isset($user) && isUserMaster($user)) {
    $gem_types = get_db_data($connect, $gem_types_request);
    $settings = get_db_data($connect, $signific_request);
    $signific = [];
    foreach ($settings as $set) {
        $signific[$set['setting']] = (float) $set['value'];
    }

    if (isset($_SESSION['messages'])) {
        $messages = $_SESSION['messages'];
        $_SESSION['messages'] = null;
    }

    $page_content = renderTemplate('settings.tmp', [
        'signific' => $signific,
        'gem_types' => $gem_types,
        'messages' => $messages
    ]);
} else {
    header('Location: /index.php');
    exit();
}

$layout = renderTemplate('layout', [
    'title' => $title,
    'page_content' => $page_content
]);

print ($layout);