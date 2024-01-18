<?php
require('./config/Database.php');
require('Product.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$db = $database->getConnection();
$product = new Product($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $data = $product->getProductById($productId);
        } else {
            $data = $product->getAllProducts("all");
        }
        break;

    case 'POST':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);

        $name = isset($formData['name']) ? $formData['name'] : null;
        $price = isset($formData['price']) ? $formData['price'] : null;
        $detail = isset($formData['detail']) ? $formData['detail'] : null;
        $ratings = isset($formData['ratings']) ? $formData['ratings'] : null;
        $rating_count = isset($formData['rating_count']) ? $formData['rating_count'] : null;
        $category = isset($formData['category']) ? $formData['category'] : null;

        $success = $product->addProduct($name, $price, $detail, $ratings, $rating_count, $category);
        $data = array('success' => $success);
        break;

    case 'PUT':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);

        $productId = isset($formData['id']) ? $formData['id'] : null;
        $name = isset($formData['name']) ? $formData['name'] : null;
        $price = isset($formData['price']) ? $formData['price'] : null;
        $detail = isset($formData['detail']) ? $formData['detail'] : null;
        $ratings = isset($formData['ratings']) ? $formData['ratings'] : null;
        $rating_count = isset($formData['rating_count']) ? $formData['rating_count'] : null;
        $category = isset($formData['category']) ? $formData['category'] : null;

        $success = $product->updateProduct($productId, $name, $detail, $price, $ratings, $rating_count, $category);
        $data = array('success' => $success);

        break;

    case 'DELETE':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);

        $productId = isset($formData['id']) ? $formData['id'] : null;

        $success = $product->deleteProduct($productId);
        $data = array('success' => $success);
        break;

    default:
        $data = array('error' => 'Invalid HTTP request method');
}

header('Content-Type: application/json');
echo json_encode($data);

exit;
?>