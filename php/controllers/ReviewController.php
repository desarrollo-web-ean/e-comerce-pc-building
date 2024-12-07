<?php
include('../db.php');
include('../models/ReviewModel.php');

class ReviewController
{

  private $model;

  public function __construct($pdo)
  {
    $this->model = new ReviewModel($pdo);
  }

  public function listReviews()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'] ?? null;

    if (!$productId || !is_numeric($productId)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'id del producto invalido']);
      return;
    }

    $productReviewList = $this->model->listReviews($productId);

    if ($productReviewList) {
      http_response_code(200);
      echo json_encode(["success" => true, "reviewList" => $productReviewList]);
    } else {
      http_response_code(404);
      echo json_encode(["success" => false, "message" => "este Producto no tiene reviews"]);
    }
  }

  public function addReview()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'] ?? null;
    $userId = $data['userId'] ?? null;
    $rating = $data['rating'] ?? null;
    $comment = $data['comment'] ?? null;

    if (
      !$productId || !$userId || !$rating || !$comment || !is_numeric($productId) || !is_numeric($userId)
    ) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos invalidos']);
      return;
    }

    $result = $this->model->addReview($productId, $userId, $rating, $comment);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'Review agregada exitosamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al agregar la review del producto']);
    }
  }

  public function editReview()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'] ?? null;
    $reviewId = $data['reviewId'] ?? null;
    $userId = $data['userId'] ?? null;
    $rating = $data['rating'] ?? null;
    $comment = $data['comment'] ?? null;

    if (
      !$productId || !$userId || !$reviewId || !$rating || !$comment || !is_numeric($productId)
      || !is_numeric($userId) || !is_numeric($reviewId)
    ) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos invalidos']);
      return;
    }

    $result = $this->model->editReview($reviewId, $productId, $userId, $rating, $comment);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'Review editada exitosamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al editar la review del producto']);
    }
  }

  public function deleteReview()
  {
    $data = json_decode(file_get_contents('php://input'), true);
    $productId = $data['productId'] ?? null;
    $userId = $data['userId'] ?? null;
    $reviewId = $data['reviewId'] ?? null;

    if (!$productId || !is_numeric($productId) || !$userId || !is_numeric($userId) || !$reviewId || !is_numeric($reviewId)) {
      http_response_code(400);
      echo json_encode(["success" => false, "message" => 'Datos invalidos']);
      return;
    }

    $result = $this->model->deleteReview($reviewId, $productId, $userId);

    if ($result) {
      http_response_code(200);
      echo json_encode(['success' => true, 'message' => 'Review eliminada exitosamente']);
    } else {
      http_response_code(500);
      echo json_encode(['success' => false, 'message' => 'Error al eliminar la review']);
    }
  }
}

$controller = new ReviewController($pdo);
$action = $_GET['action'] ?? '';

switch ($action) {
  case 'listReviews':
    $controller->listReviews();
    break;
  case 'addReview':
    $controller->addReview();
    break;
  case 'editReview':
    $controller->editReview();
    break;
  case 'deleteReview':
    $controller->deleteReview();
    break;
  default:
    http_response_code(404);
    echo json_encode([
      'success' => false,
      'message' => 'Acción no válida'
    ]);
    break;
}
