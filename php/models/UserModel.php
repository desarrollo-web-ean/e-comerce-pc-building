<?php
include '../db.php';

class UserModel
{
  private $db;

  public function __construct($pdo)
  {
    $this->db = $pdo;
  }

  public function register($name, $lastname, $email, $password)
  {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $this->db->prepare("INSERT INTO users (name, lastname, email, password) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$name, $lastname, $email, $hashedPassword]);
  }

  public function login($email, $password)
  {
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
      return $user;
    }

    return false;
  }
}
