-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Время создания: Апр 07 2020 г., 14:46
-- Версия сервера: 5.7.29-log
-- Версия PHP: 7.1.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `db_sw`
--

-- --------------------------------------------------------

--
-- Структура таблицы `t_keys`
--

CREATE TABLE `t_keys` (
  `a_index` int(11) NOT NULL,
  `a_key` varchar(22) NOT NULL DEFAULT 'AAAA-AAAA-AAAA-AAAA',
  `a_userid` varchar(64) NOT NULL DEFAULT 'u_CODE',
  `a_uuid` varchar(128) NOT NULL DEFAULT '0',
  `a_enable` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `t_psndata`
--

CREATE TABLE `t_psndata` (
  `a_index` int(11) NOT NULL,
  `a_userid` varchar(32) NOT NULL,
  `a_id_user` varchar(16) NOT NULL DEFAULT '0000000000000000',
  `a_friendly_name` varchar(64) NOT NULL DEFAULT 'USERNAME',
  `a_replaceable` tinyint(1) NOT NULL DEFAULT '0',
  `a_enable` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `t_psndata`
--


-- --------------------------------------------------------

--
-- Структура таблицы `t_session`
--

CREATE TABLE `t_session` (
  `a_index` int(11) NOT NULL,
  `a_userid` varchar(64) NOT NULL,
  `a_uuid` varchar(64) NOT NULL,
  `a_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `t_session_sw`
--

CREATE TABLE `t_session_sw` (
  `a_index` int(11) NOT NULL,
  `a_token` varchar(255) NOT NULL,
  `a_time` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `t_session_sw`
--


-- --------------------------------------------------------

--
-- Структура таблицы `t_user`
--

CREATE TABLE `t_user` (
  `a_index` int(11) NOT NULL,
  `a_name` varchar(255) NOT NULL DEFAULT 'NONE',
  `a_userid` varchar(64) NOT NULL,
  `a_uuid` varchar(128) NOT NULL DEFAULT '0',
  `a_pid` int(3) NOT NULL DEFAULT '7',
  `a_cid` int(3) NOT NULL DEFAULT '0',
  `a_psnid_remaining` int(3) NOT NULL DEFAULT '1',
  `a_psnid_quota` int(3) NOT NULL DEFAULT '2',
  `a_id` varchar(16) NOT NULL DEFAULT 'A00A-00000000',
  `a_enable` int(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `t_keys`
--
ALTER TABLE `t_keys`
  ADD PRIMARY KEY (`a_index`),
  ADD UNIQUE KEY `key` (`a_key`);

--
-- Индексы таблицы `t_psndata`
--
ALTER TABLE `t_psndata`
  ADD PRIMARY KEY (`a_index`);

--
-- Индексы таблицы `t_session`
--
ALTER TABLE `t_session`
  ADD PRIMARY KEY (`a_index`);

--
-- Индексы таблицы `t_session_sw`
--
ALTER TABLE `t_session_sw`
  ADD PRIMARY KEY (`a_index`);

--
-- Индексы таблицы `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`a_index`),
  ADD UNIQUE KEY `a_userid` (`a_userid`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `t_keys`
--
ALTER TABLE `t_keys`
  MODIFY `a_index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT для таблицы `t_psndata`
--
ALTER TABLE `t_psndata`
  MODIFY `a_index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `t_session`
--
ALTER TABLE `t_session`
  MODIFY `a_index` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `t_session_sw`
--
ALTER TABLE `t_session_sw`
  MODIFY `a_index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `t_user`
--
ALTER TABLE `t_user`
  MODIFY `a_index` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
