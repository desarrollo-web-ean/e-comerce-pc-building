<?php
class CartModel
{
  private $db;

  public function __construct($pdo)
  {
    $this->db = $pdo;
  }

  public function viewCart($userId)
  {
    $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function addProductToCart($userId, $productId, $quantity)
  {
    $stmt = $this->db->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
      $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity + ? WHERE user_id = ? AND product_id = ?");
      return $stmt->execute([$quantity, $userId, $productId]);
    } else {
      $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
      return $stmt->execute([$userId, $productId, $quantity]);
    }
    return false;
  }

  public function removeProductFromCart($userId, $productId, $quantity)
  {
    $stmt = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($item) {
      if ($item['quantity'] > $quantity) {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity - ? WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$quantity, $userId, $productId]);
      } else {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
      }
    }
    return false;
  }

  public function clearCart($userId)
  {
    $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
    return $stmt->execute([$userId]);
  }
}
