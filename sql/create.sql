-- Создание базы данных
CREATE DATABASE gemenity 
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE gemenity;

-- Создание таблицы пользователей
CREATE TABLE users (
    id		          INT AUTO_INCREMENT PRIMARY KEY,
    login	          CHAR(128),
    password          CHAR(64),
    role	          CHAR(64), -- elf/dwarf/master-dwarf
    status            CHAR(64), -- active/deleted
    registration_date DATE,
    last_auth         DATE,
    deleting_date     DATE,
    name              CHAR(128)
);

-- Создание таблицы камней
CREATE TABLE gems (
    id                  INT AUTO_INCREMENT PRIMARY KEY,
    type                INT,
    mine_dwarf          INT,
    assign_elf          INT,
    confirmation_master INT,
    mine_date           DATE,
    assign_date         DATE,
    confirmation_date   DATE,
    assigned_by         CHAR(64), -- algorithm/manually
    status              CHAR(64) -- assigned/not_assigned/confirmed
);

-- Создание таблицы типов камней
CREATE TABLE gem_type (
    id   INT AUTO_INCREMENT PRIMARY KEY,
    name CHAR(64)
);

-- Создание таблицы предпочтений
CREATE TABLE preferences (
    gem_type INT,
    user     INT,
    rating   FLOAT
);

-- Создание таблицы весов алгоритмов
CREATE TABLE settings (
    assign_equally  FLOAT,
    assign_prefs    FLOAT,
    assign_byone    FLOAT
);

-- Удаление пользователя
UPDATE users
SET STATUS = 'deleted'
WHERE login = 'levi';

-- Добавление камней
INSERT INTO gems (TYPE, mine_dwarf, assign_elf, confirmation_master, mine_date, assign_date, confirmation_date, assigned_by, STATUS)
VALUES (7, 3, 1, 3, CURDATE(), CURDATE(), CURDATE(), 'manually', 'assigned');

-- Пользователи с камнями
SELECT gems.id, login, role, users.NAME, gem_type.NAME AS 'type' FROM gems
    JOIN users ON users.id = gems.assign_elf OR users.id = gems.mine_dwarf
    JOIN gem_type ON gem_type.id = gems.type;

-- Камни и назначенные им эльфы
SELECT gems.id, login, role, users.NAME, gem_type.NAME AS 'type' FROM gems
    JOIN users ON users.id = gems.assign_elf
    JOIN gem_type ON gem_type.id = gems.TYPE;

-- Камни и добывшие их гномы
SELECT gems.id, login, role, users.NAME, gem_type.NAME AS 'type' FROM gems
    JOIN users ON users.id = gems.mine_dwarf
    JOIN gem_type ON gem_type.id = gems.TYPE;

-- ?
SELECT login, COUNT(*) FROM users
    JOIN gems ON users.id = mine_dwarf
GROUP BY login;

-- Предпочтения
SELECT login, gem_type.name, rating FROM preferences
    JOIN users ON users.id = preferences.USER
    JOIN gem_type ON preferences.gem_type = gem_type.id;

-- Число камней каждого типа, добытых определённым гномом
SELECT gem_type.NAME AS 'name', COUNT(*) FROM gems
    JOIN users ON users.id = gems.mine_dwarf
    JOIN gem_type ON gem_type.id = gems.TYPE
WHERE login = 'gimli'
GROUP BY NAME;

-- Запрос камней
SELECT gem_type.NAME,
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
    JOIN gem_type ON gem_type.id = type;