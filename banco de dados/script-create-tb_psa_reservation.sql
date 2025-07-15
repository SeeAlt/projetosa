CREATE TABLE tb_psa_reservation (
    id_reservation INT NOT NULL AUTO_INCREMENT,
    reservation_local VARCHAR(255) NOT NULL,
    people_quantity INT NOT NULL,
    reservation_datehour DATETIME NOT NULL,
    reservation_status VARCHAR(50),
    id_user INT NOT NULL,
    PRIMARY KEY (id_reservation),
    CONSTRAINT fk_reservation_user FOREIGN KEY (id_user) REFERENCES tb_psa_user(id_user)
) ENGINE=InnoDB;
    

