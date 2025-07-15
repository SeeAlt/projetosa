<?php
session_start();
require_once 'conexao.php';


if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}


$reservation_local = $_POST['reservation_local'] ?? '';
$reservation_datehour = $_POST['reservation_datehour'] ?? '';
$people_quantity = intval($_POST['people_quantity'] ?? 0);
$id_user = $_SESSION['id_user'] ?? 0;  

if (!$reservation_local || !$reservation_datehour || !$people_quantity || !$id_user) {
    echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
    exit;
}

if ($people_quantity < 1 || $people_quantity > 8) {
    echo json_encode(['success' => false, 'message' => 'Quantidade de pessoas deve ser entre 1 e 8.']);
    exit;
}

try {

    $stmt = $pdo->prepare("INSERT INTO tb_psa_reservation (reservation_local, people_quantity, reservation_datehour, id_user) VALUES (:reservation_local, :people_quantity, :reservation_datehour, :id_user)");
    $stmt->bindParam(':reservation_local', $reservation_local);
    $stmt->bindParam(':people_quantity', $people_quantity, PDO::PARAM_INT);
    $stmt->bindParam(':reservation_datehour', $reservation_datehour);
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar reserva.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco: ' . $e->getMessage()]);
}
?>