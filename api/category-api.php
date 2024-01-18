<?php
require('./config/Database.php');
require('Category.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $categoryId = $_GET['id'];
            $data = $category->getCategoryById($categoryId);
        } else {
            $data = $category->getAllCategories();
        }
        break;

    case 'POST':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);
        
        $name = isset($formData['name']) ? $formData['name'] : null;
        
        $success = $category->addCategory($name);
        $data = array('success' => $success);
        break;

    case 'PUT':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);
        
        $categoryId = isset($formData['id']) ? $formData['id'] : null;
        $name = isset($formData['name']) ? $formData['name'] : null;
        
        $success = $category->updateCategory($categoryId, $name);
        $data = array('success' => $success);

        break;

    case 'DELETE':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);
        
        $categoryId = isset($formData['id']) ? $formData['id'] : null;

        $success = $category->deleteCategory($categoryId);
        $data = array('success' => $success);
        break;

    default:
        $data = array('error' => 'Invalid HTTP request method');
}

header('Content-Type: application/json');
echo json_encode($data);

exit;
?>