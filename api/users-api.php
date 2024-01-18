<?php
require('./config/Database.php');
require('User.php');

error_reporting(E_ALL);
ini_set('display_errors', 1);

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];
            $data = $user->getUserById($userId);
        } else {
            $data = $user->getAllUsers();
        }
        break;

    case 'POST':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);

        // Login
        if (isset($formData['action']) && $formData['action'] === 'login') {
            $email = isset($formData['email']) ? $formData['email'] : null;
            $password = isset($formData['password']) ? $formData['password'] : null;

            $loginResult = $user->login($email, $password);
            echo $loginResult;
            exit;
        }

        // Register
        $first_name = isset($formData['first_name']) ? $formData['first_name'] : null;
        $last_name = isset($formData['last_name']) ? $formData['last_name'] : null;
        $email = isset($formData['email']) ? $formData['email'] : null;
        $password = isset($formData['password']) ? $formData['password'] : null;
        $user_type = isset($formData['user_type']) ? $formData['user_type'] : 'general';
        

        $success = $user->addUser($first_name, $last_name, $email, $password, $user_type);
        $data = array('success' => $success);
        break;

    case 'PUT':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);
        
        $userId = isset($formData['id']) ? $formData['id'] : null;
        $first_name = isset($formData['first_name']) ? $formData['first_name'] : null;
        $last_name = isset($formData['last_name']) ? $formData['last_name'] : null;
        $email = isset($formData['email']) ? $formData['email'] : null;
        $password = isset($formData['password']) ? $formData['password'] : null;
        $user_type = isset($formData['user_type']) ? $formData['user_type'] : null;
        
        $success = $user->updateUser($userId, $first_name, $last_name, $email, $password, $user_type);
        $data = array('success' => $success);

        break;

    case 'DELETE':
        $rawInput = file_get_contents("php://input");

        // Parse the JSON data from raw input
        $formData = json_decode($rawInput, true);
        
        $userId = isset($formData['id']) ? $formData['id'] : null;

        $success = $user->deleteUser($userId);
        $data = array('success' => $success);
        break;

    default:
        $data = array('error' => 'Invalid HTTP request method');
}

header('Content-Type: application/json');
echo json_encode($data);

exit;
?>