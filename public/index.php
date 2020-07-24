<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;

    require __DIR__ . '/../vendor/autoload.php';
    require_once '../src/config/config.php'; //Credenciales de Conexión

    $app = AppFactory::create();

    //Rutas
    require_once '../src/rutas/getClientes.php';

    $app->run();