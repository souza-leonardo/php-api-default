<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/phpScaffolding/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/core.php';
require_once '../../vendor/firebase/php-jwt/src/JWT.php';
use Firebase\JWT\JWT;

$data = json_decode(file_get_contents("php://input"));

$jwt = $data->jwt ?? null;

if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, $key, ['HS256']);

        http_response_code(200);

        echo json_encode([
            'message' => 'Acesso permitido.',
            'data' => $decoded->data
        ]);
    } catch (Exception $e) {
        http_response_code(401);

        echo json_encode([
            'message' => 'Acesso negado.',
            'error' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(400);

    echo json_encode([
        'message' => 'Acesso negado.'
    ]);
}