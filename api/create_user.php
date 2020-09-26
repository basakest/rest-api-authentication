<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// require related files
require './config/Database.php';
require './objects/User.php';

// get the instance
$database = new Database();
$conn = $database->getConnection();
$user = new User($conn);

// get the post data
$data = json_decode(file_get_contents('php://input'));


// give the data to user object's property
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

// make sure the data is not empty and create user successfully
if (!empty($user->firstname) && !empty($user->lastname) && !empty($user->email) && !empty($user->password) && $user->create()) {
    http_response_code(200);
    echo json_encode(['message' => 'User was created successfully']);
} else {
    http_response_code(400);
    echo json_encode(['message' => 'Unable to create user']);
}