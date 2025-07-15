CREATE TABLE tb_psa_review (
    id_review INT NOT NULL AUTO_INCREMENT,
    id_user INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review_comment TEXT,
    review_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_review),
    CONSTRAINT fk_review_user FOREIGN KEY (id_user) REFERENCES tb_psa_user(id_user)
) ENGINE=InnoDB;
