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

  public function list()
  {
    $products = $this->model->getAll();
    echo json_encode($products);
  }

  public function getById()
  {
    // Obtener el ID de la URL
    $id = $_GET['id'] ?? null;

    if (!$id || !is_numeric($id)) {
      echo json_encode(['success' => false, 'message' => 'ID inválido']);
      return;
    }

    // Consultar el producto desde el modelo
    $product = $this->model->getById($id);

    if ($product) {
      echo json_encode(['success' => true, 'product' => $product]);
    } else {
      echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
    }
  }

  public function create()
  {
    // Validar JWT
    $headers = getallheaders();
    $token = $headers['Authorization'] ?? '';

    if (!$token || !$userData = verifyJWT(str_replace('Bearer ', '', $token))) {
      echo json_encode(['success' => false, 'message' => 'No autorizado']);
      return;
    }

    // Verificar rol
    if ($userData['role'] !== 'admin') {
      echo json_encode(['success' => false, 'message' => 'Acceso denegado']);
      return;
    }

    // Procesar creación de producto
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($this->model->create($name, $description, $price, $stock)) {
      echo json_encode(['success' => true, 'message' => 'Producto creado']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Error al crear producto']);
    }
  }

  public function update()
  {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];

    if ($this->model->update($id, $name, $description, $price, $stock)) {
      echo json_encode(['success' => true, 'message' => 'producto actualizado correctamente']);
    } else {
      echo json_encode(['success' => false, 'message' => 'error al actualizar producto']);
    }
  }

  public function delete()
  {
    $id = $_POST['id'];
    if ($this->model->delete($id)) {
      echo json_encode(['success' => true, 'message' => 'producto eliminado correctamente']);
    } else {
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
    echo json_encode([
      'success' => false,
      'message' => 'Acción no válida'
    ]);
    break;
}
