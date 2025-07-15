<?php
session_start();
require_once 'conexao.php';

$user_email = $_POST['useremail'];
$userpassword = $_POST['userpassword'];

try {
    $stmt = $pdo->prepare("SELECT * FROM tb_psa_user WHERE useremail = :useremail AND userpassword = :userpassword");
    $stmt->bindParam(':useremail', $useremail);
    $stmt->bindParam(':userpassword', $userpassword);
    $stmt->execute();

    $tb_psa_user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tb_psa_user) {
        $_SESSION['id_user']        = $tb_psa_user['iduser'];
        $_SESSION['user_name']      = $tb_psa_user['username'];
        $_SESSION['user_login']     = $tb_psa_user['userlogin'];
        $_SESSION['user_email']     = $tb_psa_user['useremail'];
        $_SESSION['user_password']  = $tb_psa_user['userpassword'];
        $_SESSION['is_admin']       = $tb_psa_user['isadmin'];
        $_SESSION['logged']         = true;

        echo json_encode([
            'success' => true,
            'redirect' => 'index.html'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'E-mail ou senha incorretos.']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erro no banco de dados: ' . $e->getMessage()]);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Erro inesperado: ' . $e->getMessage()]);
}
?>

