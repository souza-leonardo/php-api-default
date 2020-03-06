<?php

// required headers
header("Access-Control-Allow-Origin: http://localhost/phpScaffolding/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once '../config/database.php';
require_once '../objects/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$data = json_decode(file_get_contents("php://input"));

$usuario->cpf = $data->cpf;
$cpfExists = $usuario->cpfExists();

// generate json web token
require_once '../config/core.php';
require_once '../../vendor/firebase/php-jwt/src/JWT.php';
use Firebase\JWT\JWT;

if ($cpfExists && password_verify($usuario->password, password_hash($data->password, PASSWORD_BCRYPT, ['cost' => 12]))) {
    $token = [
        'iss' => $iss,
        'aud' => $aud,
        'iat' => $iat,
        'nbf' => $nbf,
        'data' => [
            'id' => $usuario->id,
            'nome' => $usuario->nome,
            'cpf' => $usuario->cpf,
            'username' => $usuario->username
        ]
    ];

    http_response_code(200);

    $jwt = JWT::encode($token, $key);
    echo json_encode([
        'message' => 'Login realizado com sucesso.',
        'jwt' => $jwt
    ]);
} else {
    http_response_code(401);

    echo json_encode(['message' => 'Falha ao realizar o login.']);
}