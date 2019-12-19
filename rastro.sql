-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 19-Dez-2019 às 16:21
-- Versão do servidor: 10.4.6-MariaDB
-- versão do PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `rastro`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes`
--

CREATE TABLE `clientes` (
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `cpf` varchar(15) DEFAULT NULL,
  `data_nasc` date DEFAULT NULL,
  `pais` varchar(45) DEFAULT NULL,
  `cidade` varchar(45) DEFAULT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `passaporte` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `clientes`
--

INSERT INTO `clientes` (`id_cliente`, `nome`, `cpf`, `data_nasc`, `pais`, `cidade`, `telefone`, `passaporte`) VALUES
(1, 'Tiago Alves dos Santos de Oliveira', '080.608.883-41', '2019-11-07', 'Brasil', 'Granja', '+55 (88) 9 9921-7845', NULL),
(2, 'Anonimo', NULL, '2001-05-09', 'Argentina', 'Granja', '+55 (88) 9 9921-7848', '2345'),
(3, 'Santos Oliveira', '080.608.883-40', '2001-02-02', 'Brasil', 'Granja', '+55 (88) 9 9815-4335', NULL);

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes_viagem`
--

CREATE TABLE `clientes_viagem` (
  `id_cliente` int(11) NOT NULL,
  `id_viagem` int(11) NOT NULL,
  `quantidade_dependente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Um cliente realiza n viagens assim cmo um viagem é realizada por n clientes\\n';

--
-- Extraindo dados da tabela `clientes_viagem`
--

INSERT INTO `clientes_viagem` (`id_cliente`, `id_viagem`, `quantidade_dependente`) VALUES
(1, 1, 4),
(1, 3, 6),
(1, 5, 0),
(2, 2, 4),
(2, 4, 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `dispesas`
--

CREATE TABLE `dispesas` (
  `id_dispesas` int(11) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `preco` double DEFAULT NULL,
  `id_motorista` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `dispesas`
--

INSERT INTO `dispesas` (`id_dispesas`, `descricao`, `data`, `preco`, `id_motorista`) VALUES
(1, 'Batida no carro', '2019-11-21', 123.99, 1),
(3, 'Gasolina', '2019-11-30', 123.89, 2),
(4, 'Gasolina', '2001-02-02', 200.55, 1),
(5, 'Gasolina', '2019-11-21', 100, 1),
(6, 'Farol quebrado', '2019-11-10', 600, 1),
(7, 'Pneu Rasgado', '2019-11-07', 50.67, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `fornecedor`
--

CREATE TABLE `fornecedor` (
  `id_fornecedor` int(11) NOT NULL,
  `nome` varchar(60) NOT NULL,
  `telefone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `fornecedor`
--

INSERT INTO `fornecedor` (`id_fornecedor`, `nome`, `telefone`, `email`) VALUES
(1, 'Rastro', '+55 (88) 9 9945-7845', 'rastro@email.com'),
(2, 'Tiago Laravel', '+55 (88) 9 99240996', 'email@gmail.com');

-- --------------------------------------------------------

--
-- Estrutura da tabela `motorista`
--

CREATE TABLE `motorista` (
  `id_motorista` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `cpf` varchar(50) DEFAULT NULL,
  `status_motorista` varchar(45) DEFAULT 'Disponivel',
  `vinculo` varchar(45) DEFAULT NULL,
  `agencia_banco` varchar(45) DEFAULT NULL,
  `conta_banco` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `motorista`
--

INSERT INTO `motorista` (`id_motorista`, `nome`, `foto`, `cpf`, `status_motorista`, `vinculo`, `agencia_banco`, `conta_banco`) VALUES
(1, 'Tiago Alves dos Santos de Oliveira', 'upload/motorista/1.jpg', '080.608.883-43', 'Agendada', 'Externo', '12334', '1'),
(2, 'Tiago Alves', 'upload/motorista/2.jpg', '080.608.883-99', 'Agendada', 'Interno', '122', '2');

-- --------------------------------------------------------

--
-- Estrutura da tabela `motorista_viagem`
--

CREATE TABLE `motorista_viagem` (
  `id_motorista` int(11) NOT NULL,
  `id_viagem` int(11) NOT NULL,
  `id_veiculo` int(11) NOT NULL,
  `placa` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Um motorista pode realizar n viagens assim como um viagem pode ser realizada porn motoristas';

--
-- Extraindo dados da tabela `motorista_viagem`
--

INSERT INTO `motorista_viagem` (`id_motorista`, `id_viagem`, `id_veiculo`, `placa`) VALUES
(1, 1, 1, 'DFS-1254'),
(1, 3, 1, 'DFS-1254'),
(1, 4, 2, 'DFS-1253'),
(1, 5, 1, 'DFS-1254'),
(2, 2, 2, 'DFS-1253'),
(2, 3, 2, 'DFS-1253'),
(2, 5, 2, 'DFS-1253');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(45) DEFAULT NULL,
  `tipo_usuario` varchar(20) DEFAULT NULL,
  `login` varchar(45) DEFAULT NULL,
  `senha` varchar(45) DEFAULT NULL,
  `cargo` varchar(45) DEFAULT 'Não definido'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Um usuario agenda n viagens, uma viagem é agendada por 1 usuario';

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `tipo_usuario`, `login`, `senha`, `cargo`) VALUES
(1, 'Tiago Alves dos Santos de Oliveira', 'administrador', 'tiago123', 'tiago123', 'Não definido'),
(2, 'Anonimo', 'usuario', 'usuario123', 'usuario123', 'atendente');

-- --------------------------------------------------------

--
-- Estrutura da tabela `veiculo`
--

CREATE TABLE `veiculo` (
  `id_veiculo` int(11) NOT NULL,
  `placa` varchar(50) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `modelo` varchar(50) DEFAULT NULL,
  `propietario` varchar(50) DEFAULT NULL,
  `foto_carro` varchar(255) DEFAULT NULL,
  `ano` varchar(50) DEFAULT NULL,
  `capacidade_maxima` int(11) DEFAULT NULL,
  `disponivel` varchar(45) DEFAULT 'Concluida',
  `vinculo` varchar(45) DEFAULT NULL,
  `tipo` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `veiculo`
--

INSERT INTO `veiculo` (`id_veiculo`, `placa`, `marca`, `modelo`, `propietario`, `foto_carro`, `ano`, `capacidade_maxima`, `disponivel`, `vinculo`, `tipo`) VALUES
(1, 'DFS-1254', 'Fiat', 'Uno', 'Tiago', 'upload/veiculos/1.jpg', '2006', 5, 'Agendada', 'Interno', 'Carro'),
(2, 'DFS-1253', 'Fiat', 'Uno', 'Tiago Alves', 'upload/veiculos/foto_padrao.png', '2009', 5, 'Agendada', 'Interno', 'Carro'),
(3, 'TRE-345', 'Yamaha', 'XR', 'Maria', 'upload/veiculos/3.png', '2010', 2, 'Concluida', 'Externo', 'Lancha');

-- --------------------------------------------------------

--
-- Estrutura da tabela `viagem`
--

CREATE TABLE `viagem` (
  `id_viagem` int(11) NOT NULL,
  `destino` varchar(50) DEFAULT NULL,
  `origem` varchar(45) DEFAULT NULL,
  `local_origem` varchar(255) DEFAULT NULL,
  `local_destino` varchar(255) DEFAULT NULL,
  `preco` varchar(50) DEFAULT NULL,
  `data_inicio` date DEFAULT NULL,
  `data_termino` date DEFAULT NULL,
  `horario_saida` time DEFAULT NULL,
  `horario_chegada` time DEFAULT NULL,
  `localizador` varchar(255) DEFAULT NULL,
  `observacoes` text DEFAULT NULL,
  `status_viagem` varchar(45) DEFAULT NULL,
  `id_fornecedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `viagem`
--

INSERT INTO `viagem` (`id_viagem`, `destino`, `origem`, `local_origem`, `local_destino`, `preco`, `data_inicio`, `data_termino`, `horario_saida`, `horario_chegada`, `localizador`, `observacoes`, `status_viagem`, `id_fornecedor`) VALUES
(1, 'Granja', 'Camocim', 'teste', 'teste', '200', '2019-12-25', NULL, '12:56:00', NULL, NULL, 'sdfsdfsdf', 'Agendada', 2),
(2, 'Prea', 'Jijoca', 'wrewe', 'werwer', '123', '2019-12-25', NULL, '12:34:00', NULL, NULL, 'ssadasdasd', 'Agendada', 1),
(3, 'Fortaleza', 'Sobral', 'sdfsdf', 'sdfsdf', '456', '2019-12-27', NULL, '03:45:00', NULL, NULL, 'fsdfsdf', 'Agendada', 1),
(4, 'Parnaiba-PI', 'Granja-CE', 'Kintura', 'Rodoviaria', '28.8', '2019-12-14', NULL, '14:28:00', NULL, NULL, 'Fazer Prova Final de Engenharia de Software', 'Concluida', 1),
(5, 'Camocim-CE', 'Granja-CE', 'Kintura', 'Prai', '10', '2019-12-13', NULL, '17:55:00', NULL, NULL, 'Viagem em andamento teste', 'Concluida', 2);

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `clientes`
--
ALTER TABLE `clientes`
  ADD PRIMARY KEY (`id_cliente`);

--
-- Índices para tabela `clientes_viagem`
--
ALTER TABLE `clientes_viagem`
  ADD PRIMARY KEY (`id_cliente`,`id_viagem`),
  ADD KEY `fk_clientes_has_viagem_viagem1_idx` (`id_viagem`),
  ADD KEY `fk_clientes_has_viagem_clientes1_idx` (`id_cliente`);

--
-- Índices para tabela `dispesas`
--
ALTER TABLE `dispesas`
  ADD PRIMARY KEY (`id_dispesas`,`id_motorista`),
  ADD KEY `fk_dispesas_motorista_idx` (`id_motorista`);

--
-- Índices para tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  ADD PRIMARY KEY (`id_fornecedor`);

--
-- Índices para tabela `motorista`
--
ALTER TABLE `motorista`
  ADD PRIMARY KEY (`id_motorista`);

--
-- Índices para tabela `motorista_viagem`
--
ALTER TABLE `motorista_viagem`
  ADD PRIMARY KEY (`id_motorista`,`id_viagem`,`id_veiculo`,`placa`),
  ADD KEY `fk_motorista_has_viagem_viagem1_idx` (`id_viagem`),
  ADD KEY `fk_motorista_has_viagem_motorista1_idx` (`id_motorista`),
  ADD KEY `fk_motorista_viagem_veiculo1_idx` (`id_veiculo`,`placa`);

--
-- Índices para tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- Índices para tabela `veiculo`
--
ALTER TABLE `veiculo`
  ADD PRIMARY KEY (`id_veiculo`,`placa`),
  ADD UNIQUE KEY `placa_UNIQUE` (`placa`);

--
-- Índices para tabela `viagem`
--
ALTER TABLE `viagem`
  ADD PRIMARY KEY (`id_viagem`,`id_fornecedor`),
  ADD KEY `fk_viagem_fornecedor1_idx` (`id_fornecedor`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `clientes`
--
ALTER TABLE `clientes`
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `dispesas`
--
ALTER TABLE `dispesas`
  MODIFY `id_dispesas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `motorista`
--
ALTER TABLE `motorista`
  MODIFY `id_motorista` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `viagem`
--
ALTER TABLE `viagem`
  MODIFY `id_viagem` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `clientes_viagem`
--
ALTER TABLE `clientes_viagem`
  ADD CONSTRAINT `fk_clientes_has_viagem_clientes1` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_clientes_has_viagem_viagem1` FOREIGN KEY (`id_viagem`) REFERENCES `viagem` (`id_viagem`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `dispesas`
--
ALTER TABLE `dispesas`
  ADD CONSTRAINT `fk_dispesas_motorista` FOREIGN KEY (`id_motorista`) REFERENCES `motorista` (`id_motorista`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `motorista_viagem`
--
ALTER TABLE `motorista_viagem`
  ADD CONSTRAINT `fk_motorista_has_viagem_motorista1` FOREIGN KEY (`id_motorista`) REFERENCES `motorista` (`id_motorista`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_motorista_has_viagem_viagem1` FOREIGN KEY (`id_viagem`) REFERENCES `viagem` (`id_viagem`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_motorista_viagem_veiculo1` FOREIGN KEY (`id_veiculo`,`placa`) REFERENCES `veiculo` (`id_veiculo`, `placa`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `viagem`
--
ALTER TABLE `viagem`
  ADD CONSTRAINT `fk_viagem_fornecedor1` FOREIGN KEY (`id_fornecedor`) REFERENCES `fornecedor` (`id_fornecedor`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
