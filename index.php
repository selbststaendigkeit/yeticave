<?php
require_once('./helpers.php');
require_once('./user_data.php');
require_once('./functions/custom_functions.php');
require_once('./db_connection.php');


$safe_lot_creation_date = mysqli_real_escape_string($db_connection, 'created_at');
$sql_lots_query = "SELECT l.id AS id,
                          l.title AS title,
                          c.title AS category,
                          l.start_price AS price,
                          l.img_path AS image_url,
                          l.expires_at AS expiration_date
                    FROM lots AS l
            INNER JOIN categories AS c ON l.category_id = c.id
                ORDER BY $safe_lot_creation_date DESC";

$sql_lots_query_result = mysqli_query($db_connection, $sql_lots_query);
if ($sql_lots_query_result) {
    $lots = mysqli_fetch_all($sql_lots_query_result, MYSQLI_ASSOC);
} else {
    print('Ошибка запроса SQL: ' . mysqli_error($db_connection));
}

$good_categories = get_categories($db_connection);

$page_content = include_template('main.php', [
    'categories' => $good_categories,
    'lots' => $lots
]);
$layout_content = include_template('layout.php', [
    'pagetitle' => 'Главная',
    'content' => $page_content,
    'categories' => $good_categories
]);

print($layout_content);