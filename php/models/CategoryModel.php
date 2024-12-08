<?php
class CategoryModel
{
  private $db;

  public function __construct($pdo)
  {
    $this->db = $pdo;
  }

  public function getAllCategories()
  {
    $stmt = $this->db->query("SELECT * FROM categories");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getCategoryById($categoryId)
  {
    $stmt = $this->db->prepare("SELECT id, name, description FROM categories WHERE id = ? ");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function createCategory($name, $description)
  {
    $stmt = $this->db->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
    return $stmt->execute([$name, $description]);
  }

  public function updateCategory($categoryId, $name, $description)
  {
    $stmt = $this->db->prepare("UPDATE categories SET name = ?, description = ? WHERE id = ?");
    return $stmt->execute([$name, $description, $categoryId]);
  }

  public function deleteCategory($categoryId)
  {
    $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$categoryId]);
  }

  public function getProductsByCategoryId($categoryId)
  {
    $stmt = $this->db->prepare("SELECT p.* FROM products p JOIN product_categories pc ON p.id = pc.product_id WHERE pc.category_id = ?");
    $stmt->execute([$categoryId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
