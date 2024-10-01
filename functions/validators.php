<?php

function validate_strings (string $text) {
    $text = str_replace(['<', '>'], '', $text);
    if (strlen($text) > 0) {
        return $text;
    }
    return null;
}

function validate_date (string $date) {
    if (is_date_valid($date)) {
        return $date;
    }
    return null;
}