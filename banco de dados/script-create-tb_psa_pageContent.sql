CREATE TABLE tb_psa_pageContent (
    id_content INT AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(100) UNIQUE NOT NULL,
    content_text TEXT NOT NULL
) ENGINE=InnoDB;
