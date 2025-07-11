<?php

    require_once "conexao.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        try {
            $username = $_POST["username"] ?? '';;
            $userpassword = $_POST["userpassword"] ?? '';;
            $useremail = $_POST["useremail"] ?? '';;
            $usercpf = $_POST["usercpf"] ?? '';;
            $userphone = $_POST["userphone"] ?? '';;
            $useraddress = $_POST["useraddress"] ?? '';;
            $isadmin = isset($_POST["isadmin"]) ? 1 : 0;

            if (empty($username)) {
                throw new Exception("Nome não pode ser vazio.");
        }
        
        $sql = "INSERT INTO tb_psa_user (user_name, user_password, user_email, user_cpf, user_phone, user_address, is_admin)
                VALUES (:username, :userpassword, :useremail, :usercpf, :userphone, :useraddress, :isadmin)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':userpassword', $userpassword);
        $stmt->bindParam(':useremail', $useremail);
        $stmt->bindParam(':usercpf', $usercpf);
        $stmt->bindParam(':userphone', $userphone);
        $stmt->bindParam(':useraddress', $useraddress);
        $stmt->bindParam(':isadmin', $isadmin);

        $stmt->execute();

        echo  "Usuário cadastrado com sucesso!";

    } catch (PDOException $e) {
        echo json_encode(["success" => false, "message" => "Erro ao cadastrar: " . $e->getMessage()]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "message" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Erro no envio do formulário."]);
}
exit;
?>
