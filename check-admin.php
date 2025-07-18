<?php
session_start();
header('Content-Type: application/json');

echo json_encode([
  'logged' => $_SESSION['logged'] ?? 0,
  'is_admin' => $_SESSION['is_admin'] ?? 0,
  'user_name' => $_SESSION['user_name'] ?? null
]);
