DROP DATABASE IF EXISTS `sigec`;

CREATE DATABASE `sigec`;

USE `sigec`;


CREATE TABLE `bloco` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nome` varchar(80) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `sala` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bloco` int NOT NULL,
  `nome` varchar(80) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `chave`(
    `id` int NOT NULL AUTO_INCREMENT,    
    `id_sala` int not null,
    `etiqueta` varchar(30) unique not null,
    `descricao` varchar(80) not null,    
    `situacao` ENUM('disponivel', 'emprestada', 'manutenção') DEFAULT 'disponivel',
    `habilitada` tinyint(1) DEFAULT '1',
    `restrita` tinyint(1) DEFAULT '0',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `usuario` (  
  `id` int NOT NULL AUTO_INCREMENT,
  `matricula` int NOT NULL UNIQUE,
  `nome` varchar(255) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `celular` varchar(50) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT '1',
  `doc_autorizacao` varchar(255) DEFAULT NULL,
  `tipo` enum('aluno','servidor', 'terceirizado') NOT NULL,
  `perfil` enum('administrador', 'portaria', 'solicitante') NOT NULL DEFAULT 'solicitante',
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `restricao_chave` (
  `id_chave` int NOT NULL,
  `mat_solic` int NOT NULL,
  `restricao` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_chave`, `mat_solic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `emprestimo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `mat_admin_abertura` int NOT NULL,
  `mat_admin_encerramento` int NOT NULL,
  `mat_solic` int NOT NULL,
  `data_emprestimo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_devolucao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `observacao` varchar(100) DEFAULT NULL,
  `situacao` enum('ativo','encerrado') NOT NULL DEFAULT 'ativo',
    PRIMARY KEY (`id`)    
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `item_emprestimo` (    
  `id_emprestimo` int NOT NULL,
  `id_chave` int NOT NULL,  
  `devolvido_em` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_emprestimo`, `id_chave`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




ALTER TABLE sala ADD ( CONSTRAINT FOREIGN KEY (id_bloco) REFERENCES bloco(id));

/*ALTER TABLE chave ADD ( CONSTRAINT FOREIGN KEY (id_bloco) REFERENCES bloco(id));*/
ALTER TABLE chave ADD ( CONSTRAINT FOREIGN KEY (id_sala) REFERENCES sala(id));

ALTER TABLE restricao_chave ADD ( CONSTRAINT FOREIGN KEY (id_chave) REFERENCES chave(id));
ALTER TABLE restricao_chave ADD ( CONSTRAINT FOREIGN KEY (matricula_solicitante) REFERENCES usuario(matricula));

ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (mat_admin) REFERENCES usuario(matricula));
ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (mat_solic) REFERENCES usuario(matricula));

ALTER TABLE itens_emprestimo ADD ( CONSTRAINT FOREIGN KEY (id_emprestimo) REFERENCES emprestimo(id));
ALTER TABLE itens_emprestimo ADD ( CONSTRAINT FOREIGN KEY (id_chave) REFERENCES chave(id));




