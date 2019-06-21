<?php

require_once 'data.php';
require_once 'functions.php';

session_start();

$user = $_SESSION['user'];
$title = 'Распределить драгоценности';
$messages = null;

if (isset($user) && isUserMaster($user)) {
    $connect = connect_to_db($database);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $assigned_gems = [];
        $manuallyGems = explode(';', $_POST['manually-gems']);

        foreach ($_POST as $name => $value) {
            if ($name != 'manually-gems') {
                $assigned_gems[$name] = $value;
            }
        }

        $all_elves = get_db_data($connect, $all_elves_request);

        foreach ($assigned_gems as $gem => $elf_login) {
            $elf_for_gem = [];
            if(in_array($gem, $manuallyGems)) {
                $assign_by = 'manually';
            } else $assign_by = 'algorithm';

            foreach ($all_elves as $elf) {
                if ($elf['login'] == trim($elf_login)) {
                    $elf_for_gem = $elf;

                    if ($elf['status'] == 'deleted') {
                        $messages['user_deleted'] = $elf_login . ' - эльф удалён.';
                    }

                }
            }

            if(empty($elf_for_gem)) {
                $messages['not_login'] = $elf_login . ' - эльфа с таким логином не существует!';
            }

            if (!isset($messages)) {
                $gem_assign_request = 'UPDATE gems
                                       SET assign_elf ="' . $elf_for_gem['id'] . '",
                                        confirmation_master ="' . $user['id'] . '",
                                        assign_date = CURDATE(),
                                        assigned_by = "'. $assign_by .'",
                                        status = "assigned"
                                        WHERE id = ' . $gem;
                change_db_data($connect, $gem_assign_request);
            }
        }
    }

    $unassign_gems = get_db_data($connect, $unassign_gems_request);

    if (empty($unassign_gems)) {
        $messages['nothing'] = 'Нечего распределять. Добудьте ещё камней.';
    }

    $page_content = renderTemplate('gem-assign.tmp', [
        'unassign_gems' => $unassign_gems,
        'messages' => $messages
    ]);

    $messages = null;
} else {
    header('Location: /index.php');
    exit();
}

$layout_content = renderTemplate('layout', [
    'page_content' => $page_content,
    'title' => $title,
    'user' => $user
]);

print ($layout_content);