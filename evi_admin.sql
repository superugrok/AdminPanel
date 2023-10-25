-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Хост: localhost
-- Время создания: Окт 25 2023 г., 23:33
-- Версия сервера: 10.3.18-MariaDB-0+deb10u1
-- Версия PHP: 7.3.14-5+0~20200202.52+debian10~1.gbpa71879

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `evi_admin`
--

-- --------------------------------------------------------

--
-- Структура таблицы `codes`
--

CREATE TABLE `codes` (
  `id` int(11) NOT NULL,
  `code` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `codes`
--

INSERT INTO `codes` (`id`, `code`) VALUES
(41, '609a199881ca4ba9c95688235cd6ac5c'),
(38, '90e1357833654983612fb05e3ec9148c'),
(40, 'c0d8ec4888d56b0fabfe476c780e2cc4'),
(31, 'd3f5d4de09ea19461dab00590df91e4f');

-- --------------------------------------------------------

--
-- Структура таблицы `cookies`
--

CREATE TABLE `cookies` (
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `rang` varchar(255) NOT NULL,
  `reg_date` int(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `user_ip` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `cookies`
--

INSERT INTO `cookies` (`login`, `email`, `rang`, `reg_date`, `user_agent`, `user_ip`) VALUES
('Erwin', 'superugrok@mail.ru', 'Руководитель', 1581356475, '46abf0d68e56d79f1380ffaab81adce5', 'df200e7b7917ff322ca1538ddf47364b');

-- --------------------------------------------------------

--
-- Структура таблицы `email_codes`
--

CREATE TABLE `email_codes` (
  `id` int(11) NOT NULL,
  `code` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `email_codes`
--

INSERT INTO `email_codes` (`id`, `code`) VALUES
(23, 23601),
(24, 88254);

-- --------------------------------------------------------

--
-- Структура таблицы `pass_codes`
--

CREATE TABLE `pass_codes` (
  `id` int(11) NOT NULL,
  `code` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `rang` varchar(255) NOT NULL,
  `reg_date` int(11) NOT NULL,
  `current_login` int(255) NOT NULL,
  `last_login` int(255) NOT NULL,
  `2fa_key` varchar(255) DEFAULT NULL,
  `2fa` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `rang`, `reg_date`, `current_login`, `last_login`, `2fa_key`, `2fa`, `avatar`) VALUES
(1, 'Erwin', 'superugrok@mail.ru', '$2y$10$K9YKgrXdTaiqq0K4PG52OO8eCkAdnyyNNY0qswIPL2ROZ.LquM6yy', 'Руководитель', 1581356475, 1606565207, 1605035854, 'J7SG6K2TH4BRJCJP', NULL, 'https://evionrp.ru/evi-admin/assets/avatars/Erwin.png'),
(2, 'Yookie666', 'vasiti200@icloud.com', '$2y$10$7Kt.EjgN6pEGAu4bwemUaO4Xz0AvIt.kVYfxqERkZIhdBZpBHw4n.', 'Руководитель', 1582921145, 1582921259, 1582921145, NULL, NULL, 'https://evionrp.ru/evi-admin/assets/avatars/default.png'),
(4, 'DVS', 'masterxaosa@gmail.com', '$2y$10$Fqc4ZCt45CFZdpl2OXpVOej/sr08ZBeodVYNtu3h/Ys4DUZfrxXb.', 'Руководитель', 1584034975, 1584035269, 1584034981, NULL, NULL, 'https://evionrp.ru/evi-admin/assets/avatars/default.png');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Индексы таблицы `cookies`
--
ALTER TABLE `cookies`
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Индексы таблицы `email_codes`
--
ALTER TABLE `email_codes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pass_codes`
--
ALTER TABLE `pass_codes`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `codes`
--
ALTER TABLE `codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT для таблицы `email_codes`
--
ALTER TABLE `email_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT для таблицы `pass_codes`
--
ALTER TABLE `pass_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
