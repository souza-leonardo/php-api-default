<?php

// required headers
header("Access-Control-Allow-Origin: *");
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

$usuario->id = $data->id;

if ($usuario->delete()) {
    http_response_code(200);

    echo json_encode(['message' => 'Usuário deletado.']);
} else {
    http_response_code(503);

    echo json_encode(['message' => 'Incapaz de deletar o usuário.']);
}