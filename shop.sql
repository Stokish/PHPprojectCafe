-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: localhost:3306
-- Время создания: Июн 19 2020 г., 08:09
-- Версия сервера: 8.0.18
-- Версия PHP: 7.3.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `shop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Coffee'),
(2, 'Breakfast'),
(3, 'Tea'),
(4, 'Lemonade'),
(5, 'Fresh desserts');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cost` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`order_id`, `date`, `cost`) VALUES
(10, '2020-06-06 17:25:07', 48.18),
(11, '2020-06-06 17:34:10', 16.96),
(12, '2020-06-06 18:14:49', 64.92),
(25, '2020-06-07 05:15:51', 3.99),
(28, '2020-06-07 06:19:12', 15.96),
(30, '2020-06-07 10:42:44', 9.95),
(36, '2020-06-08 08:52:48', 39.94),
(37, '2020-06-09 13:02:02', 7.5),
(39, '2020-06-13 06:59:53', 30),
(41, '2020-06-17 13:22:57', 29.97),
(42, '2020-06-17 14:38:05', 12.96);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_product`
--

CREATE TABLE `orders_product` (
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders_product`
--

INSERT INTO `orders_product` (`order_id`, `product_id`) VALUES
(10, 8),
(10, 1),
(10, 16),
(11, 1),
(11, 16),
(12, 2),
(12, 9),
(25, 2),
(28, 2),
(30, 14),
(36, 12),
(36, 20),
(37, 1),
(39, 1),
(41, 8),
(42, 20),
(42, 15);

-- --------------------------------------------------------

--
-- Структура таблицы `orders_users`
--

CREATE TABLE `orders_users` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `orders_users`
--

INSERT INTO `orders_users` (`order_id`, `user_id`) VALUES
(10, 1),
(11, 1),
(12, 1),
(25, 1),
(28, 1),
(30, 23),
(36, 1),
(37, 30),
(39, 23),
(41, 23),
(42, 23);

-- --------------------------------------------------------

--
-- Структура таблицы `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `product_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `cost` double NOT NULL,
  `image` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Дамп данных таблицы `product`
--

