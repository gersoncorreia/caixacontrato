-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: 04-Out-2019 às 00:28
-- Versão do servidor: 5.7.23
-- versão do PHP: 5.6.38

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_caixa_contrato`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_caixa`
--

DROP TABLE IF EXISTS `tb_caixa`;
CREATE TABLE IF NOT EXISTS `tb_caixa` (
  `id_caixa` int(11) NOT NULL AUTO_INCREMENT,
  `id_tipo_contrato` int(11) NOT NULL,
  `codigo_caixa` int(11) NOT NULL,
  `status` enum('A','F') DEFAULT 'A',
  `data_cad` datetime DEFAULT NULL,
  `data_fechamento` datetime DEFAULT NULL,
  `situacao` enum('C','E','A') DEFAULT NULL,
  PRIMARY KEY (`id_caixa`,`id_tipo_contrato`),
  KEY `fk_tb_caixa_contratos_tb_tipo_contrato1_idx` (`id_tipo_contrato`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_caixa`
--

INSERT INTO `tb_caixa` (`id_caixa`, `id_tipo_contrato`, `codigo_caixa`, `status`, `data_cad`, `data_fechamento`, `situacao`) VALUES
(22, 1, 1, 'A', '2019-10-03 16:28:34', NULL, 'C');

--
-- Acionadores `tb_caixa`
--
DROP TRIGGER IF EXISTS `tr_caixa`;
DELIMITER $$
CREATE TRIGGER `tr_caixa` BEFORE INSERT ON `tb_caixa` FOR EACH ROW BEGIN
      declare numero integer;

   Set numero = (select max(codigo_caixa) From tb_caixa where id_tipo_contrato = new.id_tipo_contrato);
   

   if (new.codigo_caixa = 0) or (new.codigo_caixa is null)then
      set new.codigo_caixa = 1;
      SET new.data_cad = CURRENT_TIMESTAMP();
   end if;
   
        IF numero > 0 THEN
			SET new.codigo_caixa = (select max(codigo_caixa) From tb_caixa where id_tipo_contrato = new.id_tipo_contrato)+1;         
		SET new.data_cad = CURRENT_TIMESTAMP();                     
	END IF;	
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_cliente`
--

DROP TABLE IF EXISTS `tb_cliente`;
CREATE TABLE IF NOT EXISTS `tb_cliente` (
  `id_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(60) DEFAULT NULL,
  `CPF` varchar(16) DEFAULT NULL,
  `CNPJ` varchar(20) DEFAULT NULL,
  `data_inclusao` datetime DEFAULT NULL,
  PRIMARY KEY (`id_cliente`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_cliente`
--

INSERT INTO `tb_cliente` (`id_cliente`, `nome`, `CPF`, `CNPJ`, `data_inclusao`) VALUES
(78, 'MICAELA DE ARUJO SOARES CORREIA FONSECA', '936.956.832-87', '', '2019-10-03 21:32:00');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_contrato`
--

DROP TABLE IF EXISTS `tb_contrato`;
CREATE TABLE IF NOT EXISTS `tb_contrato` (
  `id_contrato` int(11) NOT NULL AUTO_INCREMENT,
  `id_caixa` int(11) NOT NULL,
  `codigo_caixa` int(11) NOT NULL,
  `codigo_produto` int(5) DEFAULT NULL,
  `nome` varchar(60) NOT NULL,
  `numero_contrato` varchar(30) NOT NULL,
  `vencimento` varchar(16) DEFAULT NULL,
  `data_inclusao` datetime DEFAULT NULL,
  `CPF` varchar(15) DEFAULT NULL,
  `CNPJ` varchar(20) DEFAULT NULL,
  `situacao` enum('C','E') DEFAULT NULL,
  PRIMARY KEY (`id_contrato`),
  KEY `fk_tb_contrato_tb_caixa_dossie_idx` (`id_caixa`)
) ENGINE=InnoDB AUTO_INCREMENT=110 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_contrato`
--

INSERT INTO `tb_contrato` (`id_contrato`, `id_caixa`, `codigo_caixa`, `codigo_produto`, `nome`, `numero_contrato`, `vencimento`, `data_inclusao`, `CPF`, `CNPJ`, `situacao`) VALUES
(109, 22, 1, 110, 'MICAELA DE ARUJO SOARES CORREIA FONSECA', '12846', '30/10/2019', '2019-10-03 21:32:00', '936.956.832-87', '', 'E');

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_produto`
--

DROP TABLE IF EXISTS `tb_produto`;
CREATE TABLE IF NOT EXISTS `tb_produto` (
  `id_produto` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(30) DEFAULT NULL,
  `codigo_produto` int(5) DEFAULT NULL,
  PRIMARY KEY (`id_produto`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_produto`
--

INSERT INTO `tb_produto` (`id_produto`, `descricao`, `codigo_produto`) VALUES
(1, 'Consignado', 110),
(2, 'CDC AUTOMATICO', 400),
(3, 'FIES', 185),
(4, 'NOVO FIES', 187),
(5, 'Conta Corrente', 1),
(6, 'Conta Poupanca', 13),
(7, 'Conta FACIL', 23),
(8, 'Conta PJ', 3),
(9, 'Financiamento Veiculo', 7044);

-- --------------------------------------------------------

--
-- Estrutura da tabela `tb_tipo_contrato`
--

DROP TABLE IF EXISTS `tb_tipo_contrato`;
CREATE TABLE IF NOT EXISTS `tb_tipo_contrato` (
  `id_tipo_contrato` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_contrato` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_contrato`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `tb_tipo_contrato`
--

INSERT INTO `tb_tipo_contrato` (`id_tipo_contrato`, `tipo_contrato`) VALUES
(1, 'HABITAÇÃO'),
(2, 'PESSOA FISICA'),
(3, 'PESSOA JURIDICA');

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `UsuariosId` int(9) NOT NULL AUTO_INCREMENT,
  `UsuariosNome` varchar(40) NOT NULL,
  `UsuariosEmail` varchar(255) NOT NULL,
  `UsuariosLogin` varchar(20) NOT NULL,
  `UsuariosSenha` varchar(255) NOT NULL,
  `UsuariosAtivo` char(1) NOT NULL DEFAULT 's',
  `UsuariosAdm` char(1) NOT NULL DEFAULT 'n',
  `UsuariosDtaCad` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`UsuariosId`),
  UNIQUE KEY `email` (`UsuariosEmail`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `usuarios`
--

INSERT INTO `usuarios` (`UsuariosId`, `UsuariosNome`, `UsuariosEmail`, `UsuariosLogin`, `UsuariosSenha`, `UsuariosAtivo`, `UsuariosAdm`, `UsuariosDtaCad`) VALUES
(1, 'RAFAEL A DA SILVA', 'rafael_assuncao826@hotmail.com', 'admin', '21232f297a57a5a743894a0e4a801fc3', 's', 's', '2016-06-02 04:24:12'),
(22, 'GERSON CORREIA LIMA NETO', 'gersoncorreia12@gmail.com', 'gerson12', 'c5067990d97b11f1ecf3306db127e21c', 's', 'n', '2019-09-30 06:20:25');

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `tb_caixa`
--
ALTER TABLE `tb_caixa`
  ADD CONSTRAINT `fk_tb_caixa_contratos_tb_tipo_contrato1` FOREIGN KEY (`id_tipo_contrato`) REFERENCES `tb_tipo_contrato` (`id_tipo_contrato`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Limitadores para a tabela `tb_contrato`
--
ALTER TABLE `tb_contrato`
  ADD CONSTRAINT `fk_tb_contrato_tb_caixa_dossie` FOREIGN KEY (`id_caixa`) REFERENCES `tb_caixa` (`id_caixa`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
