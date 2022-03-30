<?php
require_once('Config/connection.php');
require_once 'Controllers/ProductsController.php';

$controller = 'Products';

// Todo esta lógica hara el papel de un Controller
if (!isset($_REQUEST['Controller'])) {
    require_once "Controllers/$controller" . "Controller.php";
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller;
    $controller->Index();
} else {
    // Obtenemos el controlador que queremos cargar
    $controller = strtolower($_REQUEST['Controller']);
    $accion = isset($_REQUEST['action']) ? $_REQUEST['action'] : 'Index';

    // Instanciamos el controlador
    require_once "Controllers/$controller" . "Controller.php";
    $controller = ucwords($controller) . 'Controller';
    $controller = new $controller;

    // Llama la accion
    call_user_func(array($controller, $accion));
}
