<?php
include_once '../config/route.php';
global $routes;
$routeKeys = array_keys($routes);
$route     = [];
include_once 'header.php';
include_once "menu.php";
if (isset($_SERVER['REQUEST_URI'])) {
    $PATH_INFO = explode('/', substr($_SERVER['REQUEST_URI'], 1));
    if(empty($PATH_INFO[0])){
        echo view("welcome");
        die();
    }
    $path_info = str_contains($PATH_INFO[0], "?") ? explode("?", $PATH_INFO[0])[0] : $PATH_INFO[0];
    if (isset($routes[$path_info]) && $routes[$path_info]) {
        $route = $routes[$path_info];
        if (isset($routes[$path_info]["arg"]) && count($PATH_INFO) > 1 && !isset($routes[$path_info]["route"]["post"])) {
            $_GET[$routes[$path_info]["arg"]] = $PATH_INFO[1];
        } else {
            if (isset($routes[$path_info]["arg"]) && count($PATH_INFO) > 1 && isset($routes[$path_info]["route"]["post"])) {
                $_POST[$routes[$path_info]["arg"]] = $PATH_INFO[1];
            }
        }
    }

    if (!in_array($path_info, $routeKeys)) {
        http_response_code(404);
        include "../view/404.php";
        die();
    }
} else {
    include "../view/welcome.php";
}
if (!empty($route)) {
    if (!empty($_POST)) {
        if (!empty($route)) {
            $controller = new $route["route"]["post"]['controller'];
            $a          = call_user_func([$controller, $route["route"]["post"]['method']], $_POST);
            echo $a;
        }
    } else {
        $controller = new $route["route"]["get"]['controller'];
        $a          = call_user_func([$controller, $route["route"]["get"]['method']], $_GET);
        echo $a;
    }
}

?>

