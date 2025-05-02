<?php
require __DIR__ . '/../vendor/autoload.php';

use Slim\Factory\AppFactory;
use Myapi\Create\Create;
use Myapi\Read\Read;
use Myapi\Update\Update;
use Myapi\Delete\Delete;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app = AppFactory::create();
$app->setBasePath('/tecweb/Practica1/Act/a03/product_app/Backend');
$app->addBodyParsingMiddleware(); // Habilita manejo de JSON en cuerpo de solicitud

//Obtener producto por ID
$app->get('/product/{id}', function (Request $request, Response $response, array $args) {
    $prod = new Read('marketzone');
    $prod->single($args['id']);
    $data = $prod->getData();
    $response->getBody()->write($data ?: '{}');
    return $response->withHeader('Content-Type', 'application/json');
});

//Verificar si nombre de producto ya existe
$app->get('/product/checkname/{name}', function (Request $request, Response $response, array $args) {
    $prod = new Read('marketzone');
    $prod->singleByName($args['name']);
    $data = json_decode($prod->getData(), true);
    $existe = !empty($data);
    $response->getBody()->write(json_encode(['existe' => $existe]));
    return $response->withHeader('Content-Type', 'application/json');
});

//Obtener lista de productos
$app->get('/products', function (Request $request, Response $response) {
    $prod = new Read('marketzone');
    $prod->list();
    $response->getBody()->write($prod->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//Buscar productos
$app->get('/products/{search}', function (Request $request, Response $response, array $args) {
    $prod = new Read('marketzone');
    $prod->search($args['search']);
    $response->getBody()->write($prod->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//Agregar producto
$app->post('/product', function (Request $request, Response $response) {
    $data = json_encode($request->getParsedBody());
    $prod = new Create('marketzone');
    $prod->add($data);
    $response->getBody()->write($prod->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//Editar producto
$app->put('/product', function (Request $request, Response $response) {
    $data = json_encode($request->getParsedBody());
    $prod = new Update('marketzone');
    $prod->edit($data);
    $response->getBody()->write($prod->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

//Eliminar producto
$app->delete('/product', function (Request $request, Response $response) {
    $data = $request->getParsedBody();
    $id = $data['id'] ?? null;
    $prod = new Delete('marketzone');
    $prod->delete($id);
    $response->getBody()->write($prod->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

$app->run();
