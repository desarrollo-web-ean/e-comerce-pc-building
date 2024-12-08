<?php
include('../db.php');
include('../models/ProductModel.php');
include '../authMiddleware.php';

class ProductController
{
  private $model;

  public function __construct($pdo)
  {
    $this->model = new ProductModel($pdo);
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

  public function list()
  {
    $products = $this->model->getAll();

    if ($products) {
      http_response_code(200);
      echo json_encode(["success" => true, "products" => $products]);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al listar los productos. No se encontraron productos.']);
    }
  }

  public function getById()
  {
    // Obtener el ID del producto de la URL
    $productId = $_GET['productId'] ?? null;

    if (!$productId || !is_numeric($productId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'ID inválido']);
      return;
    }

    // Consultar el producto desde el modelo
    $product = $this->model->getById($productId);

    if ($product) {
      http_response_code(200);
      echo json_encode(['success' => true, 'product' => $product]);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    }
  }

  public function create()
  {
    if (!$this->validateJWTAndRole()) {
      return;
    }

    $data = json_decode(file_get_contents('php://input'), true);    
    $name = $data['name'] ?? null;
    $description = $data['description'] ?? null;
    $price = $data['price'] ?? null;
    $stock = $data['stock'] ?? null;

    if (
      !$name || !$description || !$price || !$stock
    ) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos invalidos o faltantes']);
      return;
    }

    $result = $this->model->create($name, $description, $price, $stock);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'Producto creado']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al crear producto']);
    }
  }

  public function update()
  {
    if (!$this->validateJWTAndRole()) {
      return;
    }

    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos inválidos o faltantes']);
      return;
    }
    $productId = $data['productId'] ?? null;
    $name = $data['name'] ?? null;
    $description = $data['description'] ?? null;
    $price = $data['price'] ?? null;
    $stock = $data['stock'] ?? null;

    if (
      !$productId || !is_numeric($productId) || empty($name) || empty($description) || empty($price) || empty($stock)
    ) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos invalidos o faltantes']);
      return;
    }

    $result = $this->model->update($productId, $name, $description, $price, $stock);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'producto actualizado correctamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'error al actualizar producto']);
    }
  }

  public function delete()
  {
    if (!$this->validateJWTAndRole()) {
      return;
    }
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'] ?? null;

    if (!$productId || !is_numeric($productId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'ID inválido o faltante']);
      return;
    }

    $result = $this->model->delete($productId);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'producto eliminado correctamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'error al eliminar el producto']);
    }
  }
}

$controller = new ProductController($pdo);
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'list':
    $controller->list();
    break;
  case 'getById':
    $controller->getById();
    break;
  case 'create':
    $controller->create();
    break;
  case 'update':
    $controller->update();
    break;
  case 'delete':
    $controller->delete();
    break;
  default:
    http_response_code(404);
    echo json_encode([
      'success' => false,
      'message' => 'Acción no válida'
    ]);
    break;
}
