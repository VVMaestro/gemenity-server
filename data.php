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

$gem_types_request = 'SELECT * FROM gem_type
                      WHERE gem_type.condition != "deleted"';

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

$unassign_gems_request = 'SELECT gems.id AS gem_id, gem_type.id AS type_id, gem_type.NAME AS type, users.name AS mine_dwarf, mine_date FROM gems
                          JOIN users ON mine_dwarf = users.id
                          JOIN gem_type ON gems.TYPE = gem_type.id
                          WHERE gems.STATUS = "not_assigned"';

$all_elves_request = 'SELECT * FROM users
                      WHERE role = "elf"';

$active_elves_request = 'SELECT * FROM users
                         WHERE role = "elf" and status != "deleted"';

$code_prefs_request = 'SELECT login, gem_type, rating FROM preferences
                        JOIN users ON users.id = preferences.USER';

$signific_request = 'SELECT * FROM settings';