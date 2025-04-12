<?php
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;
    
    require 'vendor/autoload.php';
    
    $app = AppFactory::create();

    $app->setBasepath("/tecweb/practica1/p17");

    $app->get('/', function ($request, $response, $args) {
        $response->getBody()->write("Hola Mundo Slim!!!");
        return $response;
    });
    
    $app->get('/hola/{nombre}', function ($request, $response, $args) {
        $response->getBody()->write("Hola, " . $args["nombre"]);
        return $response;
    });
    
    $app->post('/pruebapost', function($request, $response, $args) {
        $reqPost = $request->getParsedBody();
        $val1 = $reqPost["val1"];
        $val2 = $reqPost["val2"];
    
        $response->getBody()->write("Valores: " . $val1 . ", " . $val2);
        return $response;
    });
    
    $app->post('/testjson', function(Request $request, Response $response, $args) {
        $postData = $request->getParsedBody();
    
        $data[0]["nombre"] = $postData["nombre1"] ?? '';
        $data[0]["apellidos"] = $postData["apellido1"] ?? '';
        $data[1]["nombre"] = $postData["nombre2"] ?? '';
        $data[1]["apellidos"] = $postData["apellido2"] ?? '';
    
        $payload = json_encode($data, JSON_PRETTY_PRINT);
        $response->getBody()->write($payload);
    
        return $response->withHeader('Content-Type', 'application/json');
    });
    
    $app->run();
?>