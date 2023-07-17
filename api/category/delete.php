<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');


include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();

$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;

if ($category->delete()) {
    echo json_encode(array('message' => 'Category Deleted'));
} else {
    echo json_encode(array('message' => 'Category Not Deleted'));
}
