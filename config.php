<?php


require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('JWT_SECRET_KEY', $_ENV['JWT_SECRET_KEY']);
define('JWT_EXPIRATION', $_ENV['JWT_EXPIRATION']);
define('API_URL', $_ENV['API_URL']);
