-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 16/05/2020 às 14:47
-- Versão do servidor: 10.4.11-MariaDB
-- Versão do PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `gwdb`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `guitarwars`
--

CREATE TABLE `guitarwars` (
  `id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(255) NOT NULL,
  `score` int(11) NOT NULL,
  `music` varchar(255) NOT NULL,
  `screenshot` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Despejando dados para a tabela `guitarwars`
--

INSERT INTO `guitarwars` (`id`, `date`, `name`, `score`, `music`, `screenshot`) VALUES
(1, '2020-05-16 12:46:00', 'Fabricio Patrocinio', 1209000, 'Dreamweaver - Stratovarius', '1589633185record-guitar-hero.jpg');

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `guitarwars`
--
ALTER TABLE `guitarwars`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `guitarwars`
--
ALTER TABLE `guitarwars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