INSERT INTO `product` (`product_id`, `category_id`, `product_name`, `cost`, `image`, `description`) VALUES
(1, 1, 'Espresso', 1.25, 'https://cdn.pixabay.com/photo/2018/01/25/22/25/coffee-3107235_960_720.jpg', 'wasdxcv '),
(2, 1, 'Latte', 3.99, 'photo/Menu/Drinks/latte.jpg', 'Latte is a coffee drink made with espresso and steamed milk.'),
(8, 2, 'Pancakes', 9.99, 'photo/Menu/Breakfast/pancakes.jpeg', 'A pancake is a breakfast dish, a flat cake that\'s made by pouring batter into a hot pan and frying it on both sides. '),
(9, 2, 'Waffles with Blueberry Compote', 14.99, 'photo/Menu/Breakfast/waffles.jpeg', 'A waffle is a cooked food made from a batter that consists of flour, water, baking powder, oil, and eggs.'),
(10, 2, 'Granola', 11.99, 'photo/Menu/Breakfast/granola.jpeg', 'Basic granola requires just a handful of ingredients: oats, a sweetener, some oil, and maybe nuts or dried fruit. '),
(11, 2, 'Mini Kale Shakshuka', 17.99, 'photo/Menu/Breakfast/kale.jpeg', 'It calls for braised greens in place of tomatoes and includes plenty of lemon, feta, Greek yogurt, za’atar, and parsley.'),
(12, 2, 'Morning Potatoes', 7.99, 'photo/Menu/Breakfast/potatoes.jpeg', 'Potatoes are a very good source of vitamin B6,C, potassium, copper, manganese, dietary fiber, and pantothenic acid.'),
(13, 3, 'Black tea', 0.99, 'photo/Menu/Drinks/black_tea.jpg', 'Black tea offers a variety of health benefits, including improved cholesterol, better gut health and decreased blood pressure.'),
(14, 3, 'Jasmine tea', 1.99, 'photo/Menu/Drinks/jasmine_tea.jpg', 'Gracefully sweet and delicately floral, Jasmine is liquid flower power and probably the world\'s most popular flavoured green tea.'),
(15, 4, 'Lemonade', 0.99, 'photo/Menu/Drinks/lemonade.jpg', 'Lemonade is a very refreshing drink, and this is the best one ever! Lemonade: sugar, water, lemon juice.'),
(16, 5, 'Crack Buns', 2.99, 'photo/Menu/Desserts/crack_buns.jpg', 'These gorgeous cream puff \"crack buns” were inspired by the Great British Baking Show.'),
(17, 5, 'Margarita cupcakes', 3.99, 'photo/Menu/Desserts/margarita.jpg', 'Margarita cupcakes begin with a simple sweet lime cupcake base and are topped with fluffy tequila lime frosting!'),
(18, 5, 'Banana Pudding', 2.49, 'photo/Menu/Desserts/banana.jpg', 'Banana pudding is a classic Southern dessert, well-loved for its creamy texture and comforting qualities.'),
(19, 5, 'Brownie', 2.99, 'photo/Menu/Desserts/brownie.png', 'A chocolate brownie or simply a brownie is a square or rectangular chocolate baked treat and may be either fudgy or cakey, depending on their density.'),
(20, 5, 'Chocolate Chip Cookies', 3.99, 'photo/Menu/Desserts/chocolate.jpg', 'Crisp edges, chewy middles, and so, so easy to make. Try this wildly-popular chocolate chip cookie recipe for yourself.');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_pass` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_email` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_type_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_pass`, `user_email`, `user_address`, `user_type_id`) VALUES
(1, 'Samat Ne admin', '1', 'sam@gmail.com', 'some address', 2),
(10, 'Alisher Ne admin', '1', 'alisher@gmail.com', 'some address', 2),
(11, 'Madiar Ne admin', '1', 'madiar@gmail.com', 'some address', 2),
(20, 'Some', 'Body', 'TheWorldIsGonnaRollse@mail.com', 'Once told me', 1),
(23, 'guestzxc', 'xzcv', 'sxlmzmlzx@gmail.com', 'bbdf;\'x,x;lzm', 1),
(30, 'guest', '222', 'm@gmail.com', 'WAEDSFVB', 1),
(31, 'awasdzv', 'й223', 'w@MAIL.RU', 'цыф', 1),
(35, 'guest', 'ww', 'al@gmail.com', 'some address', 1),
(37, 'SomeOne', '123', 'myEmail@email.com', 'My Address', 1),
(38, 'ss', 'ss', 'ssasasdxs@gmail.com', 'ss', 1),
(42, 'ikjh', 'hh', 'hh@mail.ru', 'hh', 1);

-- --------------------------------------------------------

--
-- Структура таблицы `user_type`
--

CREATE TABLE `user_type` (
  `user_type_id` int(11) NOT NULL,
  `user_type_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_type`
--

INSERT INTO `user_type` (`user_type_id`, `user_type_name`) VALUES
(1, 'customer'),
(2, 'admin');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Индексы таблицы `orders_product`
--
ALTER TABLE `orders_product`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Индексы таблицы `orders_users`
--
ALTER TABLE `orders_users`
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Индексы таблицы `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `users_ibfk_1` (`user_type_id`);

--
-- Индексы таблицы `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`user_type_id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT для таблицы `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `orders_product`
--
ALTER TABLE `orders_product`
  ADD CONSTRAINT `orders_product_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_product_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `orders_users`
--
ALTER TABLE `orders_users`
  ADD CONSTRAINT `orders_users_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `orders_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_type_id`) REFERENCES `user_type` (`user_type_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
