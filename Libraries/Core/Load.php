<?php

$controllerFile = "Controllers/{$controller}Controller.php";

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controllerClass = "{$controller}Controller";
    $controllerObject = new $controllerClass();

    if (method_exists($controllerObject, $method)) {
        $controllerObject->$method($params);
    } else {
        require_once "Controllers/ErrorController.php";
        $error = new ErrorController();
        $error->index();
    }
} else {
    require_once "Controllers/ErrorController.php";
    $error = new ErrorController();
    $error->index();
}
