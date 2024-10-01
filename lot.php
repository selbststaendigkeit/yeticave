<?php
require_once('./helpers.php');
require_once('./user_data.php');
require_once('./custom_functions.php');
require_once('./db_connection.php');

$good_categories = get_categories($db_connection);

$page_404 = include_template('404.php', [
    'categories' => $good_categories
]);
$lot_id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
if (!$lot_id) {
    print($page_404);
    die();
}

$lot_query_stmt = db_get_prepare_stmt($db_connection, get_lot_stmt_query(), [$lot_id]);
mysqli_stmt_execute($lot_query_stmt);
$lot_result_object = mysqli_stmt_get_result($lot_query_stmt);

if (mysqli_num_rows($lot_result_object) > 0) {
    $lot = mysqli_fetch_assoc($lot_result_object);
} else {
    print($page_404);
    die();
}

$page_content = include_template('lot_page.php', [
    'categories' => $good_categories,
    'lot' => $lot
]);
$layout_content = include_template('layout_lot.php', [
    'pagetitle' => htmlspecialchars($lot['title']),
    'content' => $page_content,
    'categories' => $good_categories
]);

print($layout_content);
