<?php

use core\Router;

try {

	require_once 'configs/main.php';

	$Router = Router::getInstance();

	$controllerClass = $Router->controllerClassName;
	$controllerAction = $Router->actionName;

	$Controller = new $controllerClass;

	$Controller->$controllerAction();

} catch (\Exception $th) {
	dd($th, __FILE__, __LINE__,1);
} catch (\Throwable $th) {
	dd($th, __FILE__, __LINE__,1);
}
