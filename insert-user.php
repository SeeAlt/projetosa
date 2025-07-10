<?php

    require_once "conexao.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $user_name = $_POST["name"];
        $user_password = $_POST["password"];
        $user_email = $_POST["email"];
        $user_cep = $_POST["cep"];
        $user_address = $_POST["address"];
        $is_admin = $_POST["admin"];

        $sql = "INSERT INTO tb_psa_user(user_name, user_password, user_email, user_cep, user_address, is_admin)
                VALUES (:name, :password, :email, :cep, :address, :admin)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $user_name);
        $stmt->bindParam(':password', $user_passsword);
        $stmt->bindParam(':email', $user_email);
        $stmt->bindParam(':cep', $user_cep);
        $stmt->bindParam(':address', $user_address);
        $stmt->bindParam(':admin', $is_admin);


    }