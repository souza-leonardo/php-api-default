<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

require_once '../config/database.php';
require_once '../objects/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$usuario->id = $_GET['id'] ?? die();

$usuario->readOne();

$usuarioArr = [];
if ($usuario->nome != null) {
    $usuarioArr = [
        'id' => $usuario->id,
        'nome' => $usuario->nome,
        'cpf' => $usuario->cpf,
        'username' => $usuario->username,
        'password' => $usuario->password,
        'created_at' => $usuario->created_at
    ];
}

http_response_code(200);
echo json_encode(['result' => $usuarioArr]);