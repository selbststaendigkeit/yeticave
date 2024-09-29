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
