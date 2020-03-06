<?php

require_once 'Request.php';
require_once 'Router.php';

require_once 'mirosmar.php'; // arquivo q tem a classe chamada na call_user_func_array

$router = new Router(new Request);

$router->get('/mirosmar', function () {
                                //nomeClasse   //nomeFuncao //parametros
    return call_user_func_array(['Mirosmar', 'mirosmario'], []);
});