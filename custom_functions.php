<?php
function format_price_number (int $price_number) {
    $rounded_price = ceil($price_number);
    if ($rounded_price >= 1000) {
        $rounded_price = number_format($rounded_price, 0, '', ' ');
    }
    $final_price = "$rounded_price ₽";
    return $final_price;
}

function get_time_to_lot_expire ($expiration_date) {
    $current_time = time();
    $expiration_time = strtotime($expiration_date);
    $seconds_to_expiration = $expiration_time - $current_time;
    $hours_to_expiration = floor($seconds_to_expiration / 3600);
    $hours_to_expiration_final = str_pad($hours_to_expiration, 2, '0', STR_PAD_LEFT);
    $minutes_to_expiration = floor(($seconds_to_expiration - $hours_to_expiration * 3600) / 60);
    $minutes_to_expiration_final = str_pad($minutes_to_expiration, 2, '0', STR_PAD_LEFT);
    return [$hours_to_expiration_final, $minutes_to_expiration_final];
}

function get_categories ($db_connection) {
    $sql_query = "SELECT title, alias FROM categories";
    $sql_categories_query_result = mysqli_query($db_connection, $sql_query);
    if ($sql_categories_query_result) {
        return mysqli_fetch_all($sql_categories_query_result, MYSQLI_ASSOC);
    } else {
        print('Ошибка запроса SQL: ' . mysqli_error($db_connection));
    }
}

function get_lot_stmt_query () {
    return "SELECT l.id AS id,
          l.title AS title,
          c.title AS category,
     l.created_at AS creation_date,
     l.expires_at AS expiration_date,
       l.img_path AS image_url,
        l.details AS description,
          b.price AS current_price
                FROM lots AS l
          INNER JOIN categories AS c ON l.category_id = c.id
          INNER JOIN bets AS b ON l.id = b.lot_id
               WHERE l.id = ?
            ORDER BY b.price DESC";
}