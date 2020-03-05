<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$keywords = $_GET['s'] ?? '';

$stmt = $usuario->search($keywords);
$num = $stmt->rowCount();

$usuarioArr = [];
$usuarioArr['registros'] = [];

if ($num > 0) {
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row this will make $row['name'] to just $name only
        extract($row);

        $usuarioItem = [
            'id' => $id,
            'nome' => $nome,
            'cpf' => $cpf,
            'username' => $username,
            'password' => $password
        ];

        array_push($usuarioArr['registros'], $usuarioItem);
    }
}

http_response_code(200);

json_encode($usuarioArr);