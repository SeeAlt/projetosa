<?php
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['id_user'])) {
    echo json_encode([]);
    exit();
}

$id_user = $_SESSION['id_user'];

$stmt = $pdo->prepare("SELECT * FROM tb_psa_reservation WHERE id_user = :id_user ORDER BY reservation_datehour DESC");
$stmt->bindParam(':id_user', $id_user);
$stmt->execute();

$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($reservations);
?>
