CREATE TABLE tb_psa_user (
    id_user INT NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(255) NOT NULL,
    user_email VARCHAR(255) NOT NULL UNIQUE,
    user_password VARCHAR(100) NOT NULL,
    user_cpf BIGINT NOT NULL UNIQUE,
    user_phone BIGINT NOT NULL,
    is_admin TINYINT(1) DEFAULT 0,
    logged TINYINT(1),
    PRIMARY KEY (id_user)
) ENGINE=InnoDB;
    
    