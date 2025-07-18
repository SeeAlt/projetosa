<?php
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);
$id_reservation = $data['id_reservation'] ?? null;

if (!$id_reservation) {
    echo json_encode(['success' => 0, 'message' => 'ID inválido.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE tb_psa_reservation SET reservation_status = 'Cancelado' WHERE id_reservation = :id AND id_user = :user_id AND reservation_status = 'Andamento'");
    $stmt->execute([
        ':id' => $id_reservation,
        ':user_id' => $_SESSION['id_user']
    ]);

    echo json_encode(['success' => 1, 'message' => 'Reserva cancelada com sucesso.']);
} catch (PDOException $e) {
    echo json_encode(['success' => 0, 'message' => 'Erro ao cancelar: ' . $e->getMessage()]);
}
