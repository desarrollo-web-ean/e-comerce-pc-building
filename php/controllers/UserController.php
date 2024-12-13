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
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos invalidos o faltantes']);
      return;
    }

    $name = $data['name'] ?? null;
    $lastname = $data['lastname'] ?? null;
    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Email no valido']);
      return;
    }

    if (strlen($password) < 6) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'La contraseña debe tener al menos 6 caracteres']);
      return;
    }

    if (empty($name) || empty($lastname)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Nombre y apellido son requeridos']);
      return;
    }

    $result = $this->model->register($name, $lastname, $email, $password);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'usuario registrado correctamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'error al registrar']);
    }
  }

  public function login()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'el email y la contraseña son requeridos']);
      return;
    }

    $email = $data['email'] ?? null;
    $password = $data['password'] ?? null;


    $user = $this->model->login($email, $password);

    if ($user) {
      session_start();
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
      $_SESSION['user_role'] = $user['role'];
      $_SESSION['user_id'] = $user['id'];

      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'inicio de sesion exitoso', 'token' => $jwt]);
    } else {
      http_response_code(500);
      echo json_encode(['success' => true, 'message' => 'Usuario o contraseña incorrecta']);
    }
  }
}

$controller = new UserController($pdo);
$action = $_GET['action'] ?? '';
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($action) {
  case 'login':
    if ($requestMethod === 'POST') {
      $controller->login();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    break;
  case 'register':
    if ($requestMethod === 'POST') {
      $controller->register();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    break;
  default:
    http_response_code(404);
    echo json_encode([
      'success' => false,
      'message' => 'Acción no válida'
    ]);
    break;
}
