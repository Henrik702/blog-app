<?php
ob_start();
session_start();
require_once "../vendor/autoload.php";

use Dotenv\Dotenv;

try {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
    $dotenv->load();
} catch(Exception $e) {
    echo 'Error loading .env file: ' . $e->getMessage();
}

include "../View/index.php";
ob_end_flush();