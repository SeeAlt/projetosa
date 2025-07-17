<?php
require_once "conexao.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $user_name     = $_POST["user_name"] ?? '';
        $user_email    = $_POST["user_email"] ?? '';
        $user_password = password_hash($_POST["user_password"] ?? '', PASSWORD_DEFAULT);
        $user_cpf      = $_POST["user_cpf"] ?? '';
        $user_phone    = $_POST["user_phone"] ?? '';
        $is_admin      = isset($_POST["is_admin"]) ? 1 : 0;

        if (empty($user_name)) {
            throw new Exception("Nome não pode ser vazio.");
        }

        $sql = "INSERT INTO tb_psa_user (user_name, user_email, user_password, user_cpf, user_phone, is_admin)
                VALUES (:username, :useremail, :userpassword, :usercpf, :userphone, :isadmin)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $user_name);
        $stmt->bindParam(':useremail', $user_email);
        $stmt->bindParam(':userpassword', $user_password);
        $stmt->bindParam(':usercpf', $user_cpf);
        $stmt->bindParam(':userphone', $user_phone);
        $stmt->bindParam(':isadmin', $is_admin);

        $stmt->execute();

        $message = "Usuário cadastrado com sucesso!";
    } catch (PDOException $e) {
        $message = "Erro ao cadastrar: " . $e->getMessage();
    } catch (Exception $e) {
        $message = "Erro: " . $e->getMessage();
    }
}
?>