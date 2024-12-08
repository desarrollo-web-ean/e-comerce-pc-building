<?php

include('../db.php');
include('../models/CategoryModel.php');
include '../authMiddleware.php';

class CategoryController
{
  private $model;

  public function __construct($pdo)
  {
    $this->model = new CategoryModel($pdo);
  }

  private function validateJWTAndRole()
  {
    // Validar JWT
    $headers = getallheaders();
    $token = $headers['Authorization'] ?? '';
    $userData = verifyJWT(str_replace('Bearer ', '', $token));

    if (!$token || !$userData) {
      http_response_code(401);
      echo json_encode(['success' => false, 'message' => 'No autorizado']);
      return false;
    }

    // Verificar rol
    if ($userData['role'] !== 'admin') {
      http_response_code(401);
      echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
      return false;
    }

    return true;
  }

  public function getAllCategories()
  {
    $categories = $this->model->getAllCategories();

    http_response_code(200);
    echo json_encode(["success" => true, "categories" => $categories]);
    if ($categories) {
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al listar las categorias. No se encontraron categorias.']);
    }
  }

  public function getCategoryById()
  {
    $categoryId = $_GET['categoryId'] ?? null;

    if (!$categoryId || !is_numeric($categoryId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'categoryId es requerido y debe ser un número.']);
      return;
    }

    $category = $this->model->getCategoryById($categoryId);

    if ($category) {
      http_response_code(200);
      echo json_encode(["success" => true, "category" => $category]);
    } else {
      http_response_code(404);
      echo json_encode(['success' => false, 'message' => 'Error al tratar de obtener la categoría. No se encontró la categoría.']);
    }
  }

  public function createCategory()
  {
    if (!$this->validateJWTAndRole()) {
      return;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $name = $data['name'] ?? null;
    $description = $data['description'] ?? null;

    if (!$name || !$description) {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Datos invalidos o faltantes']);
      return;
    }

    $result = $this->model->createCategory($name, $description);

    if ($result) {
      http_response_code(200);
      echo json_encode(["success" => true, "message" => 'categoria creada con exito.']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al crear la categoria.']);
    }
  }

  public function updateCategory()
  {
    if (!$this->validateJWTAndRole()) {
      return;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $categoryId = $data['categoryId'] ?? null;
    $name = $data['name'] ?? null;
    $description = $data['description'] ?? null;

    if (!$categoryId || !is_numeric($categoryId)) {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => '"categoryId" es requerido y debe ser de tipo numerico']);
      return;
    }

    if (!$name || !$description) {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Datos invalidos o faltantes ("name", "description")']);
      return;
    }

    $result = $this->model->updateCategory($categoryId, $name, $description);

    if ($result) {
      http_response_code(200);
      echo json_encode(["success" => true, "message" => 'categoria actualizada con exito.']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al actualizar la categoria.']);
    }
  }

  public function deleteCategory()
  {
    if (!$this->validateJWTAndRole()) {
      return;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    $categoryId = $data['categoryId'] ?? null;

    if (!$categoryId || !is_numeric($categoryId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'categoryId es requerido y debe de ser de tipo numerico']);
      return;
    }

    $result = $this->model->deleteCategory($categoryId);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'categoria eliminada correctamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'error al eliminar la categoria']);
    }
  }

  public function getProductsByCategoryId()
  {
    $categoryId = $_GET['categoryId'] ?? null;

    if (!$categoryId || !is_numeric($categoryId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'categoryId es requerido y debe ser de tipo numerico']);
      return;
    }

    $products = $this->model->getProductsByCategoryId($categoryId);

    if ($products) {
      http_response_code(200);
      echo json_encode(['success' => true, 'products' => $products]);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al obtener los productos por categoria.']);
    }
  }
}

$controller = new CategoryController($pdo);
$action = $_GET['action'] ?? '';
$requestMethod = $_SERVER['REQUEST_METHOD'];

switch ($action) {
  case 'getCategories':
    if ($requestMethod === 'GET') {
      $controller->getAllCategories();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Metodo no permitido']);
    }
    break;
  case 'getCategoryById':
    if ($requestMethod === 'GET') {
      $controller->getCategoryById();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    }
    break;
  case 'create':
    if ($requestMethod === 'POST') {
      $controller->createCategory();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Metodo no permitido']);
    }
    break;
  case 'update':
    if ($requestMethod === 'PUT') {
      $controller->updateCategory();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Metodo no permitido']);
    }
    break;
  case 'delete':
    if ($requestMethod === 'DELETE') {
      $controller->deleteCategory();
    } else {
      http_response_code(405);
      echo json_encode(['success' => false, 'message' => 'Metodo no permitido']);
    }
    break;
  case 'getProductsByCategoryId':
    if ($requestMethod === 'GET') {
      $controller->getProductsByCategoryId();
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
