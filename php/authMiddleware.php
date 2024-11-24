<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function verifyJWT($token)
{
  try {
    $decoded = JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
    return (array) $decoded->data;
  } catch (Exception $e) {
    return false;
  }
}
