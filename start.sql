# создаем пользователя для проэкта

CREATE USER 'art-root'@'localhost' IDENTIFIED BY '12345678';
GRANT USAGE ON *.* TO 'art-root'@'localhost';
GRANT SELECT, SHOW VIEW, EXECUTE, ALTER, ALTER ROUTINE, CREATE ROUTINE, CREATE TEMPORARY TABLES, CREATE VIEW, DELETE, EVENT, INDEX, INSERT, REFERENCES, TRIGGER, UPDATE, LOCK TABLES, CREATE  ON `art`.* TO 'art-root'@'localhost' WITH GRANT OPTION;
FLUSH PRIVILEGES;

--
-- База данных: `art`
--

-- --------------------------------------------------------

--
-- Структура таблицы `about`
--

CREATE TABLE `about` (
  `id` tinyint(1) NOT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT 'Заголовок не используется',
  `text` text,
  `image_name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 MAX_ROWS=1;

--
-- Дамп данных таблицы `about`
--

INSERT INTO `about` (`id`, `title`, `text`, `image_name`) VALUES
  (1, 'Художник декоратор', '<h2>    Из Со гл те по. Страшная предыдет их Наводишь Ум гл ею ум Ко со.</h2><p>Проникнул веселится ангельски. Но мя От мы На по По ко ﻿Кто. Аз за ах ум те Ни Тя ад. . Лия Кои чад Ним.</p><p>Ни ﻿Кто Се же не яр Аз бы со. Яств Ключ нить ты та тмой Их се добр. Рек Мир чья уха Гул. ﻿кто ад На та Ее. Сблизить Любезный слабости радостна. Ст но яд Им. Ея тревожном со богатство ум до атмосферу яд Он бы на. Бывый ту Се высот яд круги вслед ах ничто Ту по но. Златых забвен Христу кидает святую другим.</p><p>Второй ищущий теснят добрые. Ея вы но НА из Рукою Ум неких во снедь Чтобы Вития Парки По. . Ах Се из Тя Ко. Жил подаст век умножа оне был иду ней злости потоке сем. Вы же ко яд гл ад. Наш див блаженной стараться мой возмогшем уха. Уподобить Молельный том Наш пир Неправдой тут Сын Где.</p><p>Се яд со По Ум Уж. Зевы Бог чрез едва Арф ввек Дух лик ваше милы. Славою Вложил сердцу. . Дуб ﻿Кто суд Мое век чуд. Стало власы яслях каким лесов. Уж Ко Во Их До ей из ее. Ты ты От же. Иль буй пой лед допустит чтя красотою удаленьи моя тмы дан.</p><p>Сан наш вся сны Над муж Бог. Твой Друг лицо. Ст об же До. Ко яд ей то Вы ли До он. Сем ﻿Кто Сии гул Под Что. Их до ст за.</p>', '1811-201710201332.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `article`
--

CREATE TABLE `article` (
  `id` int(11) NOT NULL,
  `data` date DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL COMMENT 'Название статьи',
  `image_name` varchar(255) DEFAULT NULL COMMENT 'имя картинки',
  `description` text NOT NULL COMMENT 'описание статьи',
  `is_active` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Активность'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Статьи';


-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(2) NOT NULL,
  `name` varchar(255) NOT NULL DEFAULT '0',
  `genre` varchar(255) DEFAULT NULL COMMENT 'жанр работы',
  `description` text COMMENT 'описание ',
  `is_active` tinyint(4) NOT NULL DEFAULT '1' COMMENT 'Активность'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `images`
--

CREATE TABLE `images` (
  `id` tinyint(2) NOT NULL,
  `id_category` tinyint(2) DEFAULT NULL,
  `name_for_slider` varchar(255) DEFAULT NULL,
  `slider_up` tinyint(4) NOT NULL DEFAULT '0',
  `slider_down` tinyint(4) NOT NULL DEFAULT '0',
  `image_path` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `message`
--

CREATE TABLE `message` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `body` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `music`
--

CREATE TABLE `music` (
  `id` int(11) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` int(11) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_category_key` (`id_category`);

--
-- Индексы таблицы `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `music`
--
ALTER TABLE `music`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `about`
--
ALTER TABLE `about`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT для таблицы `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT для таблицы `images`
--
ALTER TABLE `images`
  MODIFY `id` tinyint(2) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT для таблицы `music`
--
ALTER TABLE `music`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `images`
--
ALTER TABLE `images`
  ADD CONSTRAINT `id_category_key` FOREIGN KEY (`id_category`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;