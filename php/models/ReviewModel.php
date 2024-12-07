<?php
class ReviewModel
{
  private $db;

  public function __construct($pdo)
  {
    $this->db = $pdo;
  }

  public function listReviews($productId)
  {
    $stmt = $this->db->prepare("SELECT id, user_id, product_id, rating, comment FROM `reviews` WHERE product_id = ?");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addReview($productId, $userId, $rating, $comment)
  {
    $stmt = $this->db->prepare("INSERT INTO reviews (user_id, product_id, rating, comment) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$userId, $productId, $rating, $comment]);
  }

  public function editReview($reviewId, $productId, $userId, $rating, $comment)
  {
    $stmt = $this->db->prepare("UPDATE reviews SET rating = ? ,comment = ? WHERE id = ? AND product_id = ? AND user_id = ?");
    return $stmt->execute([$rating, $comment, $reviewId, $productId, $userId]);
  }

  public function deleteReview($reviewId, $productId, $userId)
  {
    $stmt = $this->db->prepare("DELETE FROM `reviews` WHERE id = ? AND product_id = ? AND user_id = ?");
    return $stmt->execute([$reviewId, $productId, $userId]);
  }
}
