DROP DATABASE IF EXISTS `sigec`;

CREATE DATABASE `sigec`;

USE `sigec`;


CREATE TABLE `bloco` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nome` varchar(100) NOT NULL,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `sala` (
  `id` int NOT NULL AUTO_INCREMENT,
  `id_bloco` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

CREATE TABLE `chave`(
    `id` int NOT NULL AUTO_INCREMENT,
    /*`id_bloco` int not null,*/
    `id_sala` int not null,
    `etiqueta` varchar(20) unique not null,
    `descricao` varchar(40) not null,    
    `situacao` ENUM('disponivel', 'emprestada') DEFAULT 'disponivel',
    `habilitada` boolean DEFAULT true,
    PRIMARY KEY (`id`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `usuario` (
  `matricula` int NOT NULL,
  `nome` varchar(100) NOT NULL,
  `senha` varchar(255) DEFAULT NULL,
  `telefone` varchar(50) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `url_foto` varchar(255) DEFAULT NULL,
  `habilitado` tinyint(1) DEFAULT '1',
  `doc_autorizacao` varchar(255) DEFAULT NULL,
  `tipo` enum('bolsista','servidor') NOT NULL,
  `permissao` enum('administrador', 'portaria', 'solicitante') NOT NULL DEFAULT 'solicitante',
  PRIMARY KEY (`matricula`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `restricao_chave` (
  `id_chave` int NOT NULL,
  `matricula_solicitante` int NOT NULL,
  `restricao` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_chave`, `matricula_solicitante`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `emprestimo` (
  `id` int NOT NULL AUTO_INCREMENT,
  `matricula_admin` int NOT NULL,
  `matricula_solicitante` int NOT NULL,
  `data_emprestimo` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_devolucao` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `observacao` varchar(100) DEFAULT NULL,
  `situacao` enum('ativo','encerrado') NOT NULL DEFAULT 'ativo',
    PRIMARY KEY (`id`)
    
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;


CREATE TABLE `itens_emprestimo` (    
  `id_emprestimo` int NOT NULL,
  `id_chave` int NOT NULL,
  `retirada_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `devolvida_em` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id_emprestimo`, `id_chave`)
)ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;




ALTER TABLE sala ADD ( CONSTRAINT FOREIGN KEY (id_bloco) REFERENCES bloco(id));

/*ALTER TABLE chave ADD ( CONSTRAINT FOREIGN KEY (id_bloco) REFERENCES bloco(id));*/
ALTER TABLE chave ADD ( CONSTRAINT FOREIGN KEY (id_sala) REFERENCES sala(id));

ALTER TABLE restricao_chave ADD ( CONSTRAINT FOREIGN KEY (id_chave) REFERENCES chave(id));
ALTER TABLE restricao_chave ADD ( CONSTRAINT FOREIGN KEY (matricula_solicitante) REFERENCES usuario(matricula));

ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (matricula_admin) REFERENCES usuario(matricula));
ALTER TABLE emprestimo ADD ( CONSTRAINT FOREIGN KEY (matricula_solicitante) REFERENCES usuario(matricula));

ALTER TABLE itens_emprestimo ADD ( CONSTRAINT FOREIGN KEY (id_emprestimo) REFERENCES emprestimo(id));
ALTER TABLE itens_emprestimo ADD ( CONSTRAINT FOREIGN KEY (id_chave) REFERENCES chave(id));




INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Auditório');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Biblioteca');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Cantina');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Aquisições e Contratações');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Assuntos Estudantis');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Comunicação e Eventos');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Controle Acadêmico');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Execução Financeira e Orçamentária');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Gestão de Pessoas');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria de Tecnologia da Informação');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria do Curso de Bacharelado em Ciências da Computação');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria do Curso de Licenciatura em Física');

INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '3', 'Coordenadoria de Infraestrutura');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '3', 'Coordenadoria de Pesquisa');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria do Curso de Licenciatura em Letras');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria do Curso Técnico em Agricultura');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria do Curso Técnico em Informática');

INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Coordenadoria Técnico-Pedagógica');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Departamento de Administração e Planejamento');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Departamento de Ensino');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Guarita');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Incubadora');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Biologia / Sementes');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Física I');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Física II');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Hardware');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Informática I');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Informática II');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Informática III');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Informática IV');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Línguas');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Manipulação de Alimentos');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Pós-Colheita');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Laboratório de Química / Solos');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'NAPNE');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Oficina');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Recepção');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala das Coordenadorias');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala dos Professores');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Videoconferência');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Vestiário Feminino – Quadra');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Vestiário Masculino – Quadra');

INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 01');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 02');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 03');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 04');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 05');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 06');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 07');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 08');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 09');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 10');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 11');
INSERT INTO `sala` (`id`, `id_bloco`, `nome`) VALUES (NULL, '1', 'Sala de Aula 12');







