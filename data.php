<?php

$database = [
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'name' => 'gemenity',
    'port' => '3306'
];

$dwarf_request = 'SELECT login, COUNT(*) AS mined_gems FROM users
                        JOIN gems ON users.id = mine_dwarf
                        GROUP BY login';

$elf_request = 'SELECT login, COUNT(*) AS assigned_gems FROM users
                        JOIN gems ON users.id = assign_elf
                        GROUP BY login';

$all_users_request = 'SELECT * FROM users';

$preference_request = 'SELECT login, gem_type.name, rating FROM preferences
                            JOIN users ON users.id = preferences.USER
                            JOIN gem_type ON preferences.gem_type = gem_type.id';

$gem_types_request = 'SELECT * FROM gem_type';