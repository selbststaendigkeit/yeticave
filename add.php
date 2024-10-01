<?php
require_once('./helpers.php');
require_once('./user_data.php');
require_once('./functions/custom_functions.php');
require_once('./functions/validators.php');
require_once('./db_connection.php');

$good_categories = get_categories($db_connection);

$validation_errors = [];
$error_messages = [
    'lot-name' => 'Введите имя, спецсимволы недопустимы',
    'category' => 'Выберите существующую категорию',
    'message' => 'Введите описание, спецсимволы недопустимы',
    'lot-rate' => 'Стартовая цена должна быть больше 0',
    'lot-step' => 'Шаг ставки должен быть больше 0',
    'lot-date' => 'Выберите дату окончания торгов',
    'lot-image' => 'Загрузите изображение .jpg, .jpeg или .png'
];
$allowed_mime_types = ['image/jpeg', 'image/png'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form_fields = filter_input_array(INPUT_POST, [
        'lot-name' => [
            'filter' => FILTER_CALLBACK,
            'options' => 'validate_strings'
        ],
        'category' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'min_range' => 1,
                'max_range' => 6
            ]
        ],
        'message' => [
            'filter' => FILTER_CALLBACK,
            'options' => 'validate_strings'
        ],
        'lot-rate' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'min_range' => 1
            ]
        ],
        'lot-step' => [
            'filter' => FILTER_VALIDATE_INT,
            'options' => [
                'min_range' => 1
            ]
        ],
        'lot-date' => [
            'filter' => FILTER_CALLBACK,
            'options' => 'validate_date'
        ]
    ], true);

    foreach ($form_fields as $field_name => $field_value) {
        if (!$field_value) {
            $validation_errors[$field_name] = $error_messages[$field_name];
        }
    }


    $lot_image = $_FILES['lot-image'];
    if ($lot_image['error']) {
        $validation_errors['lot-image'] = 'Выберите файл';
    } else {
        $image_extension = pathinfo($lot_image['name'], PATHINFO_EXTENSION);
        $image_mime_type = mime_content_type($lot_image['tmp_name']);
        if (!in_array($image_mime_type, $allowed_mime_types)) {
            $validation_errors['lot-image'] = $error_messages['lot-image'];
        } else {
            $new_filename = uniqid() . '.' . $image_extension;
            $new_image_path = "uploads/$new_filename";
            $form_fields['lot-image'] = $new_image_path;
        }
    }
    
    if (!$validation_errors) {
        $form_fields['author-id'] = 1;

        $add_lot_sql_query = "INSERT INTO lots(title, category_id, details, start_price, betting_step, expires_at, img_path, author_id)
                                   VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $add_lot_stmt = db_get_prepare_stmt($db_connection, $add_lot_sql_query, $form_fields);
        $result_object = mysqli_stmt_execute($add_lot_stmt);
        if ($result_object) {
            $last_lot_id = mysqli_insert_id($db_connection);
            move_uploaded_file($lot_image['tmp_name'], $new_image_path);
        }
        
        $add_bet_sql_query = "INSERT INTO bets(price, user_id, lot_id)
                                   VALUES (?, ?, ?)";
        $add_bet_stmt = db_get_prepare_stmt($db_connection, $add_bet_sql_query, [
            $form_fields['lot-rate'],
            $form_fields['author-id'],
            $last_lot_id
        ]);
        $bets_query_result_object = mysqli_stmt_execute($add_bet_stmt);
        if ($bets_query_result_object) {
            header("Location: lot.php?id=$last_lot_id");
        }

    }
}

$layout_content = include_template('layout_add_page.php', [
    'categories' => $good_categories,
    'errors' => $validation_errors
]);

print($layout_content);
