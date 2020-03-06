<?php

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/core.php';
require_once '../config/database.php';
require_once '../objects/usuario.php';
include_once '../shared/utilities.php';

$utilities = new Utilities();

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

$stmt = $usuario->readPaging($fromRecordNum, $recordsPerPage);
$num = $stmt->rowCount();

$usuarioArr = [];
$usuarioArr['registros'] = [];
$usuarioArr['paging'] = [];

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

    $totalRows = $usuario->count();
    $pageUrl = "{$homeUrl}usuario/read_paging.php?";
    $paging = $utilities->getPaging($page, $totalRows, $recordsPerPage, $pageUrl);
    $usuarioArr['paging'] = $paging;
}

http_response_code(200);

json_encode($usuarioArr);