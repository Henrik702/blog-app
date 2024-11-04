-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Ноя 04 2024 г., 01:34
-- Версия сервера: 8.0.30
-- Версия PHP: 8.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `blogs`
--

-- --------------------------------------------------------

--
-- Структура таблицы `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `author_id` int DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `posts`
--

INSERT INTO `posts` (`id`, `author_id`, `title`, `content`, `created_at`, `updated_at`) VALUES
(2, 34, 'test', 'test', '2024-11-03 21:48:35', '2024-11-03 21:48:35');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `created_at`) VALUES
(34, 'henrik.gevorgyan@outlook.com', 'Henrik', '$2y$10$VWG13JchfoB4I2hYodz5nO40ftnvzCV9TvZtL3Q1UQDBm6stb2cs2', '2024-11-03 21:18:40'),
(35, 'henrik.gevorgyan1995@mail.ru', 'Henrik-2', '$2y$10$Q/56wbu0VhupfgMPWYuvO.9fBEmvb6AuyUbs5fBvCdkz6wCNWO.P6', '2024-11-03 21:48:49'),
(36, 'asdasd@asda.ru', 'test', '$2y$10$CAeKRyXMwaNUvE5lJ3ySzeyatpOqvPv7C4z/BZNojJOPe5fhhIX4S', '2024-11-03 21:49:53'),
(37, 'asdasd@asdasdasdas.ru', 'asdasd', '$2y$10$Igz7y2mpmww2mPEJRb/N9OlHTk9vmg3NWLP6rob7haej7U04xdCFK', '2024-11-03 21:53:42'),
(38, 'asdasdasasda@asdasd.com', 'asdasd', '$2y$10$6gCIHu60R.lJy2HTErzz5u6nSCPDJrAd62tfg71m1et.mNbquOUj.', '2024-11-03 21:54:00'),
(39, 'henrik.gevorgyan@outlooasdk.com', 'henrik', '$2y$10$1W.vGXpxoUWwmJ.YWwVI8e/fzz3W1No7RqpZINpW7yGRL6sQlwUte', '2024-11-03 22:12:20');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `author_id` (`author_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
