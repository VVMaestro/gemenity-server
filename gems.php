<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$connect = connect_to_db($database);
$user = $_SESSION['user'];
$title = 'Драгоценности';

if (isset($user)) {
    $post_to_filter = [
        'elf' => function ($gem) {
            if ($gem['assign_elf'] == $_POST['text']) return true;
            else return false;
        },
        'dwarf' => function ($gem) {
            if ($gem['mined_dwarf'] == $_POST['text']) return true;
            else return false;
        },
        'master-dwarf' => function ($gem) {
            if ($gem['confirm_by'] == $_POST['text']) return true;
            else return false;
        },
        'assign-before' => function ($gem) {
            if (!isset($gem['assign_date'])) return false;
            if (strtotime($gem['assign_date']) <= strtotime($_POST['date'])) return true;
            else return false;
        },
        'assign-after' => function ($gem) {
            if (!isset($gem['assign_date'])) return false;
            if (strtotime($gem['assign_date']) >= strtotime($_POST['date'])) return true;
            else return false;
        },
        'confirmed-before' => function ($gem) {
            if (!isset($gem['confirmation_date'])) return false;
            if (strtotime($gem['confirmation_date']) <= strtotime($_POST['date'])) return true;
            else return false;
        },
        'confirmed-after' => function ($gem) {
            if (!isset($gem['confirmation_date'])) return false;
            if (strtotime($gem['confirmation_date']) >= strtotime($_POST['date'])) return true;
            else return false;
        },
        'type' => function ($gem) {
            if ($gem['NAME'] == $_POST['type']) return true;
            else return false;
        },
        'status' => function ($gem) {
            if ($gem['status'] == $_POST['status']) return true;
            else return false;
        }
    ];

    $gems = get_db_data($connect, $gems_request);
    $gem_types = get_db_data($connect, $gem_types_request);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $filtered_gems = array_filter($gems, $post_to_filter[$_POST['filter']]);
    } else {
        $filtered_gems = $gems;
    }

    $page_content = renderTemplate('gems.tmp', [
        'gems' => $filtered_gems,
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