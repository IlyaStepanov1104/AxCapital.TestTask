<?php
session_start();
spl_autoload_register(function (string $className) {
    require_once __DIR__ . '\src\\' . $className . '.php';
});

$route = $_GET['route'] ?? '';
$user = $_SESSION['user'] ?? null;
$routes = require __DIR__ . '/src/routes.php';

$isRouteFound = false;
foreach ($routes as $pattern => $controllerAndAction) {
    preg_match($pattern, $route, $matches);
    if (!empty($matches)) {
        $isRouteFound = true;
        break;
    }
}

unset($matches[0]);

$controllerName = $controllerAndAction[0];
$actionName = $controllerAndAction[1];

$controller = new $controllerName($user);
$controller->$actionName(...$matches);