DROP DATABASE IF EXISTS `sigec`;

CREATE DATABASE `sigec`;

USE `sigec`;


CREATE TABLE `bloco` (
    `id` INT NOT NULL AUTO_INCREMENT,
    `nome` VARCHAR(80) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `sala` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `id_bloco` INT NOT NULL,
  `nome` VARCHAR(80) NOT NULL,
  `situacao` ENUM('Ativa', 'Inativa', 'Manutencao') DEFAULT 'Ativa',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `chave`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `id_sala` INT NOT NULL,
    `etiqueta` VARCHAR(30) UNIQUE NOT NULL,
    `descricao` VARCHAR(80) NOT NULL,    
    `situacao` ENUM('Disponivel', 'Emprestada', 'Extraviada') DEFAULT 'Disponivel',
    `habilitada` TINYINT(1) DEFAULT '1',
    `restrita` TINYINT(1) DEFAULT '0',
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `usuario` (  
  `id` INT NOT NULL AUTO_INCREMENT,
  `matricula` INT NOT NULL UNIQUE,
  `nome` VARCHAR(255) NOT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `celular` VARCHAR(50) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `url_foto` VARCHAR(255) DEFAULT NULL,
  `habilitado` TINYINT(1) DEFAULT '1',
  `doc_autorizacao` VARCHAR(255) DEFAULT NULL,
  `tipo` enum('Aluno','Servidor', 'Terceirizado') NOT NULL,
  `perfil` enum('Administrador', 'Portaria', 'Solicitante') NOT NULL,
  PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `restricao_chave` (
  `id_chave` INT NOT NULL,
  `mat_solic` INT NOT NULL,
  `data_inclusao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_inclusao` INT NOT NULL,
  `motivo_inclusao` VARCHAR(255) DEFAULT NULL,
  `data_remocao` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_remocao` INT NOT NULL,
  `restrita` TINYINT(1) DEFAULT '0',
  
  PRIMARY KEY (`id_chave`, `mat_solic`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `emprestimo` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `mat_solic` INT NOT NULL,
  `mat_user_abertura` INT NOT NULL,
  `mat_user_devolucao` INT NULL,  
  `data_abertura` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_devolucao` TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `observacao` VARCHAR(255) DEFAULT NULL,
  `situacao` enum('Aberto','Devolvido', 'Atrasado') NOT NULL DEFAULT 'Aberto',
    PRIMARY KEY (`id`)    
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `item_emprestimo` (    
  `id_emprestimo` INT NOT NULL,
  `id_chave` INT NOT NULL,  
  `devolvido_em` TIMESTAMP DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `mat_user` INT NULL,
    PRIMARY KEY (`id_emprestimo`, `id_chave`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;



ALTER TABLE sala ADD ( CONSTRAINT FOREIGN KEY (id_bloco) REFERENCES bloco(id));

ALTER TABLE chave ADD ( CONSTRAINT FOREIGN KEY (id_sala) REFERENCES sala(id));

ALTER TABLE restricao_chave ADD ( CONSTRAINT FOREIGN KEY (id_chave) REFERENCES chave(id));
ALTER TABLE restricao_chave ADD ( CONSTRAINT FOREIGN KEY (mat_solic) REFERENCES usuario(matricula));

ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (mat_solic) REFERENCES usuario(matricula));
ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (mat_user_abertura) REFERENCES usuario(matricula));
ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (mat_user_devolucao) REFERENCES usuario(matricula));

ALTER TABLE item_emprestimo ADD ( CONSTRAINT FOREIGN KEY (id_emprestimo) REFERENCES emprestimo(id));
ALTER TABLE item_emprestimo ADD ( CONSTRAINT FOREIGN KEY (id_chave) REFERENCES chave(id));
ALTER TABLE item_emprestimo ADD ( CONSTRAINT FOREIGN KEY (mat_user) REFERENCES usuario(matricula));


/* Inserção de dados*/

/* Blocos */

INSERT INTO `bloco` (`nome`) VALUES ('Administrativo');
INSERT INTO `bloco` (`nome`) VALUES ('Didático');
INSERT INTO `bloco` (`nome`) VALUES ('Anexo');



/* Salas do Bloco Administrativo */

INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Guarita');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Recepção');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Coordenadoria de Tecnologia da Informação');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Coordenadoria de Controle Acadêmico');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Departamento de Administração e Planejamento');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Coordenadoria de Gestão de Pessoas');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Coordenadoria de Execução Financeira e Orçamentária');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Direção-Geral');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Laboratório de Hardware');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Laboratório de Física I');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Laboratório de Biologia / Sementes');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Laboratório de Química / Solos');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Departamento de Ensino');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Cantina');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Sala de Videoconferência');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Auditório');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Laboratório de Línguas');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Laboratório de Física II');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Sala dos Professores');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Coordenadoria de Assuntos Estudantis');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Biblioteca');

/* Bloco Didático */

INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 01');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 02');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 03');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 04');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 05');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 06');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 07');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 08');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 09');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 10');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 11');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Sala de Aula 12');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Laboratório de Informática I');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Laboratório de Informática II');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Laboratório de Informática III');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Laboratório de Informática IV');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Laboratório de Manipulação de Alimentos');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'Laboratório de Pós-Colheita');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('2', 'NAPNE');

/* Bloco Anexo */

INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('3', 'Almoxarifado');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('3', 'Oficina');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('3', 'Incubadora');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('3', 'Sala de Aula 13');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('3', 'Sala de Aula 14');


/* Quadra de Esportes */

INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Vestiário Feminino');
INSERT INTO `sala` (`id_bloco`, `nome`) VALUES ('1', 'Vestiário Masculino');


/* Chaves */

/* Emprestimos*/

INSERT INTO `emprestimo` (`id`, `mat_solic`, `mat_user_abertura`, `mat_user_devolucao`, 
             `data_abertura`, `data_devolucao`, `observacao`, `situacao`) 
      VALUES (NULL, '111111', '111111', NULL, CURRENT_TIMESTAMP, NULL, NULL, 'Aberto');

INSERT INTO `emprestimo` (`id`, `mat_solic`, `mat_user_abertura`, `mat_user_devolucao`, 
             `data_abertura`, `data_devolucao`, `observacao`, `situacao`) 
VALUES (NULL, '111111', '22222', '111111', CURRENT_TIMESTAMP, NULL, 'Um teste qualquer', 'Aberto');


/*Item Emprestimo*/

INSERT INTO `item_emprestimo` (`id_emprestimo`, `id_chave`, `devolvido_em`) 
            VALUES ('2', '4', NULL);

INSERT INTO `item_emprestimo` (`id_emprestimo`, `id_chave`, `devolvido_em`) 
            VALUES ('3', '3', NULL);


/*Usuários*/

INSERT INTO `usuario` (`id`, `matricula`, `nome`, `senha`, `celular`, `email`, `url_foto`, `habilitado`, `doc_autorizacao`, `tipo`, `perfil`) 
      VALUES (NULL, '4444444', 'FULANO DA SILVA PEREIRA', '123456', '55999999999', 'fulano.pereira@ifce.edu.br', NULL, '1', NULL, 'Servidor', 'Solicitante');