<?php

const BASE_PATH = '../';

function route($route, $id = null)
{
    $baseRoute = env("APP_URL") . '/' . $route;
    if ($id) {
        $baseRoute .= '/' . $id;
    }

    return $baseRoute;
}

function csrf()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    $csrf = htmlspecialchars($_SESSION['csrf_token']);

    return "<input type='hidden' name='csrf_token' value='$csrf'>";
}

function validateCsrfToken($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

function redirect($location)
{
    header("Location: $location");
}

function old($session_name, $name)
{
    if (!empty($_SESSION) && isset($_SESSION[$session_name])) {
        return $_SESSION[$session_name][$name];
    }

    return "";
}

function view($view, $variables = [])
{
    $path = $view;
    if (str_contains($view, ".")) {
        $path = join("/", explode(".", $path));
    }
    $path .= ".php";

    return renderTemplate(BASE_PATH . "view/$path", $variables);
}

function renderTemplate($filePath, $variables = [])
{
    extract($variables);
    ob_start();
    include($filePath);

    return ob_get_clean();
}