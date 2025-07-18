<?php
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');

try {
    
    $stmt = $pdo->prepare("
        SELECT r.rating, r.review_comment, r.review_date, u.user_name
        FROM tb_psa_review r
        JOIN tb_psa_user u ON r.id_user = u.id_user
        ORDER BY r.review_date DESC
        LIMIT 20
    ");
    $stmt->execute();
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($reviews);

} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
