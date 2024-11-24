<?php
include '../db.php';
include '../models/UserModel.php';
include '../../config.php';
require '../../vendor/autoload.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class UserController
{
  private $model;

  public function __construct($pdo)
  {
    $this->model = new UserModel($pdo);
  }

  public function register()
  {
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if ($this->model->register($name, $lastname, $email, $password)) {
      echo json_encode(['success' => true, 'message' => 'usuario registrado correctamente']);
    } else {
      echo json_encode(['success' => false, 'message' => 'error al registrar']);
    }
  }

  public function login()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $this->model->login($email, $password);

    if ($user) {
      $payload = [
        'iss' => 'armatucomputadora',
        'iat' => time(),
        'exp' => time() + JWT_EXPIRATION,
        'data' => [
          'id' => $user['id'],
          'name' => $user['name'],
          'lastname' => $user['lastname'],
          'email' => $user['email'],
          'role' => $user['role'],
        ]
      ];
      $jwt = JWT::encode($payload, JWT_SECRET_KEY, 'HS256');
      echo json_encode(['success' => true, 'message' => 'inicio de sesion exitoso', 'token' => $jwt]);
    } else {
      echo json_encode(['success' => true, 'message' => 'Usuario o contraseña incorrecta']);
    }
  }
}

$controller = new UserController($pdo);
$action = $_GET['action'] ?? '';

if ($action === 'register') {
  $controller->register();
} elseif ($action === 'login') {
  $controller->login();
}
