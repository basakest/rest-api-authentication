<?php
// required headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// files for decoding jwt will be here
require './config/core.php';
require './config/Database.php';
require './objects/User.php';
require '../vendor/autoload.php';

use Firebase\JWT\JWT;

// get post data
$data = json_decode(file_get_contents('php://input')); 
$jwt = isset($data->jwt)? $data->jwt: '';

if (!empty($jwt)) {
    try {
        $decoded = JWT::decode($jwt, $key, ['HS256']);
        http_response_code(200);
        echo json_encode(['message' => 'Access granted', 'data' => $decoded->data]);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(['message' => 'Access denied', 'error' => $e->getMessage()]);
    }
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Access denied']);
}