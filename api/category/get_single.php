<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

if ($_GET['id']) {
    $category->id = $_GET['id'];
    $category->get_single_category();

    $category_item = [
        'id' => $category->id,
        'name' => $category->name,
    ];

    print_r(json_encode($category));
} else {
    echo json_encode(array('message' => 'No categories found'));
}
;
