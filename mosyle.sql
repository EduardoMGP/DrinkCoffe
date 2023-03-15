-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 15-Mar-2023 às 02:16
-- Versão do servidor: 5.7.33
-- versão do PHP: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `mosyle`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `drink` int(11) NOT NULL DEFAULT '0',
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `drink`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@email.com', '4e6c01372114628ddcb6244b1bd470e27522e94c597b10e24c534', 0, 'admin', '2023-03-15 02:02:25', '2023-03-15 02:02:25'),
(2, 'Pedro', 'pedro@email.com', 'e033213721146cbf1f986bd5a153c49ffe930765c86c8d30dfe40', 30, 'user', '2023-03-15 02:02:25', '2023-03-15 02:12:01'),
(3, 'Joao', 'joao@email.com', 'e033213721146cbf1f986bd5a153c49ffe930765c86c8d30dfe40', 19, 'user', '2023-03-15 02:02:25', '2023-03-15 02:12:01'),
(4, 'Brenda', 'brenda@email.com', 'e033213721146cbf1f986bd5a153c49ffe930765c86c8d30dfe40', 13, 'user', '2023-03-15 02:02:25', '2023-03-15 02:12:01'),
(5, 'Amanda', 'amanda@email.com', 'e033213721146cbf1f986bd5a153c49ffe930765c86c8d30dfe40', 7, 'user', '2023-03-15 02:02:25', '2023-03-15 02:12:01');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_drink`
--

CREATE TABLE `users_drink` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `drink` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users_drink`
--

INSERT INTO `users_drink` (`id`, `user_id`, `drink`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2023-03-15 02:03:30', '2023-03-15 02:03:30'),
(2, 5, 1, '2023-03-15 02:03:41', '2023-03-15 02:03:41'),
(3, 5, 1, '2023-03-15 02:03:41', '2023-03-15 02:03:41'),
(4, 5, 1, '2023-03-15 02:03:41', '2023-03-15 02:03:41'),
(5, 5, 1, '2023-03-15 02:03:41', '2023-03-15 02:03:41'),
(6, 5, 1, '2023-03-15 02:03:41', '2023-03-15 02:03:41'),
(7, 5, 1, '2023-03-15 02:03:41', '2023-03-15 02:03:41'),
(8, 4, 2, '2023-03-15 02:03:52', '2023-03-15 02:03:52'),
(9, 4, 2, '2023-03-15 02:04:11', '2023-03-15 02:04:11'),
(10, 4, 1, '2023-03-15 02:04:11', '2023-03-15 02:04:11'),
(11, 4, 3, '2023-03-15 02:04:11', '2023-03-15 02:04:11'),
(12, 4, 1, '2023-03-15 02:04:12', '2023-03-15 02:04:12'),
(13, 4, 4, '2023-03-15 02:04:12', '2023-03-15 02:04:12'),
(14, 2, 10, '2023-03-15 02:04:26', '2023-03-15 02:04:26'),
(15, 2, 5, '2023-03-15 02:04:36', '2023-03-15 02:04:36'),
(16, 2, 5, '2023-03-15 02:04:36', '2023-03-15 02:04:36'),
(17, 2, 5, '2023-03-15 02:04:36', '2023-03-15 02:04:36'),
(18, 2, 5, '2023-03-15 02:04:36', '2023-03-15 02:04:36'),
(19, 3, 7, '2023-03-15 02:04:36', '2023-03-15 02:04:36'),
(20, 3, 12, '2023-03-13 02:04:36', '2023-03-13 02:04:36');

-- --------------------------------------------------------

--
-- Estrutura da tabela `users_token`
--

CREATE TABLE `users_token` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `token` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `expired_at` timestamp NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `users_token`
--

INSERT INTO `users_token` (`id`, `user_id`, `token`, `user_agent`, `ip`, `expired_at`, `created_at`, `updated_at`) VALUES
(1, 3, 'JLqD4U9hPEsYNW+yV84gLbyFtVlFnTWH7je2Yl/kOSEpr5nDD+lAd1tmjQm7A1doiDRmV7DML7+YSYYr7N4R+7RSoBcaJAd5dwrJ8pxgKPqV+Wxei5vwpM7zfaz81izoZQUbvzSHSqJUCKQwcRW8viB+GIo/vGtHvQfMIKeUQDntBRtp', 'PostmanRuntime/7.31.1', '127.0.0.1', '2023-03-15 05:34:53', '2023-03-15 02:04:53', '2023-03-15 02:04:53');

--
-- Índices para tabelas despejadas
--

--
-- Índices para tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Índices para tabela `users_drink`
--
ALTER TABLE `users_drink`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Índices para tabela `users_token`
--
ALTER TABLE `users_token`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT de tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `users_drink`
--
ALTER TABLE `users_drink`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de tabela `users_token`
--
ALTER TABLE `users_token`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `users_drink`
--
ALTER TABLE `users_drink`
  ADD CONSTRAINT `users_drink_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Limitadores para a tabela `users_token`
--
ALTER TABLE `users_token`
  ADD CONSTRAINT `users_token_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
