<?php
include('../db.php');
include('../models/CartModel.php');

class CartController
{
  private $model;

  public function __construct($pdo)
  {
    $this->model = new CartModel($pdo);
  }

  public function viewUserCart()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['user_id'] ?? null;

    if (!$userId || !is_numeric($userId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'Id de usuario invalido']);
      return;
    }

    $cartList = $this->model->viewCart($userId);

    if ($cartList) {
      http_response_code(200);
      echo json_encode(['success' => true, 'cartList' => $cartList]);
    } else {
      http_response_code(404);
      echo json_encode(['success' => false, 'message' => 'El carrito esta vacio']);
    }
  }

  public function addProductToCart()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = $data['user_id'] ?? null;
    $productId = $data['productId'] ?? null;
    $quantity = $data['quantity'] ?? null;

    if (!$userId || !$productId || !$quantity || !is_numeric($userId) || !is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
      return;
    }

    $result = $this->model->addProductToCart($userId, $productId, $quantity);

    if ($result) {
      http_response_code(201);
      echo json_encode(['success' => true, 'message' => 'Producto agregado al carrito']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al agregar el producto al carrito']);
    }
  }

  public function removeProductFromCart()
  {
    $data = json_decode(file_get_contents('php://input'), true);

    $userId = $data['user_id'] ?? null;
    $productId = $data['productId'] ?? null;
    $quantity = $data['quantity'] ?? null;

    if (!$userId || !$productId || !$quantity || !is_numeric($userId) || !is_numeric($productId) || !is_numeric($quantity) || $quantity <= 0) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
      return;
    }

    $result = $this->model->removeProductFromCart($userId, $productId, $quantity);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'Producto eliminado del carrito']);
    } else {
      http_response_code(404);
      echo json_encode(['success' => false, 'message' => 'Producto no encontrado en el carrito']);
    }
  }

  public function clearCart()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $userId = $data['user_id'] ?? null;

    if (!$userId || !is_numeric($userId)) {
      http_response_code(400);
      echo json_encode(['success' => false, 'message' => 'ID de usuario inválido']);
      return;
    }

    $result = $this->model->clearCart($userId);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'El carrito se ha vaciado correctamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al tratar de vaciar el carrito']);
    }
  }
}

$controller = new CartController($pdo);
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'viewUserCart':
    $controller->viewUserCart();
    break;
  case 'addProductToCart':
    $controller->addProductToCart();
    break;
  case 'removeProductFromCart':
    $controller->removeProductFromCart();
    break;
  case 'clearCart':
    $controller->clearCart();
    break;
  default:
    http_response_code(404);
    echo json_encode([
      'success' => false,
      'message' => 'Acción no válida'
    ]);
    break;
}
