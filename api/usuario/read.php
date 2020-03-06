<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once '../config/database.php';
require_once '../objects/usuario.php';

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$stmt = $usuario->read();
$num = $stmt->rowCount();

$usuariosArr = [];
$usuariosArr['registros'] = [];

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

        array_push($usuariosArr['registros'], $usuarioItem);
    }
}

http_response_code(200);
echo json_encode($usuariosArr);