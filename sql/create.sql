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