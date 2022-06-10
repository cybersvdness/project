-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 09 2022 г., 12:12
-- Версия сервера: 8.0.24
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `team_nmstuworkers`
--

-- --------------------------------------------------------

--
-- Структура таблицы `requests`
--

CREATE TABLE `requests` (
  `id` int NOT NULL,
  `FromUser` int NOT NULL,
  `ToUser` int NOT NULL,
  `IsAnswered` tinyint(1) NOT NULL DEFAULT '0',
  `Answer` tinyint(1) DEFAULT NULL,
  `Date` date NOT NULL,
  `Time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `requests`
--

INSERT INTO `requests` (`id`, `FromUser`, `ToUser`, `IsAnswered`, `Answer`, `Date`, `Time`) VALUES
(1, 2, 6, 0, NULL, '2022-06-09', '05:09:53'),
(2, 1, 2, 1, 1, '2022-06-09', '05:12:11'),
(3, 1, 7, 1, 0, '2022-06-09', '05:12:17');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `Name` varchar(30) NOT NULL,
  `Surname` varchar(30) NOT NULL,
  `Gender` varchar(4) NOT NULL,
  `Institute` varchar(10) NOT NULL,
  `Course` int NOT NULL,
  `Age` int NOT NULL,
  `Photo` varchar(100) DEFAULT NULL,
  `Link` varchar(100) NOT NULL,
  `Token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `isAdmin` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `Email`, `Password`, `Name`, `Surname`, `Gender`, `Institute`, `Course`, `Age`, `Photo`, `Link`, `Token`, `isAdmin`) VALUES
(1, 'smolnikov.ar@ya.ru', '$2y$10$B0QEGYetlAbFkQz8Gq1iIuDN6QL.M.AZzZ5meS/sbFjgjcvOEhnbe', 'Арсений', 'Смольников', 'муж', 'ИЭиАС', 2, 19, 'smolnikov-arseniy-ieias-1.jpg', 'vk.com/smolnikov', 'f660f22ccb532eba2ba3db4d23a0083f77489881', 1),
(2, 'aleksandrova@ya.ru', '$2y$10$VqkELNqtH6WnX.I..RLGye3SZIlOSpBUBJ7OAw9.9qypbjO.iqiga', 'Александра', 'Александрова', 'жен', 'ИГО', 1, 19, 'aleksandrova-aleksandra-ieias-2.jpg', 'vk.com/aleksandrova', NULL, 0),
(3, 'titov@ya.ru', '$2y$10$X9/9C80zDlEsNp3vYu2iW.OuKNjCyrPnjm2sHpqXCKpv4kL4hzwW.', 'Вячеслав', 'Титов', 'муж', 'ИЭиАС', 2, 19, 'titov-vyacheslav-ieias-3.jpg', 'vk.com/titov', NULL, 0),
(4, 'perov@ya.ru', '$2y$10$sWHBJLkG4FZLAaQZShH24OFU6QXwa5VqfzHgL04B3iAHJMmK7dKDG', 'Дмитрий', 'Перов', 'муж', 'ИЭиАС', 2, 19, 'perov-dmitriy-ieias-4.jpg', 'vk.com/perov', NULL, 0),
(5, 'seregin@ya.ru', '$2y$10$ZXw0orISdb6FCgCn8cHu6OAhuHo5n4JGdTq6tuEiYgu4ZwZoCBYsC', 'Алексей', 'Серегин', 'муж', 'ИЭиАС', 2, 19, NULL, 'vk.com/seregin', NULL, 0),
(6, 'zubenko@ya.ru', '$2y$10$bX9Hc/MuJQXLdiCAq9PTqez3NvQ34MM3FTYvD8eHd0w8ZJB0Inp02', 'Михаил', 'Зубенко', 'муж', 'ИММиМ', 4, 21, 'zubenko-mihail-immim-6.jpg', 'vk.com/zubenko', NULL, 0),
(7, 'olgovna@ya.ru', '$2y$10$CByVv9MQc0fRUX/djkMYNOZdkkb1Q6VnbpTFvY1/TUHDac8zsgpqe', 'Ольга', 'Иванова', 'жен', 'ИГДиТ', 1, 18, 'ivanova-olga-igdit-7.jpg', 'vk.com/ivanova', NULL, 0),
(8, 'shuleshko@ya.ru', '$2y$10$l50vpHbDwdqBXcWym0bI4eQxWUWqTuqqO9rufxzla3pHWn2fQ/ruy', 'Арина', 'Шулешко', 'жен', 'ИЭиАС', 2, 19, NULL, 'vk.com/shuleshko', NULL, 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `requests`
--
ALTER TABLE `requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FromUser` (`FromUser`,`ToUser`),
  ADD KEY `ToUser` (`ToUser`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `requests`
--
ALTER TABLE `requests`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `requests`
--
ALTER TABLE `requests`
  ADD CONSTRAINT `requests_ibfk_1` FOREIGN KEY (`FromUser`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `requests_ibfk_2` FOREIGN KEY (`ToUser`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
