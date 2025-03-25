<?php

require '../vendor/autoload.php';
require_once "../core/Router.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$router = new Router();

// Definir rutas de la aplicacion

//Usuario
$router->add('', 'UserController', 'index');
$router->add('register', 'UserController', 'signup');

//Home
$router->add('home', 'HomeController', 'index'); 

//Mangas
$router->add('manga/{id}', 'MangaController', 'mangaData'); 

//Definir api routes
$api_prefix = 'api/v1/';

//Usuario
$router->add($api_prefix.'register', 'UserController', 'registerUser', 'POST');
$router->add($api_prefix.'login', 'UserController', 'loginUser', 'POST');
$router->add($api_prefix.'logout', 'UserController', 'logoutUser', 'POST');

//Mangas
$router->add($api_prefix.'manga', 'MangaController', 'getAllMangas', 'GET');
$router->add($api_prefix.'manga/{id}', 'MangaController', 'getMangaData', 'GET');
$router->add($api_prefix.'manga', 'MangaController', 'createManga', 'POST');

// Obtener el método HTTP (GET, POST, PUT, DELETE, etc.)
$httpMethod = $_SERVER['REQUEST_METHOD'];
// Obtener URL
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : '';

// Ejecutar el enrutador
$router->dispatch($url, $httpMethod);