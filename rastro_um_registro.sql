-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 03-Mar-2020 às 20:35
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `clientes_viagem`
--

CREATE TABLE `clientes_viagem` (
  `id_cliente` int(11) NOT NULL,
  `id_viagem` int(11) NOT NULL,
  `quantidade_dependente` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Um cliente realiza n viagens assim cmo um viagem é realizada por n clientes\\n';

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
(1, 'Tiago Alves dos Santos de Oliveira', 'administrador', 'tiago123', 'tiago123', 'Não definido');

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
  `valor_motorista` varchar(50) DEFAULT NULL,
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
  MODIFY `id_cliente` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dispesas`
--
ALTER TABLE `dispesas`
  MODIFY `id_dispesas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `fornecedor`
--
ALTER TABLE `fornecedor`
  MODIFY `id_fornecedor` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `motorista`
--
ALTER TABLE `motorista`
  MODIFY `id_motorista` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `veiculo`
--
ALTER TABLE `veiculo`
  MODIFY `id_veiculo` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `viagem`
--
ALTER TABLE `viagem`
  MODIFY `id_viagem` int(11) NOT NULL AUTO_INCREMENT;

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
