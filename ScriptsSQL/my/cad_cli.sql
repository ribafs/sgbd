-- Tabelas primarias: clientes, users, produtos
-- Secundária: pedidos

-- Relacionamentos: pedidos com clientes, users e produtos

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `cpf` char(11) DEFAULT NULL,
  `nome` char(45) NOT NULL,
  `credito_liberado` char(1) NOT NULL,
  `data_nasc` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `username` char(45) NOT NULL,
  `password` char(255) NOT NULL,
  `role` char(20) NOT NULL,
  created DATETIME,
  modified DATETIME
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `descricao` varchar(100) NOT NULL,
  `unidade` char(4) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `quantidade` int(11) NOT NULL,
  `preco_venda` decimal(12,2) NOT NULL,
  `data_pedido` date NOT NULL,
  `data_confirmacao` date NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `produto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `clientes`
  ADD CONSTRAINT `cliente2_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `produtos`
  ADD CONSTRAINT `produto_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `pedidos`
  ADD CONSTRAINT `cliente_fk` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`id`),
  ADD CONSTRAINT `user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `produto_ped_fk` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`);

