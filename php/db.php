<?php

try {
  $host = 'localhost';
  $username = 'root';
  $password = '';
  $dbname = 'proyectophp';

  $hostDB = "mysql:host=" . $host . ";dbname=" . $dbname . ";charset=utf8";
  $pdo = new PDO($hostDB, $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Error de conexión: " . $e->getMessage());
}
