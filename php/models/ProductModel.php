<?php

class ProductModel
{
  private $db;

  public function __construct($pdo)
  {
    $this->db = $pdo;
  }

  public function getAll()
  {
    $stmt = $this->db->query("SELECT * FROM products");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getById($id)
  {
    $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function create($name, $description, $price, $stock)
  {
    $stmt = $this->db->prepare("INSERT INTO products (name, description, price, stock) VALUES (?,?,?,?)");
    return $stmt->execute([$name, $description, $price, $stock]);
  }

  public function update($id, $name, $description, $price, $stock)
  {
    $stmt = $this->db->prepare("UPDATE products SET name = ?, description = ?, price = ?, stock = ? WHERE id = ?");
    return $stmt->execute([$name, $description, $price, $stock, $id]);
  }

  public function delete($id)
  {
    $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
  }

  public function asociateCategories($productId, $categoryIds)
  {
    try {
      $this->db->beginTransaction();

      $stmt = $this->db->prepare("DELETE FROM product_categories WHERE product_id = ?");
      $stmt->execute([$productId]);

      $stmt = $this->db->prepare("INSERT INTO product_categories (product_id, category_id	) VALUES (?, ?)");

      foreach ($categoryIds as $categoryId) {
        $stmt->execute([$productId, $categoryId]);
      }

      $this->db->commit();
      return true;
    } catch (PDOException $e) {
      $this->db->rollBack();
      return false;
    }
  }

  public function getCategoriesByProductId($productId)
  {
    try {
      $this->db->beginTransaction();

      $stmt = $this->db->prepare("
        SELECT c.id, c.name
        FROM categories AS c
        JOIN product_categories AS pc ON c.id = pc.category_id
        WHERE pc.product_id = ?
      ");
      $stmt->execute([$productId]);

      $this->db->commit();

      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      $this->db->rollBack();
      return false;
    }
  }
}
