CREATE DATABASE yeticave
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE yeticave;

CREATE TABLE lots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP,
    title VARCHAR(256),
    details TEXT,
    img_path VARCHAR(256),
    start_price INT,
    expires_at TIMESTAMP,
    betting_step INT,
    author_id INT,
    winner_id INT,
    category_id INT
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(128),
    alias VARCHAR(128)
);

CREATE TABLE bets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    created_at TIMESTAMP,
    price INT,
    user_id INT,
    lot_id INT
);

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_at TIMESTAMP,
    email VARCHAR(128) UNIQUE,
    username VARCHAR(128),
    password VARCHAR(128),
    contacts TEXT,
    lot_id INT,
    bet_id INT
);

CREATE INDEX lot_name_index
ON lots (title);

CREATE INDEX categores_alias_index
ON categories (alias);

CREATE INDEX bets_lot_id_index
ON bets (lot_id);

CREATE INDEX users_username_index
ON users (username);

CREATE UNIQUE INDEX users_email_index
ON users (email);