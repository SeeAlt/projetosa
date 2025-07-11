CREATE TABLE tb_psa_user(
    id_user INT NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(255) NOT NULL,
    user_password VARCHAR(100) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    user_cpf INT NOT NULL UNIQUE,
    user_phone INT(11) NOT NULL,
    user_address VARCHAR(255) NOT NULL,
    is_admin TINYINT DEFAULT 0,
    
	CONSTRAINT pk_user PRIMARY KEY(id_user)
    );
