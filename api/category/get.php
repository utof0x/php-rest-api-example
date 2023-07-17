<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$result = $category->get_categories();
$num = $result->rowCount();

if ($num > 0) {
    $categories = array();
    $categories['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $category_item = [
            'id' => $id,
            'name' => $name,
        ];


        $categories['data'][] = $category_item;
    }

    echo json_encode($categories);
} else {
    echo json_encode(array('message' => 'No categories found'));
}