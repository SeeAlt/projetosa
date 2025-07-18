<?php
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');


if (!isset($_SESSION['id_user'])) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado']);
    exit();
}


$data = json_decode(file_get_contents('php://input'), true);

if (!$data || !isset($data['id_reservation']) || !isset($data['reservation_datehour'])) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos']);
    exit();
}

$id_reservation = (int)$data['id_reservation'];
$new_datehour = $data['reservation_datehour'];
$id_user = $_SESSION['id_user'];


if (!strtotime($new_datehour)) {
    echo json_encode(['success' => false, 'message' => 'Data inválida']);
    exit();
}

try {
    $stmt = $pdo->prepare("UPDATE tb_psa_reservation SET reservation_datehour = :new_datehour WHERE id_reservation = :id_reservation AND id_user = :id_user AND reservation_status = 'Andamento'");
    $stmt->bindParam(':new_datehour', $new_datehour);
    $stmt->bindParam(':id_reservation', $id_reservation, PDO::PARAM_INT);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Reserva não encontrada ou não pode ser alterada']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
