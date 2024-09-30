<?php
require_once('./helpers.php');
require_once('./user_data.php');
require_once('./custom_functions.php');
require_once('./db_connection.php');

$lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$sql_categories_query = "SELECT title, alias
                           FROM categories";
$sql_categories_query_result = mysqli_query($db_connection, $sql_categories_query);
if ($sql_categories_query_result) {
    $good_categories = mysqli_fetch_all($sql_categories_query_result, MYSQLI_ASSOC);
} else {
    print('Ошибка запроса SQL: ' . mysqli_error($db_connection));
}

$sql_lot_query = "SELECT l.id AS id,
          l.title AS title,
          c.title AS category,
     l.created_at AS creation_date,
     l.expires_at AS expiration_date,
       l.img_path AS image_url,
        l.details AS description,
          b.price AS current_price
                FROM lots AS l
          INNER JOIN categories AS c ON l.category_id = c.id
          LEFT JOIN bets AS b ON l.id = b.lot_id
               WHERE l.id = ?
            ORDER BY b.price DESC";

$lot_query_stmt = db_get_prepare_stmt($db_connection, $sql_lot_query, [$lot_id]);
mysqli_stmt_execute($lot_query_stmt);
$lot_result_object = mysqli_stmt_get_result($lot_query_stmt);
$lot = mysqli_fetch_assoc($lot_result_object);

$page_content = include_template('lot_page.php', [
    'categories' => $good_categories,
    'lot' => $lot
]);
$layout_content = include_template('layout.php', [
    'pagetitle' => $lot['title'],
    'content' => $page_content,
    'categories' => $good_categories
]);

print($layout_content);
