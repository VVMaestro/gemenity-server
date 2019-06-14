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

$gems_request = 'SELECT gem_type.NAME,
       elfs.NAME AS assign_elf,
       dwarfs.NAME AS mined_dwarf,
       masters.NAME AS confirm_by,
       mine_date,
       assign_date,
       confirmation_date,
       assigned_by,
       gems.status
FROM gems
    JOIN users AS dwarfs ON dwarfs.id = mine_dwarf
    left JOIN users AS elfs ON elfs.id = assign_elf
    LEFT JOIN users AS masters ON masters.id = confirmation_master
    JOIN gem_type ON gem_type.id = type;';