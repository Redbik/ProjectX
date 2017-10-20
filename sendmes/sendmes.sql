-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Окт 20 2017 г., 21:35
-- Версия сервера: 10.1.21-MariaDB
-- Версия PHP: 7.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `sendmes`
--

-- --------------------------------------------------------

--
-- Структура таблицы `otchet`
--

CREATE TABLE `otchet` (
  `id_otchet` int(11) NOT NULL,
  `ot` int(11) NOT NULL,
  `do` int(11) NOT NULL,
  `mesage` varchar(250) NOT NULL,
  `date` varchar(20) NOT NULL,
  `timee` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `otchet`
--

INSERT INTO `otchet` (`id_otchet`, `ot`, `do`, `mesage`, `date`, `timee`) VALUES
(11, 2, 11, 'wefrg', '20.10.17', '20:09:39'),
(12, 2, 11, 'wefrg', '20.10.17', '20:09:55'),
(13, 2, 11, 'wefrg', '20.10.17', '20:10:34'),
(14, 2, 11, 'wefrg', '20.10.17', '20:15:44'),
(15, 2, 11, 'wefrg', '20.10.17', '20:16:54'),
(16, 2, 11, 'wefrg', '20.10.17', '20:17:56'),
(17, 2, 11, 'wefrg', '20.10.17', '20:18:39'),
(18, 2, 11, 'wefrg', '20.10.17', '20:18:50'),
(19, 2, 11, 'ФИНАЛЬНЫЙ ТЕСТ СУКА !!!', '20.10.17', '20:20:41');

-- --------------------------------------------------------

--
-- Структура таблицы `post`
--

CREATE TABLE `post` (
  `id_post` int(11) NOT NULL,
  `vk_id` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `likes` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `post`
--

INSERT INTO `post` (`id_post`, `vk_id`, `name`, `likes`) VALUES
(2, 'alexkran', 'Александр', 2),
(3, 'nisalay', 'Саня', 200),
(4, 'danilashpala', 'Даня', 1),
(5, 'id152392306', 'Дмитрий', 10000),
(6, 'id437089105', 'dwefef', 1121),
(7, 'id439187043', 'dwefefdwwd', 1212),
(8, 'id364817213', 'wdwdw', 1313),
(9, 'kran001', 'kran001', 13),
(10, 'id323048998', 'dwefrgt', 1322),
(11, 'id116769850', 'fgrth', 44);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `otchet`
--
ALTER TABLE `otchet`
  ADD PRIMARY KEY (`id_otchet`);

--
-- Индексы таблицы `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id_post`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `otchet`
--
ALTER TABLE `otchet`
  MODIFY `id_otchet` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT для таблицы `post`
--
ALTER TABLE `post`
  MODIFY `id_post` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
