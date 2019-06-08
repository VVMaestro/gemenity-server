<?php

$database = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'name' => 'gemenity',
    'port' => '3306'
];

$actions = [
    'create_user' => function () {

    }
];

$dwarf_request = 'SELECT login, users.NAME, COUNT(*) AS mined_gems FROM users
                        JOIN gems ON users.id = mine_dwarf
                        GROUP BY login, users.NAME';

$elf_request = 'SELECT login, users.NAME, COUNT(*) AS assigned_gems FROM users
                        JOIN gems ON users.id = assign_elf
                        GROUP BY login, users.NAME';

$preference_request = 'SELECT login, gem_type.name, rating FROM preferences
                            JOIN users ON users.id = preferences.USER
                            JOIN gem_type ON preferences.gem_type = gem_type.id';