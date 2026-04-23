<?php
session_start();

require_once __DIR__ . '/../config/autoload.php';

$router = new Router();

// Định nghĩa các routes
$router->add('GET', '/', 'ProductController', 'index');
$router->add('GET', '/products', 'ProductController', 'index');
$router->add('GET', '/products/create', 'ProductController', 'create');
$router->add('POST', '/products/store', 'ProductController', 'store');
$router->add('GET', '/products/edit/{id}', 'ProductController', 'edit');
$router->add('POST', '/products/update/{id}', 'ProductController', 'update');
$router->add('GET', '/products/delete/{id}', 'ProductController', 'delete');

// Xử lý request
$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);