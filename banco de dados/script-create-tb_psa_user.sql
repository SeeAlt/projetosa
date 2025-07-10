CREATE TABLE tb_psa_user(
	id_user INT NOT NULL AUTO_INCREMENT,
    user_name VARCHAR(255) NOT NULL,
    user_passsword VARCHAR(100) NOT NULL,
    user_email VARCHAR(255) NOT NULL,
    user_cpf INT NOT NULL UNIQUE,
    user_cep INT NOT NULL,
    user_address VARCHAR(255) NOT NULL,
    is_admin BIT NOT NULL,
    
	CONSTRAINT pk_user PRIMARY KEY(id_user)
    );
    