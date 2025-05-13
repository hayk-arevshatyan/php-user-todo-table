-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Май 14 2025 г., 00:29
-- Версия сервера: 8.0.30
-- Версия PHP: 8.0.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `api_info`
--

-- --------------------------------------------------------

--
-- Структура таблицы `todo_list`
--

CREATE TABLE `todo_list` (
  `id` int NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `completed` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `todo_list`
--

INSERT INTO `todo_list` (`id`, `title`, `completed`, `user_id`) VALUES
(3, 'Finish homework', '', 8),
(4, 'Read a book', '1', 7),
(5, 'Pay bills', '', 2),
(6, 'Call a friend', '1', 4),
(7, 'Clean the house', '', 6),
(8, 'Go to the gym', '1', 9),
(9, 'Write a report', '', 8),
(10, 'Cook dinner', '1', 2),
(11, 'Study for exams', '', 1),
(12, 'Do laundry', '1', 3),
(13, 'Practice guitar', '', 5),
(14, 'Plan a trip', '1', 7),
(15, 'Attend a meeting', '', 9),
(16, 'Water the plants', '1', 6),
(17, 'Fix the car', '', 4),
(18, 'Watch a movie', '1', 8),
(19, 'Visit the museum', '', 10),
(20, 'Send an email', '1', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `company` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `zip` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `state` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `country` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `user_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `company`, `username`, `email`, `address`, `zip`, `state`, `country`, `phone`, `photo`, `user_id`) VALUES
(1, 'Van Faker Attribute Error: person.astName is not supported', 'Sipes - West', 'Hunter_Brown18', 'sally.barton57@gmail.com', '6472 Ruecker Court', '62224-9633', 'Kentucky', 'American Samoa', '410-823-8740 x8061', 'https://json-server.dev/ai-profiles/6.png', 2),
(2, 'Catharine Jenkins', 'Wisoky Inc', 'Susana17', 'skylar_yundt41@hotmail.com', '731 Kiehn Crescent', '41396-3952', 'South Dakota', 'Estonia', '1-699-512-3786 x064', 'https://json-server.dev/ai-profiles/26.png', 3),
(3, 'Glen Ferry', 'Konopelski - Trantow', 'Diana50', 'lowell19@yahoo.com', '1342 Treutel Creek', '47258-5090', 'Kentucky', 'Malaysia', '642.508.0579', 'https://json-server.dev/ai-profiles/55.png', 4),
(4, 'Ellis Rempel', 'Kohler, Thompson and Champlin', 'Marge.Reilly', 'verona_heidenreich-heller69@hotmail.com', '77642 Nienow Mountains', '15414', 'Montana', 'Albania', '1-287-584-4595 x451', 'https://json-server.dev/ai-profiles/11.png', 5),
(5, 'Maxwell Mohr', 'Haley, Heathcote and Murray', 'Meggie_Mante', 'sylvia_langworth36@yahoo.com', '701 Johan Flat', '05921-3364', 'Oregon', 'Uzbekistan', '(642) 428-8276 x037', 'https://json-server.dev/ai-profiles/58.png', 7),
(6, 'Norris Lindgren', 'Gleichner, Shields and Volkman', 'Grant_Blick', 'myra_howell@gmail.com', '1991 Harber Circles', '66497-2518', 'South Dakota', 'Finland', '267-583-0733', 'https://json-server.dev/ai-profiles/17.png', 8),
(7, 'Dessie Fisher', 'Ward and Sons', 'Mathias_Hintz3', 'timmy.moen35@hotmail.com', '8570 Jarret Tunnel', '45420', 'Missouri', 'Senegal', '445.613.7662', 'https://json-server.dev/ai-profiles/80.png', 9),
(8, 'Abigayle Cartwright', 'Botsford - Adams', 'Cruz_Kuphal', 'maxine7@hotmail.com', '7330 E State Street', '65147-2335', 'Arkansas', 'Slovakia', '806.513.8754 x723', 'https://json-server.dev/ai-profiles/67.png', 10),
(9, 'Shanon Yost-Stroman', 'Flatley and Sons', 'Colin.McKenzie27', 'kristina.jerde@gmail.com', '328 E 4th Avenue', '20809', 'Washington', 'Guernsey', '683.854.6852 x70661', 'https://json-server.dev/ai-profiles/45.png', 1),
(10, 'Wilfredo McClure', 'Orn, Greenfelder and Nader', 'Brain2', 'cecelia_kulas78@gmail.com', '647 Manor Road', '35423', 'Vermont', 'Republic of Korea', '902-567-8532 x428', 'https://json-server.dev/ai-profiles/39.png', 6);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `todo_list`
--
ALTER TABLE `todo_list`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `todo_list`
--
ALTER TABLE `todo_list`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
