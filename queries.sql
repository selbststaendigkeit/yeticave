INSERT INTO categories (title, alias)
VALUES ("Доски и лыжи", "boards"),
    ("Крепления", "attachment"),
    ("Ботинки", "boots"),
    ("Одежда", "clothing"),
    ("Инструменты", "tools"),
    ("Разное", "other");
INSERT INTO users (email, username, password, contacts)
VALUES (
        'yoyo@gmail.net',
        'YoCoolgirl',
        'query1*',
        "89189823710"
    ),
    (
        'hamburger@gmail.net',
        "FatBoy",
        "query2*",
        "89188128320"
    );
INSERT INTO lots (
        title,
        img_path,
        start_price,
        betting_step,
        author_id,
        category_id
    )
VALUES (
        '2014 Rossignol District Snowboard',
        'img/lot-1.jpg',
        10999,
        500,
        1,
        1
    ),
    (
        'DC Ply Mens 2016/2017 Snowboard',
        'img/lot-2.jpg',
        159999,
        1000,
        2,
        1
    ),
    (
        'Крепления Union Contact Pro 2015 года размер L/XLd',
        'img/lot-3.jpg',
        8000,
        500,
        2,
        2
    ),
    (
        'Ботинки для сноуборда DC Mutiny Charocal',
        'img/lot-4.jpg',
        10999,
        700,
        1,
        3
    ),
    (
        'Куртка для сноуборда DC Mutiny Charocal',
        'img/lot-5.jpg',
        7500,
        900,
        1,
        4
    ),
    (
        'Маска Oakley Canopy',
        'img/lot-6.jpg',
        5400,
        800,
        1,
        6
    );
INSERT INTO bets (price, user_id, lot_id)
VALUES (11499, 1, 1);
SELECT *
FROM categories;
SELECT l.title,
    l.start_price,
    l.img_path,
    b.price,
    c.title
FROM lots AS l
    INNER JOIN categories AS c ON l.category_id = c.id
    INNER JOIN bets AS b ON l.id = b.lot_id
WHERE l.expires_at > NOW();
SELECT l.id,
    c.title
FROM lots AS l
    INNER JOIN categories AS c ON l.category_id = c.id
WHERE l.id = 3;
UPDATE lots
SET title = 'New title'
WHERE id = 2;

SELECT *
FROM bets
WHERE lot_id = 1
ORDER BY created_at ASC