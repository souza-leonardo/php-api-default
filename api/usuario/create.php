<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

if (
    !empty($data->nome) &&
    !empty($data->cpf) &&
    !empty($data->username) &&
    !empty($data->password)
) {
    $usuario->nome = $data->nome;
    $usuario->cpf = $data->cpf;
    $usuario->username = $data->username;
    $usuario->password = md5($data->password);
    $usuario->created_at = date('Y-m-d H:i:s');

    if ($usuario->create()) {
        http_response_code(201);

        echo json_encode(['message' => 'Usuário criado com sucesso']);
    } else {
        http_response_code(503);
        echo json_encode(['message' => 'Incapaz de criar o usuário.']);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Incapaz de criar o usuário! Dados incompletos"]);
}