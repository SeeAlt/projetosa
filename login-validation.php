<?php
session_start();
require_once 'conexao.php';

header('Content-Type: application/json');

$useremail = $_POST['useremail'] ?? '';
$userpassword = $_POST['userpassword'] ?? '';

try {
   
    $stmt = $pdo->prepare("SELECT * FROM tb_psa_user WHERE user_email = :useremail");
    $stmt->bindParam(':useremail', $useremail);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    
    if ($user && password_verify($userpassword, $user['user_password'])) {
        $_SESSION['id_user']     = $user['id_user'];
        $_SESSION['user_name']   = $user['user_name'];
        $_SESSION['user_email']  = $user['user_email'];
        $_SESSION['is_admin']    = $user['is_admin'];
        $_SESSION['logged']      = 1;

        echo json_encode([
            'success' => 1,
            'redirect' => 'index.html'
        ]);
    } else {
        echo json_encode(['success' => 0, 'message' => 'E-mail ou senha incorretos.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => 0, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
}
