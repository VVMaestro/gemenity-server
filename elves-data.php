<?php

require_once 'data.php';
require_once 'functions.php';

$connect = connect_to_db($database);

$prefs = get_db_data($connect, $code_prefs_request);
$active_elves = get_db_data($connect, $active_elves_request);
$elves_to_gem_amount = get_db_data($connect, $elf_request);

$elves_to_data = [];

foreach ($active_elves as $elf) {
    $elf_data = [];
    $login = $elf['login'];

    $elf_data['login'] = $login;

    foreach ($elves_to_gem_amount as $amount) {
        if ($amount['login'] == $login) {
            $elf_data['gem_amount'] = (int) $amount['assigned_gems'];
        }
    }

    if(!isset($elf_data['gem_amount'])) {
        $elf_data['gem_amount'] = 0;
    }

    foreach ($prefs as $pref) {
        if ($pref['login'] == $login) {
            $gem_name = $pref['gem_type'];
            $gem_rating = $pref['rating'];
            $elf_data['prefs'][$gem_name] = $gem_rating;
        }
    }

    if(!isset($elf_data['prefs'])) {
        $elf_data['prefs'] = [];
    }

    array_push($elves_to_data, $elf_data);
}

$json_elves_to_data = json_encode($elves_to_data);

print($json_elves_to_data);