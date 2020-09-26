<?php
// required headers
header("Access-Control-Allow-Origin: http://rest-api-auth.localhost/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// require related files
require './config/Database.php';
require './objects/User.php';
require './config/core.php';
require '../vendor/autoload.php';

use \Firebase\JWT\JWT;

// get the instance
$database = new Database();
$conn = $database->getConnection();
$user = new User($conn);

// get the post data
$data = json_decode(file_get_contents('php://input'));

$user->email = $data->email;
// if emailExists return true, $user->password will be set
$email_exists = $user->emailExists();

if ($email_exists && password_verify($data->password, $user->password)) {
    $token = [
        'iss' => $iss,
        'aud' => $aud,
        'iat' => $iat,
        'nbf' => $nbf,
        'data' => [
            'id' => $user->id,
            'firstname' => $user->firstname,
            'lastname' => $user->lastname,
            'email' => $user->email
        ]
    ];
    http_response_code(200);
    $jwt = JWT::encode($token, $key);
    echo json_encode([
        'message' => 'Successful login',
        'jwt' => $jwt
    ]);
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Login failed']);
}
