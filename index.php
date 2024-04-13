<?php

require_once 'configs/main.php';

$controllerClass = 'core\controllers\\'. ucfirst(ControllerName) .'Controller';
$Controller = new $controllerClass;

// var_dump(URI);exit;

// var_dump($controllerClass);
echo '<pre>';
// var_dump($Controller);
