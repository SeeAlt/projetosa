<?php
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');

if (!isset($_SESSION['logged']) || !$_SESSION['logged']) {
    echo json_encode(['success' => false, 'message' => 'Usuário não autenticado.']);
    exit;
}

$id_user = $_SESSION['id_user'] ?? 0;
$rating = intval($_POST['rating'] ?? 0);
$comment = trim($_POST['comment'] ?? '');

if ($rating < 1 || $rating > 5) {
    echo json_encode(['success' => false, 'message' => 'A nota deve ser entre 1 e 5.']);
    exit;
}


try {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tb_psa_reservation WHERE id_user = :id_user AND reservation_datehour < NOW()");
    $stmt->execute([':id_user' => $id_user]);
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        echo json_encode(['success' => false, 'message' => 'Você só pode avaliar após ter realizado uma reserva.']);
        exit;
    }

    $stmt = $pdo->prepare("INSERT INTO tb_psa_review (id_user, rating, comment) VALUES (:id_user, :rating, :comment)");
    $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindParam(':comment', $comment);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Avaliação enviada com sucesso!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Erro ao salvar avaliação.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco: ' . $e->getMessage()]);
}
?>